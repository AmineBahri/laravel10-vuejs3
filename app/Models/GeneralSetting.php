<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $fillable = ['font_id','font_size','name','logo','email','facebook','youtube'];

    public $timestamps = false;

    public function font()
    {
        return $this->belongsTo(AppFont::class,'font_id','id');
    }
}
