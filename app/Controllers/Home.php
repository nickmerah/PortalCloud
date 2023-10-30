<?php namespace App\Controllers;
use \CodeIgniter\Controller;
use App\Models\AccountModel;
use App\Models\ApplicantModel;
class Home extends BaseController
{




		public function index()
	{
		 $accountModel = new AccountModel();
		 $closing = $accountModel->appendreg_date();
		 $appstartdate = $accountModel->appstartdate();
		 $appenddate = $accountModel->appenddate();
		 $sess = $accountModel->getsess();
		 $appmarkuee = $accountModel->appmarkuee();


		 $nsess = $sess + 1;
		 $data = ['title' => 'THE OKE-OGUN POLYTECHNIC, SAKI .:: Home | Application Portal'];
		 $timer = ['timer' => "$closing", 'marquee' => $appmarkuee];
         echo view('header', $data);
		 echo view('home', $timer);
		echo view('footer');

	}


	public function startup()
{
	 $accountModel = new AccountModel();
	 $closing = $accountModel->appendreg_date();
	 $appstartdate = $accountModel->appstartdate();
	 $appenddate = $accountModel->appenddate();
	 $sess = $accountModel->getsess();
	 $appmarkuee = $accountModel->appmarkuee();
	 $applicantModel = new ApplicantModel();
	 $prog = $applicantModel->getprogramme();
	 $progtype = $applicantModel->getprogrammetype();

	 $nsess = $sess + 1;
	 $data = ['title' => 'THE OKE-OGUN POLYTECHNIC, SAKI .:: Home | Application Portal'];
	 $timer = ['timer' => "$closing", 'marquee' => $appmarkuee, 'progs' => $prog, 'progtypes' => $progtype];
			 echo view('header', $data);
	 echo view('startnow', $timer);
	echo view('footer');

}


public function start()
{
	 $accountModel = new AccountModel();
	 $closing = $accountModel->appendreg_date();
	 $appstartdate = $accountModel->appstartdate();
	 $appenddate = $accountModel->appenddate();
	 $sess = $accountModel->getsess();
	 $appmarkuee = $accountModel->appmarkuee();
	 
	 if(!session()->get('authlogged_in'))
        {
            header('Location: '.base_url());
            exit();
        }
	 
       $jdata[] =  $accountModel->getjambdetail(session()->get('regno'));
 
	 $nsess = $sess + 1;
	 $data = ['title' => 'THE OKE-OGUN POLYTECHNIC, SAKI .:: Home | Application Portal'];
	 $timer = ['timer' => "$closing", 'marquee' => $appmarkuee, 'progs' => $prog, 'progtypes' => $progtype , 'jambdetails' => $jdata ];
	 echo view('header', $data);
	 echo view('start', $timer);
	echo view('footer');

}

public function startpart()
{
	 $accountModel = new AccountModel();
	 $closing = $accountModel->appendreg_date();
	 $appstartdate = $accountModel->appstartdate();
	 $appenddate = $accountModel->appenddate();
	 $sess = $accountModel->getsess();
	 $appmarkuee = $accountModel->appmarkuee();
	  $prog = $accountModel->getprogramme();
	  $cos = $accountModel->getcos();
	  
	 $nsess = $sess + 1;
	 $data = ['title' => 'THE OKE-OGUN POLYTECHNIC, SAKI .:: Home | Application Portal'];
	 $timer = ['timer' => "$closing", 'marquee' => $appmarkuee, 'progs' => $prog, 'cos' => $cos ];
	 echo view('header', $data);
	 echo view('partstart', $timer);
	echo view('footer');

}

public function startfhnd()
{
	 $accountModel = new AccountModel();
	 $closing = $accountModel->appendreg_date();
	 $appstartdate = $accountModel->appstartdate();
	 $appenddate = $accountModel->appenddate();
	 $sess = $accountModel->getsess();
	 $appmarkuee = $accountModel->appmarkuee();
	  $prog = $accountModel->getprogramme(2);
	  $progtype = $accountModel->getprogramme_type(1);
	  $cos = $accountModel->getcos(2);
	  $formname="FULL TIME HND"; $applicantModel = new ApplicantModel();
	  $states = $applicantModel->getstate();
	 $nsess = $sess + 1;
	 $data = ['title' => 'THE OKE-OGUN POLYTECHNIC, SAKI .:: Home | Application Portal'];
	 $timer = ['timer' => "$closing", 'marquee' => $appmarkuee, 'progs' => $prog, 'cos' => $cos,
	 'progtypes' => $progtype, 'formname' => $formname , 'states' => $states];

	 //echo C:\xampp\htdocs\portal\supportadmin\jambphoto\202210001645GA.jpg; exit;
//echo ROOTPATH;

	 echo view('header', $data);
	 echo view('partstart', $timer);
	echo view('footer');

}


