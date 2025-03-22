<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClearanceFeePack extends Model
{
    use HasFactory;

    protected $primaryKey = 'pack_id';
    public $timestamps = false;
    protected $table = 'cfeepack';

    protected $fillable = ['pack_id', 'pack_name'];
}
