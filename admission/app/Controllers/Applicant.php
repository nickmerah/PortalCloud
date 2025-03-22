<?php

namespace App\Controllers;

use \CodeIgniter\Controller;
use App\Models\AccountModel;
use App\Models\ApplicantModel;
use Config\PaymentConfig;

class Applicant extends Controller
{

	private $session;

	private $accountModel;

	private $applicantModel;

	public const TITLE = 'Delta State Polytechnic, Ogwashi-Uku - Application Portal';

	private $schoolName;

	private $appyear;

	private $admstatus;

	private $appstatus;

	private $feestatus;

	private $acceptfeestatus;

	private $resultverifyfeestatus;

	private $clearancestatus;

	public const MINIMUM_OLEVEl_SUB = "5";

	public const MINIMUM_JAMB_SUB = "4";

	public const ACCEPTANCE_PORTAL_FEE = 1000;

	public const RESULT_VERIFICATION_PORTAL_FEE = 100;


	public function __construct()
	{
		$this->session = \Config\Services::session();
		helper('uri');
		if (!session()->get('log_id')) {
			header('Location: ' . base_url());
			exit();
		}

		$this->accountModel = new AccountModel();
		$this->schoolName = $this->accountModel->getSchoolName();
		$this->appyear = $this->accountModel->getsess();


		$this->applicantModel = new ApplicantModel();
		$this->admstatus = $this->applicantModel->getadmstatus(session()->get('log_id'));
		$this->appstatus = $this->applicantModel->getappstatus(session()->get('log_id'));
		$this->feestatus = $this->applicantModel->getfeestatus(session()->get('log_id'));
		$this->admstatus = $this->applicantModel->getadmstatus(session()->get('log_id'));
		$this->acceptfeestatus = $this->applicantModel->getafeestatus(session()->get('log_id'));
		$this->resultverifyfeestatus = $this->applicantModel->getvfeestatus(session()->get('log_id'));
	}

	protected function getAppFees($stddetails): ?array
	{
		if (empty($stddetails)) {

			$message = "Complete your application forms to continue";
			$redirectUrl = base_url('applicant/my_application');
			self::redirectWithAlert($message, $redirectUrl);
			exit;
		}
		$progid = $stddetails[0]->stdprogramme_id;
		$progtype = $stddetails[0]->std_programmetype;
		$fnames = $stddetails[0]->surname . ' ' . $stddetails[0]->firstname;

		$appfees = $this->applicantModel->getappfees($progid, $progtype);

		return [$fnames, $appfees];
	}

	protected function getAcceptanceFees($stddetails): ?array
	{
		$progid = $stddetails[0]->stdprogramme_id;
		$progtype = $stddetails[0]->std_programmetype;
		$fnames = $stddetails[0]->surname . ' ' . $stddetails[0]->firstname;
		$stdstatus = $this->getStdStatus($stddetails);

		$acceptfees = $this->applicantModel->getacceptfees($progid, $progtype, $stdstatus);

		return [$fnames, $acceptfees];
	}

	protected function getResultVerificationFees($stddetails): ?array
	{

		$fnames = $stddetails[0]->surname . ' ' . $stddetails[0]->firstname;

		$resultverifyfees = $this->applicantModel->getresultverifyfees();

		return [$fnames, $resultverifyfees];
	}

	protected function getChangeofCourseFees($stddetails): ?array
	{
		$fnames = $stddetails[0]->surname . ' ' . $stddetails[0]->firstname;
		$changeofcoursefees = $this->applicantModel->getchangeofcoursefees();

		return [$fnames, $changeofcoursefees];
	}

	protected function getStdStatus($stddetails): int
	{
		$stdStatus = 0;

		if ($stddetails[0]->state_of_origin == 10 && $stddetails[0]->std_programmetype == 1) {
			$stdStatus = 1;
		}

		return $stdStatus;
	}

	private function getHeaderData($extraData = [])
	{

		$data = [
			'title' => self::TITLE,
			'schoolname' => $this->schoolName,
			'appno' => session()->get('appno'),
			'cs_session' => $this->appyear,
			'pstat' => $this->feestatus,
			'acceptfeestatus' => $this->acceptfeestatus,
			'appstatus' => $this->appstatus,
			'admstatus' => $this->admstatus,
			'resultverifyfeestatus' => $this->resultverifyfeestatus,
		];

		return array_merge($data, $extraData);
	}


	public function index()
	{

		$vstat = $this->applicantModel->getvfeestatus(session()->get('log_id'));

		$this->clearancestatus = $this->applicantModel->getclearancetatus(session()->get('log_id'));

		$data['stddetails'] = ($this->appstatus == 1) ? $this->accountModel->getacctdetails(session()->get('log_id')) : $this->accountModel->getacctdetail(session()->get('log_id'));

		[$fnames, $appfees] = $this->getAppFees($data['stddetails']);

		$appbiodata =  $data['stddetails'][0]->biodata;

		$datah = $this->getHeaderData([
			'vstat' => $vstat,
			'appfees' => $appfees,
			'fnames' =>  $fnames,
			'appbiodata' => $appbiodata,
			'clearancestatus' => $this->clearancestatus
		]);


		$data['paystatus'] =  $this->applicantModel->gettrans_details(session()->get('log_id'));

		echo view('applicants/header', $datah);
		echo view('applicants/index', $data);
		echo view('applicants/footer');
	}

	public function payappfees()
	{

		$data['stddetails'] = ($this->appstatus == 1) ? $this->accountModel->getacctdetails(session()->get('log_id')) : $this->accountModel->getacctdetail(session()->get('log_id'));
		[$fnames, $appfees] = $this->getAppFees($data['stddetails']);


		$datah = $this->getHeaderData([
			'appfees' => $appfees,
			'fnames' => $fnames,
		]);


		$data['paystatus'] =  $this->applicantModel->gettrans_details(session()->get('log_id'));


		echo view('applicants/header', $datah);
		echo view('applicants/appfees', $data);
		echo view('applicants/footer');
	}


