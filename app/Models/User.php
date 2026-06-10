<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Pegawai;
use App\Models\PermohonanSk;
use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'email', 'password', 'role', 'profile_photo', 'unit_kerja_id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
        ];
    }

    /**
     * Get the valid roles for the user.
     *
     * @return array<string>
     */
    public static function getRoles(): array
    {
        return ['admin', 'operator', 'pegawai'];
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function pegawai()
    {
        return $this->hasOne(Pegawai::class);
    }

}
