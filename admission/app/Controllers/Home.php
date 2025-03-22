<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\ApplicantModel;

class Home extends BaseController
{
    public const TITLE = 'Delta State Polytechnic, Ogwashi-Uku - Application Portal';

    private $schoolName;

    private $accountModel;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
        $this->schoolName = $this->accountModel->getSchoolName();
    }

    public function index()
    {
        $closing = $this->accountModel->appendreg_date();
        $appmarkuee = $this->accountModel->appmarkuee();
        $pumeenddate = $this->accountModel->appenddate();
        $data = [
            'title' => self::TITLE,
            'schoolname' => $this->schoolName,
            'timer' => "$closing",
            'marquee' => $appmarkuee,
            'pumeenddate' => $pumeenddate
        ];
        echo view('landing', $data);
    }

    public function startpart()
    {
        $appmarkuee = $this->accountModel->appmarkuee();
        $prog = $this->accountModel->getprogramme();
        $progtype = $this->accountModel->getprogrammeTypes();

        $data = ['title' => self::TITLE];
        $timer = ['marquee' => $appmarkuee, 'progs' => $prog, 'progtypes' => $progtype];
        echo view('header', $data);
        echo view('startpart', $timer);
    }


    public function starting()
    {
        $appmarkuee = $this->accountModel->appmarkuee();
        $pumeenddate = $this->accountModel->appenddate();
        $data = [
            'title' => self::TITLE,
            'schoolname' => $this->schoolName,
            'marquee' => $appmarkuee,
            'pumeenddate' => $pumeenddate
        ];
        echo view('header', $data);
        echo view('home', $data);
        echo view('footer');
    }

    public function faker()
    {
        $appmarkuee = $this->accountModel->appmarkuee();
        $pumeenddate = $this->accountModel->appenddate();
        $data = [
            'title' => self::TITLE,
            'schoolname' => $this->schoolName,
            'marquee' => $appmarkuee,
            'pumeenddate' => $pumeenddate
        ];
        echo view('header', $data);
        echo view('ahome', $data);
        echo view('footer');
    }


    public function admreq()
    {

        $data = [
            'title' => self::TITLE,
            'schoolname' => $this->schoolName,
        ];

        echo view('admreq', $data);
    }


    public function fpass()
    {
        $data = [
            'title' => self::TITLE,
            'schoolname' => $this->schoolName
        ];
        echo view('header', $data);
        echo view('forgot');
    }


    public function getProg()
    {
        $applicantModel = new ApplicantModel();
        $data = $applicantModel->getdept_options(1);
        echo json_encode($data);
    }

    public function get_prog()
    {
        $postData = $this->request->getPost();
        $applicantModel = new ApplicantModel();
        $data = $applicantModel->getprog_options($postData);
        echo json_encode($data);
    }
}
