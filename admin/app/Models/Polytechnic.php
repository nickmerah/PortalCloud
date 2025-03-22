<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polytechnic extends Model
{
    use HasFactory;

    protected $table = 'polytechnics';
    protected $primaryKey = 'pid';
    public $timestamps = false;

    protected $fillable = [];
}
