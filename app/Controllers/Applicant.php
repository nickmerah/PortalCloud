<?php
namespace App\Controllers;
use \CodeIgniter\Controller;
use App\Models\AccountModel;
use App\Models\ApplicantModel;
class Applicant extends Controller
{

    public $session = '';


    public function __construct()
    {
        $this->session = \Config\Services::session();
        helper('uri');
        if(!session()->get('log_id'))
        {
            header('Location: '.base_url());
            exit();
        }

    }

	public function index()
    {
		  $accountModel = new AccountModel();
		  $applicantModel = new ApplicantModel();

		  $appyear = $accountModel->getsess();
		  $pstat = $applicantModel->getfeestatus(session()->get('log_id'));
		  $astat = $applicantModel->getafeestatus(session()->get('log_id'));
		  $appstatus = $applicantModel->getappstatus(session()->get('log_id'));
		  $admstatus = $applicantModel->getadmstatus(session()->get('log_id'));
		  $clearstatus = $applicantModel->getclearstatus(session()->get('log_id'));
		  
		   $convert = $accountModel->getconversion();
  	  

		 if ( $appstatus == 1 ){
		 $data['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
		 }else{
	     $data['stddetails'] =  $accountModel->getacctdetail(session()->get('log_id'));
		 }

	 	$progid =  $data['stddetails'][0]->stdprogramme_id;
	 	 $progtype =  $data['stddetails'][0]->std_programmetype;

		  $datac['jambs'] =  $accountModel->getjambdetail($data['stddetails'][0]->jambno);
		  //print_r($datac['jambs']);
		  if ($progid == 1 and $progtype == 1){
			$fnames = $datac['jambs'][0]->fullname;
		  }else{
			$fnames = $data['stddetails'][0]->surname. ' '.$data['stddetails'][0]->firstname;
		  }
		    

   // 

         $appfees = $applicantModel->getappfees($progid, $progtype);
 $appbiodata =  $data['stddetails'][0]->biodata;
		 $datah = ['title' => 'TOPS .:: Home | Portal', 'appno'=>session()->get('appno'),
		 'cs_session'=> $appyear,  'pstat' => $pstat,'astat' => $astat,  'appstatus' => $appstatus,  'appfees' => $appfees, 'fnames' =>  $fnames,
     'appbiodata' =>  $appbiodata, 'admstatus' => $admstatus, 'clearstatus' => $clearstatus, 'convert' => $convert];




		$data['paystatus'] =  $applicantModel->gettrans_details(session()->get('log_id'));


       echo view('applicants/header', $datah);
        echo view('applicants/index',$data);
         echo view('applicants/footer');
    }

    public function payappfees()
      {
        $accountModel = new AccountModel();
        $applicantModel = new ApplicantModel();

        $appyear = $accountModel->getsess();
        $pstat = $applicantModel->getfeestatus(session()->get('log_id'));
        $appstatus = $applicantModel->getappstatus(session()->get('log_id'));

       if ( $appstatus == 1 ){
       $data['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
       }else{
         $data['stddetails'] =  $accountModel->getacctdetail(session()->get('log_id'));
       }
       $progid =  $data['stddetails'][0]->stdprogramme_id;
   	 	 $progtype =  $data['stddetails'][0]->std_programmetype;
       $fnames = $data['stddetails'][0]->surname. ' '.$data['stddetails'][0]->firstname;

           $appfees = $applicantModel->getappfees($progid, $progtype);

       $datah = ['title' => 'TOPS .:: Pay Application Fees | Portal', 'appno'=>session()->get('appno'),
       'cs_session'=> $appyear,  'pstat' => $pstat,  'appstatus' => $appstatus,  'appfees' => $appfees, 'fnames' =>  $fnames];




      $data['paystatus'] =  $applicantModel->gettrans_details(session()->get('log_id'));


         echo view('applicants/header', $datah);
          echo view('applicants/appfees',$data);
           echo view('applicants/footer');
      }


	public function paynow()
	{



		 $data = [];
		 if($this->request->getMethod()=='post')
        {
			 $accountModel = new AccountModel();

			 //check if portal is closed

		    $pstatus = $accountModel->portalclosing();
		  if ($pstatus == '0'){
			 echo '<script type="text/javascript">
			alert("Portal is CLOSED to Application for this Year");
			window.location = "'.base_url('applicant/').'";
		</script>';
			exit;
		}


			 $stddetails = $accountModel->getacctdetail(session()->get('log_id'));
		//	 print_r($stddetails); exit;
              foreach($stddetails as $stddetail){
				  $appno = $stddetail->jambno;
				  $surname = $stddetail->surname;
				  $firstname = $stddetail->firstname;
				  $othernames = $stddetail->othernames;
				  $semail = $stddetail->student_email;
				  $sgsm = $stddetail->student_mobiletel;
				  $progid = $stddetail->stdprogramme_id;
				  $progtype = $stddetail->std_programmetype;
				  $progname = $stddetail->programme_name;
				  $progtypename = $stddetail->programmet_name;
				  $stdcoursename = $stddetail->stdcourse;

			 }

			 $timesammp=DATE("dmyHis");
	         $tid = session()->get('log_id').$timesammp;
		    $fdate = date('Y-m-d h:i:s');
		    $tdate = date('Y-m-d');

		 $applicantModel = new ApplicantModel();
         $appfees = $applicantModel->getappfees($progid, $progtype);


//end get RRR
		$tid = session()->get('log_id').$timesammp;
		$fdate = date('Y-m-d h:i:s');
		$tdate = date('Y-m-d');
		$cs_session =  $accountModel->getsess();
		$data = [
            'log_id' => session()->get('log_id'),
            'fee_id'  => 1,
            'fee_name'  => "Application Form Fee",
			'trans_no' => $tid,
            'fee_amount'  => $appfees,
			'generated_date' => $fdate,
			'trans_date' => $fdate,
			't_date' => $tdate,
			'trans_year' => $cs_session,
			'fullnames' => "$surname $firstname $othernames",
			'semail'  => $semail,
			'appno'  => $appno,
			'rrr'  => 'N/A'
        ];


         $applicantModel->save_transaction($data);



			$fullname = "$surname $firstname $othernames";
			$trans_name = "Application Form Fee";


		  $mid = "PL03";
          $apkey = "5502";
          $hash_string = $mid . $tid . $apkey;
          $new_hash = hash('sha512', $hash_string);
	      $redirect_url = base_url('applicant/remitaresponse');
		  echo '<form action="https://tops.oystirev.com/pltpayment" name= "apiform" method="POST" id="apiform">

<input name="client_code" type="hidden" id="client_code" value="TOPS">
<input name="client" type="hidden" id="client_code" value="OKEOGUN">
<input name="matricno" type="hidden" value="'.$appno.'">
<input name="fullname" type="hidden"   value="'.$fullname.'">
<input name="trans_name" type="hidden"   value="'.$trans_name.'">
<input name="trans_no" type="hidden"   value="'.$tid.'">
<input name="department" type="hidden"   value="'.$stdcoursename.'">
<input name="faculty" type="hidden"   value="N/A">
<input name="amount" type="hidden"  value="'.$appfees.'">
<input name="session" type="hidden"   value="'.$cs_session.'">
<input name="semester" type="hidden"   value="First Semester">
<input name="programme" type="hidden" value="'.$progname.'">
<input name="programmetype" type="hidden"  value="'.$progtypename.'">
<input name="level" type="hidden"  value="N/A">
<input name="email" type="hidden"  value="'.$semail.'">
<input name="gsmno" type="hidden" value="'.$sgsm.'">
<input name="stateoforigin" type="hidden" value="N/A">
<input name="studenttype" type="hidden" value="N/A">
<input name="policy" type="hidden" value="Full Payment">
<input name="Pay_items" type="hidden" value="'.base64_encode($trans_name).'">
<input name="redirect_url" type="hidden" id="redirect_url" value="'.$redirect_url.'">
 <input name="hash_string" type="hidden" value="'.$new_hash.'">
 <script language="JavaScript">document.apiform.submit();</script>

</form>



';


		}else{

		 echo '<script type="text/javascript">
			alert("Error Generating Transaction ID,  Please Try Again");
			window.location = "../applicant";
		</script>';



		}

	}

	public function paymentslip()
    {

		  $applicantModel = new ApplicantModel();


        $data['transdetails'] =  $applicantModel->gettransdetails($this->request->uri->getSegment(3));
        $fnames = $data['transdetails'][0]->fullnames;
          $datah = ['title' => 'TOPS .:: Home | Portal', 'appno'=>session()->get('appno'), 'fnames' =>  $fnames ];

	    	echo view('applicants/header', $datah);
        echo view('applicants/payslip',$data);
         echo view('applicants/footer');

}



	public function getLGA(){
    $postData = $this->request->getPost();
	$applicantModel = new ApplicantModel();
    $data = $applicantModel->getlga($postData);
    echo json_encode($data);
  }

  public function biodata()
    {
      $accountModel = new AccountModel();
      $applicantModel = new ApplicantModel();

      $appyear = $accountModel->getsess();
      $pstat = $applicantModel->getfeestatus(session()->get('log_id'));
      $biostatus = $applicantModel->getbiostatus(session()->get('log_id'));

      if ($pstat == '0'){
			 echo '<script type="text/javascript">
			alert("You must pay for the Application Form before you update your biodata");
			window.location = "'.base_url('applicant/').'";
		</script>';
			exit;
		}


     if ( $biostatus == 1 ){
     $data['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
     }else{
       $data['stddetails'] =  $accountModel->getacctdetail(session()->get('log_id'));
     }
	 
	 //print_r($data['stddetails']); exit;
	$state_id = $applicantModel->getstateid($data['stddetails'][0]->state_of_origin);
	
     $progid =  $data['stddetails'][0]->stdprogramme_id;
     $progtype =  $data['stddetails'][0]->std_programmetype;
     $fnames = $data['stddetails'][0]->surname. ' '.$data['stddetails'][0]->firstname;
	 $data['jambdetails'] =  $accountModel->getjambdetail($data['stddetails'][0]->jambno);

     $appfees = $applicantModel->getappfees($progid, $progtype);

	// $paymentdata =  $applicantModel->gettransactiondetails("2204110323033611");
	// $data['pdata'] = $paymentdata;
	 $data['coversionfeestatus'] =  $accountModel->gettransaction(3,session()->get('log_id'));

   if ($data['coversionfeestatus'] == 'Paid') {
	echo '<script type="text/javascript">
	alert("You already paid for conversion, you will be redirected to the Conversion Page");
	window.location = "'.base_url('applicant/conversionbiodata').'";
</script>';
	exit;
   }

     $datah = ['title' => 'TOPS .:: Pay Application Fees | Portal', 'appno'=>session()->get('appno'),
     'cs_session'=> $appyear,  'pstat' => $pstat,  'appstatus' => $appstatus,  'appfees' => $appfees, 'fnames' =>  $fnames];

$data['lgas'] = $applicantModel->getlga($state_id );
$data['examtypes'] = $applicantModel->getexamtypes(session()->get('log_id'));
$data['subjects'] = $applicantModel->getsubjects();
$data['grades'] = $applicantModel->getgrades();
$data['olevels'] =  $applicantModel->get_olevel(session()->get('log_id'));

//print_r($data['olevels'] );


       echo view('applicants/header', $datah);
        echo view('applicants/profile',$data);
         echo view('applicants/footer');
    }


	public function conversionbiodata()
    {
      $accountModel = new AccountModel();
      $applicantModel = new ApplicantModel();

      $appyear = $accountModel->getsess();
      $pstat = $applicantModel->getfeestatus(session()->get('log_id'));
      $biostatus = $applicantModel->getbiostatus(session()->get('log_id'));

      if ($pstat == '0'){
			 echo '<script type="text/javascript">
			alert("You must pay for the Application Form before you update your biodata");
			window.location = "'.base_url('applicant/').'";
		</script>';
			exit;
		}

		$data['coversionfeestatus'] =  $accountModel->gettransaction(3,session()->get('log_id'));

		if ($data['coversionfeestatus'] != 'Paid') {
		 echo '<script type="text/javascript">
		 alert("You must the conversion fee,before you can access this");
		 window.location = "'.base_url('applicant/').'";
	 </script>';
		 exit;
		}


     if ( $biostatus == 1 ){
     $data['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
     }else{
       $data['stddetails'] =  $accountModel->getacctdetail(session()->get('log_id'));
     }
	 
	 //print_r($data['stddetails']); exit;
	$state_id = $applicantModel->getstateid($data['stddetails'][0]->state_of_origin);
	
     $progid =  $data['stddetails'][0]->stdprogramme_id;
     $progtype =  $data['stddetails'][0]->std_programmetype;
     $fnames = $data['stddetails'][0]->surname. ' '.$data['stddetails'][0]->firstname;
	 $data['jambdetails'] =  $accountModel->getjambdetail($data['stddetails'][0]->jambno);

     $appfees = $applicantModel->getappfees($progid, $progtype);
 
	

     $datah = ['title' => 'TOPS .:: Pay Application Fees | Portal', 'appno'=>session()->get('appno'),
     'cs_session'=> $appyear,  'pstat' => $pstat,  'appstatus' => $appstatus,  'appfees' => $appfees, 'fnames' =>  $fnames];


//print_r($data['lgas'] );exit;


       echo view('applicants/header', $datah);
        echo view('applicants/conversionprofile',$data);
         echo view('applicants/footer');
    }

		public function update_profile()
	{
		 helper(['form', 'url']);
		 $data = [];
		  if($this->request->getMethod()=='post')
        {
            $rules = [
                'gender'=>'required',
                'marital_status'=>'required',
				'student_homeaddress'=>'required',
				'contact_address'=>'required',
				'nok'=>'required',
				'nok_tel'=>'required',
				'nok_address'=>'required',
				'nok_email'=>'required',
				'clga'=>'required'];
			$dob = $this->request->getVar('dob');
			$mob = $this->request->getVar('mob');
		    $yob = $this->request->getVar('yob');
			$coversion = $this->request->getVar('conversionbox');
			$birthday = "$yob-$mob-$dob";
			 $std_id  = session()->get('log_id');
			if($this->validate($rules))
            {

			 
			$appno = session()->get('appno');
			$accountModel = new AccountModel();
			 //check if portal is closed

		    $pstatus = $accountModel->portalclosing();
		  if ($pstatus == '0'){
			 echo '<script type="text/javascript">
			alert("Portal is CLOSED to Biodata Update");
			window.location = "'.base_url('applicant/').'";
		</script>';
			exit;
		}

		      $appyear = $accountModel->getsess();
				
 if ($this->request->getVar('sprog') == 1 && $this->request->getVar('sprogtype') == 1){
	 
	$data = [

		'gender' => $this->request->getVar('gender'),
		'marital_status' => $this->request->getVar('marital_status'),
		'student_homeaddress' => $this->request->getVar('student_homeaddress'),
		'contact_address' => $this->request->getVar('contact_address'),
		'next_of_kin' => $this->request->getVar('nok'),
		'nok_tel' => $this->request->getVar('nok_tel'),
		'nok_address' => $this->request->getVar('nok_address'),
		'nok_email' => $this->request->getVar('nok_email'),
		'local_gov' => $this->request->getVar('clga'),
		'birthdate' => $birthday,
		'biodata' => 1,
		'std_custome7' => 1,
		'is_converted' => 0,
		'state_of_origin' => $this->request->getVar('cstate')
		];

 }else{
	$data = [

		'gender' => $this->request->getVar('gender'),
		'marital_status' => $this->request->getVar('marital_status'),
		'student_homeaddress' => $this->request->getVar('student_homeaddress'),
		'contact_address' => $this->request->getVar('contact_address'),
		'next_of_kin' => $this->request->getVar('nok'),
		'nok_tel' => $this->request->getVar('nok_tel'),
		'nok_address' => $this->request->getVar('nok_address'),
		'nok_email' => $this->request->getVar('nok_email'),
		'local_gov' => $this->request->getVar('clga'),
		'birthdate' => $birthday,
		'biodata' => 1,
		'is_converted' =>  0,
		'std_custome7' => 1
		];
	
 }
             //print_r($data); exit;
            $applicantModel = new ApplicantModel();




		$updatebio =	$applicantModel->updatebiodata($data, $std_id);

			if($updatebio){
				echo '<script type="text/javascript">
				alert("Your Biodata was successfully Updated");
				window.location = "../applicant/olevel";
			</script>';
	
			}
			

		

			}


		}else{

		 echo '<script type="text/javascript">
			alert("Error Updating Biodata");
			window.location = "../my_application";
		</script>';



		}

	}

	public function update_profile_to_conversion () {
		helper(['form', 'url']);
		 $data = [];
		  if($this->request->getMethod()=='post')
        { 
			$accountModel = new AccountModel();
            
			$conversionfeestatus =  $accountModel->gettransaction(3,session()->get('log_id'));

			

		if ($conversionfeestatus != 'Paid') {
		 echo '<script type="text/javascript">
		 alert("You must the conversion fee,before you can access this");
		 window.location = "'.base_url('applicant/').'";
	 </script>';
		 exit;
		}
		$applicantModel = new ApplicantModel();
 //get last part time form number to update
   $std_id  = session()->get('log_id');
   	$lastparttimeformno = "P" . $accountModel->lastparttimeformno(); 

	//update application profile
	$appprofiledata = [

		'is_converted' =>  1,
		'std_programmetype' =>  2,
		'app_no' => $lastparttimeformno
		];
		 $updateappbio =	$applicantModel->updatebiodata($appprofiledata, $std_id);


//update login profile
$logindata = [
	'log_username' => $lastparttimeformno
	];
	
	$updateappbio =	$applicantModel->updateapplogin($logindata, $std_id);

	if ($updateappbio and $updateappbio) {
		echo '<script type="text/javascript">
				alert("Your Conversion was successfully");
				window.location = "../applicant";
			</script>'; exit;
	}

	echo '<script type="text/javascript">
				alert("Error Updating Conversion Profile");
				window.location = "../conversionbiodata";
			</script>';
			
			}else{
				echo '<script type="text/javascript">
				alert("Error Updating Conversion Profile");
				window.location = "../conversionbiodata";
			</script>';
			}

		      
				

			  
	}
  public function my_application()
    {
		  $accountModel = new AccountModel();

		   //check if portal is closed

		    $pstatus = $accountModel->portalclosing();
		  if ($pstatus == '0'){
			 echo '<script type="text/javascript">
			alert("Portal is CLOSED to Filling of Application Forms");
			window.location = "'.base_url('applicant/').'";
		</script>';
			exit;
		}

		  $applicantModel = new ApplicantModel();
	      $appyear = $accountModel->getsess();
          $pstat = $applicantModel->getfeestatus(session()->get('log_id'));
  		  $appstatus = $applicantModel->getappstatus(session()->get('log_id'));


        $data['stddetails'] =  $accountModel->getacctdetail(session()->get('log_id'));

		$data['coversionfeestatus'] =  $accountModel->gettransaction(3,session()->get('log_id'));

 		$fnames = $data['stddetails'][0]->surname. ' '.$data['stddetails'][0]->firstname;

 $datah = ['title' => 'TOPS .:: My Application | Portal', 'appno'=>session()->get('appno'),
  'cs_session'=> $appyear,  'pstat' => $pstat,  'fnames' =>  $fnames, 'appstatus' => $appstatus ];
		$data['states'] = $applicantModel->getstate();
		$data['programmes'] = $applicantModel->getprogramme();
		$data['jambs'] =  $applicantModel->get_jamb(session()->get('log_id'));

       echo view('applicants/header', $datah);
        echo view('applicants/application_home',$data);
             echo view('applicants/footer');
    }


	 public function course()
    {
		  $accountModel = new AccountModel();
		  $applicantModel = new ApplicantModel();
	      $appyear = $accountModel->getsess();
	  $data = ['title' => 'TOPS .:: My Application - Courses | Portal', 'appno'=>session()->get('appno'),
		 'cs_session'=> $appyear,  'pstat' => $pstat ];
        $datas['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
		
		$datac['jambdetails'] =  $accountModel->getjambdetail($datas['stddetails'][0]->jambno);

        echo view('applicants/header', $data);
        echo view('applicants/courses',$datac);
             echo view('applicants/footer');
    }


	public function add_course()
	{
		 helper(['form', 'url']);
		 $data = [];
		  if($this->request->getMethod()=='post')
        {
            $rules = [
                'sprog'=>'required',
                'cchoice'=>'required'
		];


			if($this->validate($rules))
            {


            $std_id  = session()->get('log_id');
           $choice =  $this->request->getVar('cchoice');

            $data = [

			"$choice" => $this->request->getVar('sprog')

			];
            $applicantModel = new ApplicantModel();
			$applicantModel->update_course($data, $std_id, $choice);


			echo '<script type="text/javascript">
			alert("Your Course of Study  was successfully Added");
			window.location = "../applicant/course";
		</script>';


			}


		}else{

		 echo '<script type="text/javascript">
			alert("Error Adding Course of Study");
			window.location = "../applicant/course";
		</script>';



		}

	}

	 public function school()
    {
		  $accountModel = new AccountModel();
		  $applicantModel = new ApplicantModel();
	  $data = ['title' => 'TOPS .:: My Application - School | Portal', 'appno'=>session()->get('appno'),
		 'cs_session'=> $appyear,  'pstat' => $pstat ];
        $datac['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
		$datac['polys'] = $applicantModel->getpolys();
		$datac['courses'] = $applicantModel->getdept_options(1, $datac['stddetails'][0]->std_programmetype);
		$datac['std_eduhistory'] =  $applicantModel->get_eduhistory(session()->get('log_id'));

		$datac['std_custome5'] = $datac['stddetails'][0]->std_custome5 ;

		echo view('applicants/header', $data);
        echo view('applicants/school',$datac);
             echo view('applicants/footer');


    }

    public function certupload()
    {
		  $accountModel = new AccountModel();
		  $applicantModel = new ApplicantModel();
	  $data = ['title' => 'TOPS .:: My Application - School | Portal', 'appno'=>session()->get('appno'),
		 'cs_session'=> $appyear,  'pstat' => $pstat ];
        $datac['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
		$datac['polys'] = $applicantModel->getpolys();
		$datac['courses'] = $applicantModel->getdept_options(1, $datac['stddetails'][0]->std_programmetype);
		$datac['std_eduhistory'] =  $applicantModel->get_eduhistory(session()->get('log_id'));

		$datac['std_custome5'] = $datac['stddetails'][0]->std_custome5 ;

		echo view('applicants/header', $data);
        echo view('applicants/certupload',$datac);
             echo view('applicants/footer');


    }


		public function addcert()
	{
		 helper(['form', 'url']);
		 $data = [];
		  if($this->request->getMethod()=='post')
        {
            $rules = [

              	'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
                'max_size[file,1024]'
		]];


			 $app_id  = session()->get('log_id');
			if($this->validate($rules))
            {

			$img = $this->request->getFile('file');
			$ext = $img->guessExtension();
			$dates = date('his');
			//$newName = $img->getRandomName();
			$newName = $app_id.$dates.'.'.$ext;
            $img->move(ROOTPATH.'public/certs/', $newName);

            $data = [
			 'ndcert' => $newName

			];
            $applicantModel = new ApplicantModel();
   			$applicantModel->updatebiodata($data, $app_id);



			echo '<script type="text/javascript">
			alert("Your Certificate was successfully Added");
			window.location = "'.base_url('applicant/certupload').'";
		</script>';


			}


		}else{

		 echo '<script type="text/javascript">
			alert("Error Adding Certificate");
			window.location = "'.base_url('applicant/certupload').'";
		</script>';



		}
		  echo '<script type="text/javascript">
			alert("Error Adding Certificate");
			window.location = "'.base_url('applicant/certupload').'";
		</script>';
	}


		public function rem_ndcert()
	{


			 $app_id  = session()->get('log_id');



            $data = [
			 'ndcert' => 0

			];
            $applicantModel = new ApplicantModel();
   			$applicantModel->updatebiodata($data, $app_id);



			echo '<script type="text/javascript">
			alert("Your Certificate was successfully Removed");
			window.location = "'.base_url('applicant/certupload').'";
		</script>';



	}


	public function add_school()
	{
		 helper(['form', 'url']);
		 $data = [];
		  if($this->request->getMethod()=='post')
        {
            $rules = [
                'schoolname'=>'required',
				'fromdate'=>'required',
				'todate'=>'required',
				'ndmatno'=>'required',
				'grade'=>'required',
				'organization'=>'required',
				'address'=>'required',
				'itdatefrom'=>'required',
				'itdateto'=>'required',
				
						
		];
			 }

			if($this->validate($rules))
            {
				$ndmatno = $this->request->getVar('ndmatno');
		    
             $data = [
            'std_id' => session()->get('log_id'),
            'schoolname'  => strtoupper($this->request->getVar('schoolname')),
			'ndmatno' => $ndmatno,
            'cos'  => $this->request->getVar('cos'),
			'fromdate' =>$this->request->getVar('fromdate'),
			'todate' => $this->request->getVar('todate'),
			'organization' => strtoupper($this->request->getVar('organization')),
			'address' => strtoupper($this->request->getVar('address')),
			'itdatefrom' => $this->request->getVar('itdatefrom'),
			'itdateto' => $this->request->getVar('itdateto')

        ];
        //print_r($data); exit;
            $applicantModel = new ApplicantModel();
			$applicantModel->save_school($data);


			echo '<script type="text/javascript">
			alert("School Details successfully Added");
			window.location = "../applicant/school";
		</script>';





		}else{

		 echo '<script type="text/javascript">
			alert("Error Adding School Details");
			window.location = "../applicant/school";
		</script>';
		}

	}

	public function appfinish($column)
    {
		      $std_id  = session()->get('log_id');
			  $data = [
            "std_custome$column" => 1
        ];
	        $applicantModel = new ApplicantModel();
			$applicantModel->save_schools($data, $std_id);

			if ($column == 6) {
				return redirect()->to(base_url('applicant/declares'));
			}
	   return redirect()->to(base_url('applicant/my_application'));


    }

	public function update_profile_add_olevel()
	{
		 helper(['form', 'url']);
		 $data = [];
		  if($this->request->getMethod()=='post')
        {
            $rules = [
                'gender'=>'required',
                'marital_status'=>'required',
				'student_homeaddress'=>'required',
				'contact_address'=>'required',
				'nok'=>'required',
				'nok_tel'=>'required',
				'nok_address'=>'required',
				'nok_email'=>'required',
				'clga'=>'required'];
			$dob = $this->request->getVar('dob');
			$mob = $this->request->getVar('mob');
		    $yob = $this->request->getVar('yob');
			$coversion = $this->request->getVar('conversionbox');
			$birthday = "$yob-$mob-$dob";
			 $std_id  = session()->get('log_id');
			if($this->validate($rules))
            {

			 
			$appno = session()->get('appno');
			$accountModel = new AccountModel();
			 //check if portal is closed

		    $pstatus = $accountModel->portalclosing();
		  if ($pstatus == '0'){
			 echo '<script type="text/javascript">
			alert("Portal is CLOSED to Biodata Update");
			window.location = "'.base_url('applicant/').'";
		</script>';
			exit;
		}

		      $appyear = $accountModel->getsess();
				
 if ($this->request->getVar('sprog') == 1 && $this->request->getVar('sprogtype') == 1){
	 
	$data = [

		'gender' => $this->request->getVar('gender'),
		'marital_status' => $this->request->getVar('marital_status'),
		'student_homeaddress' => $this->request->getVar('student_homeaddress'),
		'contact_address' => $this->request->getVar('contact_address'),
		'next_of_kin' => $this->request->getVar('nok'),
		'nok_tel' => $this->request->getVar('nok_tel'),
		'nok_address' => $this->request->getVar('nok_address'),
		'nok_email' => $this->request->getVar('nok_email'),
		'local_gov' => $this->request->getVar('clga'),
		'birthdate' => $birthday,
		'biodata' => 1,
		'std_custome7' => 1,
		'is_converted' => 0,
		'state_of_origin' => $this->request->getVar('cstate')
		];

 }else{
	$data = [

		'gender' => $this->request->getVar('gender'),
		'marital_status' => $this->request->getVar('marital_status'),
		'student_homeaddress' => $this->request->getVar('student_homeaddress'),
		'contact_address' => $this->request->getVar('contact_address'),
		'next_of_kin' => $this->request->getVar('nok'),
		'nok_tel' => $this->request->getVar('nok_tel'),
		'nok_address' => $this->request->getVar('nok_address'),
		'nok_email' => $this->request->getVar('nok_email'),
		'local_gov' => $this->request->getVar('clga'),
		'birthdate' => $birthday,
		'biodata' => 1,
		'is_converted' =>  0,
		'std_custome7' => 1
		];
	
 }
             //print_r($data); exit;
            $applicantModel = new ApplicantModel();
	 	$updatebio =	$applicantModel->updatebiodata($data, $std_id);

		
		 if($updatebio){

     $subjects = $this->request->getVar('subject');
	 $mySubjects = array_values(array_filter($subjects));


	 $grades = $this->request->getVar('grade');
	 $myGrades = array_values(array_filter($grades));

	// print_r($mySubjects);
	// print_r($myGrades);
		$nosubject = count( $mySubjects);
		$nogrades = count( $myGrades);

		if ($nosubject != $nogrades){
			echo '<script type="text/javascript">
			alert("No of Olevel Subject & Grade are not the same, kindly reselect again");
			window.location = "'.base_url('applicant/biodata').'";
		</script>';
			exit;
		}

		if ($nosubject < 5){
			echo '<script type="text/javascript">
			alert("You must Select at least 5 Olevel Subjects");
			window.location = "'.base_url('applicant/biodata').'";
		</script>';
			exit;
		}
	

		//for   sitting
	  if  ($nosubject){

		//remove previous registration

		$cid = $applicantModel->removeallolevel(session()->get('log_id')) ;

		     $examtype = $this->request->getVar('examtype');
		     $frommth = $this->request->getVar('frommth');
		     $centerno = $this->request->getVar('centerno');
		     $examno = $this->request->getVar('examno');
		     $toyear = $this->request->getVar('toyear');


			 for ($i = 1; $i <= $nosubject ; $i++) {
				$subjects = $mySubjects[$i];
				$grades = $myGrades[$i];
				$data = [
            'std_id' => session()->get('log_id'),
            'subname'  => $this->request->getVar('subject')[$i],
			'certname' => $examtype,
            'grade'  => $this->request->getVar('grade')[$i],
			'emonth' =>strtoupper($frommth),
			'examno' =>$examno,
			'centerno' =>$centerno,
			'eyear' => $toyear

        ];

		 $applicantModel = new ApplicantModel();
		 $applicantModel->save_olevel($data);



				echo '<script type="text/javascript">
				alert("Your Biodata and Olevel was successfully Updated");
				window.location = "../applicant/biodata";
			</script>';
	
			}
			

		

			}


		}else{

		  echo '<script type="text/javascript">
			alert("Error Updating Biodata");
			window.location = "../applicant/biodata";
		</script>'; 



		}

			}

			echo '<script type="text/javascript">
			alert("Error Updating Biodata");
			window.location = "../applicant/biodata";
		</script>'; 
		}
	}

	public function olevel()
    {
		$accountModel = new AccountModel();
		$applicantModel = new ApplicantModel();
  
		$appyear = $accountModel->getsess();
		$pstat = $applicantModel->getfeestatus(session()->get('log_id'));
		$biostatus = $applicantModel->getbiostatus(session()->get('log_id'));
  
		if ($pstat == '0'){
			   echo '<script type="text/javascript">
			  alert("You must pay for the Application Form before you update your biodata");
			  window.location = "'.base_url('applicant/').'";
		  </script>';
			  exit;
		  }
  
  
	   if ( $biostatus == 1 ){
	   $data['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
	   }else{
		 $data['stddetails'] =  $accountModel->getacctdetail(session()->get('log_id'));
	   }
	   
	   //print_r($data['stddetails']); exit;
	  $state_id = $applicantModel->getstateid($data['stddetails'][0]->state_of_origin);
	  
	   $progid =  $data['stddetails'][0]->stdprogramme_id;
	   $progtype =  $data['stddetails'][0]->std_programmetype;
	   $fnames = $data['stddetails'][0]->surname. ' '.$data['stddetails'][0]->firstname;
	   $data['jambdetails'] =  $accountModel->getjambdetail($data['stddetails'][0]->jambno);
  
	   $appfees = $applicantModel->getappfees($progid, $progtype);
  
	  // $paymentdata =  $applicantModel->gettransactiondetails("2204110323033611");
	  // $data['pdata'] = $paymentdata;
	   $data['coversionfeestatus'] =  $accountModel->gettransaction(3,session()->get('log_id'));
  
	 if ($data['coversionfeestatus'] == 'Paid') {
	  echo '<script type="text/javascript">
	  alert("You already paid for conversion, you will be redirected to the Conversion Page");
	  window.location = "'.base_url('applicant/conversionbiodata').'";
  </script>';
	  exit;
	 }
  
	   $datah = ['title' => 'TOPS .:: Pay Application Fees | Portal', 'appno'=>session()->get('appno'),
	   'cs_session'=> $appyear,  'pstat' => $pstat,  'appstatus' => $appstatus,  'appfees' => $appfees, 'fnames' =>  $fnames];
  
  $data['lgas'] = $applicantModel->getlga($state_id );
  $data['examtypes'] = $applicantModel->getexamtypes(session()->get('log_id'));
  $data['subjects'] = $applicantModel->getsubjects();
  $data['grades'] = $applicantModel->getgrades();
  $data['olevels'] =  $applicantModel->get_olevel(session()->get('log_id'));
  
  //print_r($data['olevels'] );
  
  
		 echo view('applicants/header', $datah);
		  echo view('applicants/olevel',$data);
		   echo view('applicants/footer');


    }


	public function jamb()
    {
		  $accountModel = new AccountModel();
		  $applicantModel = new ApplicantModel();
	  $data = ['title' => 'TOPS .:: My Application - Jamb Details| Portal', 'appno'=>session()->get('appno'),
		 'cs_session'=> $appyear,  'pstat' => $pstat ];
		 $datac['olevels'] =  $applicantModel->get_olevel(session()->get('log_id'));

		 if(empty($datac['olevels'])) {
		       echo '<script type="text/javascript">
			alert("Olevel Must be Added before Jamb Details");
			window.location = "../applicant/olevel";
		</script>';

		     exit;
		 }
       
		 $datas['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
		
		$datac['jambs'] =  $accountModel->getjambdetail($datas['stddetails'][0]->jambno);
 
		echo view('applicants/header', $data);
        echo view('applicants/jambdetail',$datac);
        echo view('applicants/footer');


    }

public function add_olevel() {
		 helper(['form', 'url']);
		 $data = [];
		  if($this->request->getMethod()=='post')
        {
	 	$sittings = $this->request->getVar('noos');

		//for   sitting
	  if  ($sittings){
		     $examtype = $this->request->getVar('examtype');
		     $frommth = $this->request->getVar('frommth');
		     $centerno = $this->request->getVar('centerno');
		     $examno = $this->request->getVar('examno');
		     $toyear = $this->request->getVar('toyear');
		      $nosubject = count($this->request->getVar('subject'));


			 for ($i = 1; $i <= $nosubject ; $i++) {
				$subjects = $this->request->getVar('subject')[$i];
				$grades = $this->request->getVar('grade')[$i];
				$data = [
            'std_id' => session()->get('log_id'),
            'subname'  => $this->request->getVar('subject')[$i],
			'certname' => $examtype,
            'grade'  => $this->request->getVar('grade')[$i],
			'emonth' =>strtoupper($frommth),
			'examno' =>$examno,
			'centerno' =>$centerno,
			'eyear' => $toyear

        ];



		  $applicantModel = new ApplicantModel();
		 $applicantModel->save_olevel($data);

			 }
	  echo '<script type="text/javascript">
			alert("Olevel Details successfully Added");
			window.location = "../applicant/olevel";
		</script>';
			 }else{

		  echo '<script type="text/javascript">
			alert("Error Adding Olevel Details");
			window.location = "../applicant/olevel";
		</script>';
	  }
	}
}

 

	public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url());
    }

	public function declares()
    {
		  $accountModel = new AccountModel();
		  $applicantModel = new ApplicantModel();
	  $data = ['title' => 'TOPS .:: My Application - Declaration | Portal', 'appno'=>session()->get('appno'),
		 'cs_session'=> $appyear,  'pstat' => $pstat ];
        $datac['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
		$datac['std_eduhistory'] =  $applicantModel->get_eduhistory(session()->get('log_id'));
		$datac['olevels'] =  $applicantModel->get_olevel(session()->get('log_id'));

		$datac['firstchoice'] = $datac['stddetails'][0]->stdcourse ;
		 $datac['jambs'] =  $accountModel->getjambdetail($datac['stddetails'][0]->jambno);
	  
		echo view('applicants/header', $data);
        echo view('applicants/declares',$datac);
             echo view('applicants/footer');


    }

	public function getSchool(){
    $postData = $this->request->getPost();
	$applicantModel = new ApplicantModel();
	$data = $applicantModel->getcourses($postData);
    echo json_encode($data);
  }




  public function application_preview()
    {
		  $accountModel = new AccountModel();
		  $applicantModel = new ApplicantModel();
	  $data = ['title' => 'TOPS .:: My Application - Application Preview | Portal', 'appno'=>session()->get('appno'),
		 'cs_session'=> $appyear,  'pstat' => $pstat ];
        $datac['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
		$datac['std_eduhistory'] =  $applicantModel->get_eduhistory(session()->get('log_id'));
		$datac['olevels'] =  $applicantModel->get_olevel(session()->get('log_id'));
		$datac['jambs'] =  $accountModel->getjambdetail($datac['stddetails'][0]->jambno);
		$datac['firstchoice'] = $datac['stddetails'][0]->stdcourse ;
 

		echo view('applicants/header', $data);
        echo view('applicants/preview_application',$datac);
             echo view('applicants/footer');


    }

	public function printreceipt()
    {

		  $applicantModel = new ApplicantModel();
          $accountModel = new AccountModel();

		$datas['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
        $datac['paydetails'] =  $applicantModel->getpaydetails(session()->get('log_id'));
	   
		$datac['jambno'] = $datas['stddetails'][0]->jambno;
        $fnames = $datas['stddetails'][0]->surname. ' '.$datas['stddetails'][0]->firstname;

		if ($datas['stddetails'][0]->stdprogramme_id==1 and $datas['stddetails'][0]->std_programmetype==1) {
			$datac['stdphoto'] = $datas['stddetails'][0]->jambno.'.jpg';
		}else{
			$datac['stdphoto'] = $datas['stddetails'][0]->std_photo;
		}

		

  $data = ['title' => 'TOPS .:: Payment Receipt | Portal', 'appno'=>session()->get('appno'), 'fnames' =>  $fnames ];
		//print_r($datac['stdphoto']); exit;
		echo view('applicants/header', $data);
        echo view('applicants/payreceipt',$datac);
             echo view('applicants/footer');

    }

	public function receiptprintout()
    {

		  $applicantModel = new ApplicantModel();
          $accountModel = new AccountModel();

		$datas['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
        $datac['paydetails'] =  $applicantModel->getpaydetails(session()->get('log_id'));
	  // print_r($datas['stddetails']);
		$datac['jambno'] = $datas['stddetails'][0]->jambno;
        $fnames = $datas['stddetails'][0]->surname. ' '.$datas['stddetails'][0]->firstname;

		if ($datas['stddetails'][0]->stdprogramme_id==1 and $datas['stddetails'][0]->std_programmetype==1) {
			$datac['stdphoto'] = $datas['stddetails'][0]->jambno.'.jpg';
		}else{
			$datac['stdphoto'] = $datas['stddetails'][0]->std_photo;
		}

		$datac['stdcourse'] = $datas['stddetails'][0]->stdcourse;
		$datac['programmet_name'] = $datas['stddetails'][0]->programmet_name;
		$datac['programme_name'] = $datas['stddetails'][0]->programme_name;

 
        echo view('applicants/printreceipt',$datac);
         

    }

    public function application_forms()
      {
        $accountModel = new AccountModel();
        $applicantModel = new ApplicantModel();
 $appyear = $accountModel->getsess();
 $appstatus = $applicantModel->getappstatus(session()->get('log_id'));
          $datac['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
      $datac['std_eduhistory'] =  $applicantModel->get_eduhistory(session()->get('log_id'));
      $datac['olevels'] =  $applicantModel->get_olevel(session()->get('log_id'));
        $datac['jambs'] =  $applicantModel->get_jamb(session()->get('log_id'));
      $datac['firstchoice'] = $applicantModel->get_deptoptions($datac['stddetails'][0]->stdcourse);
      $datac['secondchoice'] = $applicantModel->get_deptoptions($datac['stddetails'][0]->stdcourse2);
      $datac['firstschool'] = $accountModel->getskool($datac['stddetails'][0]->stdcourse);
      $datac['secondschool'] = $accountModel->getskool($datac['stddetails'][0]->stdcourse2);
      $datac['examvenue'] = $applicantModel->get_school($datac['stddetails'][0]->evenue);
$fnames = $datac['stddetails'][0]->surname. ' '.$datac['stddetails'][0]->firstname;
      $data = ['title' => 'TOPS .:: My Application - Application Preview | Portal', 'appno'=>session()->get('appno'),
       'cs_session'=> $appyear,  'pstat' => $pstat, 'fnames' =>  $fnames, 'appstatus' => $appstatus ];

      echo view('applicants/header', $data);
          echo view('applicants/applicationforms',$datac);
               echo view('applicants/footer');


      }

	public function application_form()
    {
		  $accountModel = new AccountModel();
		  $applicantModel = new ApplicantModel();
		  $appyear = $accountModel->getsess();
	  $data = ['title' => 'TOPS .:: My Application - Application Preview | Portal', 'appno'=>session()->get('appno'),
		 'cs_session'=> $appyear,  'pstat' => $pstat ];
        $datac['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
		$datac['std_eduhistory'] =  $applicantModel->get_eduhistory(session()->get('log_id'));
		$datac['olevels'] =  $applicantModel->get_olevel(session()->get('log_id'));
		 
		
		
		 
		
		$datac['jambs'] =  $accountModel->getjambdetail($datac['stddetails'][0]->jambno);
		if ($datac['stddetails'][0]->stdprogramme_id == 1) {
			$datac['firstchoice'] = $datac['jambs'][0]->course;
		}else{
			$datac['firstchoice'] = $datac['stddetails'][0]->stdcourse;
		}
         
 
		$datac['examvenue'] = $applicantModel->get_school($datac['stddetails'][0]->evenue);

		echo view('applicants/header', $data);
        echo view('applicants/application_form',$datac);
             echo view('applicants/footer');


    }



	public function application_card()
    {
		  $accountModel = new AccountModel();
		  $applicantModel = new ApplicantModel();
		  $appyear = $accountModel->getsess();
	  $data = ['title' => 'TOPS .:: My Application - Acknowledgement Card | Portal', 'appno'=>session()->get('appno'),
		 'cs_session'=> $appyear,  'pstat' => $pstat ];
        $datac['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
		//print_r($datac['stddetails']);

		$datac['jambs'] =  $accountModel->getjambdetail($datac['stddetails'][0]->jambno);
		if ($datac['stddetails'][0]->stdprogramme_id == 1 and $datac['stddetails'][0]->stdprogrammetype_id == 1 ) {
			$datac['firstchoice'] = $datac['jambs'][0]->course;
		}else{
			$datac['firstchoice'] = $datac['stddetails'][0]->stdcourse;
		}

	 
		
		$datac['examvenue'] = $applicantModel->get_school($datac['stddetails'][0]->evenue);
		$datac['examdate'] = $applicantModel->get_examdate($datac['stddetails'][0]->stdcourse);

		echo view('applicants/header', $data);
        echo view('applicants/application_card',$datac);
             echo view('applicants/footer');


    }



	public function rem_course()
    {
	       $stdid =  session()->get('log_id') ;
		   $applicantModel = new ApplicantModel();
		   $cid = $this->request->uri->getSegment(3);

	       if ($cid == 1){
			 $data = ['stdcourse' => 0];
		}elseif ($cid == 2){
			 $data = ['stdcourse2' => 0];
		}else{
			$data = [];
		}

         $cid = $applicantModel->removecourse($data, $stdid) ;
		if ($cid) {
			 echo '<script type="text/javascript">
			alert("Course Successfully removed");
			 window.location = "../course";
		</script>';
    	}else{
		 echo '<script type="text/javascript">
			alert("Error removing Course");
			 window.location = "../course";
		</script>';
		}
	}

	public function rem_school()
    {
	       $applicantModel = new ApplicantModel();
		   $sid = $this->request->uri->getSegment(3);

         $cid = $applicantModel->removeschool($sid) ;
		if ($cid) {
			 echo '<script type="text/javascript">
			alert("School Detail Successfully removed");
			 window.location = "../school";
		</script>';
    	}else{
		 echo '<script type="text/javascript">
			alert("Error removing School Detail");
			 window.location = "../school";
		</script>';
		}
	}

	 

	public function rem_allolevel()
    {
	       $applicantModel = new ApplicantModel();
		   $sid = session()->get('log_id');

         $cid = $applicantModel->removeallolevel($sid) ;
		if ($cid) {
			 echo '<script type="text/javascript">
			alert("O-Level Detail Successfully Refreshed, You can now enter again");
			 window.location = "../applicant/biodata";
		</script>';
    	}else{
		 echo '<script type="text/javascript">
			alert("Error removing O-Level Detail");
			 window.location = "../applicant/biodata";
		</script>';
		}
	}


	public function rem_olevel()
    {
	       $applicantModel = new ApplicantModel();
		   $sid = $this->request->uri->getSegment(3);

         $cid = $applicantModel->removeolevel($sid) ;
		if ($cid) {
			 echo '<script type="text/javascript">
			alert("O-Level Detail Successfully removed");
			 window.location = "../olevel";
		</script>';
    	}else{
		 echo '<script type="text/javascript">
			alert("Error removing O-Level Detail");
			 window.location = "../olevel";
		</script>';
		}
	}

	public function appfinishs()
    {
        $sdate = date('Y-m-d');
		      $std_id  = session()->get('log_id');
			  $data = [
            "std_custome9" => 1,
            "appsubmitdate" => $sdate
        ];
		$applicantModel = new ApplicantModel();
		$applicantModel->save_schools($data, $std_id);
	    return redirect()->to(base_url('applicant/my_application'));


    }

    public function phistory()
      {
  		  $accountModel = new AccountModel();
  		  $applicantModel = new ApplicantModel();

  		  $appyear = $accountModel->getsess();
  		  $pstat = $applicantModel->getfeestatus(session()->get('log_id'));
  		  $appstatus = $applicantModel->getappstatus(session()->get('log_id'));

  		 if ( $appstatus == 1 ){
  		 $data['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
  		 }else{
  	     $data['stddetails'] =  $accountModel->getacctdetail(session()->get('log_id'));
  		 }

  	 	$progid =  $data['stddetails'][0]->stdprogramme_id;
  	 	 $progtype =  $data['stddetails'][0]->std_programmetype;
       $fnames = $data['stddetails'][0]->surname. ' '.$data['stddetails'][0]->firstname;

           $appfees = $applicantModel->getappfees($progid, $progtype);
		    
           $appbiodata =  $data['stddetails'][0]->biodata;
  		 $datah = ['title' => 'TOPS .:: Home | Portal', 'appno'=>session()->get('appno'),
  		 'cs_session'=> $appyear,  'pstat' => $pstat,  'appstatus' => $appstatus,  'appfees' => $appfees, 'fnames' =>  $fnames,
       'appbiodata' =>  $appbiodata];




  		$data['paystatus'] =  $applicantModel->gettrans_details(session()->get('log_id'));

//
         echo view('applicants/header', $datah);
          echo view('applicants/mypayments',$data);
           echo view('applicants/footer');
      }

   public function checkpayment()
    {

            $data = [];

			$applicantModel = new ApplicantModel();

			 $rs = $applicantModel->getrrr(session()->get('log_id'));

			 

			 if (empty($rs)) {
				  echo '<script type="text/javascript">
			alert("No Transaction had been generated\nKindly generate payment using the `Pay Now` Link");
			window.location = "'.base_url('applicant').'";
		</script>';
			 }else{


			    foreach ($rs as $r){

			          $rrr = $r->trans_no;

			        //revalidate payment
		$mid = "PL03";
         $apkey = "5502";;
        $hash_string = $rrr . $apkey . $mid;
        $hash = hash('sha512', $hash_string);
          $url 	= 'http://tops.oystirev.com/api/swi/trans' . '?' . $rrr . '/' . $hash;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);


        $result = json_decode($response);

       //  print_r($result); exit;
        if ($result->status == 'Paid') {
         $udata = [
             'trans_custom1'  => $result->status,
			 'rrr'  => $result->rrr
        ];
		 $applicantModel->update_rrr($udata, $rrr);
			  echo '<script type="text/javascript">
			alert("Transaction is Successful, Your Transaction ID is '.$rrr.' \nKindly login to print your receipt\nThis transaction will be subject to verification by the Bursary Unit");
			window.location = "'.base_url('applicant').'";
		</script>';
        }else{
              echo '<script type="text/javascript">
			alert("Transaction is Not Successful. Kindly try again");
			window.location = "'.base_url('applicant').'";
		</script>';

        }

			    }

			  }
    }
    
    
    public function afee()
      {
  		  $accountModel = new AccountModel();
  		  $applicantModel = new ApplicantModel();

  		  $appyear = $accountModel->getsess();
  		  $pstat = $applicantModel->getfeestatus(session()->get('log_id'));
  		  $appstatus = $applicantModel->getappstatus(session()->get('log_id'));
  		  $admstatus = $applicantModel->getadmstatus(session()->get('log_id'));
  		  
  		  
  		  if ( $appstatus == 1 ){
  		 $data['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
  		 }else{
  		     
  	       echo '<script type="text/javascript">
			alert("You have to submit your application and get admitted before you can pay your Acceptance Fee");
			window.location = "'.base_url('applicant').'";
		</script>';
  		 }
  		 //check if student is qualified to pay acceptance fee
  		  if ( $admstatus == 0 ){
  		 
  		     
  	       echo '<script type="text/javascript">
			alert("You have to be admitted before you can pay your Acceptance Fee");
			window.location = "'.base_url('applicant').'";
		</script>';
  		 }
  		  

  		 

  	 	$progid =  $data['stddetails'][0]->stdprogramme_id;
  	 	 $progtype =  $data['stddetails'][0]->std_programmetype;
       $fnames = $data['stddetails'][0]->surname. ' '.$data['stddetails'][0]->firstname;

           $appfees = $applicantModel->getacceptfees($progid, $progtype);
   $appbiodata =  $data['stddetails'][0]->biodata;
  		 $datah = ['title' => 'TOPS .:: Home | Portal', 'appno'=>session()->get('appno'),
  		 'cs_session'=> $appyear,  'pstat' => $pstat,  'appstatus' => $appstatus,  'appfees' => $appfees, 'fnames' =>  $fnames,
       'appbiodata' =>  $appbiodata];




  		$data['paystatus'] =  $applicantModel->getaccept_details(session()->get('log_id'));


         echo view('applicants/header', $datah);
          echo view('applicants/acceptfee',$data);
           echo view('applicants/footer');
      }
    
    public function payacceptance()
	{



		 $data = [];
	
			 $accountModel = new AccountModel();
			 $applicantModel = new ApplicantModel();

			 //check if portal is closed
		  

			 $stddetails = $accountModel->getacctdetail(session()->get('log_id'));
			 
			 $appstatus = $applicantModel->getappstatus(session()->get('log_id'));
  		  $admstatus = $applicantModel->getadmstatus(session()->get('log_id'));
			 
			 if ( $admstatus == 0 or $appstatus == 0){
  		 
  		     
  	       echo '<script type="text/javascript">
			alert("You must submit your application or be admitted before you can pay your Acceptance Fee");
			window.location = "'.base_url('applicant').'";
		</script>';
  		 }
			 
		// print_r($stddetails); exit;
              foreach($stddetails as $stddetail){
				  $appno = $stddetail->app_no;
				  $surname = $stddetail->surname;
				  $firstname = $stddetail->firstname;
				  $othernames = $stddetail->othernames;
				  $semail = $stddetail->student_email;
				  $sgsm = $stddetail->student_mobiletel;
				  $progid = $stddetail->stdprogramme_id;
				  $progtype = $stddetail->std_programmetype;
				  $progname = $stddetail->programme_name;
				  $progtypename = $stddetail->programmet_name;
				  $stdcoursename = $stddetail->programme_option;

			 }

			 $timesammp=DATE("dmyHis");
	         $tid = session()->get('log_id').$timesammp;
		    $fdate = date('Y-m-d h:i:s');
		    $tdate = date('Y-m-d');

		 $applicantModel = new ApplicantModel();
         $appfees = $applicantModel->getacceptfees($progid, $progtype);


//end get RRR
		$tid = session()->get('log_id').$timesammp;
		$fdate = date('Y-m-d h:i:s');
		$tdate = date('Y-m-d');
		$cs_session =  $accountModel->getsess();
		$data = [
            'log_id' => session()->get('log_id'),
             'fee_id'  => 2,
            'fee_name'  => "Acceptance Fee",
			'trans_no' => $tid,
            'fee_amount'  => $appfees,
			'generated_date' => $fdate,
			'trans_date' => $fdate,
			't_date' => $tdate,
			'trans_year' => $cs_session,
			'fullnames' => "$surname $firstname $othernames",
			'semail'  => $semail,
			'appno'  => $appno,
			'rrr'  => 'N/A'
        ];


        	 if($applicantModel->save_transaction($data))
        { 



			$fullname = "$surname $firstname $othernames";
			$trans_name = "Acceptance Fee";


		  $mid = "PL03";
          $apkey = "5502";
          $hash_string = $mid . $tid . $apkey;
          $new_hash = hash('sha512', $hash_string);
	      $redirect_url = base_url('applicant/remitaresponse');
		  echo '<form action="https://tops.oystirev.com/pltpayment" name= "apiform" method="POST" id="apiform">

<input name="client_code" type="hidden" id="client_code" value="TOPS">
<input name="client" type="hidden" id="client_code" value="OKEOGUN">
<input name="matricno" type="hidden" value="'.$appno.'">
<input name="fullname" type="hidden"   value="'.$fullname.'">
<input name="trans_name" type="hidden"   value="'.$trans_name.'">
<input name="trans_no" type="hidden"   value="'.$tid.'">
<input name="department" type="hidden"   value="'.$stdcoursename.'">
<input name="faculty" type="hidden"   value="N/A">
<input name="amount" type="hidden"  value="'.$appfees.'">
<input name="session" type="hidden"   value="'.$cs_session.'">
<input name="semester" type="hidden"   value="First Semester">
<input name="programme" type="hidden" value="'.$progname.'">
<input name="programmetype" type="hidden"  value="'.$progtypename.'">
<input name="level" type="hidden"  value="N/A">
<input name="email" type="hidden"  value="'.$semail.'">
<input name="gsmno" type="hidden" value="'.$sgsm.'">
<input name="stateoforigin" type="hidden" value="N/A">
<input name="studenttype" type="hidden" value="N/A">
<input name="policy" type="hidden" value="Full Payment">
<input name="Pay_items" type="hidden" value="'.base64_encode($trans_name).'">
<input name="redirect_url" type="hidden" id="redirect_url" value="'.$redirect_url.'">
 <input name="hash_string" type="hidden" value="'.$new_hash.'">
 <script language="JavaScript">document.apiform.submit();</script>

</form>



';


		}else{

		 echo '<script type="text/javascript">
			alert("Error Generating Transaction ID,  Please Try Again");
			window.location = "../applicant";
		</script>';



		}

	}
	
	public function cfee()
      {
  		  $accountModel = new AccountModel();
  		  $applicantModel = new ApplicantModel();

  		  $appyear = $accountModel->getsess();
  		  $pstat = $applicantModel->getfeestatus(session()->get('log_id'));
  		  $appstatus = $applicantModel->getappstatus(session()->get('log_id'));
  	      $admstatus = $applicantModel->getadmstatus(session()->get('log_id'));
  	      $convert = $accountModel->getconversion();
  	 	   
  		   if ( $convert == 0 ){
  		 
  		     
  	       echo '<script type="text/javascript">
			alert("Payment for Conversion has not been enabled");
			window.location = "'.base_url('applicant').'";
		</script>';
  		 }
  		  
  		if ( $appstatus == 1 ){
  		 $data['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
  		 }else{
  		     
  	       echo '<script type="text/javascript">
			alert("You have to submit your application and before you can pay your Conversion Fee");
			window.location = "'.base_url('applicant').'";
		</script>';
  		 }
  		 //check if student is qualified to pay acceptance fee
  		  if ( $admstatus == 1 ){
  		 
  		     
  	       echo '<script type="text/javascript">
			alert("You are already admitted you should no longer Convert");
			window.location = "'.base_url('applicant').'";
		</script>';
  		 }
  		  
         
  	   
  	 	$progid =  $data['stddetails'][0]->stdprogramme_id;
  	 	 $progtype =  $data['stddetails'][0]->std_programmetype;
       $fnames = $data['stddetails'][0]->surname. ' '.$data['stddetails'][0]->firstname;
       
       $appfees = $applicantModel->getconvertfees($progid, $progtype);
            $appbiodata =  $data['stddetails'][0]->biodata;
  		 $datah = ['title' => 'TOPS .:: Home | Portal', 'appno'=>session()->get('appno'),
  		 'cs_session'=> $appyear,  'pstat' => $pstat,  'appstatus' => $appstatus,  'appfees' => $appfees, 'fnames' =>  $fnames,
       'appbiodata' =>  $appbiodata];


  		$data['paystatus'] =  $applicantModel->getconvert_details(session()->get('log_id'));

         echo view('applicants/header', $datah);
          echo view('applicants/convertfee',$data);
           echo view('applicants/footer'); 
      }

public function payconversion()
	{



		 $data = [];
	
			 $accountModel = new AccountModel();
			 $applicantModel = new ApplicantModel();

			 //check if portal is closed
		  

			 $stddetails = $accountModel->getacctdetail(session()->get('log_id'));
			 
			 $appstatus = $applicantModel->getappstatus(session()->get('log_id'));
  		   $convert = $accountModel->getconversion();
			 
			 if ( $appstatus == 0 or $convert == 0){
  		 
  		     
  	       echo '<script type="text/javascript">
			alert("You must submit your application before you can pay for Conversion / Conversion Fee payment is not enabled");
			window.location = "'.base_url('applicant').'";
		</script>';
  		 }
			 
	  //print_r($stddetails); exit;
              foreach($stddetails as $stddetail){
				  $appno = $stddetail->app_no;
				  $surname = $stddetail->surname;
				  $firstname = $stddetail->firstname;
				  $othernames = $stddetail->othernames;
				  $semail = $stddetail->student_email;
				  $sgsm = $stddetail->student_mobiletel;
				  $progid = $stddetail->stdprogramme_id;
				  $progtype = $stddetail->std_programmetype;
				  $progname = $stddetail->programme_name;
				  $progtypename = $stddetail->programmet_name;
				  $stdcoursename = $stddetail->programme_option;

			 }

			 $timesammp=DATE("dmyHis");
	         $tid = session()->get('log_id').$timesammp;
		    $fdate = date('Y-m-d h:i:s');
		    $tdate = date('Y-m-d');

	
         $appfees = $applicantModel->getconvertfees($progid, $progtype);


//end get RRR
		$tid = session()->get('log_id').$timesammp;
		$fdate = date('Y-m-d h:i:s');
		$tdate = date('Y-m-d');
		$cs_session =  $accountModel->getsess();
		$data = [
            'log_id' => session()->get('log_id'),
             'fee_id'  => 3,
            'fee_name'  => "Conversion Fee",
			'trans_no' => $tid,
            'fee_amount'  => $appfees,
			'generated_date' => $fdate,
			'trans_date' => $fdate,
			't_date' => $tdate,
			'trans_year' => $cs_session,
			'fullnames' => "$surname $firstname $othernames",
			'semail'  => $semail,
			'appno'  => $appno,
			'rrr'  => 'N/A'
        ];


        	 if($applicantModel->save_transaction($data))
        { 



			$fullname = "$surname $firstname $othernames";
			$trans_name = "Conversion Fee";


		  $mid = "PL03";
          $apkey = "5502";
          $hash_string = $mid . $tid . $apkey;
          $new_hash = hash('sha512', $hash_string);
	      $redirect_url = base_url('applicant/remitaresponse');
		  echo '<form action="https://tops.oystirev.com/pltpayment" name= "apiform" method="POST" id="apiform">

<input name="client_code" type="hidden" id="client_code" value="TOPS">
<input name="client" type="hidden" id="client_code" value="OKEOGUN">
<input name="matricno" type="hidden" value="'.$appno.'">
<input name="fullname" type="hidden"   value="'.$fullname.'">
<input name="trans_name" type="hidden"   value="'.$trans_name.'">
<input name="trans_no" type="hidden"   value="'.$tid.'">
<input name="department" type="hidden"   value="'.$stdcoursename.'">
<input name="faculty" type="hidden"   value="N/A">
<input name="amount" type="hidden"  value="'.$appfees.'">
<input name="session" type="hidden"   value="'.$cs_session.'">
<input name="semester" type="hidden"   value="First Semester">
<input name="programme" type="hidden" value="'.$progname.'">
<input name="programmetype" type="hidden"  value="'.$progtypename.'">
<input name="level" type="hidden"  value="N/A">
<input name="email" type="hidden"  value="'.$semail.'">
<input name="gsmno" type="hidden" value="'.$sgsm.'">
<input name="stateoforigin" type="hidden" value="N/A">
<input name="studenttype" type="hidden" value="N/A">
<input name="policy" type="hidden" value="Full Payment">
<input name="Pay_items" type="hidden" value="'.base64_encode($trans_name).'">
<input name="redirect_url" type="hidden" id="redirect_url" value="'.$redirect_url.'">
 <input name="hash_string" type="hidden" value="'.$new_hash.'">
 <script language="JavaScript">document.apiform.submit();</script>

</form>



';


		}else{

		 echo '<script type="text/javascript">
			alert("Error Generating Transaction ID,  Please Try Again");
			window.location = "../applicant";
		</script>';



		}

	}

	public function remitaresponse()
	{
		  $params =  $_REQUEST['params'];
		  $param = json_decode($params);

		  $data = [
            'rrr' => $param->rrr,
            'paytype'  => $param->paytype,
			'trans_no' => $param->trans_no,
            'amount'  => $param->amount,
			'datepaid' => $param->datepaid,
             'status'  => $param->status,
			 'message'  => $param->message
        ];



		$accountModel = new AccountModel();
		$applicantModel = new ApplicantModel();
	    $saveresponse = $accountModel->saveresponse($data);

	 if ($saveresponse){
		 //update payment with RRR
		  $pdata = [
            'rrr' => $param->rrr
        ];

		 $accountModel->update_transactions($pdata, $param->trans_no);
		}
		 //get status of RRR and update

		 if ($param->status == 'Paid'){
		 //revalidate payment
		$mid = "PL01";
        $apkey = "1009";
        $rrr = $param->trans_no;
        $hash_string = $rrr . $apkey . $mid;
        $hash = hash('sha512', $hash_string);
        $url 	= 'http://tops.oystirev.com/api/swi/trans' . '?' . $rrr . '/' . $hash;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);

        $result = json_decode($response);

			 $udata = [
             'trans_custom1'  => $result->status
        ];
		 $accountModel->update_transactions($udata, $result->ptrans_no);

		 $paymentdata =  $applicantModel->gettransactiondetails($result->ptrans_no);
		 
		 if($paymentdata->fee_id == 3){
			$prefix = "P22";
			$gps = count($accountModel->getlistofstudents($prefix))+1;
			$paddedstring = str_pad("$gps",5, "0", STR_PAD_LEFT);
			$newformnumber = $prefix.$paddedstring;
			$data = ['std_programmetype'=> 2, 'app_no'=> $newformnumber];
			$accountModel->updateacctdetail($data,session()->get('log_id'));
		 }


			  echo '<script type="text/javascript">
			alert("Transaction is Successful, Your RRR is '.$param->rrr.' \nKindly login to print your receipt\nThis transaction will be subject to verification by the Bursary Unit");
			window.location = "'.base_url('applicant').'";
		</script>';
		 }else{
			  echo '<script type="text/javascript">
			alert("Transaction is Pending, Your RRR is '.$param->rrr.' \nKindly requery your transaction if debited or try again");
			window.location = "'.base_url('applicant/paymentslip/'.$param->trans_no).'";
			</script>';
		 }


	
	}

	public function aphistory()
      {
  		  $accountModel = new AccountModel();
  		  $applicantModel = new ApplicantModel();

  		  $appyear = $accountModel->getsess();
  		  $pstat = $applicantModel->getfeestatus(session()->get('log_id'));
  		  $appstatus = $applicantModel->getappstatus(session()->get('log_id'));

  		 if ( $appstatus == 1 ){
  		 $data['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
  		 }else{
  	     $data['stddetails'] =  $accountModel->getacctdetail(session()->get('log_id'));
  		 }

  	 	$progid =  $data['stddetails'][0]->stdprogramme_id;
  	 	 $progtype =  $data['stddetails'][0]->std_programmetype;
       $fnames = $data['stddetails'][0]->surname. ' '.$data['stddetails'][0]->firstname;

           $appfees = $applicantModel->getacceptfees($progid, $progtype);
		    
           $appbiodata =  $data['stddetails'][0]->biodata;
  		 $datah = ['title' => 'TOPS .:: Home | Portal', 'appno'=>session()->get('appno'),
  		 'cs_session'=> $appyear,  'pstat' => $pstat,  'appstatus' => $appstatus,  'appfees' => $appfees, 'fnames' =>  $fnames,
       'appbiodata' =>  $appbiodata];


 

  		$data['paystatus'] =  $applicantModel->getaccept_details(session()->get('log_id'));


         echo view('applicants/header', $datah);
          echo view('applicants/accpayments',$data);
           echo view('applicants/footer');
      }

	  public function admletter()
    {
		 $accountModel = new AccountModel();
		 $applicantModel = new ApplicantModel();
		 $appyear = $accountModel->getsess();
		  $appsess = substr($appyear,2,4); 

		  $data['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
		  $progid =  $data['stddetails'][0]->stdprogramme_id;
  	 	  $progtype =  $data['stddetails'][0]->std_programmetype;
 
		   if ($progid == 1 and $progtype == 1) { //jamb candidates
			$deptname = $accountModel->getprog_code_jamb($data['stddetails'][0]->stdcourse);
		   }else{
			$deptname = $accountModel->getprog_code($data['stddetails'][0]->stdcourse);
		   }
		  //  $deptname = $accountModel->getdeptname($pcode); 
		//  $dnos = $accountModel->getstdno($data['stddetails'][0]->stdcourse, $appsess);
		     //$app_no = "$fac$pcode$appsess$dnos";
		   // $admdate = $accountModel->getadmdate($progid, $data['stddetails'][0]->stdcourse);

			$paystatus  =  $applicantModel->getaccept_details(session()->get('log_id'));
			$stdstatus =  $paystatus[0]->trans_custom1 ;

		 
        $datah = ['title' => 'TOPS .:: Home | Application Portal',  'appno'=>session()->get('appno'),
	 	 'cs_session'=> $appyear,  'pstat' => $pstat,  'csstat' => $csstat, 'app_no' => $app_no, 'deptname' => $deptname];

		//   if ($stdstatus != 'Paid'){
		//  	 echo '<script type="text/javascript">
		//  	alert("Kindly Pay the  Acceptance Fee before you can access your Admission Letter");
		// 	 window.location = "'.base_url('applicant').'";
		//  </script>';
		//  	exit; 
		//  }

		 echo view('applicants/header', $datah);
		  echo view('applicants/admletta',$data);
		  echo view('applicants/footer');
        
    }


	public function update_profile_add_olevel_test()
	{
		 helper(['form', 'url']);
		 $data = [];
		  if($this->request->getMethod()=='post')
        {
            $rules = [
                'gender'=>'required',
                'marital_status'=>'required',
				'student_homeaddress'=>'required',
				'contact_address'=>'required',
				'nok'=>'required',
				'nok_tel'=>'required',
				'nok_address'=>'required',
				'nok_email'=>'required',
				'clga'=>'required'];
			$dob = $this->request->getVar('dob');
			$mob = $this->request->getVar('mob');
		    $yob = $this->request->getVar('yob');
			$coversion = $this->request->getVar('conversionbox');
			$birthday = "$yob-$mob-$dob";
			 $std_id  = session()->get('log_id');
			if($this->validate($rules))
            {

			 
			$appno = session()->get('appno');
			$accountModel = new AccountModel();
			 //check if portal is closed

		    $pstatus = $accountModel->portalclosing();
		  if ($pstatus == '0'){
			 echo '<script type="text/javascript">
			alert("Portal is CLOSED to Biodata Update");
			window.location = "'.base_url('applicant/').'";
		</script>';
			exit;
		}

		      $appyear = $accountModel->getsess();
				
 if ($this->request->getVar('sprog') == 1 && $this->request->getVar('sprogtype') == 1){
	 
	$data = [

		'gender' => $this->request->getVar('gender'),
		'marital_status' => $this->request->getVar('marital_status'),
		'student_homeaddress' => $this->request->getVar('student_homeaddress'),
		'contact_address' => $this->request->getVar('contact_address'),
		'next_of_kin' => $this->request->getVar('nok'),
		'nok_tel' => $this->request->getVar('nok_tel'),
		'nok_address' => $this->request->getVar('nok_address'),
		'nok_email' => $this->request->getVar('nok_email'),
		'local_gov' => $this->request->getVar('clga'),
		'birthdate' => $birthday,
		'biodata' => 1,
		'std_custome7' => 1,
		'is_converted' => 0,
		'state_of_origin' => $this->request->getVar('cstate')
		];

 }else{
	$data = [

		'gender' => $this->request->getVar('gender'),
		'marital_status' => $this->request->getVar('marital_status'),
		'student_homeaddress' => $this->request->getVar('student_homeaddress'),
		'contact_address' => $this->request->getVar('contact_address'),
		'next_of_kin' => $this->request->getVar('nok'),
		'nok_tel' => $this->request->getVar('nok_tel'),
		'nok_address' => $this->request->getVar('nok_address'),
		'nok_email' => $this->request->getVar('nok_email'),
		'local_gov' => $this->request->getVar('clga'),
		'birthdate' => $birthday,
		'biodata' => 1,
		'is_converted' =>  0,
		'std_custome7' => 1
		];
	
 }
             //print_r($data); exit;
            $applicantModel = new ApplicantModel();
	 	$updatebio =	$applicantModel->updatebiodata($data, $std_id);
		 $olevels =  $applicantModel->get_olevel(session()->get('log_id'));

		 if($updatebio and empty($olevels)){


	//first sitting		
     $subjects = $this->request->getVar('subject');
	 $mySubjects = array_values(array_filter($subjects));
	 $grades = $this->request->getVar('grade');
	 $myGrades = array_values(array_filter($grades));
		$nosubject = count( $mySubjects);
		$nogrades = count( $myGrades);
		

		if ($nosubject != $nogrades){
			echo '<script type="text/javascript">
			alert("No of Olevel Subject & Grade for First Sitting are not the same, kindly reselect again");
			window.location = "'.base_url('applicant/biodata').'";
		</script>';
			exit;
		}

		//second sitting		
		$subjectss = $this->request->getVar('subjects');
		$mySubjectss = array_values(array_filter($subjectss));
		$gradess = $this->request->getVar('grades');
		$myGradess = array_values(array_filter($gradess));
		   $nosubjects = count( $mySubjectss);
		   $nogradess = count( $myGradess);

		   if ($nosubjects != $nogradess){
			echo '<script type="text/javascript">
			alert("No of Olevel Subject & Grade for Second Sitting are not the same, kindly reselect again");
			window.location = "'.base_url('applicant/biodata').'";
		</script>';
			exit;
		}

		$totalsubjects  = $nosubject + $nosubjects; 

		if ($totalsubjects < 5){
			echo '<script type="text/javascript">
			alert("You must Select at least 5 Olevel Subjects");
			window.location = "'.base_url('applicant/biodata').'";
		</script>';
			exit;
		}
	

		
	  if  ($totalsubjects){

		//remove previous registration
		 
		 $applicantModel->removeallolevel(session()->get('log_id')) ;

		 //for 1st sitting
			 for ($i = 1; $i <= $nosubject ; $i++) {
				$subjects = $mySubjects[$i];
				$grades = $myGrades[$i];
				$data = [
            'std_id' => session()->get('log_id'),
            'subname'  => $this->request->getVar('subject')[$i],
			'certname' =>$this->request->getVar('examtype'),
            'grade'  => $this->request->getVar('grade')[$i],
			'emonth' => strtoupper($this->request->getVar('frommth')),
			'examno' => $this->request->getVar('examno'),
			'centerno' => $this->request->getVar('centerno'),
			'eyear' => $this->request->getVar('toyear'),
			'sitting' => 'First'

        ];

		//print_r($data); exit;
		 $successfirst  = $applicantModel->save_olevel($data);
			}
			
//for 2nd sitting
for ($j = 1; $j <= $nosubjects ; $j++) {
	$subjectss = $mySubjectss[$j];
	$gradess = $myGradess[$j];
	$datas = [
'std_id' => session()->get('log_id'),
'subname'  => $this->request->getVar('subjects')[$j],
'certname' =>$this->request->getVar('examtypes'),
'grade'  => $this->request->getVar('grades')[$j],
'emonth' => strtoupper($this->request->getVar('frommths')),
'examno' => $this->request->getVar('examnos'),
'centerno' => $this->request->getVar('centernos'),
'eyear' => $this->request->getVar('toyears'),
'sitting' => 'Second'

];

$successsecond  = $applicantModel->save_olevel($datas);
}


				echo '<script type="text/javascript">
				alert("Your Biodata and Olevel was successfully Updated");
				window.location = "../applicant/biodata";
			</script>';
		

			}else{
				echo '<script type="text/javascript">
				alert("Error Adding Olevel1");
				window.location = "../applicant/biodata";
			</script>'; 
			}
			echo '<script type="text/javascript">
			alert("Error Adding Olevel2");
			window.location = "../applicant/biodata";
		</script>'; 

		}else{

		  echo '<script type="text/javascript">
			alert("Biodata Updated");
			window.location = "../applicant/biodata";
		</script>'; 



		}

			}

			echo '<script type="text/javascript">
			alert("Error Updating Biodata");
			window.location = "../applicant/biodata";
		</script>'; 
		}
	}

	public static function getValidUrl($file) {
		$file_headers = @get_headers($file);
		 $headerstring = $file_headers[0];
		$exists = strpos($headerstring, '404') ? 0 : 1;
		return $exists;
		}

		public function screening()
    {
		$accountModel = new AccountModel();
		$applicantModel = new ApplicantModel();


		$checkolevelscreen =  $applicantModel->getscreeningstatus();

		if (!$checkolevelscreen) {
			echo '<script type="text/javascript">
	  alert("Online Screening is currently not available, you can check back later.");
	  window.location = "'.base_url('applicant').'";
  </script>'; exit;
}

		$checkolevelscreen =  $applicantModel->checkScreen(session()->get('log_id'));

		if ($checkolevelscreen) {
			echo '<script type="text/javascript">
	  alert("You have already submitted your Olevel Subjects for screening");
	  window.location = "'.base_url('applicant').'";
  </script>'; exit;
}
  
		$appyear = $accountModel->getsess();
		$pstat = $applicantModel->getfeestatus(session()->get('log_id'));
		$biostatus = $applicantModel->getbiostatus(session()->get('log_id'));
  
		if ($pstat == '0'){
			   echo '<script type="text/javascript">
			  alert("You must pay for the Application Form before you update your biodata");
			  window.location = "'.base_url('applicant/').'";
		  </script>';
			  exit;
		  }
  
  
	   if ( $biostatus == 1 ){
	   $data['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
	   }else{
		 $data['stddetails'] =  $accountModel->getacctdetail(session()->get('log_id'));
	   }
	   
	 
	   
	   $fnames = $data['stddetails'][0]->surname. ' '.$data['stddetails'][0]->firstname;
	   $data['jambdetails'] =  $accountModel->getjambdetail($data['stddetails'][0]->jambno);

	    $admreg = $applicantModel->get_admreq($data['stddetails'][0]->stdcourse);
  
	  
  
	   $datah = ['title' => 'TOPS .:: Pay Application Fees | Portal', 'appno'=>session()->get('appno'),
	   'cs_session'=> $appyear,  'pstat' => $pstat,    'fnames' =>  $fnames, 'admreg' => $admreg ];
 
        $appOlevels =  $applicantModel->get_olevel(session()->get('log_id'));

		$secondSitting = [];
		foreach ($appOlevels as $subjs) {
    		if ($subjs->sitting === 'Second') {
        		$secondSitting[] = $subjs;
    		}
		}

	 $data['hasSecondSitting'] =  $secondSitting;
	   
	  $data['olevels'] =  $applicantModel->get_jamb_olevel($data['stddetails'][0]->jambno);
  // print_r($data['olevels']); exit;
 
		 echo view('applicants/header', $datah);
		  echo view('applicants/screening',$data);
		   echo view('applicants/footer');


    }

	public function submit_screening()
    {

		  $sel_sub =  $this->request->getVar('sel_sub') ?? [];
	  	$selsubs =  $this->request->getVar('sel_subs') ?? [];

	
	 	$allselected = array_merge($sel_sub,$selsubs ) ;
		 
		if ($selsubs){
			$hasDoubleSitting = 1;
		}
		if (empty($allselected)) {
				  echo '<script type="text/javascript">
			alert("No Subject(s) had been selected, Kindly select Subject(s) for screening");
			window.location = "'.base_url('applicant/screening').'";
		</script>'; exit;
	}
	$nos = count($allselected);
	if ($nos > 5  || $nos < 5) {
		echo '<script type="text/javascript">
  alert("You are to select 5 subjects from your combination");
  window.location = "'.base_url('applicant/screening').'";
</script>'; exit; 
}
$applicantModel = new ApplicantModel();

//$selectedsubjects =  $applicantModel->getsubject_details($selsub);
$selectedsubject =  $applicantModel->getjambsubject_details($sel_sub) ?? [];


 

if ($hasDoubleSitting) {
	$selectedsubjects =  $applicantModel->getsubject_details($selsubs);
	 
		foreach ($selectedsubjects as $item) {
			$item = (object) $item; 
			$item->subjects = $item->subname;
			unset($item->subname);
		
			$item->grades = $item->grade;
			unset($item->grade);
		}
	 
   $divisor = 5;
} else {
	$divisor = 10;
}
$selectedsubjects = $selectedsubjects ?? [];
 
$selectedsubjects = array_merge($selectedsubject, $selectedsubjects);



//print_r($selectedsubjects); 

//check that maths/eng is selected
/*$requiredSubjects = ['MATHEMATICS', 'ENGLISH LANG.'];
$foundSubjects = [];

foreach ($selectedsubjects as $reqSubject) {
    if (in_array($reqSubject->subjects, $requiredSubjects)) {
        $foundSubjects[] = $reqSubject->subjects;
    }
}

if (count(array_intersect($requiredSubjects, $foundSubjects)) !== count($requiredSubjects)) {
	echo '<script type="text/javascript">
	alert("You must select MATHEMATICS AND ENGLISH LANG.");
	window.location = "'.base_url('applicant/screening').'";
  </script>'; exit;
}  

//check for duplicate subjects
$uniqueCheck = [];
$duplicates = [];

foreach ($selectedsubjects as $subjects) {
    if (in_array($subjects->subjects, $uniqueCheck)) {
        $duplicates[] = $subjects->subjects;
    } else {
        $uniqueCheck[] = $subjects->subjects;
    }
}

*/



$mathEnglishSubjects = [];
$duplicatesExist = false;

foreach ($selectedsubjects as $reqSubject) {
    $lowercaseSubject = strtolower($reqSubject->subjects);
    if (strpos($lowercaseSubject, 'mathematics') === 0 || strpos($lowercaseSubject, 'english') === 0) {
        if (in_array($reqSubject->subjects, $mathEnglishSubjects)) {
            $duplicatesExist = true;
            break;
        }
        $mathEnglishSubjects[] = $reqSubject->subjects;
    }
}
 
$containsMathematics = false;
$containsEnglish = false;

foreach ($selectedsubjects as $item) {
    $lowercaseSubject = strtolower($item->subjects);
    if (strpos($lowercaseSubject, 'mathematics') === 0) {
        $containsMathematics = true;
    }
    if (strpos($lowercaseSubject, 'english') === 0) {
        $containsEnglish = true;
    }
}

if (!($containsMathematics && $containsEnglish)) {
	echo '<script type="text/javascript">
	alert("You must select MATHEMATICS AND ENGLISH LANG.");
	window.location = "'.base_url('applicant/screening').'";
  </script>'; exit;
}  
 

if (count($mathEnglishSubjects) < 2) {
	echo '<script type="text/javascript">
	alert("You must select MATHEMATICS AND ENGLISH LANG.");
	window.location = "'.base_url('applicant/screening').'";
  </script>'; exit;
} 


foreach ($selectedsubjects as $items) {
    $subjectCounts = array();

    // Parsing the subjects from the subject_grades string
    $pattern = '/([a-zA-Z\s]+) - [A-Z0-9]+/';
    preg_match_all($pattern, $items->subject_grades, $matches);

    if (isset($matches[1])) {
        foreach ($matches[1] as $subject) {
            $lowercaseSubject = strtolower($subject);
            if (!isset($subjectCounts[$lowercaseSubject])) {
                $subjectCounts[$lowercaseSubject] = 1;
            } else {
                $subjectCounts[$lowercaseSubject]++;
            }
        }
    }

    $duplicatedSubjects = array_filter($subjectCounts, function ($count) {
        return $count > 1;
    });

    if (count($duplicatedSubjects) > 0) {
        echo "Some subjects are duplicated in the 'subject_grades' string for log_id: " . $item->log_id . ".\n";
        echo "The duplicated subjects are: " . implode(", ", array_keys($duplicatedSubjects)) . "\n";
    } else {
        echo "No subjects are duplicated in the 'subject_grades' string for log_id: " . $item->log_id . ".\n";
    }
}
 
if ($duplicatesExist) {
    $duppy = implode(", ", $mathEnglishSubjects);
	echo '<script type="text/javascript">
	alert("You have selected duplicated subject(s): '.$duppy.'\n");
	window.location = "'.base_url('applicant/screening').'";
  </script>'; exit;
} 

//check for 2nd sitting

/*$foundSecond = false;
foreach ($selectedsubjects as $subject) {
    if ($subject->sitting === 'Second') {
        $foundSecond = true;
        break;
    }
}*/

$jambcutoff = 120;

//compute score
$grades = array_column($selectedsubjects, 'grades');

$score = $applicantModel->calculateTotalWeightedScore($grades);
$utmescore = $applicantModel->getjambscore(session()->get('log_id'));

$actualscore = $score + $divisor ;
$jambscore = ($utmescore > $jambcutoff) ? ($utmescore/400*60) : 0;
 $totalscore = $actualscore + $jambscore;

 // Convert the stdClass objects array to an associative array
 $gradeWeightsArray = $applicantModel->gradeWeights();

$gradeWeights = [];
foreach ($gradeWeightsArray as $gradeweight) {
    $gradeWeights[$gradeweight->gradecode] = $gradeweight->points;
}
	 
 $result = [];
    foreach ($selectedsubjects as $olevelsub) {
        $subject = $olevelsub->subjects;
        $grade = $olevelsub->grades;
        $points = isset($gradeWeights[$grade]) ? $gradeWeights[$grade] : 0;
        $result[] = "$subject - $grade ($points)";
    }
      $subject_grades =  implode(', ', $result) . ', Sitting('.$divisor.'), UTME Score: '.$utmescore.'('.$jambscore.')';

	  $data = [
		'log_id' => session()->get('log_id'),
		'subject_grades'  => $subject_grades,
		'havesecondsitting' => $hasDoubleSitting,
		'score'  => $totalscore
	];
	 print_r($data); exit;
 
	$submit = $applicantModel->save_screening($data);
	if ($submit) {
		echo '<script type="text/javascript">
	alert("OLevel Subjects have been successfully submitted for screening");
	window.location = "'.base_url('applicant').'";
  </script>'; exit;

	}else{

		echo '<script type="text/javascript">
	alert("Error submitting OLevel Subjects for screening");
	window.location = "'.base_url('applicant/screening').'";
  </script>'; exit;

	}

	

    }
	  
}

 

?>
