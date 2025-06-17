<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'stdprofile';
    protected $primaryKey = 'std_id';
    protected $fillable = [
        'std_logid',
        'matric_no',
        'surname',
        'firstname',
        'othernames',
        'gender',
        'marital_status',
        'birthdate',
        'matset',
        'local_gov',
        'state_of_origin',
        'religion',
        'nationality',
        'contact_address',
        'student_email',
        'student_homeaddress',
        'student_mobiletel',
        'std_genotype',
        'std_bloodgrp',
        'std_pc',
        'next_of_kin',
        'nok_address',
        'nok_tel',
        'stdprogramme_id',
        'stdprogrammetype_id',
        'stdfaculty_id',
        'stddepartment_id',
        'stdcourse',
        'stdlevel',
        'std_admyear',
        'std_photo',
        'cs_status',
        'std_status',
        'student_status',
        'promote_status'
    ];

    public function programme()
    {
        return $this->belongsTo(Programme::class, 'stdprogramme_id', 'programme_id');
    }

    public function programmeType()
    {
        return $this->belongsTo(ProgrammeType::class, 'stdprogrammetype_id', 'programmet_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'stdlevel', 'level_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'stddepartment_id', 'departments_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'stdfaculty_id', 'faculties_id');
    }

    public function stdcourseOption(): BelongsTo
    {
        return $this->belongsTo(DeptOption::class, 'stdcourse', 'do_id');
    }

    public function stateor(): BelongsTo
    {
        return $this->belongsTo(StateOfOrigin::class, 'state_of_origin', 'state_id');
    }

    public function lga(): BelongsTo
    {
        return $this->belongsTo(Lga::class, 'local_gov', 'lga_id');
    }

    public function deptOption()
    {
        return $this->hasOne(DeptOption::class, 'do_id', 'stdcourse');
    }

    public function getGenderByLogId($std_logid)
    {
        return $this->where('std_logid', $std_logid)->value('gender');
    }

    public function courseRegs()
    {
        return $this->hasMany(CourseRegistration::class, 'log_id', 'std_logid');
    }

    public function getStudentIdByLogId($std_logid)
    {
        return $this->where('std_logid', $std_logid)->value('cs_status');
    }

    public function setSurnameAttribute($value)
    {
        $this->attributes['surname'] = strtoupper($value);
    }

    public function setFirstnameAttribute($value)
    {
        $this->attributes['firstname'] = strtoupper($value);
    }

    public function setOthernamesAttribute($value)
    {
        $this->attributes['othernames'] = strtoupper($value);
    }

    public function setMatricNoAttribute($value)
    {
        $this->attributes['matric_no'] = strtoupper($value);
    }

    public function setStudentEmailAttribute($value)
    {
        $this->attributes['student_email'] = strtoupper($value);
    }

    public function getLgaNameByLogId($std_logid)
    {
        return $this->join('lga', 'lga_id', '=', 'local_gov')
            ->where('std_logid', $std_logid)
            ->value('lga_name');
    }
}
