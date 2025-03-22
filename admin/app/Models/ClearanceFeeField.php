<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClearanceFeeField extends Model
{
    use HasFactory;

    protected $primaryKey = 'field_id';
    public $timestamps = false;
    protected $table = 'cfield';

    protected $fillable = ['field_id', 'field_name', 'pack_id'];

    public function pack(): BelongsTo
    {
        return $this->belongsTo(ClearanceFeePack::class, 'pack_id');
    }
}
