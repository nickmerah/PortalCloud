<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StdTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'trans_id';
    public $timestamps = false;
    protected $table = 'stdtransaction';

    public function fees(): BelongsTo
    {
        return $this->belongsTo(StudentFeeField::class, 'fee_id', 'field_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'log_id', 'std_logid');
    }

    public function transLevel(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'levelid', 'level_id');
    }

    public static function getStdTransactionSessions($feeType = 'fees'): Collection
    {
        return self::select('trans_year')
            ->where(['pay_status' => 'Paid', 'fee_type' => $feeType])
            ->groupBy('trans_year')
            ->orderBy('trans_year', 'DESC')
            ->pluck('trans_year');
    }

    public function stateor(): BelongsTo
    {
        return $this->belongsTo(StateOfOrigin::class, 'appsor', 'state_id');
    }
}