    public function admreq()
	{
		$accountModel = new AccountModel();
		$closing = $accountModel->appendreg_date();
		$appstartdate = $accountModel->appstartdate();
		$appenddate = $accountModel->appenddate();
		$sess = $accountModel->getsess();
		$appmarkuee = $accountModel->appmarkuee();


		$nsess = $sess + 1;
		$data = ['title' => 'THE OKE-OGUN POLYTECHNIC, SAKI .:: Admission Requirements | Application Portal'];
		$timer = ['timer' => "$closing", 'marquee' => $appmarkuee];
				echo view('header', $data);
		 echo view('admreq', $timer);
		echo view('footer');

	}

	public function getformno()
	{
		$accountModel = new AccountModel();
		$closing = $accountModel->appendreg_date();
		$appstartdate = $accountModel->appstartdate();
		$appenddate = $accountModel->appenddate();
		$sess = $accountModel->getsess();
		$appmarkuee = $accountModel->appmarkuee();


		$nsess = $sess + 1;
		$data = ['title' => 'THE OKE-OGUN POLYTECHNIC, SAKI .:: Admission Requirements | Application Portal'];
		$timer = ['timer' => "$closing", 'marquee' => $appmarkuee];
				echo view('header', $data);
		 echo view('getformno', $timer);
		echo view('footer');

	}


	public function fpass()
	{
	$accountModel = new AccountModel();
	$closing = $accountModel->appendreg_date();
	$appstartdate = $accountModel->appstartdate();
	$appenddate = $accountModel->appenddate();
	$sess = $accountModel->getsess();
	$appmarkuee = $accountModel->appmarkuee();


	$nsess = $sess + 1;
	$data = ['title' => 'THE OKE-OGUN POLYTECHNIC, SAKI .:: Admission Requirements | Application Portal'];
	$timer = ['timer' => "$closing", 'marquee' => $appmarkuee];
			echo view('header', $data);
	 echo view('forgot', $timer);
	echo view('footer');

	}


	public function contactus()
	{

		 $accountModel = new AccountModel();
	 	$closing = $accountModel->appendreg_date();
	 	$appstartdate = $accountModel->appstartdate();
	 	$appenddate = $accountModel->appenddate();
	 	$sess = $accountModel->getsess();
	 	$appmarkuee = $accountModel->appmarkuee();


	 	$nsess = $sess + 1;
	 	$data = ['title' => 'THE OKE-OGUN POLYTECHNIC, SAKI .:: Contact Us | Application Portal'];
	 	$timer = ['timer' => "$closing", 'marquee' => $appmarkuee];
	 			echo view('header', $data);
	 	 echo view('contactus', $timer);
	 	echo view('footer');
	}


	public function getProg(){
    $postData = $this->request->getPost();
	//$progId = $this->request->getVar('prog_id');
	//$progType = $this->request->getVar('prog_type');
	 $applicantModel = new ApplicantModel();
	$data = $applicantModel->getdept_options(1);
    echo json_encode($data);
  }

  public function get_prog(){
    $postData = $this->request->getPost();
	 $applicantModel = new ApplicantModel();
	$data = $applicantModel->getprog_options($postData);
    echo json_encode($data);
  }

