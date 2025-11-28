<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class SubscriptionStatus extends Model
{
    //
    use HasFactory,Notifiable;
    protected $table ='subscription_status';
    protected $primaryKey='subscription_status_id';
    public $timestamps=false;

    protected $fillable=[
        'subscription_status',
        'active_flag'
    ];
    protected $guarded=[
        'subscription_status_id'
    ];
}
