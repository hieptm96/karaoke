<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class ModelTracking extends Model
{
    protected static function boot()
    {
        parent::boot();

        $user = Auth::user();

        static::creating(function ($model) use ($user) {
            $model->beforeCreating();
            $model->setCreatedBy($user);
            $model->setUpdatedBy($user);
        });

        static::updating(function ($model) use ($user) {
            $model->beforeUpdating();
            $model->setUpdatedBy($user);
        });
    }

    protected function setCreatedBy(User $user = null)
    {
        if ($user) {
            $this->created_by = $user->id;
        }

        return $this;
    }

    protected function setUpdatedBy(User $user = null)
    {
        if ($user) {
            $this->updated_by = $user->id;
        }

        return $this;
    }

    protected function beforeCreating()
    {
        //
    }

    protected function beforeUpdating()
    {
        //
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}