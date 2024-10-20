<?php
//use App\Facades\AuditLog;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('login');  
}); */


//Clear route cache:

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Events\MyEvent;
use Facades\App\Facades\ApiChat;
use App\Jobs\SendAccountActivatedUserNotification;
use App\Models\CaseLog;
use App\Models\Diary;
use App\Models\ReferenceData;
use App\Models\ReferenceDataOptions;

Route::get('/route-cache', function() {
	$exitCode = Artisan::call('route:cache');
	return 'Routes cache cleared';
});

//Clear config cache:
Route::get('/config-cache', function() {
	$exitCode = Artisan::call('config:cache');
	return 'Config cache cleared';
}); 

// Clear application cache:
Route::get('/clear-cache', function() {
	$exitCode = Artisan::call('cache:clear');
	return 'Application cache cleared';
});

// Clear view cache:
Route::get('/view-clear', function() {
	$exitCode = Artisan::call('view:clear');
	return 'View cache cleared';
});

// Clear view cache:
Route::get('/view-optimize', function() {
	$exitCode = Artisan::call('optimize');
	return 'View cache cleared';
});


Route::get('/terminosycondiciones', function () {
    return view('auth.terminosycondiciones');  
});




//Route::get('/chats/{id}', 'DiaryController@prueba');

/* Route::get('/mail', function () {
	//Prueba para renderizar mail
	$user = \Auth::user()->sessions;
	$session_data=[];
	//dd($url);
	$session = new App\SessionAdmin();
	$session->verifyToken();     
	$session_data['ip'] = $session->getUserIpAddr();
	$session_data['country'] = $session->getGeoLocalization('country');
	$session_data['city'] = $session->getGeoLocalization('city');
	$session_data['os'] = $session->getOS();
	$session_data['browser'] = $session->getBrowser();
	$session_data['time'] = date('Y-m-d H:i:s');
	$session->access_address = json_encode($session_data);  

	return (new App\Notifications\LoginNotification(\Auth::user(),$session_data,$session))
	->toMail(\Auth::user()->email);

    //return \Auth::user()->notify(new LoginNotification(\Auth::user()));;  
}); */

Route::get('/pruebas/app', function () {
	//AuditLogFacade::create();
	$token = "jsjsj";
	$date = "06 julio 2024";
	$user = auth()->user();
	$password_send = "documento";
	$caseL = CaseLog::first();
	return view('mail.user_register_notification',compact('password_send','user'));

	$data = ReferenceDataOptions::all();
	foreach ($data as $location) {
		$shortName = sanear_string($location->value);
		//dd($shortName);
		$dt = ReferenceDataOptions::find($location->id);
		$dt->value_db = $shortName;
		$dt->save();
	}
	dd($data);

	$data = ReferenceData::doesntHave('options')
	->get();


	//dd($data);

	foreach ($data as $location) {
		$shortName = sanear_string($location->name);
		//dd($shortName);
		$dt = new ReferenceDataOptions();
		$dt->references_data_id = $location->id;
		$dt->value = $location->name;
		$dt->value_db = $shortName;
		$dt->save();
	}
	dd($data);
	$data = ReferenceData::all();
	foreach ($data as $location) {
		$shortName = sanear_string($location->name);
		//dd($shortName);
		$dt = ReferenceData::find($location->id);
		$dt->short_name = $shortName;
		$dt->save();
	}
	dd($data);
	$token = "jsjsj";
	return view('mail.account_restore_password',compact('token'));

	dd('');  

});
/*
Route::get('/', function () {

return view('mantenimiento');

});

Route::get('/login', function () {

	\Auth::logout();
	return view('mantenimiento');
	
	});
*/
Route::group(["namespace"=>'App\Http\Controllers'], function(){
 Route::get('/listen/chat/message','ChatController@listenMessageEvent');

 Route::get('/listen/chat','ChatController@listenMessageEvent');

});

