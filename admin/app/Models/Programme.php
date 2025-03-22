<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    use HasFactory;

    protected $table = 'programme';
    protected $primaryKey = 'programme_id';
    public $timestamps = false;

    protected $fillable = [
        'programme_name',
        'aprogramme_name',
    ];

    public function courses()
    {
        return $this->hasMany(DeptOption::class, 'programme_id', 'prog_id');
    }
}
