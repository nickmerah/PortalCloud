<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remedial extends Model
{
    use HasFactory;

    protected $table = 'rprofile';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'surname',
        'firstname',
        'othername',
        'matno',
        'pid',
        'cert',
        'level',
        'sess',
        'password',
        'updated_at',
    ];

    public function currentSession()
    {
        return $this->belongsTo(RemedialSession::class, 'sess', 'cs_session');
    }
}
