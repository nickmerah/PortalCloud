<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolInfo extends Model
{
    use HasFactory;

    protected $table = 'schoolinfo';
    protected $primaryKey = 'skid';
    public $timestamps = false;

    protected $fillable = [
        'schoolname',
        'schoolabvname',
        'schooladdress',
        'schoolemail',
        'endreg_date',
        'markuee',
        'appmarkuee',
        'appendreg_date'
    ];
}
