<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'trans_id';
    public $timestamps = false;
    protected $table = 'ctransaction';

    protected $fillable = ['programme_id'];

    public function fees(): BelongsTo
    {
        return $this->belongsTo(ClearanceFeeField::class, 'fee_id', 'field_id');
    }

    public function clearanceStudents(): BelongsTo
    {
        return $this->belongsTo(ClearanceProfile::class, 'log_id', 'csid');
    }
}
