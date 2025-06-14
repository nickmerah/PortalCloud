<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'subjects';

    protected $fillable = ['subjectcode', 'subjectname'];
}
