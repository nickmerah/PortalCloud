<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentSession extends Model
{
    use HasFactory;

    protected $table = 'j_current_session';
    protected $primaryKey = 'cs_id';
    public $timestamps = false;

    protected $fillable = [
        'cs_session',
        'start_date',
        'end_date',
        'prog_id',
        'status',
    ];
}
