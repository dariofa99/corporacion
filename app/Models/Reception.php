<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

class Reception extends Model
{
    protected $table = 'receptions';
    protected $fillable = ['number', 'user_id', 'token', 'type_status_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function type_status()
    {
        return $this->belongsTo(ReferenceTable::class, 'type_status_id');
    }

    public function case()
    {
        return $this->belongsTo(CaseM::class, 'id', 'reception_id');
    }
    public function scopeGetData($query, $request)
    {

        if (trim($request->data)) {
            if ($request->type and $request->data and ($request->type == 'identification_number' ||
            $request->type == 'user_name')) {
                return $query->where(function ($qu) use ($request) {
                    $qu->whereHas('user', function ($q) use ($request) {
                        if ($request->type == 'user_name') {
                            $q->where('users.name', 'like', '%' . $request->data . '%');
                        }
                        if ($request->type == 'identification_number') {
                            $q->where('users.identification_number', $request->data);
                        }
                    });
                });
            }
            return $query->Where(function ($query) use ($request) {
                $query->orWhereDate('created_at', $request->data);
                $query->orWhere('number', $request->data);
            });
        }
        // return false;
    }
    //Events
    public static function boot()
    {
        parent::boot();
        static::created(function ($item) {
            Event::dispatch('reception.created', $item);
        });
        static::updated(function ($item) {
            Event::dispatch('reception.updated', $item);
        });
        static::deleted(function ($item) {
            Event::dispatch('reception.deleted', $item);
        });
    }
}
