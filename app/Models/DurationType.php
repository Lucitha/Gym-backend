<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class DurationType extends Model
{
    //

    use HasFactory,Notifiable;
    protected $table = 'duration_types';
    protected $primaryKey = 'duration_type_id';
    public $timestamps = false;
    protected $fillable = [
        'Duration_type',
        'active_flag'
    ];
    protected $guarded = [
        'duration_type_id'
    ];
}
