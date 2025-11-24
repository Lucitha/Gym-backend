<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class CourseTypes extends Model
{
    //
     use HasFactory,Notifiable;
    protected $tableName = 'course_types';
    
    protected $primaryKey = 'course_type_id'; 
    public $incrementing = true;
    protected $keyType = 'int';  

    protected $fillable = [
        'course_type_name',
        'active_flag' 
    ];

    public $timestamps = false;
}
