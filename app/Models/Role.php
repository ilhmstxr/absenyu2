<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'role',

    ];
    protected $table = 'role';

    public function register()
    {
        return $this->hasMany('App\Models\Register', 'role');
    }

    public function user()
    {
        return $this->hasMany(user::class);
    }
}                                                                                                   
