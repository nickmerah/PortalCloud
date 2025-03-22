<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'trans_id';
    public $timestamps = false;
    protected $table = 'rtransaction';
}
