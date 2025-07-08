<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentLogin extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'stdlogin';
    protected $primaryKey = 'log_id';
    protected $fillable = [
        'log_username',
        'log_surname',
        'log_firstname',
        'log_othernames',
        'log_email'
    ];

    public function setLogUsernameAttribute($value)
    {
        $this->attributes['log_username'] = strtoupper($value);
    }

    public function setLogSurnameAttribute($value)
    {
        $this->attributes['log_surname'] = strtoupper($value);
    }

    public function setLogFirstnameAttribute($value)
    {
        $this->attributes['log_firstname'] = strtoupper($value);
    }

    public function setLogOthernamesAttribute($value)
    {
        $this->attributes['log_othernames'] = strtoupper($value);
    }

    public function setLogEmailAttribute($value)
    {
        $this->attributes['log_email'] = strtolower($value);
    }

    public function setStudentEmailAttribute($value)
    {
        $this->attributes['student_email'] = strtolower($value);
    }
}
