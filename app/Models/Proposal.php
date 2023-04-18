<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'judul',
        'berkas_kp',
        'berkas',
        'status',
        'dosen_id',
    ];

    public function dosens(){
        return $this->belongsTo('App\Models\Dosen',  'dosen_id');
    }
    
    public function users(){
        return $this->belongsTo('App\Models\User',  'user_id');
    }

}
