<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eduhistory extends Model
{
    use HasFactory;

    protected $table = 'jeduhistory';
    protected $primaryKey = 'eh_id';
    public $timestamps = false;

    protected $fillable = [];

    public function polytechnic()
    {
        return $this->belongsTo(Polytechnic::class, 'schoolname', 'pid');
    }

    public function ndCourse()
    {
        return $this->hasOne(DeptOption::class, 'do_id', 'cos');
    }
}
