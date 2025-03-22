<?php

namespace App\Models;

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
}
