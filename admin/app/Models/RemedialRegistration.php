<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemedialRegistration extends Model
{
    use HasFactory;

    protected $table = 'remedialcourse_reg';
    protected $primaryKey = 'id';
    public $timestamps = false;

    //protected $fillable = false;

    public function currentSession()
    {
        return $this->belongsTo(RemedialSession::class, 'cyearsession', 'cs_session');
    }

    public function remedial()
    {
        return $this->belongsTo(Remedial::class, 'std_id', 'id');
    }
}
