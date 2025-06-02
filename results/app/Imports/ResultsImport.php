<?php

namespace App\Imports;

use App\Models\Results;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Courses;
use Illuminate\Validation\ValidationException;

class ResultsImport implements ToModel, WithHeadingRow, WithStartRow
{

	/**
	 * Define the starting row for the import.
	 * This will skip the first 5 rows.
	 *
	 * @return int
	 */
	public function startRow(): int
	{
		return 6; // Skips the first 5 rows (starts from row 6)
	}

	public function model(array $row)
	{

		$integerKeysExist = array_filter(array_keys($row), fn($key) => is_int($key));

		if (empty($integerKeysExist)) {
			throw ValidationException::withMessages([
				'file' => 'Oops! The result you uploaded is not in the right template.',
			]);
		}

		$regno = $row[1];
		$cat = $row[2] ?? 0;
		$exam = $row[3] ?? 0;
		$score = $cat + $exam;

		$courseId = request()->all()['courses'];
		$course = Courses::where('thecourse_id', $courseId)
			->select('thecourse_code', 'thecourse_title', 'thecourse_unit')
			->first();

		//input result
		$results = Results::firstOrNew([
			'matric_no' => $regno,
			'level_id' => request()->all()['clevel'],
			'semester' => request()->all()['semester'],
			'stdcourse_id' => $courseId,
			'course_code' => $course->thecourse_code,
			'course_title' => $course->thecourse_title,
			'course_unit' => $course->thecourse_unit,
			'cyearsession' => request()->all()['sess'],
			'cos' => request()->all()['courseofstudy'],
			'semester' => request()->all()['semester'],
		]);

		$results->fill([
			'cat' => $cat,
			'exam' => $exam,
			'std_rstatus' => Results::getGradeAndPoint($score)['grade'],
			'std_mark' => $score,
		]);

		$results->save();

		Results::where('matric_no', '=', 'NA')->delete();

		return;
	}
}
