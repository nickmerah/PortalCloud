<?php

namespace App\Models;

use App\Imports\ResultsImport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Results extends Model
{
	use HasFactory;

	protected $table = 'stdresults';
	public $timestamps = false;
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

	public function student()
	{
		return $this->belongsTo(Students::class, 'matric_no');
	}

	public function level()
	{
		return $this->belongsTo(Levels::class, 'level_id');
	}

	public static function getMarkAndGrade($cyearsession, $matric_no, $level_id, $stdcourse_id)
	{
		return self::where('cyearsession', $cyearsession)
			->where('matric_no', $matric_no)
			->where('level_id', $level_id)
			->where('stdcourse_id', $stdcourse_id)
			->select('std_mark', 'std_rstatus', 'course_unit')
			->first();
	}

	public static function getGradeAndPoint($score)
	{
		return match (true) {
			$score >= 75 && $score <= 100 => ['grade' => 'A',  'point' => 4.00],
			$score >= 70 => ['grade' => 'AB', 'point' => 3.50],
			$score >= 65 => ['grade' => 'B',  'point' => 3.25],
			$score >= 60 => ['grade' => 'BC', 'point' => 3.00],
			$score >= 55 => ['grade' => 'C',  'point' => 2.75],
			$score >= 50 => ['grade' => 'CD', 'point' => 2.50],
			$score >= 45 => ['grade' => 'D',  'point' => 2.25],
			$score >= 40 => ['grade' => 'E',  'point' => 2.00],
			default       => ['grade' => 'F',  'point' => 0.00],
		};
	}
}
