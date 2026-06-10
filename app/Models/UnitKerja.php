<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    protected $fillable = ['nama_unit_kerja'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }

    public function templateSk()
    {
        return $this->hasOne(TemplateSk::class);
    }
}
