<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CaseM extends Model // implements Auditable
{

    protected $table = "cases"; //el modelo se va a relacionar con la tabla
    protected $fillable = ['case_number', 'type_status_id', 'type_case_id', 'type_branch_law_id', 'reception_id']; //que campos tiene la




    public function users()
    {
        return $this->belongsToMany(User::class, 'user_cases', 'case_id')
            ->withPivot('type_defendant', 'user_id', 'case_id', 'type_user_id', 'status', 'id');
    }

    public function inputsForUser()
    {
        return $this->belongsToMany(ReferenceData::class, 'user_case_inputs', 'case_id')
            ->withPivot('reference_data_id', 'user_id', 'case_id')
            ->withTimestamps();;
    }

    public function panic_alerts()
    {
        return $this->belongsToMany(PanicAlert::class, 'panic_alerts_has_case', 'case_id')
            ->withPivot('case_id', 'panic_alert_id')->withTimestamps();;
    }

    public function type_case()
    {
        return $this->belongsTo(ReferenceTable::class, 'type_case_id');
    }

    public function status()
    {
        return $this->belongsTo(ReferenceTable::class, 'type_status_id');
    }

    public function logs()
    {
        return $this->hasMany(CaseLog::class, 'case_id');
    }

    public function reception()
    {
        return $this->hasOne(Reception::class, 'id', 'reception_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'case_id');
    }


    public function type_branch_law()
    {
        return $this->belongsTo(ReferenceTable::class, 'type_branch_law_id');
    }

    public function getCaseData($type_data_id)
    {
        return $data = DB::table('case_data')
            ->where(['type_data_id' => $type_data_id, 'case_id' => $this->id])->first();
    }

    public function getTotalPayments()
    {
        //  dd('hoa');

        return $data = $this->payments()
            ->where('type_status_id', '<>', 57)
            ->where('type_status_id', '<>', 15)
            ->sum('value');
    }

    public function getBalancePayments()
    {
        $pays_credit_data = $this->payments()
            ->where('type_status_id', 50)
            ->where('type_status_id', '<>', 15)
            ->get();
        $pay = 0;
        foreach ($pays_credit_data as $key => $pay_credit_data) {
            $pay = $pay + $pay_credit_data->credits()
                ->where('type_status_id', 111)
                ->orwhere('type_status_id', 116)
                ->sum('payment_credits.value');
        }
        return $pay;
    }

    public function getSupportLogs()
    {
        $logs = $this->logs()
            ->where('type_status_id', '<>', 15)
            ->whereIn('type_log_id', [33])->get();
        $data = [];
        $anterior = '';
        $_logs = [];
        foreach ($logs as $key => $noti) {
            $category = $noti->type_category->name;
            $_logs[] = $noti;
            if ($anterior != $category) {
                $_logs = [];
                $_logs[] = $noti;
                $data[$category] = $_logs;
                $anterior = $category;
            } else {
                $data[$category] = $_logs;
            }
        }
        return $data;
    }

    public function scopeGetData($query, $request)
    {

        if (trim($request->data)) { 

            if ($request->type and $request->data and ($request->type == 'case_number' || $request->type == 'type_case' ||
                $request->type == 'branch_law' || $request->type == 'status' || $request->type == 'created_at')) {
                return $query->Where(function ($query) use ($request) {
                    $query->orWhere('cases.case_number', $request->data);
                    $query->orWhere('cases.type_status_id', '=', $request->data);
                    $query->orWhere('cases.type_case_id', '=', $request->data);
                    $query->orWhere('cases.type_branch_law_id', '=', $request->data);
                    $query->orWhereDate('cases.created_at', '=', $request->data);
                });
            }
           /*  $query->leftJoin('user_cases', 'user_cases.case_id', '=', 'cases.id')
            ->join('users','users.id','=','user_cases.user_id'); */
            return $query->Where(function ($query) use ($request) {
                $query->orWhere('users.name', 'like', '%' . $request->data . '%');
                $query->orWhere('users.identification_number', $request->data);
            });
        }
        // return false;
    }
    public function scopeGetSearch($query, $request)
    {

        if (!is_numeric($request->select_filter_table)) {
            return $query->Where(function ($query) use ($request) {
                if ($request->select_filter_table == 'type_status') {
                    $query->where('cases.type_status_id', '=', $request->select_options_filter_table);
                }
                if ($request->select_filter_table == 'type_case') {
                    $query->where('cases.type_case_id', '=', $request->select_options_filter_table);
                }
                if ($request->select_filter_table == 'type_branch_law') {
                    $query->where('cases.type_branch_law_id', '=', $request->select_options_filter_table);
                }
                if ($request->fecha_ini and $request->fecha_fin) {
                    $query->whereDate('cases.created_at', '>=', $request->fecha_ini)
                        ->whereDate('cases.created_at', '<=', $request->fecha_fin);
                }
            });
        } else {
            return $query->join('user_cases', 'user_cases.case_id', '=', 'cases.id')
                ->join('users', 'users.id', '=', 'user_cases.user_id')
                ->join('user_aditional_data', 'user_aditional_data.user_id', '=', 'users.id')
                ->where('reference_data_option_id', $request->select_options_filter_table);
            // ->groupBy('case_number') ;
        }
    }

    public function getUserByType($tipo_usuario)
    {
        $users =  $this->users()->where('type_user_id', $tipo_usuario)
            ->orderBy('user_cases.created_at', 'desc')
            ->first();
           
        if (!($users)) {
            $users = new User();
        }
        return $users;
    }
    public function getUsersByType($tipo_usuario)
    {
        $users =  $this->users()->where('type_user_id', $tipo_usuario)
            ->orderBy('user_cases.created_at', 'desc')
            ->get();
           
        if (count($users)<=0) {
            $users = new Collection;
        }
        return $users;
    }
    //Events
    public static function boot()
    {
        parent::boot();
        static::created(function ($item) {
            Event::dispatch('case.created', $item);
        });
        static::updated(function ($item) {
            Event::dispatch('case.updated', $item);
        });
        static::deleted(function ($item) {
            Event::dispatch('case.deleted', $item);
        });
    }
}
