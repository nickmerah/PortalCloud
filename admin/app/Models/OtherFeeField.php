<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherFeeField extends Model
{
    use HasFactory;

    protected $primaryKey = 'of_id';
    public $timestamps = false;
    protected $table = 'ofield';

    protected $fillable = ['of_amount', 'ofield_name', 'of_prog', 'of_status'];
}
