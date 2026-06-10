<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateSk extends Model
{
    protected $fillable = [
        'unit_kerja_id',
        'nama_template',
        'template_path',
    ];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }
}
