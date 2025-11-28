<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Categories extends Model
{
    use HasFactory,Notifiable;
    protected $tableName = 'categories';
    
    protected $primaryKey = 'category_id'; 
    public $incrementing = true;
    protected $keyType = 'int';  

    protected $fillable = [
        'category_name',
        'active_flag' 
    ];
    
    protected $guarded = [
        'category_id',
    ];

    public $timestamps = false;
    
}
