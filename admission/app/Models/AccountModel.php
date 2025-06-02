<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table = 'jlogin';

    protected $primaryKey = 'log_id';

    protected $allowedFields = ['log_surname', 'log_firstname', 'log_othernames', 'log_username', 'log_email', 'log_password', 'log_gsm', 'datereg'];

    protected $validationRules    = [
        'log_username'     => 'alpha_numeric_space|is_unique[jlogin.log_username]',
        'log_email'        => 'required|valid_email|is_unique[jlogin.log_email]',
        'log_password'     => 'required|min_length[4]',
        'log_surname' =>  'required|alpha_numeric_space',
        'log_firstname' =>  'required|alpha_numeric_space',
        'log_othernames' =>   'required|alpha_numeric_space',
        'log_gsm' =>   'required|alpha_numeric_space'

    ];

    protected $validationMessages = [
        'log_email'        => [
            'is_unique' => 'Sorry. That email has already been taken. Please choose another.',

        ]
    ];

    public function getSchoolName()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('schoolinfo');
        $builder->select('schoolname');
        $result = $builder->get();
        $arr =  $result->getResult();
        return   $arr[0]->schoolname;
    }


    public function authreg($appno)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jambapplicants');
        $builder->select('pid, fullname,  jambno');
        $builder->where('jambno', $appno);
        $builder->where('status', 0);
        $result = $builder->get();
        return $result->getResult();
    }


    public function create_account($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jlogin');
        if ($builder->insert($data)) {
            return $db->insertID();
        } else {
            return false;
        }
    }

    public function create_std_account($datas)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        if ($builder->insert($datas)) {


            return true;
        } else {
            return false;
        }
    }

    public function getnos($prog, $ptid, $sess, $prefix, $prefixType)
    {
        $prefixs = $prefix . $prefixType . $sess;

        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        $builder->where('stdprogramme_id', $prog);
        $builder->where('std_programmetype', $ptid);
        $builder->like('app_no', $prefixs, 'after');
        $builder->orderBy('app_no', 'DESC');
        $result = $builder->get();
        $arr =  $result->getResult();
        $nos = empty($arr) ? 0 : substr($arr[0]->app_no, 9);

        $genNumber =    str_pad($nos + 1, 6, "0", STR_PAD_LEFT);
        return  $prefixs . $genNumber;
    }

    public function getsess()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('j_current_session');
        $builder->select('cs_session');
        $builder->where('status', 'current');
        $result = $builder->get();
        $arr =  $result->getResult();
        return   $arr[0]->cs_session;
    }

    public function getconversion()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('portal_status');
        $builder->select('convert_status');
        $result = $builder->get();
        $arr =  $result->getResult();
        return    $arr[0]->convert_status;
    }


    public function getstdid($appno)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jlogin');
        $builder->select('log_id');
        $builder->where('log_username', $appno);
        $result = $builder->get();
        $arr =  $result->getResult();
        return      $arr[0]->log_id;
    }

    public function getjambdetail($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jambapplicants');
        $builder->join('programme', 'jambapplicants.prog=programme.programme_id');
        $builder->join('programme_type', 'jambapplicants.progtype=programme_type.programmet_id');
        $builder->where('jambno', $sid);
        $result = $builder->get();
        return $result->getResult();
    }


    public function getacctdetail($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        $builder->join('programme', 'jprofile.stdprogramme_id=programme.programme_id');
        $builder->join('programme_type', 'jprofile.std_programmetype=programme_type.programmet_id');
        $builder->join('dept_options', 'jprofile.stdcourse=dept_options.do_id');
        $builder->where('std_logid', $sid);
        $result = $builder->get();
        return $result->getResult();
    }

    public function getacctdetails($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        $builder->select('
            jprofile.*, 
            state.state_name, 
            lga.lga_name, 
            programme.programme_name, 
             programme.programme_id,
            programme.aprogramme_name, 
            dept1.programme_option , 
            dept2.programme_option as secondchoice,
            programme_type.programmet_name
            ');
        $builder->join('state', 'jprofile.state_of_origin=state.state_id');
        $builder->join('lga', 'jprofile.local_gov=lga.lga_id');
        $builder->join('programme', 'jprofile.stdprogramme_id=programme.programme_id');
        $builder->join('dept_options AS dept1', 'jprofile.stdcourse = dept1.do_id', 'left');
        $builder->join('dept_options AS dept2', 'jprofile.std_course = dept2.do_id', 'left');
        $builder->join('programme_type', 'jprofile.std_programmetype=programme_type.programmet_id');
        $builder->where('std_logid', $sid);
        $result = $builder->get();
        return $result->getResult();
    }

    public function getskool($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('faculties');
        $builder->select('faculties.faculties_name');
        $builder->join('departments', 'departments.fac_id = faculties.faculties_id');
        $builder->join('dept_options', 'dept_options.dept_id=departments.departments_id');
        $builder->where('dept_options.do_id', $sid);
        $result = $builder->get();
        return $result->getResult();
    }

    public function getrrr($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('rrr');
        $builder->where('log_id', $sid);
        $result = $builder->get();
        return $result->getResult();
    }

    public function update_pass($rdata, $std_id, $appno)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jlogin');
        $builder->where('log_id', $std_id);
        $builder->where('log_username', $appno);
        if ($builder->update($rdata)) {
            return true;
        } else {
            return false;
        }
    }

    public function appendreg_date()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('schoolinfo');
        $builder->select('appendreg_date');
        $result = $builder->get();
        $arr =  $result->getResult();
        return    $cs_session =  $arr[0]->appendreg_date;
    }


    public function appmarkuee()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('schoolinfo');
        $builder->select('appmarkuee');
        $result = $builder->get();
        $arr =  $result->getResult();
        return    $cs_session =  $arr[0]->appmarkuee;
    }

    public function pumeenddate()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('schoolinfo');
        $builder->select('pumeenddate');
        $result = $builder->get();
        $arr =  $result->getResult();
        return    $cs_session =  $arr[0]->pumeenddate;
    }


    public function appstartdate()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('schoolinfo');
        $builder->select('appstartdate');
        $result = $builder->get();
        $arr =  $result->getResult();
        return    $cs_session =  $arr[0]->appstartdate;
    }


    public function appenddate()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('schoolinfo');
        $builder->select('appenddate');
        $result = $builder->get();
        $arr =  $result->getResult();
        return   $arr[0]->appenddate;
    }

    public function portalclosing()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('portal_status');
        $builder->select('p_status');
        $result = $builder->get();
        $arr =  $result->getResult();
        return    $arr[0]->p_status;
    }

    public function updatepassport($data, $std_id)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        $builder->where('std_logid', $std_id);
        if ($builder->update($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function saveresponse($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('remita_response');
        if ($builder->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update_transactions($data, $trans_no)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->where('trans_no', $trans_no);
        if ($builder->update($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function getprogrammetype($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme');
        $builder->select('aprogramme_name');
        $builder->where('programme_id', $sid);
        $result = $builder->get();
        $arr =  $result->getResult();
        return     $arr[0]->aprogramme_name;
    }

    public function getprogrammeTypeName($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme_type');
        $builder->select('programmet_aname');
        $builder->where('programmet_id', $sid);
        $result = $builder->get();
        $arr =  $result->getResult();
        return     $arr[0]->programmet_aname;
    }

    public function getprogramme()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme');
        $builder->select('programme_id,programme_name,aprogramme_name');
        $result = $builder->get();
        return   $result->getResult();
    }

    public function getCos($progId, $progTypeId)
    {
        $db = \Config\Database::connect();
        $db->query("SET SESSION sql_mode = ''");
        $builder = $db->table('dept_options');
        $builder->select('do_id, programme_option');
        $builder->where('prog_id', $progId);

        if ($progTypeId != 2) {
            $builder->where('d_status', 1);
        }

        if ($progTypeId == 2) {
            $builder->where('prog_option', 0);
            $builder->where('d_status_pt', 1);
        }

        $builder->orderBy('programme_option', 'ASC');
        $result = $builder->get();
        return $result->getResult();
    }

    public function getprogrammeTypes()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme_type');
        $builder->select('programmet_id,programmet_name');
        $builder->where('pt_status', 1);
        $result = $builder->get();
        return  $result->getResult();
    }

    public function checkIfCosIsDisabled($progtype, $cos, $cos_two)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dept_options');
        $builder->groupStart()
            ->where('do_id', $cos)
            ->orWhere('do_id', $cos_two)
            ->groupEnd();
        if ($progtype == 1) {
            $builder->where('d_status', 0);
        } else {
            $builder->where('d_status_pt', 0);
        }

        $result = $builder->get();
        return $result->getNumRows() > 0;
    }
}