  public function login()
	{
		 $accountModel = new AccountModel();
		 $closing = $accountModel->appendreg_date();
		 $appstartdate = $accountModel->appstartdate();
		 $appenddate = $accountModel->appenddate();
		 $sess = $accountModel->getsess();
		 $appmarkuee = $accountModel->appmarkuee();


		 $nsess = $sess + 1;
		 $data = ['title' => 'THE OKE-OGUN POLYTECHNIC, SAKI .:: Home | Application Portal'];
		 $timer = ['timer' => "$closing", 'marquee' => $appmarkuee];
         echo view('header', $data);
		 echo view('login', $timer);
		echo view('footer');

	}

	public function startphnd()
{
	 $accountModel = new AccountModel();
	 $closing = $accountModel->appendreg_date();
	 $appstartdate = $accountModel->appstartdate();
	 $appenddate = $accountModel->appenddate();
	 $sess = $accountModel->getsess();
	 $appmarkuee = $accountModel->appmarkuee();
	  $prog = $accountModel->getprogramme(2);
	  $progtype = $accountModel->getprogramme_type(2);
	  $cos = $accountModel->getcos(2);
	  $formname="PART TIME HND"; $applicantModel = new ApplicantModel();
	  $states = $applicantModel->getstate();
	 $nsess = $sess + 1;
	 $data = ['title' => 'THE OKE-OGUN POLYTECHNIC, SAKI .:: Home | Application Portal'];
	 $timer = ['timer' => "$closing", 'marquee' => $appmarkuee, 'progs' => $prog, 'cos' => $cos,
	 'progtypes' => $progtype, 'formname' => $formname , 'states' => $states];

	 

	 echo view('header', $data);
	 echo view('partstart', $timer);
	echo view('footer');

}

public function startpnd()
{
	 $accountModel = new AccountModel();
	 $closing = $accountModel->appendreg_date();
	 $appstartdate = $accountModel->appstartdate();
	 $appenddate = $accountModel->appenddate();
	 $sess = $accountModel->getsess();
	 $appmarkuee = $accountModel->appmarkuee();
	  $prog = $accountModel->getprogramme(1);
	  $progtype = $accountModel->getprogramme_type(2);
	  $cos = $accountModel->getcos(1);
	  $formname="PART TIME ND"; $applicantModel = new ApplicantModel();
	  $states = $applicantModel->getstate();
	 $nsess = $sess + 1;
	 $data = ['title' => 'THE OKE-OGUN POLYTECHNIC, SAKI .:: Home | Application Portal'];
	 $timer = ['timer' => "$closing", 'marquee' => $appmarkuee, 'progs' => $prog, 'cos' => $cos,
	 'progtypes' => $progtype, 'formname' => $formname , 'states' => $states];

	 

	 echo view('header', $data);
	 echo view('partstart', $timer);
	echo view('footer');

}


public function confirmapplyreceipt()
    {

		  $applicantModel = new ApplicantModel();
          $accountModel = new AccountModel();
		
		   $tid = $this->request->uri->getSegment(3);
		  $paydetails =  $applicantModel->getconfirmpaydetail($tid);
		 
		  $datas['stddetails'] =  $accountModel->getacctdetails($paydetails[0]->log_id);
		 
        $fnames = $datas['stddetails'][0]->surname. ' '.$datas['stddetails'][0]->firstname;
		$appno =  $datas['stddetails'][0]->app_no;

		if ($datas['stddetails'][0]->stdprogramme_id==1 and $datas['stddetails'][0]->std_programmetype==1) {
			$stdphoto = $datas['stddetails'][0]->jambno.'.jpg';
		}else{
			$stdphoto = $datas['stddetails'][0]->std_photo;
		}

		 
		if (empty($paydetails)) {
			 echo '<script type="text/javascript">
			alert("Transaction Not Paid or Not Found");
			window.location = "'.base_url('applicant/').'";
		</script>'; exit;
    	} 
		

  $datac = ['title' => 'TOPS .:: Payment Receipt | Portal', 'appno'=>$appno, 'fnames' =>  $fnames, 'paydetails' => $paydetails
  , 'stdphoto' => $stdphoto ];
	 
		  
         echo view('applicants/applyreceipt',$datac);
         echo view('applicants/footer');

    }

}
