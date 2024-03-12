<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['page_id','role_id','read','edit','create','update','delete'];

    public function page() 
    {
        return $this->belongsTo(Page::class);
    }

    public function role() 
    {
        return $this->belongsTo(Role::class);
    }


}
