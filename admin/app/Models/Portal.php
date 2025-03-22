<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portal extends Model
{
    use HasFactory;

    protected $primaryKey = 'do_id';
    public $timestamps = false;
    protected $table = 'portal_status';

    protected $fillable = [
        'p_name',
        'prog_type',
        'p_status',
        'prog_type',
        'p_message',
    ];

    public function programmeType(): BelongsTo
    {
        return $this->belongsTo(ProgrammeType::class, 'prog_type', 'programmet_id');
    }
}
