<?php
namespace App\Models;
use CodeIgniter\Model;

class ApplicantModel extends Model
{

  public function getfeestatus($appid)
	 {

        $db = \Config\Database::connect();
		$builder = $db->table('transaction_app');
		$builder->select('trans_custom1');
		$builder->where('log_id',$appid);
		$builder->where('trans_custom1','Paid');
		$builder->where('fee_id',1);
		$result= $builder->get();
        $arr =  $result->getResult();
		if  ($arr[0]->trans_custom1 == 'Paid'){
			return 1;
		}else{
			return 0;
		}


    }
    
    
    public function getafeestatus($appid)
	 {

        $db = \Config\Database::connect();
		$builder = $db->table('transaction_app');
		$builder->select('trans_custom1');
		$builder->where('log_id',$appid);
		$builder->where('trans_custom1','Paid');
		$builder->where('fee_id',2);
		$result= $builder->get();
        $arr =  $result->getResult();
		if  ($arr[0]->trans_custom1 == 'Paid'){
			return 1;
		}else{
			return 0;
		}


    }


	 public function getappfees($progid, $progtype)
	 {

        $db = \Config\Database::connect();
		$builder = $db->table('fees_amt_pass');
		$builder->select('amount');
		$builder->where('item_id',1);
		$builder->where('prog_id',$progid);
		$builder->where('f_p_time',$progtype);
		$result= $builder->get();
        $arr =  $result->getResult();
		return $arr[0]->amount ;



    }
    
    public function getacceptfees($progid, $progtype)
	 {

        $db = \Config\Database::connect();
		$builder = $db->table('fees_amt_pass');
		$builder->select('amount');
		$builder->where('item_id',2);
		$builder->where('prog_id',$progid);
		$builder->where('f_p_time',$progtype);
		$result= $builder->get();
        $arr =  $result->getResult();
		return $arr[0]->amount ;



    }

public function getconvertfees($progid, $progtype)
	 {

        $db = \Config\Database::connect();
		$builder = $db->table('fees_amt_pass');
		$builder->select('amount');
		$builder->where('item_id',3);
		$builder->where('prog_id',$progid);
		$builder->where('f_p_time',$progtype);
		$result= $builder->get();
        $arr =  $result->getResult();
		return $arr[0]->amount ;



    }
	public function getcsfeestatus($appid)
	 {

        $db = \Config\Database::connect();
		$builder = $db->table('transaction_app');
		$builder->select('trans_custom1');
		$builder->where('log_id',$appid);
		$builder->where('trans_custom1','Paid');
		$builder->where('fee_name','Change of Course Fee');
		$result= $builder->get();
        $arr =  $result->getResult();
		if  ($arr[0]->trans_custom1 == 'Paid'){
			return 1;
		}else{
			return 0;
		}


    }

 public function save_transaction($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('transaction_app');
        if($builder->insert($data))
        {
			return true;
        }
        else
        {
            return false;
        }
    }

