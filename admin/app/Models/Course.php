<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory;

    protected $primaryKey = 'thecourse_id';
    public $timestamps = false;
    protected $table = 'courses';

    protected $fillable = [
        'thecourse_title',
        'thecourse_code',
        'thecourse_unit',
        'prog',
        'prog_type',
        'csession',
        'levels',
        'semester',
        'stdcourse',
    ];

    public function programmeType(): BelongsTo
    {
        return $this->belongsTo(ProgrammeType::class, 'prog_type', 'programmet_id');
    }

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class, 'prog', 'programme_id');
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'levels', 'level_id');
    }

    public function deptOption(): BelongsTo
    {
        return $this->belongsTo(DeptOption::class, 'stdcourse', 'do_id');
    }
}
