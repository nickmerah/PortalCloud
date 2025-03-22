<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    use HasFactory;

    protected $primaryKey = 'hid';
    public $timestamps = false;
    protected $table = 'hostels';

    public function rooms()
    {
        return $this->hasMany(HostelRoom::class, 'hostelid', 'hid');
    }

    public function ofee()
    {
        return $this->belongsTo(StudentOFeeField::class, 'related_ofee_id', 'of_id');
    }
}
