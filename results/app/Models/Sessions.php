<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    public $timestamps = false;
    protected $table = 'stdresult_session';
    protected $primaryKey = 'cs_id';
}
