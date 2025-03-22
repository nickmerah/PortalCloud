<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroups extends Model
{
    use HasFactory;

    protected $primaryKey = 'group_id';
    public $timestamps = false;
    protected $table = 'group_table';

    protected $fillable = ['group_name', 'group_description'];
}
