<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemedialSession extends Model
{
    use HasFactory;

    protected $table = 'rcurrent_session';
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