Route::group(['middleware' => ['auth','sadmin','vlogout'],"namespace"=>'App\Http\Controllers'], function(){

	Route::get('/', function(){
		return redirect('/home');
	});

	
	//control accesos
	//Route::post('/verify/token','UsersController@verifyToken');
	Route::get('/token/admin/session/{token}/{action}','SessionAdminController@adminSessionToken');
	//Route::get('/token/locked/session/{token}','SessionAdminController@lockedSessionToken');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

////////////////////Users
    Route::resource('/admin/users','UsersController');
	Route::post('/users/find','UsersController@find');
	Route::post('/users/insert/data','UsersController@insertData');
	Route::get('/users/get/data','UsersController@getData');
	Route::get('/get/data','UsersController@datachat');
	Route::post('/get/users/login','UsersController@getLogin');
	Route::post('/admin/users/photo/update','UsersController@updatePhoto');
	Route::post('/admin/users/update','UsersController@update');
	Route::post('/admin/users/insert/type/data','UsersController@insertTypeData');
	Route::post('/admin/users/insert/note','UsersController@insertNote');
	Route::post('/admin/users/update/note','UsersController@updateNote');
	Route::get('/admin/users/delete/note','UsersController@deleteNote');
	Route::post('/add/static/data','UsersController@addStaticData');
	Route::get('/admin/users/unread/notifications','NotificationsController@unreadNotifications');
	Route::get('/admin/users/view/notifications','NotificationsController@index');
	Route::get('/admin/users/delete/notifications/{id}','NotificationsController@destroy');
	
	

////////////////////Permisos
/*	Route::resource('/admin/permisos','PermissionsController');
	Route::resource('/admin/roles','RolesController');
	Route::get('/admin/asig','RolesController@admin')->name('roles.admin');
	Route::post('/admin/sync/permission','RolesController@syncPermissionRole');
	Route::post('/admin/get/sync/permissions','RolesController@getPermissionsRole');
	Route::post('/admin/permissions/change','RolesController@change_permissions');*/
	Route::resource('admin/roles','AdminRolesAndPermisionsController');
    Route::post('admin/sync/rol/permissions','AdminRolesAndPermisionsController@syncRolPermissions');
    Route::get('admin/create/role','AdminRolesAndPermisionsController@adminRoles');
    Route::post('admin/store/role','AdminRolesAndPermisionsController@storeRole');
    Route::post('admin/update/role','AdminRolesAndPermisionsController@updateRole'); 
    Route::get('admin/delete/role','AdminRolesAndPermisionsController@deleteRole');

    Route::get('admin/create/permission','AdminRolesAndPermisionsController@adminPermissions');
    Route::post('admin/store/permission','AdminRolesAndPermisionsController@storePermission');
    Route::post('admin/update/permission','AdminRolesAndPermisionsController@updatePermission');
    Route::get('admin/delete/permission','AdminRolesAndPermisionsController@deletePermission');
	
     
	Route::resource('/casos','CasesController');
	Route::post('/casos/add/noveltydata','CasesController@storeNoveltyData')->name('cases.addnoveltydata');
	Route::post('/casos/add/noveltyhasdata','CasesController@storeNoveltyHasData')->name('cases.addnoveltyhasdata');
	Route::post('/casos/insert/data','CasesController@insertData');
	Route::get('/casos/find/novelty/options/{id}','ReferencesDataController@getOptionsByCategory');
	Route::post('/casos/insert/user','CasesController@insertUser');
	Route::post('/casos/delete/user','CasesController@deleteUser');
	Route::post('/casos/delete/novelty','CasesController@deleteNoveltyData');
	Route::post('/casos/delete/noveltyhas','CasesController@deleteNoveltyHasData');
	Route::post('/casos/find/notification','CasesController@findNotificationMail');
	Route::post('/casos/get/logs','CasesController@getLogs');
	Route::get('/casos/search/logs','CasesController@searchLogs');
	Route::post('/casos/store/payment','CasesController@storePayment');
	Route::post('/casos/edit/payment','CasesController@editPayment');
	Route::post('/casos/update/payment','CasesController@updatePayment');
	Route::post('/casos/delete/payment','CasesController@deletePayment');
	Route::post('/casos/stream','CasesController@notifyClientStream');
	Route::post('/casos/asig/reception','CasesController@asigReception');
	Route::post('/casos/insert/input/for/user','CasesController@asigInputForUsers');
//case logs
	Route::resource('/casos/logs','CaseLogsController');
	Route::post('/casos/update/logs/{id}','CaseLogsController@update');
	Route::post('/casos/insert/support/logs','CaseLogsController@insertSupport');
	Route::get('/oficina/descargar/documento/{id}','CaseLogsController@downloadFileLog');
	Route::post('/log/delete/supports','CaseLogsController@deleteSupport');

	//cobros
	Route::resource('/cobros','PaymentsController');
	Route::post('/payments/insert/supports','PaymentsController@insertSupport');
	Route::post('/payments/insert/credits','PaymentsController@insertPaymentCredits');
	Route::post('/payments/delete/supports','PaymentsController@deleteSupport');
	Route::get('/payments/download/support/{id}','PaymentsController@downloadFile');
	Route::post('/payments/pay/credit','PaymentsController@payCredit'); 
	//creditos
	Route::resource('/creditos','PaymentsCreditsController');

	//Route::resource('/chat','ChatController');
	

	//Agenda
	Route::resource('/agenda','DiaryController');
	Route::post('/agenda/create','DiaryController@create');
	Route::post('/agenda/update','DiaryController@update');
	Route::post('/agenda/delete','DiaryController@destroy');
	Route::post('/agenda/edit','DiaryController@edit');
	Route::get('/agenda/source/{id}','DiaryController@show');

	Route::get('/pruebaio','DiaryController@prueba'); //-------------------- esto es una prueba

	//clientes
	Route::get('/clientes', 'ClientsController@index');

	//directorio
	Route::resource('/directorio','DirectoryController');
	//receptions
	Route::resource('/recepciones','ReceptionsController');
	//personal
	Route::get('/personal', 'StaffController@index');

	//biblioteca
	Route::get('/biblioteca', 'LibraryController@index');
	Route::post('/biblioteca/create', 'LibraryController@create');
	Route::post('/biblioteca/source', 'LibraryController@show');
	Route::post('/biblioteca/update', 'LibraryController@update');
	Route::get('/biblioteca/download/{id}', 'LibraryController@downloadFile');
	Route::post('/biblioteca/delete', 'LibraryController@destroy');

	//reportes
	Route::resource('/reportes','ReportesExcelController');
	Route::post('/reportes/excel/generate','ReportesExcelController@toExcel'); 
	Route::post('/reportes/get/option/filter','ReportesExcelController@getOptionFilter'); 
	//Route::get('/home', 'HomeController@index')->name('home');

	Route::post('/reportes/get/graphics/data','ReportesChartsController@getData');


	//vista del cliente /oficina
	Route::resource('/oficina','FrontClientController');
	Route::group(['prefix'=>'oficina'],function(){//clientes
		Route::get('/documentos/view','FrontClientController@documents')->name('office.docs');
		Route::get('/user/edit/{id}','FrontClientController@editProfile');
		Route::get('/chat/view','FrontClientController@chat')->name('office.chat');
		Route::get('/reception/view/{id}','FrontClientController@reception')->name('office.reception');
		Route::get('/notificaciones/view','FrontClientController@notifications')->name('office.notification');
		Route::get('/pagos/view','FrontClientController@payments')->name('office.pay');
		Route::get('/diary/view','FrontClientController@diary')->name('office.diary');
		Route::post('/upload/supports','FrontClientController@uploadSupport');
		Route::get('/panic/alerts','FrontClientController@panic_alerts')->name('office.alerts');
		Route::get('/panic/directories','FrontClientController@panic_directories')->name('office.directories');
		
	});  

	//notificaciones mail
	//Route::get('/notificaciones/view/log/{token}', 'UserMailNotificationController@confirm_notification');

	//Referencias data
	Route::resource('/categorias','ReferencesDataController');
	Route::resource('/panic/alerts','PanicApiController');
	Route::get('/panic/alerts','PanicApiController@index')->name('panic.alerts');
	Route::get('/panic/directories','PanicApiController@directories')->name('panic.directories');
	Route::get('/panic/alerts/view/directory/{user_id}','PanicApiController@view_directory');

	//Auditoria
	Route::resource('/auditoria','AuditLogController');
});
//notificaciones mail
Route::group(["namespace"=>'App\Http\Controllers'], function(){
Route::resource('/notificaciones', 'UserMailNotificationController');

Route::get('/notificaciones/view/log/{token}', 'UserMailNotificationController@confirm_notification');
Route::get('/notificaciones/download/log/{id}', 'UserMailNotificationController@downloadFileLog');
Route::get('/pruebas', 'UserMailNotificationController@pruebas');

Route::get('/prueba', function(){

	//event( new MyEvent('hello world'));
	return view("content.pruebas.index");
});

Route::get('/pruebas', function(){

	//$chat = ApiChat::render("room");

	//dd(config()->get('chat.connection.code'));
	$token = 1234;
	return view("content.chat.index",compact('token'));



//SendAccountActivatedUserNotification::dispatch(auth()->user());

//SendEventDiaryEmail::dispatch($case->users()->where('type_user_id',7)->get(),$diary)->onQueue('diarys');                   
               

return "Hi";
});

});
Auth::routes();



