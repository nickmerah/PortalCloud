<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentOFeeField extends Model
{
    use HasFactory;

    protected $primaryKey = 'of_id';
    public $timestamps = false;
    protected $table = 'ofield';

    protected $fillable = ['of_id', 'ofield_name'];
}
