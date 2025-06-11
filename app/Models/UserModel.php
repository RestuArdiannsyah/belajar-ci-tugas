<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username',
        'email',
        'no_hp',
        'password',
        'role',
        'foto_profil',
        'bio',
        'posisi',
        'created_at',
        'updated_at'
    ];
}
