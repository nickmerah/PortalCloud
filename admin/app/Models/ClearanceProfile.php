<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClearanceProfile extends Model
{
    use HasFactory;

    protected $table = 'cprofile';
    protected $primaryKey = 'csid';
    public $timestamps = false;

    protected $fillable = [];


    public function programme()
    {
        return $this->belongsTo(Programme::class, 'prog_id', 'programme_id');
    }

    public function clearanceDept(): BelongsTo
    {
        return $this->belongsTo(DeptOption::class, 'dept_id', 'do_id');
    }

    public function clearanceLevel(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id');
    }
}
