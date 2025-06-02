<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    protected $table = 'stdcurrent_session';
    public $timestamps = false;
    protected $primaryKey = 'cs_id';
}
