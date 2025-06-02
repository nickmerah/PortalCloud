<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Courses extends Model
{
    use HasFactory;

    protected $table = 'courses';
    public $timestamps = false;
    protected $primaryKey = 'thecourse_id';

    protected $fillable = [
        'thecourse_id ',
        'thecourse_title',
        'thecourse_code',
        'thecourse_unit',
        'prog',
        'prog_type',
        'levels',
        'semester',
        'stdcourse'
    ];
}
