<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    use HasFactory;

    public static array $gradeScale = [
        ['min' => 75, 'max' => 100, 'grade' => 'A', 'point' => 4.00],
        ['min' => 70, 'max' => 74, 'grade' => 'AB', 'point' => 3.50],
        ['min' => 65, 'max' => 69, 'grade' => 'B', 'point' => 3.25],
        ['min' => 60, 'max' => 64, 'grade' => 'BC', 'point' => 3.00],
        ['min' => 55, 'max' => 59, 'grade' => 'C', 'point' => 2.75],
        ['min' => 50, 'max' => 54, 'grade' => 'CD', 'point' => 2.50],
        ['min' => 45, 'max' => 49, 'grade' => 'D', 'point' => 2.25],
        ['min' => 40, 'max' => 44, 'grade' => 'E', 'point' => 2.00],
        ['min' => 0, 'max' => 39, 'grade' => 'F', 'point' => 0.00],
    ];

    public static array $finalCgpaScale = [
        ['min' => 3.50, 'max' => 4.00, 'class' => 'Distinction'],
        ['min' => 3.00, 'max' => 3.49, 'class' => 'Upper Credit'],
        ['min' => 2.50, 'max' => 2.99, 'class' => 'Lower Credit'],
        ['min' => 0.00, 'max' => 2.49, 'class' => 'Pass'],
    ];
    public $timestamps = false;
    protected $table = 'stdresults';
    protected $primaryKey = 'stdresult_id';
    protected $fillable = [
        'matric_no',
        'level_id',
        'stdcourse_id',
        'course_code',
        'course_title',
        'course_unit',
        'cat',
        'exam',
        'std_mark',
        'std_rstatus',
        'cyearsession',
        'cos',
        'semester',
    ];

    public static function getMarkAndGrade($cyearsession, $matric_no, $level_id, $stdcourse_id)
    {
        return self::where('cyearsession', $cyearsession)
            ->where('matric_no', $matric_no)
            ->where('level_id', $level_id)
            ->where('stdcourse_id', $stdcourse_id)
            ->select('std_mark', 'std_rstatus', 'course_unit')
            ->first();
    }

    public static function getGradeAndPoint($score): array
    {
        foreach (self::$gradeScale as $scale) {
            if ($score >= $scale['min'] && $score <= $scale['max']) {
                return [
                    'grade' => $scale['grade'],
                    'point' => $scale['point'],
                ];
            }
        }
        return ['grade' => 'F', 'point' => 0];
    }

    public static function isFinalYear(int $level): bool
    {
        return in_array($level, [2, 4]);
    }

    public static function getGradeLetters(): array
    {
        return array_map(fn($scale) => $scale['grade'], self::$gradeScale);
    }

    public function student()
    {
        return $this->belongsTo(Students::class, 'matric_no');
    }

    public function level()
    {
        return $this->belongsTo(Levels::class, 'level_id');
    }
}
