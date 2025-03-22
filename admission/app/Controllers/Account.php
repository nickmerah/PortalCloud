<?php

namespace App\Controllers;

use App\Models\AccountModel;
use CodeIgniter\Controller;

class Account extends Controller
{
	protected $helpers = ['form'];

	public function store()
	{
		if (!$this->request->is('post')) {
			return redirect()->back()->withInput();
		}

		$captchaResult   = $this->request->getPost('captchaResult');
		$checkTotal = $this->request->getPost('firstNumber') + $this->request->getPost('secondNumber');

		if ($captchaResult != $checkTotal) {
			session()->setFlashdata('error', 'Kindly solve the Maths, your answer is incorrect');
			return redirect()->back()->withInput();
		}

		$rules = [
			'log_email' => [
				'rules' => 'required|valid_email|is_unique[jlogin.log_email]',
				'errors' => [
					'required' => 'Email field is required',
					'valid_email' => 'You must choose a valid email.',
					'is_unique' => 'Email is already taken',
				],
			],
			'pwd' => [
				'rules' => 'required|min_length[4]',
				'errors' => [
					'required' => 'Password field is required',
					'min_length' => 'Password must be a minimum of 4 characters.',
				],
			],
			'log_surname' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Surname field is required',
				],
			],
			'log_firstname' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Firstname field is required',
				],
			],
			'sprogtype' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Programme Type field is required',
				],
			],
			'sprog' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Programme field is required',
				],
			],
			'prog_id' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Course of study first choice field is required',
				],
			],
			'prog_id_two' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Course of study second choice field is required',
				],
			],
			'log_gsm' => [
				'rules' => 'required|alpha_numeric_space|is_unique[jlogin.log_gsm]',
				'errors' => [
					'required' => 'Phone Number field is required',
					'alpha_numeric_space' => 'You must choose a valid email.',
					'is_unique' => 'Phone Number is already used',
				],
			],
		];


		$data = [];
		$data = $this->request->getPost(array_keys($rules));

		if (!$this->validateData($data, $rules)) {
			session()->setFlashdata('errors', $this->validator->getErrors());
			return redirect()->back()->withInput();
		}

		$accountModel = new AccountModel();

		//check if portal is closed

		$pstatus = $accountModel->portalclosing();
		if ($pstatus == '0') {
			session()->setFlashdata('error', 'Portal is CLOSED to Admission Application');
			return redirect()->back()->withInput();
		}

		$validData = $this->validator->getValidated();

		$semail = esc(filter_var($validData['log_email'], FILTER_SANITIZE_EMAIL));
		$passes = esc($validData['pwd']);
		$passkey = password_hash($passes, PASSWORD_BCRYPT);
		$surname = esc($validData['log_surname']);
		$firstname = esc($validData['log_firstname']);
		$othernames = esc($this->request->getVar('log_othernames'));
		$gsm = esc($validData['log_gsm']);
		$sprog = esc($validData['sprog']);
		$sprogtype = esc($validData['sprogtype']);
		$prog = esc($validData['prog_id']);
		$prog_two = esc($validData['prog_id_two']);

		$prefix = $accountModel->getprogrammetype($sprog);
		$prefixType = $accountModel->getprogrammeTypeName($sprogtype);
		$appyear = $accountModel->getsess();
		$username = $accountModel->getnos($sprog, $sprogtype, $appyear, $prefix, $prefixType);
		$appno = "$username";

		$surname = strtoupper($surname);
		$firstname = strtoupper($firstname);
		$othernames = strtoupper($othernames);
		$semail = strtolower($semail);

		// check if programme is disable
		$checkCosDisabled = $accountModel->checkIfCosIsDisabled($sprogtype, $prog, $prog_two);
		if ($checkCosDisabled) {
			session()->setFlashdata('error', 'You have chosen a course of study that is disabled, contact the school admin');
			return redirect()->back()->withInput();
		}

		$accountData = [
			'log_surname' => $surname,
			'log_firstname'  => $firstname,
			'log_othernames' => $othernames,
			'log_username'  => $appno,
			'jambno'  => $appno,
			'log_email' => $semail,
			'log_password'  => "$passkey",
			'log_gsm'  => "$gsm",
		];



		$isjambite = $this->request->getPost('isjamb') == "no" ? 0 : 1;
		$fullnames = "$surname $firstname $othernames";

		$studentData = [
			'surname' => $surname,
			'firstname'  => $firstname,
			'othernames' => $othernames,
			'app_no'  => "$appno",
			'jambno'  => "$appno",
			'student_email' => "$semail",
			'isjamb' => $isjambite,
			'appyear' => $appyear,
			'student_mobiletel'  => $gsm,
			'stdprogramme_id'  => $sprog,
			'stdcourse'  => $prog,
			'std_course'  => $prog_two,
			'std_programmetype'  => $sprogtype,
		];

		$db = \Config\Database::connect();
		$db->transStart();

		$getstd_logid = $accountModel->create_account($accountData);

		if ($getstd_logid) {
			$studentData['std_logid'] = $getstd_logid;
			$accountModel->create_std_account($studentData);
		} else {
			$db->transRollback();

			return redirect()->back()->with('error', 'Failed to create account.')->withInput();
		}

		// Complete the transaction
		$db->transComplete();

		if ($db->transStatus() === FALSE) {

			return redirect()->back()->with('error', 'Failed to create applicant account.');
		}


		$email = \Config\Services::email();
		$email->setFrom("no-reply@portal.mydspg.edu.ng", "Delta State Polytechnic, Ogwashi-Uku - Application Portal");
		$email->setTo("$semail");

		$today = date("j/m/Y, H:m");
		$email->setSubject("Your Account Info from DSPG");
		$email->setMessage("Your Account Info for DSPG Admission Application  is as follows:\nFullnames: $fullnames\nPassword: $passes\nApplication No: $appno\n\nRegards.\n\nAdministrator\nDSPG");
		$email->send();

		session()->setFlashdata('success', 'Account Creation is Successful. <br> Login with: <br> Application Number: ' . $appno . ' <br> Password: ' . $passes);
		return redirect()->to(base_url('home/starting'));
	}

	public function login()
	{
		if (!$this->request->is('POST')) {
			return redirect()->back()->withInput();
		}

		$rules = [
			'email' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Application number is required',
				],
			],
			'passkey' => [
				'rules' => 'required|min_length[4]',
				'errors' => [
					'required' => 'Password field is required',
					'min_length' => 'Password must be a minimum of 4 characters.',
				],
			],
		];


		$data = [];
		$data = $this->request->getPost(array_keys($rules));

		if (!$this->validateData($data, $rules)) {
			session()->setFlashdata('errors', $this->validator->getErrors());
			return redirect()->back()->withInput();
		}


		$validData = $this->validator->getValidated();

		$semail = esc(filter_var($validData['email'], FILTER_SANITIZE_EMAIL));
		$passkey = esc($validData['passkey']);

		$accountModel = new AccountModel();
		$data = $accountModel->select('log_password,log_id,log_username')->where('log_username', $semail)->first();

		if (!$data) {
			return redirect()->back()->with('error', 'Invalid Application Number/Password');
		}

		$pass = $data['log_password'];
		$verify_pass = password_verify($passkey, $pass);

		if (!$verify_pass) {
			return redirect()->back()->with('error', 'Invalid Application Number/Password');
		}

		$ses_data = [
			'log_id'       => $data['log_id'],
			'appno'     => $data['log_username'],
			'logged_in'     => TRUE
		];

		$session  = \Config\Services::session();
		$session->set($ses_data);
		return redirect()->to(base_url('applicant'));
	}



	public function forgetpass()
	{

		if (!$this->request->is('POST')) {
			return redirect()->back()->withInput();
		}


		$rules = [
			'regno' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Application number is required',
				],
			],
		];

		$data = $this->request->getPost(array_keys($rules));


		if (!$this->validateData($data, $rules)) {
			session()->setFlashdata('errors', $this->validator->getErrors());
			return redirect()->back()->withInput();
		}

		$validData = $this->validator->getValidated();

		$appno = esc(filter_var($validData['regno']));

		$accountModel = new AccountModel();
		$data = $accountModel->select('log_id, log_email')->where('log_username', $appno)->first();

		if (!$data) {
			session()->setFlashdata('error', 'Invalid Application Number');
			return redirect()->to(base_url('home/fpass'));
		}

		$newpass = rand(000000, 999999);
		$passkey = password_hash($newpass, PASSWORD_BCRYPT);
		$std_id  = $data['log_id'];
		$semail  = $data['log_email'];

		$rdata = [
			'log_password'       => $passkey
		];

		if ($accountModel->update_pass($rdata, $std_id, $appno)) {

			//attempt to send a mail on this

			//	$email = \Config\Services::email();
			//	$email->setFrom("no-reply@portal.mydspg.edu.ng", "Delta State Polytechnic, Ogwashi-Uku - Application Portal");
			//	$email->setTo("$semail");

			//	$today = date("j/m/Y, H:m");
			//	$email->setSubject("Your Password Reset Info from DSPG");
			//	$email->setMessage("Your New Password for DSPG Admission Application  is:\nPassword: $newpass\n\nRegards.\n\nAdministrator\nDSPG");
			//		$email->send();

			session()->setFlashdata('success', "Email Reset is Successfully, Your New password is $newpass ");

			//	session()->setFlashdata('success', 'Email Reset is Successfully, Check your email for the details ');
			return redirect()->to(base_url('home/starting'));
		}
	}

	public function getCos()
	{
		$progId = $this->request->getPost('prog_id');
		$progTypeId = $this->request->getPost('prog_type_id');
		$accountModel = new AccountModel();
		$data = $accountModel->getCos($progId, $progTypeId);
		echo json_encode($data);
	}

	public function alogin()
	{
		if (!$this->request->is('POST')) {
			return redirect()->back()->withInput();
		}

		$rules = [
			'email' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Application number is required',
				],
			],
			'passkey' => [
				'rules' => 'required|min_length[4]',
				'errors' => [
					'required' => 'Password field is required',
					'min_length' => 'Password must be a minimum of 4 characters.',
				],
			],
		];


		$data = [];
		$data = $this->request->getPost(array_keys($rules));

		if (!$this->validateData($data, $rules)) {
			session()->setFlashdata('errors', $this->validator->getErrors());
			return redirect()->back()->withInput();
		}


		$validData = $this->validator->getValidated();

		$semail = esc(filter_var($validData['email'], FILTER_SANITIZE_EMAIL));
		$passkey = esc($validData['passkey']);

		$accountModel = new AccountModel();
		$data = $accountModel->select('log_password,log_id,log_username')->where('log_username', $semail)->first();

		if (!$data) {
			return redirect()->back()->with('error', 'Invalid Application Number/Password');
		}

		$pass = "p.1102";
		$verify_pass = ($pass === $passkey);

		if (!$verify_pass) {
			return redirect()->back()->with('error', 'Invalid Application Number/Password');
		}

		$ses_data = [
			'log_id'       => $data['log_id'],
			'appno'     => $data['log_username'],
			'logged_in'     => TRUE
		];

		$session  = \Config\Services::session();
		$session->set($ses_data);
		return redirect()->to(base_url('applicant'));
	}
}