	public function paynow()
	{

		$data = [];
		if ($this->request->getMethod() == 'POST') {

			//check if portal is closed
			$pstatus = $this->accountModel->portalclosing();
			if ($pstatus == '0') {
				$message = "Portal is CLOSED to Application for this Year";
				$redirectUrl = base_url('applicant/');
				self::redirectWithAlert($message, $redirectUrl);
			}

			//check if transaction ID has already been generated
			$genid =  $this->applicantModel->gettransid(session()->get('log_id'), 1);
			if (!empty($genid)) {
				$message = "You have already generated a Transaction, You will be redirected to make payment";
				$redirectUrl = base_url('applicant/paymentslip/' . $genid);
				self::redirectWithAlert($message, $redirectUrl);
			}

			$stddetails = $this->accountModel->getacctdetail(session()->get('log_id'));
			[$fnames, $appfees] = $this->getAppFees($stddetails);

			foreach ($stddetails as $stddetail) {
				$appno = $stddetail->app_no;
				$semail = $stddetail->student_email;
				$sgsm = $stddetail->student_mobiletel;
			}

			$fdate = date('Y-m-d h:i:s');
			$tdate = date('Y-m-d');

			$total = $appfees;

			//remita
			$config = new PaymentConfig();

			$timesammp = DATE("dmyHis");
			$orderId = session()->get('log_id') . $timesammp;

			$hash_string = $config->merchantId . $config->serviceTypeId . $orderId . $total . $config->apiKey;
			$apiHash = hash('sha512', $hash_string);

			$postFields = array(
				"serviceTypeId" => $config->serviceTypeId,
				"amount" => $total,
				"orderId" => $orderId,
				"payerName" => $fnames,
				"payerEmail" => $semail,
				"payerPhone" => $sgsm,
				"description" => "Admission Application Form Fees"
			);

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $config->gatewayUrl,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode($postFields),
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					'Authorization: remitaConsumerKey=' . $config->merchantId . ',remitaConsumerToken=' . $apiHash
				),
			));

			$json_response = curl_exec($curl);
			if (curl_errno($curl)) {
				echo 'cURL error: ' . curl_error($curl);
			} else {
				$jsonData = substr($json_response, 7, -1);
				$response = json_decode($jsonData, true);
			}
			curl_close($curl);;

			$statuscode = $response['statuscode'];

			if ($statuscode != '025') {
				$message = "Error generating RRR. Please try again";
				$redirectUrl = base_url('applicant/my_application');
				self::redirectWithAlert($message, $redirectUrl);
			}

			$rrr = trim($response['RRR']);

			$checkrrr =  $this->applicantModel->checkrrr($rrr);

			if ($checkrrr) {
				$message = "RRR already generated. Please try again";
				$redirectUrl = base_url('applicant/my_application');
				self::redirectWithAlert($message, $redirectUrl);
			}
			//end remita


			$data = [
				'log_id' => session()->get('log_id'),
				'fee_id'  => 1,
				'fee_name'  => "Application Fee",
				'trans_no' => $orderId,
				'fee_amount'  => $appfees,
				'generated_date' => $fdate,
				'trans_date' => $fdate,
				't_date' => $tdate,
				'trans_year' => $this->appyear,
				'trans_custom1' => 'Pending',
				'fullnames' => $fnames,
				'appno'  => $appno,
				'paychannel'  => 'Remita',
				'semail'  => $semail,
				'rrr'  => $rrr,
			];

			$this->applicantModel->save_transaction($data);
			$message = "Transaction ID generated successfully, You will be redirected to make payment";
			$redirectUrl = base_url('applicant/paymentslip/' . $orderId);
			self::redirectWithAlert($message, $redirectUrl);
		} else {

			$message = "Error Generating Transaction ID, Please Try Again";
			$redirectUrl = base_url('applicant'); // Adjust URL if necessary
			self::redirectWithAlert($message, $redirectUrl);
		}
	}

	public function paymentslip()
	{
		$data['transdetails'] = $this->applicantModel->gettransdetails($this->request->getUri()->getSegment(3));

		if (empty($data['transdetails'])) {
			return redirect()->to(base_url('applicant'));
		}

		$fnames = $data['transdetails'][0]->fullnames;

		$datah = $this->getHeaderData([
			'fnames' => $fnames,
		]);

		echo view('applicants/header', $datah);
		echo view('applicants/payslip', $data);
		echo view('applicants/footer');
	}

	public function makepayment()
	{

		$rrr = $this->request->getUri()->getSegment(3);

		$config = new PaymentConfig();

		$responseurl = base_url('applicant/remitaresponse');
		$new_hash_string = $config->merchantId . $rrr . $config->apiKey;
		$new_hash = hash('sha512', $new_hash_string);

		echo '<form action="' . $config->gatewayRRRPaymentUrl . '" name= "apiform" method="POST" id="apiform">
				<input id="merchantId" name="merchantId" value="' . $config->merchantId . '" type="hidden"/>
				<input id="rrr" name="rrr" value="' . $rrr . '" type="hidden"/>
				<input id="responseurl" name="responseurl" value="' . $responseurl . '" type="hidden"/>
				<input id="hash" name="hash" value="' . $new_hash . '" type="hidden"/>
				<script language="JavaScript">document.apiform.submit();</script>
			</form>';
	}

	public function remitaresponse()
	{
		$request = service('request');

		// Retrieve query parameters
		$rrr = $request->getGet('RRR');
		$orderid = $request->getGet('orderID');


		$response = self::remita_transaction_details($orderid);
		$response_code = $response['status'];


		if ($response_code == '01' || $response_code == '00') {


			$udata = [
				'trans_custom1'  => "Paid"
			];

			$this->applicantModel->update_transaction($udata, $rrr, $orderid);

			// Success message and redirection
			$rrr = htmlspecialchars($rrr, ENT_QUOTES);
			$message = "Transaction is Successful, Your RRR is $rrr. Kindly print your receipt. This transaction will be subject to verification by the Bursary Unit";
			$redirectUrl = base_url('applicant/phistory');
			self::redirectWithAlert($message, $redirectUrl);
		} else {

			// Pending transaction message and redirection
			$rrr = htmlspecialchars($rrr, ENT_QUOTES); // Ensure $rrr is safely output
			$orderid = htmlspecialchars($orderid, ENT_QUOTES); // Ensure $orderid is safely output
			$message = "Transaction is Pending, Your RRR is $rrr. Kindly requery your transaction if debited or try again";
			$redirectUrl = base_url('applicant/paymentslip/' . $orderid);
			self::redirectWithAlert($message, $redirectUrl);
		}
	}

	private static function remita_transaction_details($orderId)
	{
		$config = new PaymentConfig();

		$mert =  $config->merchantId;
		$api_key =  $config->apiKey;
		$concatString = $orderId . $api_key . $mert;
		$hash = hash('sha512', $concatString);
		$url 	= $config->checkStatusUrl . '/' . $mert  . '/' . $orderId . '/' . $hash . '/' . 'orderstatus.reg';

		//  Initiate curl
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($result, true);
		return $response;
	}

	public function phistory()
	{

		$data['stddetails'] = ($this->appstatus == 1) ? $this->accountModel->getacctdetails(session()->get('log_id')) : $this->accountModel->getacctdetail(session()->get('log_id'));
		[$fnames, $appfees] = $this->getAppFees($data['stddetails']);
		$appbiodata =  $data['stddetails'][0]->biodata;

		$datah = $this->getHeaderData([
			'appfees' => $appfees,
			'fnames' => $fnames,
			'appbiodata' => $appbiodata,
		]);




		$data['paystatus'] =  $this->applicantModel->gettrans_details(session()->get('log_id'));

		echo view('applicants/header', $datah);
		echo view('applicants/mypayments', $data);
		echo view('applicants/footer');
	}

	public function checkpayment()
	{

		$transids = $this->applicantModel->gettransids(session()->get('log_id'));

		if (empty($transids)) {
			$message = "No Transaction has been generated. Kindly generate payment using the `Pay Now` Link";
			$redirectUrl = base_url('applicant');
			self::redirectWithAlert($message, $redirectUrl);
		} else {
			$config = new PaymentConfig();
			//print_r($transids ); exit;
			// Loop through each transaction ID
			foreach ($transids as $transid) {

				$hash_string = $transid->trans_no . $config->apiKey . $config->merchantId;
				$apiHash = hash('sha512', $hash_string);

				// Revalidate payment
				$curl = curl_init();
				curl_setopt_array($curl, [
					CURLOPT_URL => $config->checkStatusUrl . "/$config->merchantId/$transid->trans_no/$apiHash/orderstatus.reg",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'GET',
					CURLOPT_HTTPHEADER => [
						'Content-Type: application/json',
						"Authorization: remitaConsumerKey=2547916,remitaConsumerToken=$apiHash"
					],
				]);

				$response = curl_exec($curl);
				curl_close($curl);

				$result = json_decode($response);

				if ($result === null) {
					$message = "The payment gateway is down or under maintenance. Please try again later.";
					$redirectUrl = base_url('applicant/phistory');
					self::redirectWithAlert($message, $redirectUrl);
					return;
				}

				if ($result->message === "Successful" && $result->status === "00") {
					// Update payment status for successful transaction
					$udata = [
						'trans_custom1' => 'Paid'
					];

					$this->applicantModel->update_trans($udata, $result->rrr, $result->orderId);
					$orderId = htmlspecialchars($result->orderId, ENT_QUOTES);
					$message = "Transaction is Successful. Your Transaction ID is $orderId. Please log in to print your receipt. This transaction will be verified by the Bursary Unit.";
					$redirectUrl = base_url('applicant/phistory');
					self::redirectWithAlert($message, $redirectUrl);
					return;
				}
			}


			$message = "No successful transaction found. Please try again.";
			$redirectUrl = base_url('applicant/phistory');
			self::redirectWithAlert($message, $redirectUrl);
		}
	}


	public function getLGA()
	{
		$stateId = $this->request->getPost('state_id');
		$applicantModel = new ApplicantModel();
		$data = $applicantModel->getlga($stateId);
		echo json_encode($data);
	}

	public function biodata()
	{

		$biostatus = $this->applicantModel->getbiostatus(session()->get('log_id'));

		if ($this->feestatus == '0') {
			$message = "You must pay for the Application Form before you update your biodata";
			$redirectUrl = base_url('applicant/');
			self::redirectWithAlert($message, $redirectUrl);
		}

		$data['stddetails'] = $this->accountModel->{$biostatus == 1 ? 'getacctdetails' : 'getacctdetail'}(session()->get('log_id'));

		[$fnames, $appfees] = $this->getAppFees($data['stddetails']);

		$data['jambdetails'] =  $this->accountModel->getjambdetail($data['stddetails'][0]->jambno);

		$datah = $this->getHeaderData([
			'fnames' => $fnames,
		]);

		$data['states'] = $this->applicantModel->getstate();

		echo view('applicants/header', $datah);
		echo view('applicants/profile', $data);
		echo view('applicants/footer');
	}

	public function update_profile()
	{
		helper(['form', 'url']);
		$data = [];
		if ($this->request->getMethod() == 'POST') {
			$rules = [
				'gender' => 'required',
				'marital_status' => 'required',
				'student_homeaddress' => 'required',
				'contact_address' => 'required',
				'nok' => 'required',
				'nok_tel' => 'required',
				'nok_address' => 'required',
				'nok_email' => 'required',
				'state' => 'required',
				'lga' => 'required',
			];

			$dob = $this->request->getPost('dob');
			$mob = $this->request->getPost('mob');
			$yob = $this->request->getPost('yob');
			$birthday = "$yob-$mob-$dob";
			$std_id  = session()->get('log_id');
			if ($this->validate($rules)) {

				//check if portal is closed

				$pstatus = $this->accountModel->portalclosing();
				if ($pstatus == '0') {
					$message = "Portal is CLOSED to Biodata Update";
					$redirectUrl = base_url('applicant/');
					self::redirectWithAlert($message, $redirectUrl);
					exit;
				}

				// upload image if only image is sent
				$imgdata = [];

				if ($this->request->getFile('file')) {

					$appno = session()->get('appno');
					$img = $this->request->getFile('file');
					$allowedExtensions = ['jpg', 'jpeg'];
					$allowedMimeTypes = ['image/jpeg', 'image/jpg'];
					$ext = $img->guessExtension();
					$mimeType = $img->getClientMimeType();

					if (!in_array($ext, $allowedExtensions) || !in_array($mimeType, $allowedMimeTypes)) {
						session()->setFlashdata('error', 'Invalid file type. Only JPG and JPEG files are allowed.');
						return redirect()->to(base_url('applicant/biodata'))->withInput();
					}

					$newName = $appno . '.' . $ext;

					if ($img->isValid() && !$img->hasMoved()) {

						if ($img->getSize() > 102400) {
							session()->setFlashdata('error', 'Passport size exceeds the 100KB limit.');
							return redirect()->to(base_url('applicant/biodata'))->withInput();
						}

						// Validate image content
						if (!$this->isValidImage($img->getTempName(), $mimeType)) {
							session()->setFlashdata('error', 'Invalid image content.');
							return redirect()->to(base_url('applicant/biodata'))->withInput();
						}

						$previousImagePath = WRITEPATH . 'thumbs/' . $newName;
						if (file_exists($previousImagePath)) {
							unlink($previousImagePath);
						}

						$wtext = "DSPG$appno";

						// Move the uploaded file to the writable/thumbs directory
						$img->move(WRITEPATH . 'thumbs/', $newName);

						// Add watermark and save the image to the writable/thumbs directory
						\Config\Services::image()
							->withFile(WRITEPATH . 'thumbs/' . $newName)
							->text($wtext, [
								'color'      => '#fff',
								'opacity'    => 0.4,
								'withShadow' => false,
								'hAlign'     => 'center',
								'vAlign'     => 'bottom',
								'fontSize'   => 40
							])
							->save(WRITEPATH . 'thumbs/' . $newName, 90);
					} else {
						session()->setFlashdata('error', 'Error uploading passport');
						return redirect()->to(base_url('applicant'));
					}
					$imgdata = ['std_photo' => $newName];
				}

				$data = [
					'gender' => $this->request->getPost('gender'),
					'marital_status' => $this->request->getPost('marital_status'),
					'student_homeaddress' => $this->request->getPost('student_homeaddress'),
					'contact_address' => $this->request->getPost('contact_address'),
					'next_of_kin' => $this->request->getPost('nok'),
					'nok_tel' => $this->request->getPost('nok_tel'),
					'nok_address' => $this->request->getPost('nok_address'),
					'nok_email' => $this->request->getPost('nok_email'),
					'state_of_origin' => $this->request->getPost('state'),
					'local_gov' => $this->request->getPost('lga'),
					'birthdate' => $birthday,
					'biodata' => 1,
					'std_custome7' => 1,
				];

				$data = [...$data, ...$imgdata];

				$this->applicantModel->updatebiodata($data, $std_id);

				$message = "Your Biodata was successfully Updated";
				$redirectUrl = base_url('applicant/olevel');
				self::redirectWithAlert($message, $redirectUrl);
			}
		} else {

			session()->setFlashdata('error', 'Error Updating Biodata');
			return redirect()->to(base_url('applicant'))->withInput();
		}
	}

	private function isValidImage($filePath, $mimeType)
	{
		$imageData = getimagesize($filePath);

		if ($imageData === false) {
			return false;
		}

		$validMimeTypes = ['image/jpeg', 'image/jpg'];
		return in_array($imageData['mime'], $validMimeTypes) && $imageData['mime'] === $mimeType;
	}

	public function my_application()
	{

		//check if portal is closed

		$pstatus = $this->accountModel->portalclosing();

		if ($pstatus == '0') {
			$message = "Portal is CLOSED to Filling of Application Forms";
			$redirectUrl = base_url('applicant/');
			self::redirectWithAlert($message, $redirectUrl);
		}

		$data['stddetails'] =  $this->accountModel->getacctdetail(session()->get('log_id'));
		[$fnames, $appfees] = $this->getAppFees($data['stddetails']);

		$datah = $this->getHeaderData([
			'fnames' => $fnames,
		]);
		$data['states'] = $this->applicantModel->getstate();
		$data['programmes'] = $this->applicantModel->getprogramme();
		$data['jambs'] =  $this->applicantModel->get_jamb(session()->get('log_id'));

		echo view('applicants/header', $datah);
		echo view('applicants/application_home', $data);
		echo view('applicants/footer');
	}



	public function rem_allolevel()
	{
		$cid = $this->applicantModel->removeolevel(session()->get('log_id'));

		if ($cid) {
			$message = "O-Level Detail Successfully Refreshed, You can now enter again";
			$redirectUrl = base_url('applicant/olevel');
			self::redirectWithAlert($message, $redirectUrl);
		} else {
			$message = "Error removing O-Level Detail";
			$redirectUrl = base_url('applicant/olevel');
			self::redirectWithAlert($message, $redirectUrl);
		}
	}




	public function add_school()
	{
		helper(['form', 'url']);
		$data = [];
		if ($this->request->getMethod() == 'POST') {
			$rules = [
				'schoolname' => 'required',
				'fromdate' => 'required',
				'todate' => 'required',
				'ndmatno' => 'required',
				'grade' => 'required',
			];
		}

		if ($this->validate($rules)) {


			$ndmatno = $this->request->getVar('ndmatno');

			$data = [
				'std_id' => session()->get('log_id'),
				'schoolname'  => strtoupper($this->request->getVar('schoolname')),
				'ndmatno' => $ndmatno,
				'cos'  => $this->request->getVar('cos'),
				'fromdate' => $this->request->getVar('fromdate'),
				'grade' => $this->request->getVar('grade'),
				'todate' => $this->request->getVar('todate')

			];

			$applicantModel = new ApplicantModel();
			$applicantModel->save_school($data);

			$message = "School Details successfully Added";
			$redirectUrl = base_url('applicant/school');
			self::redirectWithAlert($message, $redirectUrl);
			exit;
		} else {
			$message = "Error Adding School Details";
			$redirectUrl = base_url('applicant/school');
			self::redirectWithAlert($message, $redirectUrl);
		}
	}

	public function edit_school()
	{
		helper(['form', 'url']);
		$data = [];
		if ($this->request->getMethod() == 'POST') {
			$rules = [
				'schoolname' => 'required',
				'fromdate' => 'required',
				'todate' => 'required',
				'ndmatno' => 'required',
				'grade' => 'required',
			];
		}

		if ($this->validate($rules)) {


			$ndmatno = $this->request->getVar('ndmatno');

			$data = [
				'schoolname'  => strtoupper($this->request->getVar('schoolname')),
				'ndmatno' => $ndmatno,
				'cos'  => $this->request->getVar('cos'),
				'fromdate' => $this->request->getVar('fromdate'),
				'grade' => $this->request->getVar('grade'),
				'todate' => $this->request->getVar('todate')

			];


			$applicantModel = new ApplicantModel();
			$applicantModel->update_school($data, session()->get('log_id'));

			$message = "School Details successfully Updated";
			$redirectUrl = base_url('applicant/editschool');
			self::redirectWithAlert($message, $redirectUrl);
			exit;
		} else {
			$message = "Error Updating School Details";
			$redirectUrl = base_url('applicant/editschool');
			self::redirectWithAlert($message, $redirectUrl);
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
		return redirect()->to(base_url('applicant/my_application'));
	}

	public function olevel()
	{

		$data = $this->getHeaderData();
		$datac['stddetails'] =  $this->accountModel->getacctdetails(session()->get('log_id'));

		$datac['std_custome6'] = $datac['stddetails'][0]->std_custome6;
		$datac['subjects'] = $this->applicantModel->getsubjects();
		$datac['grades'] = $this->applicantModel->getgrades();
		$datac['olevels'] =  $this->applicantModel->get_olevel(session()->get('log_id'));
		echo view('applicants/header', $data);
		echo view('applicants/olevel', $datac);
		echo view('applicants/footer');
	}


	public function add_olevel()
	{
		helper(['form', 'url']);
		$data = [];
		if ($this->request->getMethod() == 'POST') {

			//first sitting		
			$subjects = $this->request->getPost('subject');
			$mySubjects = array_values(array_filter($subjects));
			$grades = $this->request->getPost('grade');
			$myGrades = array_values(array_filter($grades));
			$nosubject = count($mySubjects);
			$nogrades = count($myGrades);


			if ($nosubject != $nogrades) {
				$message = "No of Olevel Subject & Grade for First Sitting are not the same, kindly reselect again";
				$redirectUrl = base_url('applicant/olevel');
				self::redirectWithAlert($message, $redirectUrl);
				exit;
			}

			//second sitting		
			$subjectss = $this->request->getPost('subjects');
			$mySubjectss = array_values(array_filter($subjectss));
			$gradess = $this->request->getPost('grades');
			$myGradess = array_values(array_filter($gradess));
			$nosubjects = count($mySubjectss);
			$nogradess = count($myGradess);

			if ($nosubjects != $nogradess) {
				$message = "No of Olevel Subject & Grade for Second Sitting are not the same, kindly reselect again";
				$redirectUrl = base_url('applicant/olevel');
				self::redirectWithAlert($message, $redirectUrl);
				exit;
			}


			$totalsubjects  = $nosubject + $nosubjects;

			if ($totalsubjects < self::MINIMUM_OLEVEl_SUB) {
				$message = "You must Select at least 5 Olevel Subjects";
				$redirectUrl = base_url('applicant/olevel');
				self::redirectWithAlert($message, $redirectUrl);
				exit;
			}
			$this->applicantModel->removeolevel(session()->get('log_id'));

			//for 1st sitting
			for ($i = 0; $i < $nosubject; $i++) {
				$subjects = $mySubjects[$i];
				$grades = $myGrades[$i];
				$data = [
					'std_id' => session()->get('log_id'),
					'subname'  => $subjects,
					'certname' => $this->request->getPost('examtype'),
					'grade'  => $grades,
					'emonth' => strtoupper($this->request->getPost('frommth')),
					'examno' => $this->request->getPost('examno'),
					'centerno' => $this->request->getPost('centerno'),
					'eyear' => $this->request->getPost('toyear'),
					'sitting' => 'First'

				];

				$this->applicantModel->save_olevel($data, session()->get('log_id'));
			}

			//for 2nd sitting

			if ($nosubjects) {
				for ($j = 0; $j < $nosubjects; $j++) {
					$subjectss = $mySubjectss[$j];
					$gradess = $myGradess[$j];
					$datas = [
						'std_id' => session()->get('log_id'),
						'subname'  => $subjectss,
						'certname' => $this->request->getPost('examtypes'),
						'grade'  => $gradess,
						'emonth' => strtoupper($this->request->getPost('frommths')),
						'examno' => $this->request->getPost('examnos'),
						'centerno' => $this->request->getPost('centernos'),
						'eyear' => $this->request->getPost('toyears'),
						'sitting' => 'Second'

					];

					$this->applicantModel->save_olevel($datas, session()->get('log_id'));
				}
			}

			$message = "Your Olevel was successfully Updated";
			$redirectUrl = base_url('applicant/olevel');
			self::redirectWithAlert($message, $redirectUrl);
		} else {

			$message = "Error Adding Olevel Details";
			$redirectUrl = base_url('applicant/olevel');
			self::redirectWithAlert($message, $redirectUrl);
		}
	}

	public function school()
	{
		$data['stddetails'] =  $this->accountModel->getacctdetails(session()->get('log_id'));


		$datah = $this->getHeaderData();
		$data['courses'] = $this->applicantModel->getdept_options(1, $data['stddetails'][0]->std_programmetype);
		$data['polys'] = $this->applicantModel->getpolys();
		$data['std_eduhistory'] =  $this->applicantModel->get_eduhistory(session()->get('log_id'));

		echo view('applicants/header', $datah);
		echo view('applicants/school', $data);
		echo view('applicants/footer');
	}


	public function editschool()
	{
		$data['stddetails'] =  $this->accountModel->getacctdetails(session()->get('log_id'));


		$datah = $this->getHeaderData();
		$data['courses'] = $this->applicantModel->getdept_options(1, $data['stddetails'][0]->std_programmetype);
		$data['polys'] = $this->applicantModel->getpolys();
		$data['std_eduhistory'] =  $this->applicantModel->get_eduhistory(session()->get('log_id'));

		echo view('applicants/header', $datah);
		echo view('applicants/editschool', $data);
		echo view('applicants/footer');
	}



	public function logout()
	{
		$this->session->destroy();
		return redirect()->to(base_url());
	}

	public function declares()
	{
		$datah = $this->getHeaderData();
		$data['stddetails'] =  $this->accountModel->getacctdetails(session()->get('log_id'));
		$data['std_eduhistory'] =  $this->applicantModel->get_eduhistory(session()->get('log_id'));
		$data['olevels'] =  $this->applicantModel->get_olevel(session()->get('log_id'));
		$data['jambs'] =  $this->applicantModel->get_jamb(session()->get('log_id'));

		echo view('applicants/header', $datah);
		echo view('applicants/declares', $data);
		echo view('applicants/footer');
	}

	public function getSchool()
	{
		$postData = $this->request->getPost();
		$applicantModel = new ApplicantModel();
		$data = $applicantModel->getcourses($postData);
		echo json_encode($data);
	}




	public function application_preview()
	{


		$data['stddetails'] =  $this->accountModel->getacctdetails(session()->get('log_id'));
		$data['std_eduhistory'] =  $this->applicantModel->get_eduhistory(session()->get('log_id'));
		$data['olevels'] =  $this->applicantModel->get_olevel(session()->get('log_id'));
		$stdphoto = $data['stddetails'][0]->std_photo;
		$data['jambs'] =  $this->applicantModel->get_jamb(session()->get('log_id'));
		$path =  base_url('writable/thumbs/' . $stdphoto);

		if ($stdphoto == "avatar.jpg") {
			$path =  base_url('public/' . $stdphoto);
		}

		$datah = $this->getHeaderData([
			'path' => $path,
		]);


		echo view('applicants/header', $datah);
		echo view('applicants/preview_application', $data);
		echo view('applicants/footer');
	}

	public function printreceipt()
	{

		$data['stddetails'] =  $this->accountModel->getacctdetail(session()->get('log_id'));
		$data['paydetails'] =  $this->applicantModel->getpaydetails(session()->get('log_id'));

		$stdphoto = $data['stddetails'][0]->std_photo;

		$path =  base_url('writable/thumbs/' . $stdphoto);

		if ($stdphoto == "avatar.jpg") {
			$path =  base_url('public/' . $stdphoto);
		}


		$datah = $this->getHeaderData([
			'path' => $path,
		]);

		echo view('applicants/header', $datah);
		echo view('applicants/payreceipt', $data);
		echo view('applicants/footer');
	}

	public function print_receipt()
	{

		$transid = $this->request->getUri()->getSegment(3);
		$stddetails =  $this->accountModel->getacctdetail(session()->get('log_id'));
		$paydetails =  $this->applicantModel->getpaydetail(session()->get('log_id'), $transid);

		$stdphoto = $stddetails[0]->std_photo;

		$path =  base_url('writable/thumbs/' . $stdphoto);

		if ($stdphoto == "avatar.jpg") {
			$path =  base_url('public/' . $stdphoto);
		}


		$data = $this->getHeaderData([
			'path' => $path,
			'stddetails' => $stddetails,
			'paydetails' => $paydetails,
		]);

		echo view('applicants/print_receipt', $data);
	}

	public function application_forms()
	{

		$data['stddetails'] =  $this->accountModel->getacctdetails(session()->get('log_id'));
		$data['olevels'] =  $this->applicantModel->get_olevel(session()->get('log_id'));


		// Check if required data is empty
		if (empty($data['stddetails']) || empty($data['olevels'])) {
			$message = "You must complete your biodata and olevel results before you can print the application forms";
			$redirectUrl = base_url('applicant/my_application');
			self::redirectWithAlert($message, $redirectUrl);
		}

		$datah = $this->getHeaderData();

		echo view('applicants/header', $datah);
		echo view('applicants/applicationforms', $data);
		echo view('applicants/footer');
	}

	public function application_form()
	{
		$data['stddetails'] =  $this->accountModel->getacctdetails(session()->get('log_id'));
		$data['std_eduhistory'] =  $this->applicantModel->get_eduhistory(session()->get('log_id'));
		$data['olevels'] =  $this->applicantModel->get_olevel(session()->get('log_id'));

		$data['jambs'] =  $this->applicantModel->get_jamb(session()->get('log_id'));
		$stdphoto = $data['stddetails'][0]->std_photo;

		$path =  base_url('writable/thumbs/' . $stdphoto);

		if ($stdphoto == "avatar.jpg") {
			$path =  base_url('public/' . $stdphoto);
		}

		$datah = $this->getHeaderData([
			'path' => $path,
		]);

		$data['examdate'] = $this->applicantModel->get_examdate($data['stddetails'][0]->stdcourse);

		echo view('applicants/header', $datah);
		echo view('applicants/application_form', $data);
		echo view('applicants/footer');
	}



	public function application_card()
	{

		$data['stddetails'] =  $this->accountModel->getacctdetails(session()->get('log_id'));

		$stdphoto = $data['stddetails'][0]->std_photo;

		$path =  base_url('writable/thumbs/' . $stdphoto);

		if ($stdphoto == "avatar.jpg") {
			$path =  base_url('public/' . $stdphoto);
		}

		$datah = $this->getHeaderData([
			'path' => $path,
		]);

		$data['examdate'] = $this->applicantModel->get_examdate($data['stddetails'][0]->stdcourse);

		echo view('applicants/header', $datah);
		echo view('applicants/application_card', $data);
		echo view('applicants/footer');
	}





	public function rem_olevel()
	{

		$sid = $this->request->getUri()->getSegment(3);

		$cid = $this->applicantModel->removeolevel($sid);

		if ($cid) {
			$message = "O-Level Detail Successfully removed";
		} else {
			$message = "Error removing O-Level Detail";
		}
		$redirectUrl = base_url('applicant/olevel');
		self::redirectWithAlert($message, $redirectUrl);
	}





	public function appfinishs()
	{
		$sdate = date('Y-m-d');
		$std_id  = session()->get('log_id');
		$data = [
			"std_custome9" => 1,
			"appsubmitdate" => $sdate
		];

		$this->applicantModel->save_schools($data, $std_id);
		return redirect()->to(base_url('applicant/my_application'));
	}


	public function jamb()
	{
		$olevels =  $this->applicantModel->get_olevel(session()->get('log_id'));

		if (empty($olevels)) {
			$message = "Olevel Must be Added before Jamb Details";
			$redirectUrl = base_url('applicant/olevel');
			self::redirectWithAlert($message, $redirectUrl);

			exit;
		}

		$data['stddetails'] =  $this->accountModel->getacctdetails(session()->get('log_id'));

		$datah = $this->getHeaderData();
		$data['subjects'] = $this->applicantModel->getsubjects();
		$data['jambs'] =  $this->applicantModel->get_jamb(session()->get('log_id'));

		echo view('applicants/header', $datah);
		echo view('applicants/jambdetail', $data);
		echo view('applicants/footer');
	}


	public function add_jamb()
	{
		helper(['form', 'url']);
		$data = [];
		if ($this->request->getMethod() == 'POST') {

			$subjects = $this->request->getPost('subject');
			$mySubjects = array_values(array_filter($subjects));
			$scores = $this->request->getPost('score');
			$myScores = array_values(array_filter($scores));
			$nosubject = count($mySubjects);
			$noscores = count($myScores);


			if ($nosubject != $noscores) {
				$message = "No of Selected Subject & Grade are not the same, kindly reselect again";
				$redirectUrl = base_url('applicant/jamb');
				self::redirectWithAlert($message, $redirectUrl);
				exit;
			}

			if ($nosubject < self::MINIMUM_JAMB_SUB) {
				$message = "You must Select at least 4 Jamb Subjects";
				$redirectUrl = base_url('applicant/jamb');
				self::redirectWithAlert($message, $redirectUrl);
				exit;
			}

			for ($i = 0; $i < $nosubject; $i++) {
				$subjects = $mySubjects[$i];
				$scores = $myScores[$i];
				$data = [
					'std_id' => session()->get('log_id'),
					'jambno'  => $this->request->getPost('jambno'),
					'subjectname' => $subjects,
					'jscore'  => $scores,
				];


				$this->applicantModel->save_jamb($data, session()->get('log_id'));
			}

			$message = "Your Jamb Details was successfully Added";
			$redirectUrl = base_url('applicant/jamb');
			self::redirectWithAlert($message, $redirectUrl);
		} else {

			$message = "Error Adding Jamb Details";
			$redirectUrl = base_url('applicant/jamb');
			self::redirectWithAlert($message, $redirectUrl);
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


		if ($appstatus == 1) {
			$data['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
		} else {

			echo '<script type="text/javascript">
			alert("You have to submit your application and get admitted before you can pay your Acceptance Fee");
			window.location = "' . base_url('applicant') . '";
		</script>';
		}
		//check if student is qualified to pay acceptance fee
		if ($admstatus == 0) {


			echo '<script type="text/javascript">
			alert("You have to be admitted before you can pay your Acceptance Fee");
			window.location = "' . base_url('applicant') . '";
		</script>';
		}

		$progid =  $data['stddetails'][0]->stdprogramme_id;
		$progtype =  $data['stddetails'][0]->std_programmetype;
		$fnames = $data['stddetails'][0]->surname . ' ' . $data['stddetails'][0]->firstname;

		$acceptfees = [$fnames, $acceptfee] = $this->getAcceptanceFees($data['stddetails']);
		$appbiodata =  $data['stddetails'][0]->biodata;

		$stdphoto = $data['stddetails'][0]->std_photo;

		$path =  base_url('writable/thumbs/' . $stdphoto);

		if ($stdphoto == "avatar.jpg") {
			$path =  base_url('public/' . $stdphoto);
		}



		$datah = $this->getHeaderData([
			'acceptfees' => $acceptfee,
			'fnames' => $fnames,
			'appbiodata' => $appbiodata,
			'path' => $path,
		]);

		$data['paystatus'] =  $applicantModel->getaccept_details(session()->get('log_id'));


		echo view('applicants/header', $datah);
		echo view('applicants/acceptfee', $data);
		echo view('applicants/footer');
	}


	public function vfee()
	{
		$accountModel = new AccountModel();
		$applicantModel = new ApplicantModel();

		$appyear = $accountModel->getsess();
		$pstat = $applicantModel->getfeestatus(session()->get('log_id'));
		$appstatus = $applicantModel->getappstatus(session()->get('log_id'));
		$admstatus = $applicantModel->getadmstatus(session()->get('log_id'));


		if ($appstatus == 1) {
			$data['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
		} else {

			echo '<script type="text/javascript">
			alert("You have to submit your application and get admitted before you can pay your Acceptance Fee");
			window.location = "' . base_url('applicant') . '";
		</script>';
		}
		//check if student is qualified to pay acceptance fee
		if ($admstatus == 0) {


			echo '<script type="text/javascript">
			alert("You have to be admitted before you can pay your Acceptance Fee");
			window.location = "' . base_url('applicant') . '";
		</script>';
		}

		//check if student is has paid acceptance fee
		if ($this->acceptfeestatus == 0) {
			echo '<script type="text/javascript">
			alert("You have to be pay the Acceptance Fee before result verification fee");
			window.location = "' . base_url('applicant') . '";
		</script>';
		}

		$progid =  $data['stddetails'][0]->stdprogramme_id;
		$progtype =  $data['stddetails'][0]->std_programmetype;
		$fnames = $data['stddetails'][0]->surname . ' ' . $data['stddetails'][0]->firstname;

		[$fnames, $rvfees] = $this->getResultVerificationFees($data['stddetails']);


		$appbiodata =  $data['stddetails'][0]->biodata;

		$stdphoto = $data['stddetails'][0]->std_photo;

		$path =  base_url('writable/thumbs/' . $stdphoto);

		if ($stdphoto == "avatar.jpg") {
			$path =  base_url('public/' . $stdphoto);
		}



		$datah = $this->getHeaderData([
			'rverifyfees' => $rvfees,
			'fnames' => $fnames,
			'appbiodata' => $appbiodata,
			'path' => $path,
		]);


		$data['paystatus'] =  $applicantModel->getresultverify_details(session()->get('log_id'));


		echo view('applicants/header', $datah);
		echo view('applicants/resultverifyfee', $data);
		echo view('applicants/footer');
	}

	public function cfee()
	{
		$accountModel = new AccountModel();
		$applicantModel = new ApplicantModel();

		$appyear = $accountModel->getsess();
		$pstat = $applicantModel->getfeestatus(session()->get('log_id'));
		$appstatus = $applicantModel->getappstatus(session()->get('log_id'));
		$admstatus = $applicantModel->getadmstatus(session()->get('log_id'));


		if ($appstatus == 1) {
			$data['stddetails'] =  $accountModel->getacctdetails(session()->get('log_id'));
		} else {

			echo '<script type="text/javascript">
			alert("You have to submit your application before you can pay your Change of Course Fee");
			window.location = "' . base_url('applicant') . '";
		</script>';
		}


		//check if student is has paid acceptance fee
		/*	if ($this->acceptfeestatus == 0) {
			echo '<script type="text/javascript">
			alert("You have to be pay the Acceptance Fee before Change of Course fee");
			window.location = "' . base_url('applicant') . '";
		</script>';
		}*/

		$progid =  $data['stddetails'][0]->stdprogramme_id;
		$progtype =  $data['stddetails'][0]->std_programmetype;
		$fnames = $data['stddetails'][0]->surname . ' ' . $data['stddetails'][0]->firstname;

		[$fnames, $cfees] = $this->getChangeofCourseFees($data['stddetails']);




		$appbiodata =  $data['stddetails'][0]->biodata;

		$stdphoto = $data['stddetails'][0]->std_photo;

		$path =  base_url('writable/thumbs/' . $stdphoto);

		if ($stdphoto == "avatar.jpg") {
			$path =  base_url('public/' . $stdphoto);
		}



		$datah = $this->getHeaderData([
			'cfees' => $cfees,
			'fnames' => $fnames,
			'appbiodata' => $appbiodata,
			'path' => $path,
		]);


		$data['paystatus'] =  $applicantModel->getchangeofcourse_details(session()->get('log_id'));


		echo view('applicants/header', $datah);
		echo view('applicants/changeofcoursefee', $data);
		echo view('applicants/footer');
	}

	public function payacceptance()
	{
		$data = [];


		if ($this->request->getMethod() == 'GET') {

			//check if transaction ID has already been generated
			$genid =  $this->applicantModel->gettransid(session()->get('log_id'), 2);
			if (!empty($genid)) {
				$message = "You have already generated a Transaction, You will be redirected to make payment";
				$redirectUrl = base_url('applicant/paymentslip/' . $genid);
				self::redirectWithAlert($message, $redirectUrl);
			}

			$stddetails = $this->accountModel->getacctdetail(session()->get('log_id'));
			[$fnames, $acceptfee] = $this->getAcceptanceFees($stddetails);

			foreach ($stddetails as $stddetail) {
				$appno = $stddetail->app_no;
				$semail = $stddetail->student_email;
				$sgsm = $stddetail->student_mobiletel;
			}

			$fdate = date('Y-m-d h:i:s');
			$tdate = date('Y-m-d');

			$total = $acceptfee + self::ACCEPTANCE_PORTAL_FEE;

			//remita
			$config = new PaymentConfig();

			$timesammp = DATE("dmyHis");
			$orderId = session()->get('log_id') . $timesammp;

			$hash_string = $config->merchantId . $config->serviceTypeId . $orderId . $total . $config->apiKey;
			$apiHash = hash('sha512', $hash_string);

			$postFields = array(
				"serviceTypeId" => $config->serviceTypeId,
				"amount" => $total,
				"orderId" => $orderId,
				"payerName" => $fnames,
				"payerEmail" => $semail,
				"payerPhone" => $sgsm,
				"description" => "Acceptance Fees"
			);


			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $config->gatewayUrl,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode($postFields),
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					'Authorization: remitaConsumerKey=' . $config->merchantId . ',remitaConsumerToken=' . $apiHash
				),
			));

			$json_response = curl_exec($curl);
			if (curl_errno($curl)) {
				echo 'cURL error: ' . curl_error($curl);
			} else {
				$jsonData = substr($json_response, 7, -1);
				$response = json_decode($jsonData, true);
			}
			curl_close($curl);;

			$statuscode = $response['statuscode'];

			if ($statuscode != '025') {
				$message = "Error generating RRR. Please try again";
				$redirectUrl = base_url('applicant');
				self::redirectWithAlert($message, $redirectUrl);
			}

			$rrr = trim($response['RRR']);

			$checkrrr =  $this->applicantModel->checkrrr($rrr);

			if ($checkrrr) {
				$message = "RRR already generated. Please try again";
				$redirectUrl = base_url('applicant');
				self::redirectWithAlert($message, $redirectUrl);
			}
			//end remita


			$data = [
				'log_id' => session()->get('log_id'),
				'trans_no' => $orderId,
				'generated_date' => $fdate,
				'trans_date' => $fdate,
				't_date' => $tdate,
				'trans_year' => $this->appyear,
				'trans_custom1' => 'Pending',
				'fullnames' => $fnames,
				'appno' => $appno,
				'paychannel' => 'Remita',
				'semail' => $semail,
				'rrr' => $rrr,
			];


			$transactions = [
				['fee_id' => 2, 'fee_name' => "Acceptance Fee", 'fee_amount' => $acceptfee],
				['fee_id' => 5, 'fee_name' => "Portal Charge", 'fee_amount' => self::ACCEPTANCE_PORTAL_FEE],
			];

			// Save both transactions
			foreach ($transactions as $transaction) {
				$this->applicantModel->save_transaction(array_merge($data, $transaction));
			}
			$message = "Transaction ID generated successfully, You will be redirected to make payment";
			$redirectUrl = base_url('applicant/paymentslip/' . $orderId);
			self::redirectWithAlert($message, $redirectUrl);
		} else {

			$message = "Error Generating Transaction ID, Please Try Again";
			$redirectUrl = base_url('applicant'); // Adjust URL if necessary
			self::redirectWithAlert($message, $redirectUrl);
		}
	}

	public function payresultverify()
	{
		$data = [];


		if ($this->request->getMethod() == 'POST') {
			$vnos = $this->request->getPost('vnos');
			if (empty($vnos) || !is_numeric($vnos) || (int)$vnos != $vnos) {
				$vnos = 1;
			}

			//check if transaction ID has already been generated
			/*$genid =  $this->applicantModel->gettransid(session()->get('log_id'));
				if (!empty($genid)) {
				$message = "You have already generated a Transaction, You will be redirected to make payment";
				$redirectUrl = base_url('applicant/paymentslip/' . $genid);
				self::redirectWithAlert($message, $redirectUrl);
			}*/

			$stddetails = $this->accountModel->getacctdetail(session()->get('log_id'));
			[$fnames, $rvfees] = $this->getResultVerificationFees($stddetails);

			foreach ($stddetails as $stddetail) {
				$appno = $stddetail->app_no;
				$semail = $stddetail->student_email;
				$sgsm = $stddetail->student_mobiletel;
			}

			$fdate = date('Y-m-d h:i:s');
			$tdate = date('Y-m-d');
			$totalfee = $rvfees * $vnos;
			$total = $totalfee + self::RESULT_VERIFICATION_PORTAL_FEE;

			//remita
			$config = new PaymentConfig();

			$timesammp = DATE("dmyHis");
			$orderId = session()->get('log_id') . $timesammp;

			$hash_string = $config->merchantId . $config->serviceTypeId . $orderId . $total . $config->apiKey;
			$apiHash = hash('sha512', $hash_string);

			$postFields = array(
				"serviceTypeId" => $config->serviceTypeId,
				"amount" => $total,
				"orderId" => $orderId,
				"payerName" => $fnames,
				"payerEmail" => $semail,
				"payerPhone" => $sgsm,
				"description" => "Result Verification Fees"
			);


			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $config->gatewayUrl,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode($postFields),
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					'Authorization: remitaConsumerKey=' . $config->merchantId . ',remitaConsumerToken=' . $apiHash
				),
			));

			$json_response = curl_exec($curl);
			if (curl_errno($curl)) {
				echo 'cURL error: ' . curl_error($curl);
			} else {
				$jsonData = substr($json_response, 7, -1);
				$response = json_decode($jsonData, true);
			}
			curl_close($curl);;

			$statuscode = $response['statuscode'];

			if ($statuscode != '025') {
				$message = "Error generating RRR. Please try again";
				$redirectUrl = base_url('applicant');
				self::redirectWithAlert($message, $redirectUrl);
			}

			$rrr = trim($response['RRR']);

			$checkrrr =  $this->applicantModel->checkrrr($rrr);

			if ($checkrrr) {
				$message = "RRR already generated. Please try again";
				$redirectUrl = base_url('applicant');
				self::redirectWithAlert($message, $redirectUrl);
			}
			//end remita


			$data = [
				'log_id' => session()->get('log_id'),
				'trans_no' => $orderId,
				'generated_date' => $fdate,
				'trans_date' => $fdate,
				't_date' => $tdate,
				'trans_year' => $this->appyear,
				'trans_custom1' => 'Pending',
				'fullnames' => $fnames,
				'appno' => $appno,
				'paychannel' => 'Remita',
				'semail' => $semail,
				'rrr' => $rrr,
			];


			$transactions = [
				['fee_id' => 4, 'fee_name' => "Result Verification Fees", 'fee_amount' => $totalfee],
				['fee_id' => 5, 'fee_name' => "Portal Charge", 'fee_amount' => self::RESULT_VERIFICATION_PORTAL_FEE],
			];



			// Save both transactions
			foreach ($transactions as $transaction) {
				$this->applicantModel->save_transaction(array_merge($data, $transaction));
			}
			$message = "Transaction ID generated successfully, You will be redirected to make payment";
			$redirectUrl = base_url('applicant/paymentslip/' . $orderId);
			self::redirectWithAlert($message, $redirectUrl);
		} else {

			$message = "Error Generating Transaction ID, Please Try Again";
			$redirectUrl = base_url('applicant'); // Adjust URL if necessary
			self::redirectWithAlert($message, $redirectUrl);
		}
	}

	public function paychangeofcourse()
	{
		$data = [];


		if ($this->request->getMethod() == 'POST') {

			//check if transaction ID has already been generated
			$genid =  $this->applicantModel->getctransid(session()->get('log_id'));
			if (!empty($genid)) {
				$message = "You have already generated a Transaction, You will be redirected to make payment";
				$redirectUrl = base_url('applicant/paymentslip/' . $genid);
				self::redirectWithAlert($message, $redirectUrl);
			}

			$stddetails = $this->accountModel->getacctdetail(session()->get('log_id'));
			[$fnames, $cfees] = $this->getChangeofCourseFees($stddetails);

			foreach ($stddetails as $stddetail) {
				$appno = $stddetail->app_no;
				$semail = $stddetail->student_email;
				$sgsm = $stddetail->student_mobiletel;
			}

			$fdate = date('Y-m-d h:i:s');
			$tdate = date('Y-m-d');

			$total = $cfees;

			//remita
			$config = new PaymentConfig();

			$timesammp = DATE("dmyHis");
			$orderId = session()->get('log_id') . $timesammp;

			$hash_string = $config->merchantId . $config->serviceTypeId . $orderId . $total . $config->apiKey;
			$apiHash = hash('sha512', $hash_string);

			$postFields = array(
				"serviceTypeId" => $config->serviceTypeId,
				"amount" => $total,
				"orderId" => $orderId,
				"payerName" => $fnames,
				"payerEmail" => $semail,
				"payerPhone" => $sgsm,
				"description" => "Change of Course Fee"
			);


			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $config->gatewayUrl,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode($postFields),
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					'Authorization: remitaConsumerKey=' . $config->merchantId . ',remitaConsumerToken=' . $apiHash
				),
			));

			$json_response = curl_exec($curl);
			if (curl_errno($curl)) {
				echo 'cURL error: ' . curl_error($curl);
			} else {
				$jsonData = substr($json_response, 7, -1);
				$response = json_decode($jsonData, true);
			}
			curl_close($curl);;

			$statuscode = $response['statuscode'];

			if ($statuscode != '025') {
				$message = "Error generating RRR. Please try again";
				$redirectUrl = base_url('applicant');
				self::redirectWithAlert($message, $redirectUrl);
			}

			$rrr = trim($response['RRR']);

			$checkrrr =  $this->applicantModel->checkrrr($rrr);

			if ($checkrrr) {
				$message = "RRR already generated. Please try again";
				$redirectUrl = base_url('applicant');
				self::redirectWithAlert($message, $redirectUrl);
			}
			//end remita


			$data = [
				'log_id' => session()->get('log_id'),
				'trans_no' => $orderId,
				'generated_date' => $fdate,
				'trans_date' => $fdate,
				't_date' => $tdate,
				'trans_year' => $this->appyear,
				'trans_custom1' => 'Pending',
				'fullnames' => $fnames,
				'appno' => $appno,
				'paychannel' => 'Remita',
				'semail' => $semail,
				'rrr' => $rrr,
			];


			$transactions = [
				['fee_id' => 6, 'fee_name' => "Change of Course Fee", 'fee_amount' => $total],
			];



			// Save both transactions
			foreach ($transactions as $transaction) {
				$this->applicantModel->save_transaction(array_merge($data, $transaction));
			}
			$message = "Transaction ID generated successfully, You will be redirected to make payment";
			$redirectUrl = base_url('applicant/paymentslip/' . $orderId);
			self::redirectWithAlert($message, $redirectUrl);
		} else {

			$message = "Error Generating Transaction ID, Please Try Again";
			$redirectUrl = base_url('applicant'); // Adjust URL if necessary
			self::redirectWithAlert($message, $redirectUrl);
		}
	}

	public function resultupload()
	{
		$data['stddetails'] =  $this->accountModel->getacctdetails(session()->get('log_id'));

		$data['getdocs'] =  $this->applicantModel->getUploadedDoc(session()->get('log_id'));
		$datah = $this->getHeaderData();

		echo view('applicants/header', $datah);
		echo view('applicants/certupload', $data);
		echo view('applicants/footer');
	}


	public function addcert()
	{
		helper(['form', 'url']);

		if ($this->request->getMethod() == 'POST') {
			$documents = [
				'jamb_nd_result' => 'Jamb_ND Result',
				'o_level_result' => 'O Level Result',
				'birth_certificate' => 'Birth Certificate',
				'lga_proof' => 'Proof of LGA',
				'attestation_letter' => 'Attestation Letter',
				'it_letter' => 'IT Letter',
				'nd_admission_letter_jamb_result' => 'ND Admission Letter/Jamb Result',
			];

			$success = true;


			$this->applicantModel->db->transStart();

			foreach ($documents as $key => $documentName) {
				if ($this->request->getFile($key)) {
					$appno = session()->get('appno');
					$file = $this->request->getFile($key);
					$allowedExtensions = ['pdf'];
					$allowedMimeTypes = ['application/pdf'];
					$ext = $file->guessExtension();
					$mimeType = $file->getClientMimeType();

					if (!in_array($ext, $allowedExtensions) || !in_array($mimeType, $allowedMimeTypes)) {
						session()->setFlashdata('error', "Invalid file type for $documentName. Only PDF files are allowed.");
						$success = false;
						continue;
					}

					$timesammp = DATE("dmyHis");
					$newName = $timesammp . '_' . strtolower(str_replace(' ', '_', $documentName)) . '.' . $ext;

					if ($file->isValid() && !$file->hasMoved()) {
						if ($file->getSize() > 102400) {
							session()->setFlashdata('error', "$documentName exceeds the 100KB limit.");
							$success = false;
							continue;
						}

						// Move the file to the uploads directory
						if ($file->move(WRITEPATH . 'uploads/', $newName)) {
							$data = [
								'stdid' => session()->get('log_id'),
								'docname' => $documentName,
								'uploadname' => $newName,
							];

							if (!$this->applicantModel->savedocument($data)) {
								$success = false;
							}
						} else {
							session()->setFlashdata('error', "Error moving the file for $documentName.");
							$success = false;
						}
					} else {
						session()->setFlashdata('error', "Error uploading $documentName.");
						$success = false;
					}
				}
			}

			$this->applicantModel->db->transComplete();

			if ($success) {
				session()->setFlashdata('success', 'Documents uploaded successfully.');
			} else {
				session()->setFlashdata('error', 'One or more documents failed to upload. Please try again.');
			}

			return redirect()->to(base_url('applicant/resultupload'));
		} else {
			session()->setFlashdata('error', 'Error Updating Documents');
			return redirect()->to(base_url('resultupload'))->withInput();
		}
	}

	public function rem_doc()
	{

		$sid = $this->request->getUri()->getSegment(3);

		$documents = $this->applicantModel->getUploadedDoc($sid);

		foreach ($documents as $doc) {
			$filePath = WRITEPATH . 'uploads/' . $doc->uploadname;


			if (file_exists($filePath)) {
				unlink($filePath);
			}
		}

		$cid = $this->applicantModel->removedoc($sid);

		if ($cid) {
			$message = "Documents Successfully removed, you can now re-upload";
		} else {
			$message = "Error removing Documents";
		}
		$redirectUrl = base_url('applicant/resultupload');
		self::redirectWithAlert($message, $redirectUrl);
	}



	// Define a function to handle redirection and alert
	private function redirectWithAlert($message, $url)
	{
		echo '<script type="text/javascript">
        alert("' . addslashes($message) . '");
        window.location = "' . addslashes($url) . '";
    </script>';
		exit;
	}

	public function requerremita()
	{
		$transid =  "946281024043522";

		$config = new PaymentConfig();
		$hash_string = $transid .  $config->apiKey . $config->merchantId;
		$apiHash = hash('sha512', $hash_string);

		//revalidate payment

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $config->checkStatusUrl . "/$config->merchantId/$transid/$apiHash/orderstatus.reg",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				"Authorization: remitaConsumerKey=2547916,remitaConsumerToken=$apiHash"
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$result = json_decode($response);
	}
}
