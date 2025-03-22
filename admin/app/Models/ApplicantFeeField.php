<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantFeeField extends Model
{
    use HasFactory;

    protected $primaryKey = 'field_id';
    public $timestamps = false;
    protected $table = 'field_pass';

    protected $fillable = ['field_id', 'field_name'];
}
