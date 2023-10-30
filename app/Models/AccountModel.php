<?php 
namespace App\Models;
use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table = 'applogin';

    protected $primaryKey = 'log_id';
    
    protected $allowedFields = ['log_surname', 'log_firstname', 'log_othernames', 'log_username', 'log_email', 'log_password','log_gsm','datereg'];
	
	protected $validationRules    = [
        'log_username'     => 'alpha_numeric_space|is_unique[applogin.log_username]',
        'log_email'        => 'required|valid_email|is_unique[applogin.log_email]',
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
	
	public function authreg($appno)
	 {

        $db = \Config\Database::connect();
		$builder = $db->table('jambapplicants');
		$builder->select('pid, fullname,  jambno');
		$builder->where('jambno',$appno);
		$builder->where('status',0);
		$result= $builder->get();
       return  $arr =  $result->getResult();
		       
		     
        
    }

    public function checkjambno($ptid)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('application_profile');
        $builder->select('jambno');	
        $builder->where('jambno',$ptid);
		
       return   $nos = $builder->countAllResults();
        
    }
	
	
	public function create_account($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('applogin');
        if($builder->insert($data))
        {
			return $db->insertID();
        }
        else
        {
            return false;
        }
    }
	
	public function create_std_account($datas)
    {
 
        $db = \Config\Database::connect();
        $builder = $db->table('application_profile');
        if($builder->insert($datas))
        {
            
	
			return true;
        }
        else
        {
            return false;
        }
    }
	
	public function getnos($ptid, $sess)
    {   
        $prefix = ($ptid == 1 ? "F" : "P").$sess;
        
       $db = \Config\Database::connect();
       $builder = $db->table('application_profile');
       $builder->select('app_no');		
       $builder->where('std_programmetype',$ptid);
       $builder->like('app_no', $prefix, 'after');
       $builder->orderBy('app_no','DESC');
      //     $sql = $builder->getCompiledSelect();
  // echo $sql; exit; 
       $result=$builder->get();
        $arr =  $result->getResult();
    $nos = substr($arr[0]->app_no, 3); 
 
     $genFormNumber =    str_pad($nos+1, 5, "0", STR_PAD_LEFT); 
       return $genFormNumber;
    }
	
	public function getsess()
    {

        $db = \Config\Database::connect();
		$builder = $db->table('app_current_session');
		$builder->select('cs_session');
		$result=$builder->get();
         $arr =  $result->getResult();
		return    $cs_session =  $arr[0]->cs_session;
		     
        
    }
    
    public function getconversion()
    {

        $db = \Config\Database::connect();
		$builder = $db->table('portal_status');
		$builder->select('convert_status');
		$result=$builder->get();
         $arr =  $result->getResult();
		return    $convert_status =  $arr[0]->convert_status;
		     
        
    }
	
	
	 public function getstdid($appno)
	 {

        $db = \Config\Database::connect();
		$builder = $db->table('applogin');
		$builder->select('log_id');
		$builder->where('log_username',$appno);
		$result= $builder->get();
         $arr =  $result->getResult();
		return      $arr[0]->log_id;
		     
        
    }
	
	public function getjambdetail($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jambapplicants');
        $builder->join('programme','jambapplicants.prog=programme.programme_id');
        $builder->join('programme_type','jambapplicants.progtype=programme_type.programmet_id');
		$builder->where('jambno',$sid);
        $result=$builder->get(); 
        return $result->getResult();
    }

    public function updatejambdetails($data,$sid)
    {
       $db = \Config\Database::connect();
        $builder = $db->table('jambapplicants');
		$builder->where('jambno',$sid);
        if($builder->update($data))
        {
            return true;
        }
        else
        {
            return false;
        }
		 
    }
	
	
	public function getacctdetail($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('application_profile');
        $builder->join('programme','application_profile.stdprogramme_id=programme.programme_id');
        $builder->join('programme_type','application_profile.std_programmetype=programme_type.programmet_id');
      //  $builder->join('dept_options','application_profile.stdcourse=dept_options.do_id');
		$builder->where('std_logid',$sid);
        $result=$builder->get(); 
        return $result->getResult();
    }


    public function updateacctdetail($data,$sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('application_profile');
		$builder->where('std_logid',$sid);
        if($builder->update($data))
        {
            return true;
        }
        else
        {
            return false;
        }
		 
    }

    public function getlistofstudents($match)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('application_profile');
		$builder->like('app_no',$match,'after');
        $result=$builder->get(); 
        return $result->getResult();
    }
	
	
	public function getacctdetails($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('application_profile');
		//$builder->join('state','application_profile.state_of_origin=state.state_id');
	//	$builder->join('lga','application_profile.local_gov=lga.lga_id');
		 $builder->join('programme','application_profile.stdprogramme_id=programme.programme_id');
		//  $builder->join('dept_options','application_profile.stdcourse=dept_options.do_id');
		  $builder->join('programme_type','application_profile.std_programmetype=programme_type.programmet_id');
        $builder->where('std_logid',$sid);
        $result=$builder->get(); 
        return $result->getResult();
    }
	
