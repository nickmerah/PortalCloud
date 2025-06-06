<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Students extends Model
{
    use HasFactory;

    protected $table = 'students_profile';
    public $timestamps = false;
    protected $primaryKey = 'std_id';

    protected $fillable = [
        'surname',
        'firstname',
        'othernames',
        'matric_no',
        'stdprogramme_id',
        'stdprogrammetype_id',
        'stdfaculty_id',
        'stddepartment_id',
        'stdcourse',
        'stdlevel',
    ];

    public function getFullNameAttribute()
    {
        return trim("{$this->surname} {$this->firstname} {$this->othernames}");
    }

    public function programme()
    {
        return $this->belongsTo(Programmes::class, 'stdprogramme_id', 'programme_id');
    }

    public function programmeType()
    {
        return $this->belongsTo(ProgrammeType::class, 'stdprogrammetype_id', 'programmet_id');
    }

    public function departmentOption()
    {
        return $this->belongsTo(DepartmentOptions::class, 'stdcourse', 'do_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'stddepartment_id', 'departments_id');
    }

    public function level()
    {
        return $this->belongsTo(Levels::class, 'stdlevel', 'level_id');
    }

    public function school()
    {
        return $this->belongsTo(Faculty::class, 'stdfaculty_id', 'faculties_id');
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
}
