<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFeeField extends Model
{
    use HasFactory;

    protected $primaryKey = 'field_id';
    public $timestamps = false;
    protected $table = 'field';

    protected $fillable = ['field_id', 'field_name'];
}
