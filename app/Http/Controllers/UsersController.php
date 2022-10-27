<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Session;
use Redirect;
use Validator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Storage;
use App\Models\CaseM;
use App\Models\UserNote;
use App\Models\SessionAdmin;
use App\Facades\AuditLog;
use App\Jobs\SendRegisterNotificationEmail;
use App\Jobs\SendRegisterUserNotificationEmail;
use App\Notifications\UserRegister\DBNotification;
use App\Jobs\SendAccountActivatedUserNotification;
use App\Models\UserAditionalData;
use App\Models\ReferenceData;
use App\Services\UsersService;

class UsersController extends Controller
{
    private $userService;

    public function __construct(UsersService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth');
        // $this->middleware('permission:edit_usuarios|ver_perfil_usuario|editar_perfil_cliente',   ['only' => ['edit']]);
        $this->middleware('permission:ver_usuarios', ['only' => ['index', 'show']]);
        //$this->middleware('permission:ver_perfil_usuario',   ['only' => ['edit']]);
        // $this->middleware('permission:editar_perfil_cliente',   ['only' => ['edit']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $users = $this->getUsers($request);

        return view('content.users.users_list', compact('users'));
    }

    private function getUsers(Request $request)
    {
        $users = User::join('model_has_roles as ru', 'users.id', '=', 'ru.model_id')
            ->where('type_status_id', '<>', 15)
            ->where('users.id', '<>', \Auth::user()->id)
            ->where('role_id', '<>', '1')
            ->paginate(10);

        return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json($request->all());
        $messages = [
            'email.unique' => 'El :attribute  ya existe en otra cuenta.',
            'email.required' => 'El :attribute es requerido.',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'unique:users'],
            ],
            $messages,
        );

        if ($validator->fails()) {
            if ($request->ajax()) {
                //return response()->json(errors$validator);
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!$request->has('password')) {
            $password_send = \Str::random(6);
            $request['password'] = $password_send;
        } else {
            $password_send = $request['password'];
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'address' => $request['address'],
            'image' => 'dist/img/user-default-min.jpg',
            'identification_number' => $request['identification_number'],
            'type_identification_id' => $request['type_identification_id'],
            'type_status_id' => 16,
            'password' => Hash::make($request['password']),
        ]);

        if ($request->has('role_id')) {
            $user->roles()->attach($request['role_id']);
        } else {
            $user->roles()->attach(5);
        }
        $response = [];
        $response['user'] = $user;
        if ($request->has('case_id')) {
            $type_defendant = $request->type_defendant ? $request->type_defendant : null;
            $user->cases()->attach($request->case_id, [
                'type_user_id' => $request->type_user_id,
                'type_defendant' => $type_defendant,
            ]);
            $user->type_user_id = $request->type_user_id;
            $case = CaseM::find($request->case_id);
            if ($request->type_user_id == 7) {
                $response['render_view'] = view('content.cases.partials.ajax.client_data', compact('case'))->render();
            }
            if ($request->type_user_id == 8) {
                $response['render_view'] = view('content.cases.partials.ajax.professional_data', compact('case'))->render();
            }
            if ($request->type_user_id == 21) {
                $response['render_view'] = view('content.cases.partials.ajax.defendant', compact('case'))->render();
            }
            if ($request->type_user_id == 25) {
                $response['render_view'] = view('content.cases.partials.ajax.interventor', compact('case'))->render();
            }
        }
        if ($request->has('view') and $request['view'] == 'user') {
            $users = $this->getUsers($request);
            $response['render_view'] = view('content.users.partials.ajax.index', compact('users'))->render();
        }

        SendRegisterNotificationEmail::dispatch($user, $password_send)->onQueue('diarys');

        $users = $this->userService->getUsersByPermissionName('recibir_correo_user_register');

        SendRegisterUserNotificationEmail::dispatch($users, $user)->onQueue('diarys');
        //
        if ($request->ajax()) {
            return response()->json($response);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd("sss");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'id');
        //dd($user->roles);
        if (
            $id != auth()->user()->id and
            !auth()
                ->user()
                ->can('edit_usuarios') and
            !auth()
                ->user()
                ->can('ver_perfil_usuario') and
            !auth()
                ->user()
                ->can('editar_perfil_cliente')
        ) {
            abort(403);
        }
        $canedit = true;
        if ($id != auth()->user()->id) {
            $canedit = false;
            if (
                auth()
                    ->user()
                    ->can('edit_usuarios')
            ) {
                $canedit = true;
            } elseif (
                auth()
                    ->user()
                    ->can('editar_perfil_cliente')
            ) {
                if (count($user->roles) <= 0 || (count($user->roles) > 0 and $user->roles[0]->name == 'cliente')) {
                    $canedit = true;
                } else {
                    if (
                        !auth()
                            ->user()
                            ->can('edit_usuarios') and
                        !auth()
                            ->user()
                            ->can('ver_perfil_usuario')
                    ) {
                        abort(403);
                    }
                }
            } elseif (
                auth()
                    ->user()
                    ->can('ver_perfil_usuario')
            ) {
                $canedit = false;
            }
        }

        return view('content.users.user_edit', compact('user', 'canedit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return response()->json($request->all());
        $user = User::find($request->id);
        $old_status = $user->type_status_id;
        if ($request->get('password')) {
            if (Hash::check($request->oldpassword, \Auth::user()->password)) {
                if ($request->password == $request->confirpassword) {
                    $user->password = bcrypt($request->password);
                    $user->save();
                    return response()->json($user);
                } else {
                    return response()->json(['error' => 'La nueva contrase単a no coincide']);
                }
            } else {
                return response()->json(['error' => 'La contrase単a de administrador o actual es incorrecta']);
            }
        }
        if ($request->has('email')) {
            $messages = [
                'email.unique' => 'El :attribute  ya existe en otra cuenta.',
                'email.required' => 'El :attribute es requerido.',
            ];
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => ['required', Rule::unique('users')->ignore($user->id)],
                ],
                $messages,
            );

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(['errors' => $validator->errors()->all()]);
                }
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        $user->fill($request->all());
        if ($request->get('role_id')) {
            $user->roles()->sync($request->role_id);
            AuditLog::setEvent('update')
                ->setModelDescription(json_encode($user->roles))
                ->setTable($user->getTable())
                ->store($user);
        }
        $user->save();
        $user->roles;
        if ($old_status == 16 and $user->type_status_id == 141) {
            SendAccountActivatedUserNotification::dispatch($user)->onQueue('diarys');
        }
        if ($request->ajax()) {
            return response()->json($user);
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $user->type_status_id = 15;
        $user->save();
        $response = [];

        $users = $this->getUsers($request);
        $response['render_view'] = view('content.users.partials.ajax.index', compact('users'))->render();

        return $response;
    }

    public function find(Request $request)
    {
        // return $request->all();
        $user = User::where(['identification_number' => $request->identification_number, 'type_identification_id' => $request->type_identification_id])->first();
        if ($user) {
            $user->roles;
        }
        //$user->data = $user->getData();
        return response()->json($user);
    }

    public function updatePhoto(Request $request)
    {
        // return response()->json($request->all());
        $user = User::find($request->id);
        if ($request->file('image') != '') {
            $docum = $request->file('image');
            $nombre_arch = $docum->getClientOriginalName();
            $nombre_arch = htmlentities($nombre_arch);
            $nombre_arch = preg_replace('/\&(.)[^;]*;/', '\\1', $nombre_arch);
            $file_name = preg_replace('([^A-Za-z0-9. ])', '', $nombre_arch);
            $extension = $docum->extension();
            $file_name = md5($file_name) . '.' . $extension;
            $file_route = time() . '_' . $file_name;
            Storage::disk('profile_files')->put($file_route, file_get_contents($docum->getRealPath()));
            $complet_path = Storage::disk('profile_files')->url($file_route);
            if ($user->image != '') {
                if (file_exists(public_path($user->image)) and $user->image != 'dist/img/user-default-min.jpg') {
                    unlink($user->image);
                }
            }
            $user->image = $complet_path;
            $user->save();
        }
        $user->isAuth = $user->id == auth()->user()->id ? true : false;
        return response()->json($user);
    }

    public function insertData(Request $request)
    {
        // return response()->json($request->all());

        $data = \DB::table('user_data')
            ->where(['type_data_id' => $request->type_data_id, 'user_id' => $request->user_id])
            ->first();
        if ($data) {
            $data = \DB::table('user_data')
                ->where(['type_data_id' => $request->type_data_id, 'user_id' => $request->user_id])
                ->update($request->except('component'));
        } else {
            // $request['user_id'] = \Auth::user()->id;
            $request['created_at'] = date('Y-m-d H:i:s');
            $request['updated_at'] = date('Y-m-d H:i:s');
            $data = \DB::table('user_data')
                ->where(['type_data_id' => $request->type_data_id, 'user_id' => $request->user_id])
                ->insert($request->except('component'));
        }

        $user = User::find($request->user_id);
        $user->data = $user->getData($request->component);
        //if($request->type_data_id)
        AuditLog::setEvent('create')
            ->setModelDescription(json_encode($user->data))
            ->setTable($user->getTable())
            ->store();
        return response()->json($user);
    }

    public function insertNote(Request $request)
    {
        //  return response()->json($request->all());

        $note = new UserNote($request->all());
        $note->save();

        $user = $note->user;
        /*
     AuditLog::setEvent('create')
     ->setModelDescription(json_encode($user->notes))
     ->setTable($user->getTable())
     ->store($user); */

        $view = view('content.users.partials.ajax.note_component', compact('user'))->render();
        $response = [];
        $response['render_view'] = $view;
        return response()->json($response);
    }

    public function updateNote(Request $request)
    {
        //  return response()->json($request->all());

        $user = User::find($request->user_id);
        $note = $user
            ->notes()
            ->where('user_notes.id', $request->id)
            ->first();
        $note->note = $request->note;
        $note->save();

        /*     AuditLog::setEvent('update')
            ->setModelDescription(json_encode($note))
            ->setTable($user->getTable())
            ->store($user); */

        $view = view('content.users.partials.ajax.note_component', compact('user'))->render();
        $response = [];
        $response['render_view'] = $view;
        return response()->json($response);
    }

    public function deleteNote(Request $request)
    {
        //  return response()->json($request->all());

        $user = User::find($request->user_id);
        $note = $user
            ->notes()
            ->where('user_notes.id', $request->id)
            ->first();
        $note->type_status_id = 15;
        $note->save();
        /*
        AuditLog::setEvent('delete')
            ->setModelDescription(json_encode($note))
            ->setTable($user->getTable())
            ->store($user); */

        $view = view('content.users.partials.ajax.note_component', compact('user'))->render();
        $response = [];
        $response['render_view'] = $view;
        return response()->json($response);
    }

    public function getData(Request $request)
    {
        // return response()->json($request->all());
        $user = User::find($request->user_id);
        $user->data = $user->getData('case');

        return response()->json($user);
    }

    public function getLogin()
    {
        // return response()->json($request->all());
        $users = User::where('remember_token', '<>', '')
            ->where('id', '<>', \Auth::user()->id)
            ->get();
        return response()->json($users);
    }

    public function insertTypeData(Request $request)
    {
        //  return response()->json($request->all());
        $request['created_at'] = date('Y-m-d H:i:s');
        $request['updated_at'] = date('Y-m-d H:i:s');

        $insert = \DB::table('references_data')->insertGetId($request->except(['user_id']));

        $user = User::find($request->user_id);
        $view = '';
        $canedit = true;
        if ($request->user_id != auth()->user()->id) {
            $canedit = false;
            if (
                auth()
                    ->user()
                    ->can('edit_usuarios')
            ) {
                $canedit = true;
            } elseif (
                auth()
                    ->user()
                    ->can('editar_perfil_cliente')
            ) {
                if (count($user->roles) <= 0 || (count($user->roles) > 0 and $user->roles[0]->name == 'cliente')) {
                    $canedit = true;
                } else {
                    if (
                        !auth()
                            ->user()
                            ->can('edit_usuarios') and
                        !auth()
                            ->user()
                            ->can('ver_perfil_usuario')
                    ) {
                        abort(403);
                    }
                }
            } elseif (
                auth()
                    ->user()
                    ->can('ver_perfil_usuario')
            ) {
                $canedit = false;
            }
        }
        if ($request->section == 'about_me') {
            $view = view('content.users.partials.ajax.about_me_component', compact('user', 'canedit'))->render();
        } elseif ($request->section == 'case') {
            $view = view('content.users.partials.ajax.aditional_data_component', compact('user', 'canedit'))->render();
        }
        $response = [
            'view' => $view,
        ];
        return response()->json($response);
    }

    public function addStaticData(Request $request)
    {
        //  return response()->json($request->all());
        $question = ReferenceData::find($request->reference_data_id);
        $user = User::find($request->user_id);
        if ($question->type_data_id == 136 and $request->has('fire')) {
            if ($request->has('fire') and $request->fire == 'insert') {
                $answer = UserAditionalData::create([
                    'value' => $request->value,
                    'user_id' => $request->user_id,
                    'reference_data_option_id' => $request->reference_data_option_id,
                    'reference_data_id' => $request->reference_data_id,
                ]);
            } elseif ($request->has('fire') and $request->fire == 'delete') {
                $answer = UserAditionalData::where([
                    'user_id' => $request->user_id,
                    'reference_data_option_id' => $request->reference_data_option_id,
                    'reference_data_id' => $request->reference_data_id,
                ])->delete();
            }
        } else {
            $search = [];
            $search['reference_data_id'] = $request->reference_data_id;
            if ($request->has('value_is_other')) {
                $search['reference_data_option_id'] = $request->reference_data_option_id;
                $answer = $user
                    ->aditional_data()
                    ->where($search)
                    ->first();
            } else {
                $answer = $user
                    ->aditional_data()
                    ->where($search)
                    ->first();
            }

            if ($answer) {
                if ($request->value) {
                    $answer->value = $request->value;
                }
                if ($request->value_is_other) {
                    $answer->value_is_other = $request->value_is_other;
                }
                $answer->reference_data_option_id = $request->reference_data_option_id;
                $answer->save();
            } else {
                $answer = UserAditionalData::create([
                    'value' => $request->value,
                    'user_id' => $request->user_id,
                    'reference_data_option_id' => $request->reference_data_option_id,
                    'reference_data_id' => $request->reference_data_id,
                ]);
            }
        }
        $q_view = view('content.users.partials.ajax.static_data_question', compact('question', 'user'))->render();
        $response = [];
        $response['q_view'] = $q_view;
        return response()->json($response);
    }

   
}
