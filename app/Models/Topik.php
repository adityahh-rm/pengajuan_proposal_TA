<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topik extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable =[
        'judul_topik',
        'status',
    ];

    public function dosens(){
        return $this->belongsTo('App\Models\Dosen',  'dosen_id');
    }
}
