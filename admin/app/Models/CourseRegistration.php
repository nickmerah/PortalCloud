<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model
{
    use HasFactory;

    protected $primaryKey = 'stdcourse_id';
    public $timestamps = false;
    protected $table = 'course_reg';

    protected $fillable = ['status', 'remark'];
}
