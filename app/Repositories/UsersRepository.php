<?php

namespace App\Repositories;

use App\Models\ReferenceData;
use App\Models\ReferenceDataOptions;
use App\Services\UsersService;
use App\Models\User;
use App\Models\UserAditionalData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsersRepository extends BaseRepository implements UsersService
{

  public function __construct(User $user)
  {
    parent::__construct($user);
  }

  public function getUsersByPermissionName($permission): Collection
  {

    $users = User::join('model_has_roles as ru', 'users.id', '=', 'ru.model_id')
      ->join('roles', 'roles.id', '=', 'ru.role_id')
      ->join('role_has_permissions', 'role_has_permissions.role_id', '=', 'roles.id')
      ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
      ->where('users.type_status_id', '<>', 15)
      ->where('permissions.name', $permission)
      ->select("users.id", 'users.email', 'users.name')
      ->get();

    return $users;
  }
  protected function store(Request $request)
  {
  }
  public function insertData(Request $request)
  {

    if ($request->has('data') and is_array($request->data)) {
      $requestData = $request->data;
      foreach ($request->data as $key => $option_r) {
        $option_r['user_id'] = $request['user_id'];
        $ref_data = ReferenceData::where(function ($query) use ($option_r) {
          if (isset($option_r['short_name'])) {
            $query->where([
              'short_name' => $option_r['short_name']
            ]);
          } elseif (isset($option_r['question_id'])) {
            $query->where([
              'id' => $option_r['question_id']
            ]);
          }
        })->where([
          'section' => $request['component']
        ])->first();
        if ($ref_data) {
          $this->storeData($ref_data, $option_r);
        }
        //
      }
    }
    return true;
  }

  private function storeData($question, $request)
  {



    if (isset($request['options']) and count($request['options']) > 0) {

      foreach ($request['options'] as $key => $option_r) {
        $option = ReferenceDataOptions::where(function ($query) use ($option_r) {
          if (isset($option_r['value_db'])) {
            $query->where([
              'value_db' => $option_r['value_db']
            ]);
          } elseif (isset($option_r['option_id'])) {
            $query->where([
              'id' => $option_r['option_id']
            ]);
          }
        })->first();
        $tipo_pregunta = $question->type_data_id;
        $data = UserAditionalData::where([
          'reference_data_id' => $question->id,
          'user_id' => $request['user_id'],
          /* 'reference_data_option_id' => $option->id */
        ])->where(function($query) use ($option,$tipo_pregunta){
          if($tipo_pregunta==136){
            $query->where(['reference_data_option_id' => $option->id]);
          }
        })->first();


        if ($data) {
          
          Log::info($tipo_pregunta);
          if ($tipo_pregunta != 136) { ///texto
            $data->value = $option_r["value"];
            $data->reference_data_option_id = $option->id;
            $data->value_is_other = (isset($option_r["value_is_other"]) and $option_r["value_is_other"] != "") ? $option_r["value_is_other"] : "";
            $data->save();
          } else if ($tipo_pregunta == 136) {
            if ($option_r["value"] != "") {
              $data->value = $option_r["value"];
              $data->reference_data_option_id = $option->id;
              $data->value_is_other = (isset($option_r["value_is_other"]) and $option_r["value_is_other"] != "") ? $option_r["value_is_other"] : "";
              $data->save();
            }else{
              $data->delete();
            }
          }
        } else {
          if ($option_r["value"] != '') {
            $data = UserAditionalData::create([
              'reference_data_id' => $question->id,
              'reference_data_option_id' => $option->id,
              'user_id' => $request["user_id"],
              'value' => $option_r["value"],
              'value_is_other' => (isset($option_r["value_is_other"]) and $option_r["value_is_other"] != "") ? $option_r["value_is_other"] : "",
            ]);
          }
        }
      }
    }
    return $data;
  }
}
