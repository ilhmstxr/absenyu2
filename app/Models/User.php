<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function bk(){
    //     return $this->belongsTo(bk::class);
    // }

    // public function guru(){
    //     return $this->belongsTo(guru::class);
    // }

    // public function siswa (){
    //     return $this->belongsTo(Siswa::class);
    // }

    public function kelas()
    {
        return $this->belongsTo(kelas::class);
    }

    public function absen()
    {
        return $this->hasmany(absen::class, 'siswa_id');
    }
}
