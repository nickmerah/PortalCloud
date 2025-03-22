<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammeType extends Model
{
    use HasFactory;

    protected $table = 'programme_type';
    protected $primaryKey = 'programmet_id';
    public $timestamps = false;

    protected $fillable = [
        'programmet_name',
        'd_status',
    ];
}
