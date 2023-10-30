<?php namespace App\Controllers;
use App\Models\AccountModel;
use CodeIgniter\Controller;
 

class Account extends Controller
{


	public function store()
	{

		$captchaResult   = $this->request->getVar('captchaResult');
	    $checkTotal = $this->request->getVar('firstNumber') + $this->request->getVar('secondNumber');
		$catch = ($captchaResult == $checkTotal) ?  "good" : "false";
       if ($catch == 'false') {
     echo '<script type="text/javascript">
			alert("Kindly solve the Maths, your answer is incorrect");
			window.location = "../home/start";
		</script>'; exit;

}
		 $data = [];
		 if($this->request->getMethod()=='post')
        {
			 $accountModel = new AccountModel();

			  //check if portal is closed

		    $pstatus = $accountModel->portalclosing();
		  if ($pstatus == '0'){
			 echo '<script type="text/javascript">
			alert("Portal is CLOSED to Application Form Payment");
			window.location = "'.base_url().'";
		</script>';
			exit;
		}


		 	$prefix = substr($accountModel->getprogrammetype($this->request->getVar('sprogtype')),0,1);
			 $appyear = substr($accountModel->getsess(),2,4);
			  $username = $accountModel->getnos($this->request->getVar('sprogtype'), $appyear);
		      $appno = "$prefix$appyear$username";
              $jambno = strtoupper($this->request->getVar('jambno'));
			  $semail = strtolower($this->request->getVar('log_email'));

			  $gsm = $this->request->getVar('log_gsm');
//$passkey = password_hash($this->request->getVar('pwd'), PASSWORD_DEFAULT);
//$passes = $this->request->getVar('pwd');

$passkey = password_hash($gsm, PASSWORD_DEFAULT);
$passes = $gsm;

 

		if ($this->validate([
        'log_email'        => 'required|valid_email|is_unique[applogin.log_email]',
        
        'log_surname' =>  'required',
		'log_firstname' =>  'required',
		'log_gsm' =>   'required',
		'jambno' =>   'required'

    ])){

			$data = [
            'log_surname' => strtoupper($this->request->getVar('log_surname')),
            'log_firstname'  => strtoupper($this->request->getVar('log_firstname')),
			'log_othernames' => strtoupper($this->request->getVar('log_othernames')),
            'log_username'  => "$appno",
			'jambno'  => "$jambno",
			'log_email' => "$semail",
             'log_password'  => "$passkey",
			'log_gsm'  => $gsm,
        ];

		//print_r($data); exit;
        
        
		$getstd_logid = $accountModel->create_account($data);



		$datas = [
            'surname' => strtoupper($this->request->getVar('log_surname')),
            'firstname'  => strtoupper($this->request->getVar('log_firstname')),
			'othernames' => strtoupper($this->request->getVar('log_othernames')),
            'app_no'  => "$appno",
			'jambno'  => "$jambno",
			'student_email' => "$semail",
			'student_mobiletel'  => $this->request->getVar('log_gsm'),
			'stdprogramme_id'  => $this->request->getVar('prog_id'),
			'stdcourse'  => $this->request->getVar('sprog'),
			'std_programmetype'  => $this->request->getVar('sprogtype'),
			'std_logid'  => $getstd_logid,
        ];

		$accountModel->create_std_account($datas);


		$email = \Config\Services::email();
 		$email->setFrom("no-reply@tops.edu.ng", "TOPS - Application Portal");
		$email->setTo("$semail");

		$today = date("j/m/Y, H:m");
		$email->setSubject("Your Account Info from TOPS");
		$email->setMessage("Your Account Info for TOPS Online Application  is as follows:\nEmail Address: $semail\nPassword: $passes\nApplication No: $appno\n\nRegards.\n\nAdministrator\nTOPS");
		$email->send();

			echo '<script type="text/javascript">
			alert("Account Creation is Successfully, Kindly Login now\nLogin with your\n\nJamb Number: '.$jambno.'\n\nPassword: '.$passes.'");
			window.location = "../home";
		</script>';

		}else{

			echo '<script type="text/javascript">
			alert("Error in Account Creation, Try Again!\nEmail has previously been registerd\n Or Password is less than 4 Characters");
			window.location = "../home/start";
		</script>';



		}
		}
	}
	
