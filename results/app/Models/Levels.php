<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Levels extends Model
{
    use HasFactory;

    protected $table = 'stdlevel';
    protected $primaryKey = 'level_id';

    function getLevelName($levelId)
    {
        $level = self::find($levelId);
        return $level ? $level->level_name : null;
    }
}
