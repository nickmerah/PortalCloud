<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StdCurrentSession extends Model
{
    use HasFactory;

    protected $table = 'stdcurrent_session';
    protected $primaryKey = 'cs_id';
    public $timestamps = false;

    protected $fillable = [
        'cs_session',
        'start_date',
        'end_date',
        'prog_id',
        'cs_sem',
        'status',
    ];

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class, 'prog_id', 'programme_id');
    }

    public static function getStdCurrentSession($progid = 1)
    {
        $currentSession = self::select('cs_session', 'cs_sem')
            ->where(['status' => 'current', 'prog_id' => $progid])
            ->first();

        return $currentSession ? ['cs_session' => $currentSession->cs_session, 'cs_sem' => $currentSession->cs_sem] : null;
    }
}
