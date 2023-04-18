<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable =[
        'nidn',
        'nama',
        'email',
        'status'
    ];

    public function roles(){
        return $this->belongsTo('App\Models\Roles',  'roles_id');
    }

}
