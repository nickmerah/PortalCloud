<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'trans_id';
    public $timestamps = false;
    protected $table = 'jtransaction';

    protected $fillable = ['level_name', 'programme_id'];

    public function fees(): BelongsTo
    {
        return $this->belongsTo(ApplicantFeeField::class, 'fee_id', 'field_id');
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class, 'log_id', 'std_logid');
    }
}