	public function gettransdetails($rrr)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transaction_app');
        $builder->where('trans_no',$rrr);
		$builder->where('trans_custom1','Pending');
        $result=$builder->get();
        return $result->getResult();
    }

    public function gettransactiondetails($rrr)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transaction_app');
        $builder->where('trans_no',$rrr);
        $result=$builder->get();
        return $result->getResult()[0];
    }

	public function getstate()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('state');
        $result=$builder->get();
        return $result->getResult();
    }

	public function getlga($postData)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('lga');
        $builder->where('state_id',$postData);
		$result=$builder->get();
        return $result->getResult();
    }

    public function getstateid($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('state');
        $builder->select('state_id');
        $builder->where('state_name',$sid);
		$result=$builder->get();
        $arr =  $result->getResult();
		return $arr[0]->state_id ;
    }

	 public function updatebiodata($data, $std_id)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('application_profile');
		$builder->where('std_logid',$std_id);
        if($builder->update($data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function updateapplogin($data, $std_id)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('applogin');
		$builder->where('log_id',$std_id);
        if($builder->update($data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

  public function getprogramme()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme');
        $result=$builder->get();
        return $result->getResult();
    }

	public function getprogrammeconfig()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme_config');
        $result=$builder->get();
        return $result->getResult();
    }

     public function getprogrammetype()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme_type');
        $result=$builder->get();
        return $result->getResult();
    }

	public function getdept_options($pid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dept_options');
		$builder->where('prog_id',$pid);
		$builder->orderBy('programme_option','ASC');
        $result=$builder->get(); 
        return $result->getResult();
    }

	public function getprog_options($pid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme_config');
		$builder->where('programme_type',$pid);
        $result=$builder->get();
        return $result->getResult();
    }

	 public function update_course($data, $std_id)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('application_profile');
		$builder->where('std_logid',$std_id);
        if($builder->update($data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

  public function get_deptoptions($cid)
    {
        $db = \Config\Database::connect();
		$builder = $db->table('dept_options');
		$builder->select('CONCAT(aprogramme_name, " ", programme_option) as cos');
		$builder->join('programme','programme.programme_id=dept_options.prog_id');
		$builder->where('do_id',$cid);
		$result= $builder->get();
         $arr =  $result->getResult();

		return    $arr[0]->cos ;
    }

	public function getpolys()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('polytechnics');
        $builder->orderBy('pname','ASC');
        $result=$builder->get();
        return $result->getResult();
    }
	public function save_school($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('eduhistory');
        if($builder->insert($data))
        {
			return true;
        }
        else
        {
            return false;
        }
    }

	public function get_eduhistory($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('eduhistory');
		$builder->select('eduhistory.eh_id,  eduhistory.ndmatno,eduhistory.fromdate, eduhistory.todate,   
        eduhistory.organization,  eduhistory.address,  eduhistory.itdatefrom,  eduhistory.itdateto, polytechnics.pname, dept_options.programme_option');
        $builder->join('polytechnics','eduhistory.schoolname=polytechnics.pid');
        $builder->join('dept_options','eduhistory.cos=dept_options.do_id');
        $builder->where('std_id',$std_id);
        $result=$builder->get();
        return $result->getResult();

    }

	 public function save_schools($data, $std_id)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('application_profile');
		$builder->where('std_logid',$std_id);
        if($builder->update($data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

	 public function getexamtypes($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('eduhistory');
		$builder->select('certificates.certname');
        $builder->join('certificates','eduhistory.certname=certificates.id');
        $builder->where('eduhistory.std_id',$std_id);
		$builder->where('certificates.etype','OL');
        $result=$builder->get();
        return $result->getResult();


    }

	public function getsubjects()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('subjects');
		$builder->select('subjectname');
		$builder->orderBy('subjectname','ASC');
        $result=$builder->get();
        return $result->getResult();
    }

	public function getgrades()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('grades');
		$builder->select('gradecode');
        $result=$builder->get();
        return $result->getResult();
    }

	public function save_olevel($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('olevels');
        if($builder->insert($data))
        {
			return true;
        }
        else
        {
            return false;
        }
    }
    public function save_jamb($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('jamb');
        if($builder->insert($data))
        {
			return true;
        }
        else
        {
            return false;
        }
    }

	public function get_olevel($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('olevels');
		$builder->where('std_id',$std_id);
        $result=$builder->get();
        return $result->getResult();

    }

    public function get_jamb_olevel($jambno)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('screeningdata');
		$builder->where('jambno',$jambno);
        $result=$builder->get();
        return $result->getResult();

    }

    	public function get_jamb($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jambapplicants');
		$builder->where('jambno',$sid);
        $result=$builder->get();
        return $result->getResult();

    }




	public function getschool()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('faculties');
        $result=$builder->get();
        return $result->getResult();
    }

	public function getcourses($postData)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dept_options');
		$builder->join('departments','dept_options.dept_id=departments.departments_id');
        $builder->where('departments.fac_id',$postData);
        $builder->join('programme','dept_options.prog_id=programme.programme_id');
        $builder->orderBy('dept_options.programme_option', 'ASC');
		$result=$builder->get();
        return $result->getResult();
    }

	public function getpaydetails($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transaction_app');
        $builder->where('log_id',$std_id);
		$builder->where('trans_custom1','Paid');
        $builder->orderBy('t_date', 'DESC');
        $result=$builder->get();
        return $result->getResult();
    }

	public function update_transaction($data, $rrr)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('transaction_app');
		$builder->where('rrr',$rrr);
        if($builder->update($data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }


	public function gettrans_details($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transaction_app');
		//$builder->select('trans_custom1');
		//$builder->where('fee_id',1);
        $builder->where('log_id',$std_id);
		$builder->where('trans_custom1','Paid');
		$result=$builder->get();
        return $result->getResult();
    }


public function getaccept_details($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transaction_app');
		$builder->select('trans_custom1');
		$builder->where('fee_id',2);
        $builder->where('log_id',$std_id);
		$builder->where('trans_custom1','Paid');
		$result=$builder->get();
        return $result->getResult();
    }
    
    
    public function getconvert_details($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transaction_app');
		$builder->select('trans_custom1');
		$builder->where('fee_id',3);
        $builder->where('log_id',$std_id);
		$builder->where('trans_custom1','Paid');
		$result=$builder->get();
        return $result->getResult();
    }

	 public function getappstatus($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('application_profile');
		$builder->select('std_custome9');
        $builder->where('std_logid',$std_id);
		$result=$builder->get();
        $arr =  $result->getResult();
		return      $arr[0]->std_custome9;
    }
    
    public function getadmstatus($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('application_profile');
		$builder->select('adm_status');
        $builder->where('std_logid',$std_id);
		$result=$builder->get();
        $arr =  $result->getResult();
		return      $arr[0]->adm_status;
    }
    
    public function getclearstatus($std_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('application_profile');
		$builder->select('eclearance');
        $builder->where('std_logid',$std_id);
		$result=$builder->get();
        $arr =  $result->getResult();
		return      $arr[0]->eclearance;
    }

    public function getbiostatus($std_id)
     {
         $db = \Config\Database::connect();
         $builder = $db->table('application_profile');
 		$builder->select('biodata');
         $builder->where('std_logid',$std_id);
 		$result=$builder->get();
         $arr =  $result->getResult();
 		return      $arr[0]->biodata;
     }

    public function removecourse($data,$stdid)
    {

         $db = \Config\Database::connect();
        $builder = $db->table('application_profile');
		$builder->where('std_logid',$stdid);
		if($builder->update($data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

	public function removeschool($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('eduhistory');
        $builder->where('eh_id',$sid);
        if($builder->delete())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

	public function removeolevel($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('olevels');
        $builder->where('o_id',$sid);
        if($builder->delete())
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    public function removeallolevel($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('olevels');
        $builder->where('std_id',$sid);
        if($builder->delete())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

   public function get_school($cid)
    {
        $db = \Config\Database::connect();
		$builder = $db->table('faculties');
		$builder->select('faculties_name');
		$builder->where('faculties_id',$cid);
		$result= $builder->get();
         $arr =  $result->getResult();
		return      $arr[0]->faculties_name;
    }


	public function get_progname($cid)
    {
        $db = \Config\Database::connect();
		$builder = $db->table('programme');
		$builder->select('programme_name');
		$builder->join('dept_options','dept_options.prog_id=programme.programme_id');
		$builder->where('dept_options.do_id',$cid);
		$result= $builder->get();
         $arr =  $result->getResult();
		return      $arr[0]->programme_name;
    }


    public function get_examdate($cid)
    {
        $db = \Config\Database::connect();
		$builder = $db->table('dept_options');
		$builder->select('examdates');
		$builder->where('dept_options.do_id',$cid);
		$result= $builder->get();
         $arr =  $result->getResult();
		return      $arr[0]->examdates;
    }

    public function remove_jamb_details($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jamb');
        $builder->where('std_id',$sid);
        if($builder->delete())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

	public function save_jambs($data, $std_id)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('application_profile');
		$builder->where('std_logid',$std_id);
        if($builder->update($data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getrrr($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transaction_app');
		$builder->select('trans_no');
		$builder->where('log_id',$sid);
		$builder->where('trans_custom1','Pending');
		$builder->where('paychannel','Remita');
        $result=$builder->get();
        return $result->getResult();
    }

	public function update_rrr($data,$rrr )
    {
       $db = \Config\Database::connect();
        $builder = $db->table('transaction_app');
		$builder->where('trans_no',$rrr);
        if($builder->update($data))
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function getconfirmpaydetail($tid)
    {
       
        $db = \Config\Database::connect();
        $builder = $db->table('transaction_app');
        $builder->where('trans_no',$tid);
		$builder->where('trans_custom1','Paid');
        $result=$builder->get();
        return $result->getResult();
    }

    public function get_admreq($cid)
    {
        $db = \Config\Database::connect();
		$builder = $db->table('dept_options');
		$builder->select('dept_id');
		$builder->where('jamb_option',$cid);
		$result= $builder->get();
         $arr =  $result->getResult();
        $deptid =     $arr[0]->dept_id ;
 
		$builders = $db->table('departments');
		$builders->select('admReq');
		$builders->where('departments_id',$deptid);
		$results = $builders->get();
        $arrs =  $results->getResult();
		return    $arrs[0]->admReq ;
    }

    public function getsubject_details($selsub)
    {
    $db = \Config\Database::connect();
   $builder = $db->table('olevels');
   $builder->select('o_id, subname,  grade, sitting');
   $builder->whereIn('o_id',$selsub);
   $result= $builder->get();

  return  $arr =  $result->getResult();
   }


   public function getjambsubject_details($selsub)
   {
   $db = \Config\Database::connect();
  $builder = $db->table('screeningdata');
  $builder->select('id, subjects,  grades');
  $builder->whereIn('id',$selsub);
  $result= $builder->get();

 return  $arr =  $result->getResult();
  }

   public function gradeWeights()
{
    $db = \Config\Database::connect();
    $builder = $db->table('grades');
    $builder->select('gradecode, points');
    $builder->where('id <', 12);
    $result= $builder->get();
    $gradeWeightsArray =  $result->getResult();
    return  $gradeWeightsArray;
    
}

public function calculateTotalWeightedScore($grades)
{
     
    $gradeWeightsArray =   self::gradeWeights();
    $gradeWeights = [];
    foreach ($gradeWeightsArray as $item) {
        $gradeWeights[$item->gradecode] = $item->points;
    }

    $totalWeightedScore = 0;
    foreach ($grades as $grade) {
        $totalWeightedScore += isset($gradeWeights[$grade]) ? $gradeWeights[$grade] : 0;
    }
    return $totalWeightedScore;
}


public function getjambscore($cid)
{
    $db = \Config\Database::connect();
    $builder = $db->table('application_profile');
    $builder->select('jambno');
    $builder->where('std_logid',$cid);
    $result= $builder->get();
     $arr =  $result->getResult();
    $jambno =     $arr[0]->jambno ;
 
    $builders = $db->table('jambapplicants');
    $builders->select('score');
    $builders->where('jambno',$jambno);
    $results = $builders->get();
    $arrs =  $results->getResult();
    return    $arrs[0]->score ;
}

public function save_screening($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('screening');
        if($builder->insert($data))
        {
			return true;
        }
        else
        {
            return false;
        }
    }

    public function checkScreen($cid)
    {
        $db = \Config\Database::connect();
		$builder = $db->table('screening');
		$builder->where('log_id',$cid);
		$result= $builder->get();
       return  $arr =  $result->getResult();
		      
    }

    public function getscreeningstatus()
    {

        $db = \Config\Database::connect();
		$builder = $db->table('portal_status');
		$builder->select('online_screening');
		$result=$builder->get();
         $arr =  $result->getResult();
		return     $arr[0]->online_screening;
		     
        
    }


}
