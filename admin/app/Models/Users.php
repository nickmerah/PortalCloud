<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $timestamps = false;
    protected $table = 'users';

    protected $fillable = [
        'u_username',
        'u_password',
        'u_surname',
        'u_firstname',
        'u_email',
        'u_status',
        'u_group',
        'u_dept',
        'u_cos',
        'u_prog',
        'u_progtype',
        'lastLogin',
    ];

    public function usergroup(): BelongsTo
    {
        return $this->belongsTo(UserGroups::class, 'u_group', 'group_id');
    }

    protected $hidden = [
        'log_password',
    ];

    public function setUPasswordAttribute($value)
    {

        if (!empty($value) && Hash::needsRehash($value)) {
            $this->attributes['u_password'] = Hash::make($value);
        } else {
            $this->attributes['u_password'] = $value;
        }
    }

    public function getDeptOptionNamesAttribute()
    {
        $deptIds = explode(',', $this->u_dept);

        return DeptOption::whereIn('do_id', $deptIds)->pluck('programme_option')->toArray();
    }

    public function programmeType(): BelongsTo
    {
        return $this->belongsTo(ProgrammeType::class, 'u_progtype', 'programmet_id');
    }

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class, 'u_prog', 'programme_id');
    }

    public function getDepartmentNamesAttribute()
    {
        $deptIds = explode(',', $this->u_cos);

        return Department::whereIn('departments_id', $deptIds)->pluck('departments_name')->toArray();
    }

    public function getLevelNamesAttribute()
    {
        $levelIds = explode(',', $this->u_level);

        return Level::whereIn('level_id', $levelIds)->pluck('level_name')->toArray();
    }

    public function getCosNamesAttribute()
    {
        $deptIds = explode(',', $this->u_cos);

        return DeptOption::whereIn('do_id', $deptIds)->pluck('programme_option')->toArray();
    }
}
