<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolFee extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'fees_amt';

    protected $fillable = ['field_id', 'amount', 'prog_id', 'level_id', 'resident_status', 'sessionid', 'prog_type', 'semester'];

    public function fees(): BelongsTo
    {
        return $this->belongsTo(StudentFeeField::class, 'field_id');
    }

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class, 'prog_id', 'programme_id');
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function programmeType(): BelongsTo
    {
        return $this->belongsTo(ProgrammeType::class, 'prog_type', 'programmet_id');
    }
}
