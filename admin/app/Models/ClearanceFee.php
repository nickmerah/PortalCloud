<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClearanceFee extends Model
{
    use HasFactory;

    protected $primaryKey = 'fee_id';
    public $timestamps = false;
    protected $table = 'cfees_amt';

    protected $fillable = ['item_id', 'amount', 'prog_id', 'pack_id'];

    public function fees(): BelongsTo
    {
        return $this->belongsTo(ClearanceFeeField::class, 'item_id', 'field_id');
    }

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class, 'prog_id', 'programme_id');
    }

    public function pack(): BelongsTo
    {
        return $this->belongsTo(ClearanceFeePack::class, 'pack_id');
    }
}
