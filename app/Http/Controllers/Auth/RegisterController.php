<?php

namespace App\Http\Controllers\Auth;

use App\Services\UsersService;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendRegisterNotificationEmail;
use App\Jobs\SendRegisterUserNotificationEmail;
use App\Notifications\UserRegisterDBNotification;
use Illuminate\Support\Facades\Notification
;
class RegisterController extends Controller

{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    private $userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UsersService $userService)
    {
        $this->userService = $userService;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {


        $users = $this->userService->getUsersByPermissionName("recibir_correo_user_register");

       
          $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'address' => "Sin direccion",
            'image' => 'dist/img/user-default-min.jpg',
            'identification_number'=>$data['identification_number'],
            'type_identification_id'=>6,
            'type_status_id'=>16,
            'password' => Hash::make($data['password']),
        ]); 
         $user->roles()->attach(5);
         //Notification::send($users, new UserRegisterDBNotification($user));
         SendRegisterUserNotificationEmail::dispatch($users,$user)->onQueue('diarys');
         return   $user ;
         
    }
}
