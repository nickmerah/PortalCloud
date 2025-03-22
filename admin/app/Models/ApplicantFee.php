<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantFee extends Model
{
    use HasFactory;

    protected $primaryKey = 'fee_id';
    public $timestamps = false;
    protected $table = 'fees_amt_pass';

    protected $fillable = ['item_id', 'amount', 'prog_id', 'f_p_time'];

    public function fees(): BelongsTo
    {
        return $this->belongsTo(ApplicantFeeField::class, 'item_id', 'field_id');
    }

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class, 'prog_id', 'programme_id');
    }

    public function programmeType(): BelongsTo
    {
        return $this->belongsTo(ProgrammeType::class, 'f_p_time', 'programmet_id');
    }
}
