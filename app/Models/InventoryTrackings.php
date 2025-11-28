<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class InventoryTrackings extends Model
{
    //
    use HasFactory,Notifiable;
    protected $table ='inventory_trackings';
    protected $primaryKey='inventory_tracking_id';
    public $timestamps=false;
    protected $fillable=[];
    protected $guarded=[
        'inventory_tracking_id'
    ];

}