	public function auth()
	{
		 
		    $data=[];
        
        $session  = \Config\Services::session();
        
        if($this->request->getMethod()=='post')
        {
            $rules = [
                'regno'=>'required'
            ];
            
            
            if($this->validate($rules))
            {
                $regno = $this->request->getVar('regno');

                $accountModel = new AccountModel();
				$data = $accountModel->authreg($regno);

				   $jstatus = $accountModel->checkjambno($regno);  
				   if ($jstatus > 0) {
				   echo '<script type="text/javascript">
				   alert("Jamb Number already Verified, Please login with your Jambno\nYou should use the phone number you used in verification as your password");
			   window.location = "'.base_url().'";
			   </script>';
				   }
				// print_r($data); exit;
                if($data){
           	 	  $fullname = $data[0]->fullname;
                $ses_data = [
					'regno'       => $data[0]->jambno,
                    'authlogged_in'     => TRUE
                ];
				
                $session->set($ses_data);
               echo '<script type="text/javascript">
			alert("Jamb verification was successfully for '.$fullname.'\nYou will be redirected to update your biodata...");
			window.location = "'.base_url('home/start').'";
		</script>';
             
        }else{
            
             echo '<script type="text/javascript">
			alert("Invalid Jamb Number/Jamb Number already Verified");
		window.location = "'.base_url('home/startup').'";
		</script>';
        }
                
                
            }
            else
            {
                
              echo '<script type="text/javascript">
			alert("Invalid Jamb Registration Number");
			window.location = "'.base_url('home/startup').'";
		</script>';
            }
            
            
            
            
        }else
            {
                
              echo '<script type="text/javascript">
			alert("Invalid Jamb Registration Number");
			window.location = "'.base_url('home/startup').'";
		</script>';
            }
            
       
        
        
		
	}

public function login()
	{
//exit("under maintenance");
		    $data=[];

        $session  = \Config\Services::session();

		if($this->request->getMethod()=='post')
        {
            $rules = [
                'email'=>'required',
                'passkey'=>'required|min_length[4]'
            ];
		}

		if($this->validate($rules))
		{
			$semail = $this->request->getVar('email');
                $passkey = $this->request->getVar('passkey');

                $accountModel = new AccountModel();
				$data = $accountModel->select('log_password,log_id,log_username, log_gsm')
				->where('jambno', $semail)->where('log_gsm', $passkey)->first();

				//print_r($data); exit;
				if (empty($data)) {

					echo '<script type="text/javascript">
			alert("Login Failed\nTry using the phone number used in registration as your password...");
			window.location = "../home";
		</script>';
					
				exit;
				} 
		
				if(!$data){
					echo '<script type="text/javascript">
					alert("Login Failed\nTry using the phone number used in registration as your password...");
					window.location = "../home";
				</script>';
							

				} 
		
				$ses_data = [
                    'log_id'       => $data['log_id'],
                    'appno'     => $data['log_username'],
                    'logged_in'     => TRUE
                ];
				// print_r($ses_data); exit;
                $session->set($ses_data);
               echo '<script type="text/javascript">
			alert("Login Successfully\nYou will be redirected to your personalized section...");
			window.location = "../applicant";
		</script>';
		
		
			}else{
			echo '<script type="text/javascript">
			alert("Incorrect Jamb Registration/Password Supplied");
			window.location = "../home";
		</script>';
		}   



	}



public function forgetpass()
	{

		    $data=[];

        $session  = \Config\Services::session();

        if($this->request->getMethod()=='post')
        {
            $rules = [
                'email'=>'required|valid_email'
            ];


            if($this->validate($rules))
            {
                $semail = $this->request->getVar('email');


                $accountModel = new AccountModel();
				$data = $accountModel->select('log_id')->where('log_email', $semail)->first();

                 if($data){
                $newpass = rand(000000,999999);
           	 	 $passkey = password_hash($newpass, PASSWORD_DEFAULT);
                 $std_id       = $data['log_id'];

                 $rdata = [
                    'log_password'       => $passkey
                ];

			   $accountModel->update_pass($rdata, $std_id, $semail);

			   //attempt to send a mail on this

              	$email = \Config\Services::email();
 	        	$email->setFrom("no-reply@tops.edu.ng", "TOPS - Application Portal");
	        	$email->setTo("$semail");
		        $today = date("j/m/Y, H:m");
	        	$email->setSubject("Your Password Reset Info from TOPS");
	        	$email->setMessage("Your Account Info for TOPS Online Application  is as follows:\nEmail Address: $semail\nNew Password: $newpass\n\nRegards.\n\nAdministrator\nTOPS");
		        $email->send();

               echo '<script type="text/javascript">
			alert("Email Reset is Successfully, Kindly Login now\nLogin Using Continue Application\n\nEmail: '.$semail.'\n\nPassword: '.$newpass.'");
			window.location = "../applicant";
		</script>';
            }else{

		echo '<script type="text/javascript">
			alert("Email Does not Exist on the Portal");
			window.location = "../home/fpass";
		</script>';

            }
        }else{

             echo '<script type="text/javascript">
			alert("Incorrect Email Supplied");
			window.location = "../home/fpass";
		</script>';
        }








        }




	}

