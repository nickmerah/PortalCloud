<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseRegistration extends Model
{
    use HasFactory;

    protected $primaryKey = 'stdcourse_id';
    public $timestamps = false;
    protected $table = 'course_reg';

    protected $fillable = ['status', 'remark'];


    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'clevel_id', 'level_id');
    }
}
