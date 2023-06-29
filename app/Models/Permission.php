<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'action'];

    public function roles()
        {
            return $this->belongsToMany(Role::class);
        }
    public function permission()
        {
            return $this->hasOneThrough(User::class,Permission_Role::class,'user_id','id');
        }
}
