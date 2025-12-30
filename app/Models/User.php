<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'role_id'
    ];

    protected $hidden = ['password'];

    public $timestamps = false;

    // RELASI KE ROLE
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id_role');
    }
}