public function getskool($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('faculties');
		$builder->select('faculties.faculties_name');
		$builder->join('departments','departments.fac_id = faculties.faculties_id');
		$builder->join('dept_options','dept_options.dept_id=departments.departments_id');
        $builder->where('dept_options.do_id',$sid);
        $result=$builder->get(); 
        return $result->getResult();
    }
	
	public function getrrr($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transaction_app');
		$builder->select('rrr');
		$builder->where('log_id',$sid);
        $result=$builder->get(); 
        return $result->getResult();
    }
    
    public function update_pass($rdata, $std_id, $semail)
    {
     
        $db = \Config\Database::connect();
        $builder = $db->table('applogin');
		$builder->where('log_id',$std_id);
		$builder->where('log_email',$semail);
        if($builder->update($rdata))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function appendreg_date()
    {

        $db = \Config\Database::connect();
		$builder = $db->table('schoolinfo');
		$builder->select('appendreg_date');
		$result=$builder->get();
         $arr =  $result->getResult();
		return    $cs_session =  $arr[0]->appendreg_date;
		     
        
    }
	
	
	public function appmarkuee()
    {

        $db = \Config\Database::connect();
		$builder = $db->table('schoolinfo');
		$builder->select('appmarkuee');
		$result=$builder->get();
         $arr =  $result->getResult();
		return    $cs_session =  $arr[0]->appmarkuee;
		     
        
    }
    
    
    public function appstartdate()
    {

        $db = \Config\Database::connect();
		$builder = $db->table('schoolinfo');
		$builder->select('appstartdate');
		$result=$builder->get();
         $arr =  $result->getResult();
		return    $cs_session =  $arr[0]->appstartdate;
		     
        
    }
    
    
    public function appenddate()
    {

        $db = \Config\Database::connect();
		$builder = $db->table('schoolinfo');
		$builder->select('appenddate');
		$result=$builder->get();
         $arr =  $result->getResult();
		return    $cs_session =  $arr[0]->appenddate;
		     
        
    }
    
    public function portalclosing()
    {

        $db = \Config\Database::connect();
		$builder = $db->table('portal_status');
		$builder->select('p_status');
		$result=$builder->get();
         $arr =  $result->getResult();
		return    $p_status =  $arr[0]->p_status;
		     
        
    }
    
     public function updatepassport($data, $std_id)
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
	
		public function saveresponse($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('remita_response');
        if($builder->insert($data))
        {
			return true;
        }
        else
        {
            return false;
        }
    }
	
	public function update_transactions($data,$trans_no )
    {
       $db = \Config\Database::connect();
        $builder = $db->table('transaction_app');
		$builder->where('trans_no',$trans_no);
        if($builder->update($data))
        {
            return true;
        }
        else
        {
            return false;
        }
		 
    }

    public function gettransactiondata($transaction_no, $studentId)
    {
        $db = \Config\Database::connect();
		$builder = $db->table('transaction_app');
		$builder->where('log_id',$studentId);
        $builder->where('fee_id',$transaction_no);
		$result=$builder->get();
        $arr =  $result->getResult();
		return    $cs_session =  $arr[0]; 
    }

    public function gettransaction($transactionType,$studentId )
    {

        $db = \Config\Database::connect();
		$builder = $db->table('transaction_app');
        $builder->select('trans_custom1');
		$builder->where('log_id',$studentId);
        $builder->where('fee_id',$transactionType);
        $builder->where('trans_custom1',"Paid");
		$result=$builder->get();
        $arr =  $result->getResult();
		return    $cs_session =  $arr[0]->trans_custom1; 
    }
    
    public function getprogrammetype($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme_type');
        $builder->select('programmet_name');
        $builder->where('programmet_id',$sid);
        $result=$builder->get();
        $arr =  $result->getResult();
		return    $cs_session =  $arr[0]->programmet_name;
    }
	
    public function getprogramme ($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme');
		$builder->where('programme_id',$sid);
        $builder->select('programme_id,programme_name,aprogramme_name');
        $result=$builder->get();
      return   $arr =  $result->getResult();
		   
    }
	public function getprogramme_type($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('programme_type');
        $builder->select('programmet_name,programmet_id');
        $builder->where('programmet_id',$sid);
        $result=$builder->get();
        
      return   $arr =  $result->getResult();
    }
	
    public function getcos($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dept_options');
        $builder->select('programme_option');
		$builder->where('prog_id',$sid);
		$builder->orderBy('programme_option','ASC');
        $result=$builder->get();
     return    $arr =  $result->getResult();
		    
    }

    public function getprog_code($fac)
    {

        $db = \Config\Database::connect();
		$builder = $db->table('dept_options');
        $builder->select('departments_name');
        $builder->join('departments','departments.departments_id =dept_options.dept_id');
		$builder->where('programme_option',$fac);
		$result=$builder->get();
         $arr =  $result->getResult();
		return    $cs_session =  $arr[0]->departments_name;
		     
        
    }
    public function getprog_code_jamb($fac)
    {

        $db = \Config\Database::connect();
		$builder = $db->table('dept_options');
        $builder->select('departments_name');
        $builder->join('departments','departments.departments_id =dept_options.dept_id');	 
		$builder->where('jamb_option',$fac);
		$result=$builder->get();
         $arr =  $result->getResult();
		return    $cs_session =  $arr[0]->departments_name;
		     
        
    }

    

    public function getstdno($sid, $sess)
    {

        $db = \Config\Database::connect();
		$builder = $db->table('application_profile');
		$builder->select('count(std_id) as dno');
		$builder->where('stdcourse',$sid);
        $builder->where('adm_status',1);
		$builder->where('substr(app_no,2,2)',$sess);
		$result=$builder->get();
		$arr =  $result->getResult();
		$nos =  $arr[0]->dno;
        return   str_pad($nos, 3, "0", STR_PAD_LEFT);
    }

   

    public function getdeptname($sid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dept_options');
        $builder->select('departments_name');
        $builder->join('departments','departments.departments_id =dept_options.dept_id');
		$builder->where('dept_code',$sid);
      //  $sql = $builder->getCompiledSelect();
 // echo $sql; exit; 
        $result=$builder->get(); 
        $arr =  $result->getResult();
		return      $arr[0]->departments_name;
    }

    public function getadmdate($progid, $fac)
    {

        $db = \Config\Database::connect();
		$builder = $db->table('dept_options');
		$builder->select('admletter_date');
		$builder->where('prog_id',$progid);
        $builder->where('jamb_option',$fac);
		$result=$builder->get();
         $arr =  $result->getResult();
		return     $arr[0]->admletter_date;
		     
        
    }

    public function lastparttimeformno()
    {

        $db = \Config\Database::connect();
		$builder = $db->table('application_profile');
		$builder->select('app_no');
        $builder->where('std_programmetype',2);
		$builder->orderBy('app_no','DESC');
		$result=$builder->get();
		$arr =  $result->getResult();
		$nos =  $arr[0]->app_no;
        return    substr($nos, 1) + 1;
    }
	
}