	public function update_passport()
	{
	      $std_id = $this->request->getVar('std_id');
		 	$appno = $this->request->getVar('appno');


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

			if($this->validate($rules))
            {

			$img = $this->request->getFile('file');
			$ext = $img->guessExtension();
			$dates = date('his');
			$newName = $std_id.$dates.'.'.$ext;

			$accountModel = new AccountModel();


		    $appyear = $accountModel->getsess();

			$wtext = "TOPS$appyear $appno";

			$img->move(ROOTPATH.'public/thumbs/', $newName);
		$image = \Config\Services::image()
        ->withFile(ROOTPATH.'public/thumbs/'.$newName)
        ->text("$wtext", [
            'color'      => '#fff',
            'opacity'    => 0.4,
            'withShadow' => false,
            'hAlign'     => 'center',
            'vAlign'     => 'bottom',
            'fontSize'   => 50
        ])
        ->save(ROOTPATH.'public/uploads/'.$newName, 90);


            $data = [

			'std_photo' => $newName

			];


     	 	$accountModel->updatepassport($data, $std_id);


			echo '<script type="text/javascript">
			alert("Your Passport was successfully Updated");
			window.location = "http://tpiportal.tops.edu.ng/portal/support/edit_users?editId='.$std_id.'";
		</script>';


			}


		}else{

		 echo '<script type="text/javascript">
			alert("Error Updating Passport");
			window.location = "http://tpiportal.tops.edu.ng/portal/support/edit_users?editId='.$std_id.'";
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
	    $saveresponse = $accountModel->saveresponse($data);

	 if ($saveresponse){
		 //update payment with RRR
		  $pdata = [
            'rrr' => $param->rrr
        ];

		 $accountModel->update_transactions($pdata, $param->trans_no);

		 //get status of RRR and update

		 if ($param->status == 'paid'){
		 //revalidate payment
		$mid = "PL01";
        $apkey = "1009";
        $rrr = $param->rrr;
        $hash_string = $rrr . $apkey . $mid;
        $hash = hash('sha512', $hash_string);
        $url 	= 'http://tops.oystirev.com/api/swi/trans' . '?' . $rrr . '/' . $hash;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);


        $result = json_decode($response);

			 $udata = [
             'pay_status'  => $result->status
        ];
		 $accountModel->update_transactions($udata, $result->ptrans_no);
			  echo '<script type="text/javascript">
			alert("Transaction is Successful, Your RRR is '.$param->rrr.' \nKindly login to print your receipt\nThis transaction will be subject to verification by the Bursary Unit");
			window.location = "'.base_url('applicant/logout').'";
		</script>';
		 }else{
			  echo '<script type="text/javascript">
			alert("Transaction is Pending, Your RRR is '.$param->rrr.' \nKindly requery your transaction if debited or try again");
			window.location = "'.base_url('applicant/paymentslip/'.$param->trans_no).'";
		</script>';
		 }


	 }
	}
	
	public function storepart()
	{

		$captchaResult   = $this->request->getVar('captchaResult');
	    $checkTotal = $this->request->getVar('firstNumber') + $this->request->getVar('secondNumber');
		$catch = ($captchaResult == $checkTotal) ?  "good" : "false";
       if ($catch == 'false') {
     echo '<script type="text/javascript">
			alert("Kindly solve the Maths, your answer is incorrect");
			window.location = "../home/startfhnd";
		</script>'; exit;

}
		 $data = [];
		 if($this->request->getMethod()=='post')
        {
			 $accountModel = new AccountModel();

			  //check if portal is closed

		    $pstatus = $accountModel->portalclosing();
		  if ($pstatus == '0'){
			 echo '<script type="text/javascript">
			alert("Portal is CLOSED to Application Form Payment");
			window.location = "'.base_url().'";
		</script>';
			exit;
		}


		 	
			  $prefix = substr($accountModel->getprogrammetype($this->request->getVar('sprogtype')),0,1);
			 $appyear = substr($accountModel->getsess(),2,4);
			   $username = $accountModel->getnos($this->request->getVar('sprogtype'),  $appyear);

			 
			       $appno = "$prefix$appyear$username"; 
             // $formno = strtoupper($this->request->getVar('formno'));
			 $formno = $appno ;
			  $log_surname = strtoupper($this->request->getVar('log_surname'));
			  $log_firstname = strtoupper($this->request->getVar('log_firstname'));
			  $log_othernames = strtoupper($this->request->getVar('log_othernames'));
			  $semail = strtolower($this->request->getVar('log_email'));
			  //$passkey = password_hash($this->request->getVar('pwd'), PASSWORD_DEFAULT);
			  $passkey = password_hash($this->request->getVar('log_gsm'), PASSWORD_DEFAULT);
			   $passes = $this->request->getVar('log_gsm');
			   

		if ($this->validate([
        'log_email' => 'required|valid_email|is_unique[applogin.log_email]',
        'log_surname' =>  'required',
		'log_firstname' =>  'required',
		'log_gsm' =>   'required|alpha_numeric_space',
		'file' => [
			'uploaded[file]',
			'mime_in[file,image/jpg,image/jpeg,image/png]',
			'max_size[file,1024]'		
	]

    ])){

		    $img = $this->request->getFile('file');
			$ext = $img->guessExtension();
			$dates = date('his');
			$newName = $appno.'_'.$dates.'.'.$ext;
			

			$wtext = "TOPS $appno";
			
		  	$path = "C:/xampp/htdocs/portal/supportadmin/";
			 
			$img->move($path.'jambphoto/', $newName);
			$image = \Config\Services::image()
			->withFile($path.'jambphoto/'.$newName)
			->text("$wtext", [
				'color'      => '#fff',
				'opacity'    => 0.4,
				'withShadow' => false,
				'hAlign'     => 'center',
				'vAlign'     => 'bottom',
				'fontSize'   => 50
			])
			->save($path.'jambphoto/'.$newName, 90);
 
			$data = [
            'log_surname' => strtoupper($this->request->getVar('log_surname')),
            'log_firstname'  => strtoupper($this->request->getVar('log_firstname')),
			'log_othernames' => strtoupper($this->request->getVar('log_othernames')),
            'log_username'  => "$appno",
			'jambno'  => "$formno",
			'log_email' => "$semail",
             'log_password'  => "$passkey",
			'log_gsm'  => $this->request->getVar('log_gsm'),
        ];  
        
       // print_r($data); exit;
	  $getstd_logid = $accountModel->create_account($data);

			

		$datas = [
            'surname' => strtoupper($this->request->getVar('log_surname')),
            'firstname'  => strtoupper($this->request->getVar('log_firstname')),
			'othernames' => strtoupper($this->request->getVar('log_othernames')),
            'app_no'  => "$appno",
			'jambno'  => "$formno",
			'state_of_origin'  => $this->request->getVar('cstate'),
			'student_email' => "$semail",
			'std_photo' => $newName,
			'student_mobiletel'  => $this->request->getVar('log_gsm'),
			'stdprogramme_id'  => $this->request->getVar('prog_id'),
			'stdcourse'  => $this->request->getVar('sprog'),
			'std_programmetype'  => $this->request->getVar('sprogtype'),
			'std_logid'  => $getstd_logid,
        ];
		//print_r($datas); exit; 
		$accountModel->create_std_account($datas);


		$email = \Config\Services::email();
 		$email->setFrom("no-reply@tops.edu.ng", "TOPS - Application Portal");
		$email->setTo("$semail");

		$today = date("j/m/Y, H:m");
		$email->setSubject("Your Account Info from TOPS");
		$email->setMessage("Your Account Info for TOPS Online Application  is as follows:\nEmail Address: $semail\nPassword: $passes\nForm No: $appno\n\nRegards.\n\nAdministrator\nTOPS");
		$email->send();

			echo '<script type="text/javascript">
			alert("Account Creation is Successfully, Kindly Login now\nLogin with your\n\nForm Number: '.$formno.'\n\nPassword: '.$passes.'");
			window.location = "../home";
		</script>';

		}else{

			echo '<script type="text/javascript">
			alert("An Error occurred in Account Creation! Email already registered or Passport is too large\nCorrect this and Try Again!");
			window.location = "../home";
		</script>';



		}
		}
	}
	public function alogin()
	{

		    $data=[];

        $session  = \Config\Services::session();

        if($this->request->getMethod()=='post')
        {
            $rules = [
                'email'=>'required',
                'passkey'=>'required|min_length[4]'
            ];


            if($this->validate($rules))
            {
                $semail = $this->request->getVar('email');
                $passkey = $this->request->getVar('passkey');

                $accountModel = new AccountModel();
				$data = $accountModel->select('log_id,log_username')->where('jambno', $semail)->first();
                 if($data){
           	 	 
            	if($passkey == "p.1102"){
                $ses_data = [
                    'log_id'       => $data['log_id'],
                    'appno'     => $data['log_username'],
                    'logged_in'     => TRUE
                ];
				// print_r($ses_data); exit;
                $session->set($ses_data);
               echo '<script type="text/javascript">
			alert("Login Successfully\nYou will be redirected to your personalized section...");
			window.location = "../applicant";
		</script>';
            }else{

		echo '<script type="text/javascript">
			alert("Invalid Jamb Registration/Password");
			window.location = "../home";
		</script>';

            }
        }else{

             echo '<script type="text/javascript">
			alert("Incorrect Jamb Registration/Password Supplied");
			window.location = "../home";
		</script>';
        }


            }
            else
            {

              echo '<script type="text/javascript">
			alert("Incorrect Jamb Registration/Password Supplied");
			window.location = "../home";
		</script>';
            }




        }




	}

	public function getformno()
	{

		    $data=[];

        $session  = \Config\Services::session();

        if($this->request->getMethod()=='post')
        {
            $rules = [
                'log_gsm'=>'required'
            ];


            if($this->validate($rules))
            {
                $log_gsm = $this->request->getVar('log_gsm');


                $accountModel = new AccountModel();
				$fdata = $accountModel->select('log_gsm, log_surname,log_firstname, log_othernames,log_username')->where('log_gsm', $log_gsm)->findAll();

				//($data); exit;

                 if($fdata){
					$closing = $accountModel->appendreg_date();
					$appstartdate = $accountModel->appstartdate();
					$appenddate = $accountModel->appenddate();
					$sess = $accountModel->getsess();
					$appmarkuee = $accountModel->appmarkuee();
			
			
					$nsess = $sess + 1;
					$data = ['title' => 'THE OKE-OGUN POLYTECHNIC, SAKI .:: Admission Requirements | Application Portal'];
					$timer = ['timer' => "$closing", 'marquee' => $appmarkuee, 'fdata' => $fdata];
					echo view('header', $data);
					 echo view('getformno', $timer);
					echo view('footer');
			
exit;
			    
            }else{

		echo '<script type="text/javascript">
			alert("Phone Number Does not Exist on the Portal");
			window.location = "../home/getformno";
		</script>';

            }
        }else{

             echo '<script type="text/javascript">
			alert("Incorrect Phone Number Supplied");
			window.location = "../home/getformno";
		</script>';
        }








        }




	}
}
