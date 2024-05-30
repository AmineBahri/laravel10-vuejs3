<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppFont extends Model
{
    use HasFactory;

    protected $fillable = ['name_font','path'];

    public $timestamps = false;
}
