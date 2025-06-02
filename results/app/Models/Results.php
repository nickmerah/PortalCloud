<?php

namespace App\Models;

use App\Http\Controllers\ResultController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Imports\ResultsImport;

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

	public static function getMark($cyearsession, $matric_no, $level_id, $stdcourse_id)
	{

		return self::where('cyearsession', $cyearsession)
			->where('matric_no', $matric_no)
			->where('level_id', $level_id)
			->where('stdcourse_id', $stdcourse_id)
			->value('std_mark');
	}

	public static function getRemark($courses, $matric_no, $level_id)
	{
		$failedCoursesPerSession = [];

		//get failed course per session
		foreach ($courses as $course) {
			$mark = self::getMark(
				$course->cyearsession,
				$matric_no,
				$level_id,
				$course->course_id
			);

			if ($mark < ResultsImport::PASS_MARK) {
				$failedCoursesPerSession[] = [
					'title' => strtoupper($course->coursetitle),
					'category' => $course->course_category,
				];
			}
		}



		$failedCoreCourses = array_filter($failedCoursesPerSession, function ($course) {
			return $course['category'] === 'core';
		});

		$failedPerSessionCount = count($failedCoreCourses);

		// get 200 level remarks
		if ($level_id >= 2) {

			if ($failedPerSessionCount >= 1) {
				return "REPEAT LEVEL";
			}

			if ($failedPerSessionCount > 2) {
				return "ADVISED TO WITHDRAW";
			}

			if ($failedPerSessionCount > 0) {
				$ctitles = array_column($failedCoursesPerSession, 'title');
				return "TO RESIT: " . implode(' AND ', $ctitles);
			}

			return "PASS";
		}
		return "N/A";
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
