<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    use HasFactory,Notifiable;
    protected $tableName = 'rooms';
    
    protected $primaryKey = 'room_id'; 
    public $incrementing = true;
    protected $keyType = 'int';  

    protected $fillable = [
        'room_name',
        'capacity',
        'length',
        'width',
        'height',
        'active_flag'
    ];
    public $timestamps = false;
     
    
}
