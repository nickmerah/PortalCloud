<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeptOption extends Model
{
    use HasFactory;

    protected $primaryKey = 'do_id';
    public $timestamps = false;
    protected $table = 'dept_options';

    protected $fillable = [
        'dept_id',
        'programme_option',
        'duration',
        'prog_id',
        'deptcode',
        'dept_code',
        'exam_date',
        'exam_time',
        'admletter_date',
        'd_status',
        'prog_option',
        'd_status_pt'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'dept_id', 'departments_id');
    }

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class, 'prog_id', 'programme_id');
    }
}
