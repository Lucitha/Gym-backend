<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class InventoryLogs extends Model
{
    //
    use HasFactory,Notifiable;
    protected $table ='inventory_logs';
    protected $primaryKey='inventory_log_id';
    public $timestamps=false;
    protected $fillable=[
        'active_flag',
        'action_date',
        'description',
        'inventory_id',
        'creation_date'
    ];
    protected $guarded=[
        'inventory_log_id'
    ];
}
