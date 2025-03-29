<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Applicant extends Model
{
    use HasFactory;

    protected $table = 'jprofile';
    protected $primaryKey = 'std_id';
    public $timestamps = false;

    protected $fillable = [
        'std_logid',
        'app_no',
        'jambno',
        'student_id',
        'surname',
        'firstname',
        'othernames',
        'gender',
        'marital_status',
        'birthdate',
        'home_town',
        'local_gov',
        'state_of_origin',
        'contact_address',
        'student_email',
        'student_homeaddress',
        'student_mobiletel',
        'next_of_kin',
        'nok_address',
        'nok_email',
        'nok_tel',
        'stdfaculty_id',
        'stddepartment_id',
        'stdcourse',
        'std_course',
        'std_programmetype',
        'adm_status',
        'eclearance',
        'reject',
    ];

    public static function applicantsForCurrentSession()
    {
        return self::whereHas('currentSession', function ($query) {
            $query->where('status', 'current');
        })->get();
    }

    public function currentSession()
    {
        return $this->belongsTo(CurrentSession::class, 'appyear', 'cs_session');
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class, 'stdprogramme_id', 'programme_id');
    }

    public function stdcourseOption(): BelongsTo
    {
        return $this->belongsTo(DeptOption::class, 'stdcourse', 'do_id');
    }

    public function std_courseOption(): BelongsTo
    {
        return $this->belongsTo(DeptOption::class, 'std_course', 'do_id');
    }

    public function stateor(): BelongsTo
    {
        return $this->belongsTo(StateOfOrigin::class, 'state_of_origin', 'state_id');
    }

    public function lga(): BelongsTo
    {
        return $this->belongsTo(Lga::class, 'local_gov', 'lga_id');
    }

    public function jamb(): HasMany
    {
        return $this->hasMany(Jamb::class, 'std_id', 'std_logid');
    }

    public function eduhistory(): BelongsTo
    {
        return $this->belongsTo(Eduhistory::class, 'std_logid', 'std_id');
    }

    public function deptOption()
    {
        return $this->hasOne(DeptOption::class, 'do_id', 'stdcourse');
    }

    public static function getApplicantLogStatusByLogId($logid)
    {
        $log_status = DB::table('jlogin')
            ->where('log_id', $logid)
            ->select('log_status')
            ->first();
        if ($log_status) {
            $log_status = $log_status;
        } else {
            $log_status = 0;
        }

        return $log_status;
    }
}
