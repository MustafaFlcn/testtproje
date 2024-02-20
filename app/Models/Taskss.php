<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taskss extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='taskss';

    protected $fillable = [
        'task_time',
        'title',
        'subject',
        'user_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
