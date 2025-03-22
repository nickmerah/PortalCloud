<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmittedApplicants extends Model
{
    use HasFactory;

    protected $table = 'admittedapplicants';
    protected $primaryKey = 'pid';
    public $timestamps = false;

    protected $fillable = [
        'appno',
        'course',
        'status',
    ];

    public function applicant()
    {
        return $this->hasOne(Applicant::class, 'app_no', 'appno');
    }
}
