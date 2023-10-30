<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class ApiModel extends Model
{
    protected $table = 'application_profile';
    protected $primaryKey = 'std_id';
    //protected $allowedFields = ['app_no','surname'];
}