<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Settings extends Model
{
    //
    use HasFactory,Notifiable;
    protected $table ='settings';
    protected $primaryKey='setting_id';
    public $timestamps=false;
    protected $fillable=[
        'company',
        'logo',
        'horraires',
        'description',
        'contacts',
        'social_link'

    ];
    protected $guarded=[
        'setting_id'
    ];
}
