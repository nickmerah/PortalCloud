<?php

namespace App\Helpers;

use App\Models\Audit;
use Illuminate\Support\Facades\Auth;

class AuditHelper
{
    public static function logAudit($action, $tableName, $recordId = null, $oldData = null, $newData = null)
    {
        Audit::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'table_name' => $tableName,
            'record_id' => $recordId,
            'old_data' => $oldData,
            'new_data' => $newData,
        ]);
    }
}
