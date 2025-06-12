<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicantModel extends Model
{

    public function getfeestatus($appid)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('trans_custom1');
        $builder->where('log_id', $appid);
        $builder->where('trans_custom1', 'Paid');
        $builder->where('fee_id', 1);
        $result = $builder->get();
        $arr = $result->getResult();
        return (!empty($arr) && $arr[0]->trans_custom1 == 'Paid') ? 1 : 0;
    }


    public function getafeestatus($appid)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('trans_custom1');
        $builder->where('log_id', $appid);
        $builder->where('trans_custom1', 'Paid');
        $builder->where('fee_id', 2);
        $result = $builder->get();
        $arr = $result->getResult();
        return (!empty($arr) && $arr[0]->trans_custom1 == 'Paid') ? 1 : 0;
    }

    public function getvfeestatus($appid)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('trans_custom1');
        $builder->where('log_id', $appid);
        $builder->where('trans_custom1', 'Paid');
        $builder->where('fee_id', 4);
        $result = $builder->get();
        $arr = $result->getResult();
        return (!empty($arr) && $arr[0]->trans_custom1 == 'Paid') ? 1 : 0;
    }

    public function getclearancetatus($appid)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        $builder->select('eclearance, reject');
        $builder->where('std_logid', $appid);
        $result = $builder->get();
        return $result->getResult();
    }

    public function getappfees($progid, $progtype)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('fees_amt_pass');
        $builder->select('amount');
        $builder->where('item_id', 1);
        $builder->where('prog_id', $progid);
        $builder->where('f_p_time', $progtype);
        $result = $builder->get();
        $arr = $result->getResult();
        return !empty($arr) ? $arr[0]->amount : 0;
    }

    public function getacceptfees($progid, $progtype, $stdstatus)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('fees_amt_pass');
        $builder->select('amount');
        $builder->where('item_id', 2);
        $builder->where('prog_id', $progid);
        $builder->where('f_p_time', $progtype);
        $builder->where('stdstatus', $stdstatus);
        $result = $builder->get();
        $arr = $result->getResult();
        return !empty($arr) ? $arr[0]->amount : 0;
    }

    public function getresultverifyfees()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('fees_amt_pass');
        $builder->select('amount');
        $builder->where('item_id', 4);
        $result = $builder->get();
        $arr = $result->getResult();
        return !empty($arr) ? $arr[0]->amount : 0;
    }

    public function getchangeofcoursefees()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('ofield');
        $builder->select('of_amount');
        $builder->where('of_id', 1);
        $result = $builder->get();
        $arr = $result->getResult();
        return !empty($arr) ? $arr[0]->of_amount : 0;
    }

    public function getconvertfees($progid, $progtype)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('fees_amt_pass');
        $builder->select('amount');
        $builder->where('item_id', 3);
        $builder->where('prog_id', $progid);
        $builder->where('f_p_time', $progtype);
        $result = $builder->get();
        $arr = $result->getResult();
        return !empty($arr) ? $arr[0]->amount : 0;
    }

    public function getcsfeestatus($appid)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('trans_custom1');
        $builder->where('log_id', $appid);
        $builder->where('trans_custom1', 'Paid');
        $builder->where('fee_name', 'Change of Course Fee');
        $result = $builder->get();
        $arr = $result->getResult();
        return (!empty($arr) && $arr[0]->trans_custom1 == 'Paid') ? 1 : 0;
    }

    public function save_transaction($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        return $builder->insert($data);
    }

    public function gettransdetails($tid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->where('trans_no', $tid);
        $builder->where('trans_custom1', 'Pending');
        $result = $builder->get();
        return $result->getResult();
    }

    public function getstate()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('state');
        $result = $builder->get();
        return $result->getResult();
    }

    public function getlga($postData)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('lga');
        $builder->where('state_id', $postData);
        $result = $builder->get();
        return $result->getResult();
    }

    public function updatebiodata($data, $std_id)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        $builder->where('std_logid', $std_id);
        return $builder->update($data);
    }


    public function getprogramme()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme');
        $result = $builder->get();
        return $result->getResult();
    }

    public function getprogrammeconfig()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme_config');
        $result = $builder->get();
        return $result->getResult();
    }

    public function getprogrammetype()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme_type');
        $result = $builder->get();
        return $result->getResult();
    }

    public function getdept_options($pid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dept_options');
        $builder->where('prog_id', $pid);
        $builder->orderBy('programme_option', 'ASC');
        $result = $builder->get();
        return $result->getResult();
    }

    public function getprog_options($pid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme_config');
        $builder->where('programme_type', $pid);
        $result = $builder->get();
        return $result->getResult();
    }

    public function update_course($data, $std_id)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        $builder->where('std_logid', $std_id);
        return $builder->update($data);
    }

    public function get_deptoptions($cid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dept_options');
        $builder->select('CONCAT(aprogramme_name, " ", programme_option) as cos');
        $builder->join('programme', 'programme.programme_id=dept_options.prog_id');
        $builder->where('do_id', $cid);
        $result = $builder->get();
        $arr = $result->getResult();
        return !empty($arr) ? $arr[0]->cos : null;
    }

    public function getpolys()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('polytechnics');
        $builder->orderBy('pname', 'ASC');
        $result = $builder->get();
        return $result->getResult();
    }

    public function save_school($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jeduhistory');
        $builder->insert($data);

        $build = $db->table('jprofile');
        $build->where('std_logid', $data['std_id']);
        return $build->update(['std_custome5' => 1]);
    }

    public function update_school($data, $std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jeduhistory');
        $builder->where('std_id', $std_id);
        return $builder->update($data);
    }

    public function get_eduhistory($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jeduhistory');
        $builder->select('jeduhistory.eh_id,  jeduhistory.ndmatno,jeduhistory.fromdate, jeduhistory.grade, jeduhistory.todate,  polytechnics.pid, polytechnics.pname, dept_options.programme_option, dept_options.do_id');
        $builder->join('polytechnics', 'jeduhistory.schoolname=polytechnics.pid');
        $builder->join('dept_options', 'jeduhistory.cos=dept_options.do_id');
        $builder->where('std_id', $std_id);
        $result = $builder->get();
        return $result->getResult();
    }

    public function save_schools($data, $std_id)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        $builder->where('std_logid', $std_id);
        return $builder->update($data);
    }


    public function getsubjects()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('subjects');
        $builder->select('subjectname');
        $builder->orderBy('subjectname', 'ASC');
        $result = $builder->get();
        return $result->getResult();
    }

    public function getgrades()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('grades');
        $builder->select('gradecode');
        $result = $builder->get();
        return $result->getResult();
    }

    public function save_olevel($data, $sid)
    {
        $db = \Config\Database::connect();

        $build = $db->table('jprofile');
        $build->where('std_logid', $sid);
        $build->update(['std_custome6' => 1]);

        $builder = $db->table('jolevels');
        return $builder->insert($data);
    }


    public function get_olevel($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jolevels');
        $builder->where('std_id', $std_id);
        $result = $builder->get();
        return $result->getResult();
    }

    public function get_jamb($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jamb');
        $builder->where('std_id', $std_id);
        $result = $builder->get();
        return $result->getResult();
    }


    public function save_jamb($data)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('jamb');
        $condition = [
            'std_id' => $data['std_id'],
            'subjectname' => $data['subjectname']
        ];

        $exists = $builder->where($condition)->countAllResults();
        if ($exists) {
            $builder->where($condition)->update($data);
        } else {
            $builder->insert($data);
        }

        $build = $db->table('jprofile');
        $build->where('std_logid', $data['std_id']);
        return $build->update(['std_custome7' => 1]);
    }


    public function getschool()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('faculties');
        $result = $builder->get();
        return $result->getResult();
    }

    public function getcourses($postData)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dept_options');
        $builder->join('departments', 'dept_options.dept_id=departments.departments_id');
        $builder->where('departments.fac_id', $postData);
        $builder->join('programme', 'dept_options.prog_id=programme.programme_id');
        $builder->orderBy('dept_options.programme_option', 'ASC');
        $result = $builder->get();
        return $result->getResult();
    }

    public function getpaydetails($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->where('log_id', $std_id);
        $builder->where('trans_custom1', 'Paid');
        $result = $builder->get();
        return $result->getResult();
    }

    public function getpaydetail($std_id, $transid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('jtransaction.*, SUM(fee_amount) as total_fee_amount');
        $builder->where('log_id', $std_id);
        $builder->where('trans_no', $transid);
        $builder->where('trans_custom1', 'Paid');
        $builder->groupBy('trans_no');
        $result = $builder->get();
        return $result->getResult();
    }

    public function update_transaction($data, $rrr, $orderId)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->where('rrr', $rrr);
        $builder->where('trans_no', $orderId);
        return $builder->update($data);
    }


    public function gettrans_details($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('trans_custom1');
        $builder->where('fee_id', 1);
        $builder->where('log_id', $std_id);
        $result = $builder->get();
        return $result->getResult();
    }


    public function getaccept_details($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('trans_custom1');
        $builder->where('fee_id', 2);
        $builder->where('log_id', $std_id);
        $result = $builder->get();
        return $result->getResult();
    }

    public function getresultverify_details($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('trans_custom1');
        $builder->where('fee_id', 4);
        $builder->where('log_id', $std_id);
        $result = $builder->get();
        return $result->getResult();
    }

    public function getchangeofcourse_details($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('trans_custom1');
        $builder->where('fee_id', 6);
        $builder->where('log_id', $std_id);
        $result = $builder->get();
        return $result->getResult();
    }


    public function getconvert_details($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('trans_custom1');
        $builder->where('fee_id', 3);
        $builder->where('log_id', $std_id);
        $builder->where('trans_custom1', 'Paid');
        $result = $builder->get();
        return $result->getResult();
    }

    public function getappstatus($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        $builder->select('std_custome9');
        $builder->where('std_logid', $std_id);
        $result = $builder->get();
        $arr = $result->getResult();
        return !empty($arr) ? $arr[0]->std_custome9 : 0;
    }

    public function getadmstatus($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        $builder->select('adm_status');
        $builder->where('std_logid', $std_id);
        $result = $builder->get();
        $arr = $result->getResult();
        return !empty($arr) ? $arr[0]->adm_status : 0;
    }

    public function getclearstatus($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        $builder->select('eclearance');
        $builder->where('std_logid', $std_id);
        $result = $builder->get();
        $arr = $result->getResult();
        return !empty($arr) ? $arr[0]->eclearance : 0;
    }

    public function getbiostatus($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        $builder->select('biodata');
        $builder->where('std_logid', $std_id);
        $result = $builder->get();
        $arr = $result->getResult();
        return !empty($arr) ? $arr[0]->biodata : 0;
    }

    public function removecourse($data, $stdid)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        $builder->where('std_logid', $stdid);
        return $builder->update($data);
    }

    public function removeschool($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jeduhistory');
        $builder->where('eh_id', $sid);
        return $builder->delete();
    }

    public function removeolevel($sid)
    {
        $db = \Config\Database::connect();

        $build = $db->table('jprofile');
        $build->where('std_logid', $sid);
        $build->update(['std_custome6' => 0]);

        $builder = $db->table('jolevels');
        $builder->where('std_id', $sid);
        return $builder->delete();
    }

    public function get_school($cid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('faculties');
        $builder->select('faculties_name');
        $builder->where('faculties_id', $cid);
        $result = $builder->get();
        $arr = $result->getResult();
        return !empty($arr) ? $arr[0]->faculties_name : null;
    }


    public function get_progname($cid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme');
        $builder->select('programme_name');
        $builder->join('dept_options', 'dept_options.prog_id=programme.programme_id');
        $builder->where('dept_options.do_id', $cid);
        $result = $builder->get();
        $arr = $result->getResult();
        return !empty($arr) ? $arr[0]->programme_name : null;
    }

    public function remove_jamb_details($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jamb');
        $builder->where('std_id', $sid);
        return $builder->delete();
    }

    public function save_jambs($data, $std_id)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jprofile');
        $builder->where('std_logid', $std_id);
        return $builder->update($data);
    }

    public function gettransid($sid, $id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('trans_no');
        $builder->where('log_id', $sid);
        $builder->where('trans_custom1', 'Pending');
        $builder->where('paychannel', 'Remita');
        $builder->where('fee_id', $id);
        $result = $builder->get();
        $arr = $result->getResult();

        return !empty($arr) ? $arr[0]->trans_no : null;
    }

    public function gettransids($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('trans_no');
        $builder->where('log_id', $sid);
        $builder->where('trans_custom1', 'Pending');
        $builder->where('paychannel', 'Remita');
        // $builder->where('rrr', '!=', 'NA');
        $result = $builder->get();
        $arr = $result->getResult();

        return !empty($arr) ? $arr : [];
    }

    public function getctransid($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('trans_no');
        $builder->where('log_id', $sid);
        $builder->where('trans_custom1', 'Pending');
        $builder->where('paychannel', 'Remita');
        $builder->where('fee_id', 6);
        $result = $builder->get();
        $arr = $result->getResult();

        return !empty($arr) ? $arr[0]->trans_no : null;
    }


    public function checkrrr($rrr)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->select('rrr');
        $builder->where('paychannel', 'Remita');
        $builder->where('rrr', $rrr);
        $result = $builder->get();
        $arr = $result->getResult();
        return !empty($arr) ? $arr[0]->rrr : null;
    }

    public function update_trans($data, $rrr, $trans_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jtransaction');
        $builder->where('rrr', $rrr);
        $builder->where('trans_no', $trans_id);
        return $builder->update($data);
    }

    public function get_examdate($cid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dept_options');
        $builder->select('exam_date');
        $builder->where('do_id', $cid);
        $result = $builder->get();
        $arr = $result->getResult();
        return !empty($arr) ? $arr[0]->exam_date : null;
    }

    public function savedocument($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jcertificates');
        return $builder->insert($data);
    }

    public function getUploadedDoc($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jcertificates');
        $builder->where('stdid', $sid);
        $result = $builder->get();
        return $result->getResult();
    }

    public function removedoc($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jcertificates');
        $builder->where('stdid', $sid);
        return $builder->delete();
    }

    public function insertJsonData($jsonData, $requestType)
    {
        if (!is_string($jsonData) || empty($jsonData)) {
            return false;
        }

        try {
            // Check if the JSON data contains HTML tags
            if ($this->containsHtmlTags($jsonData)) {
                $jsonData = '503 Service Unavailable';
            }

            $db = \Config\Database::connect();
            $builder = $db->table('remitalogs');

            // Insert the data and capture the result
            $inserted = $builder->insert([
                'json_data' => $jsonData,
                'requesttype' => $requestType,
            ]);

            return $inserted;
        } catch (\Exception $e) {
            log_message('error', 'Error inserting JSON data: ' . $e->getMessage());
            return false;
        }
    }

    private function containsHtmlTags($string)
    {
        return preg_match('/<[^>]*>/', $string) === 1;
    }
}
