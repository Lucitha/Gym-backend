<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Inventory extends Model
{
    //
    use HasFactory,Notifiable;
    protected $table ='inventory';
    protected $primaryKey='inventory_id';
    public $timestamps=false;
    protected $fillable=[
        'name',
        'active_flag',
        'brand',
        'model',
        'quantity',
        'description',
        'category_id',
    ];
    protected $guarded=[
        'inventory_id'
    ];


}
