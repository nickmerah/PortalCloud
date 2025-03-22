<?php

namespace App\Policies;

use Illuminate\Support\Facades\DB;


class MenuPolicy
{
    protected function hasAccess($userData, $feature)
    {
        if (!isset($userData['uGroup'])) {
            return false;
        }

        // Query the permissions table to check if the user's group has access to the feature
        return DB::table('permissions')
            ->where('feature', $feature)
            ->where('group_id', $userData['uGroup'])
            ->exists();
    }

    public function accessSettings($userData)
    {
        return $this->hasAccess($userData, 'accessSettings');
    }

    public function accessUsers($userData)
    {
        return $this->hasAccess($userData, 'accessUsers');
    }

    public function accessBiodata($userData)
    {
        return $this->hasAccess($userData, 'accessBiodata');
    }

    public function accessReports($userData)
    {
        return $this->hasAccess($userData, 'accessReports');
    }

    public function accessRegistrationReports($userData)
    {
        return $this->hasAccess($userData, 'accessRegistrationReports');
    }

    public function accessDashboard($userData)
    {
        return $this->hasAccess($userData, 'accessDashboard');
    }

    public function accessAdmissionBiodata($userData)
    {
        return $this->hasAccess($userData, 'accessAdmissionBiodata');
    }

    public function accessHostel($userData)
    {
        return $this->hasAccess($userData, 'accessHostel');
    }

    public function accessStudentPayment($userData)
    {
        return $this->hasAccess($userData, 'accessStudentPayment');
    }

    public function accessClearancePayment($userData)
    {
        return $this->hasAccess($userData, 'accessClearancePayment');
    }

    public function accessRemedialPayment($userData)
    {
        return $this->hasAccess($userData, 'accessRemedialPayment');
    }

    public function accessStudentSummary($userData)
    {
        return $this->hasAccess($userData, 'accessStudentSummary');
    }

    public function accessClearanceSummary($userData)
    {
        return $this->hasAccess($userData, 'accessClearanceSummary');
    }

    public function accessRemedialSummary($userData)
    {
        return $this->hasAccess($userData, 'accessRemedialSummary');
    }

    public function accessCourseRegistration($userData)
    {
        return $this->hasAccess($userData, 'accessCourseRegistration');
    }

    public function accessViewStudentData($userData)
    {
        return $this->hasAccess($userData, 'accessViewStudentData');
    }


    public function getAllPermissions()
    {
        $methods = get_class_methods($this);
        $permissions = [];

        foreach ($methods as $method) {
            if (strpos($method, 'access') === 0) {
                $permissionKey = strtolower(substr($method, 6));
                $permissions[$method] = ucfirst($permissionKey);
            }
        }

        return $permissions;
    }
}
