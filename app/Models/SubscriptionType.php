<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class SubscriptionType extends Model
{
    //
    use HasFactory,Notifiable;
    protected $table = 'subscription_types';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'duration_type_id',
        'active_flag',
        'creation_date'
    ];
    protected $guarded =[
        'subscription_type_id'
    ];
}