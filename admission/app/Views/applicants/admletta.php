<!DOCTYPE html>

<html lang="en">





<head>

  <meta charset="UTF-8">

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

  <title><?= $header['title']; ?></title>

  <!-- General CSS Files -->

  <link rel="stylesheet" href="<?= base_url('assets/css/app.min.css'); ?>">

  <!-- Template CSS -->

  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">

  <link rel="stylesheet" href="<?= base_url('assets/css/components.css'); ?>">

  <!-- Custom style CSS -->

  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css'); ?>">



  <script>
    window.onload = function() {

      window.print();

    };
  </script>



</head>



<body style="background-color: white">









  <!-- Main Content -->



  <style>
    .container {

      display: flex;

      align-items: flex-start;

      font-family: Arial, sans-serif;

      margin: 20px;

    }

    .photo {

      width: 100px;

      margin-right: 20px;

    }

    .photo img {

      width: 100%;

      height: auto;

      border: 2px solid #ccc;

    }

    .details {

      flex-grow: 1;

    }

    .details table {

      border-collapse: collapse;

      width: 100%;

    }

    .details td {

      padding: 5px 10px;

      vertical-align: top;

    }

    .qr {

      margin-left: 20px;

    }

    .qr img {

      width: 80px;

      height: 80px;

    }



    .watermarked-page {

      position: relative;

      width: 100%;

      height: 100vh;

      /* Full viewport height */

      padding: 20px;

      /* Adjust as needed */

      box-sizing: border-box;

    }



    .watermarked-page .watermark {

      position: absolute;

      top: 0%;

      left: 0;

      width: 100%;

      height: 100%;

      pointer-events: none;

      opacity: 0.1;

      background: url(<?= base_url('assets/img/logo.png'); ?>) no-repeat center center;

      background-size: 70% auto;

    }
  </style>

  <div class="main">



    <div>











      <?php if (isset($stddetails)): ?>





        <?php foreach ($stddetails as $biodetail): ?>

          <div class="card">
            <div class="watermarked-page">

              <div class="watermark">

              </div>

              <div align="center">

                <img src="<?= base_url('assets/img/logo.png'); ?>" alt="dspg" width="90" height="101">

                <br>

                <br>

                <h4><?= strtoupper($header['schoolname']); ?></h4>







                <strong style="font-size:18px; color:#900"> <u>ADMISSION LETTER OF <?= $biodetail->surname; ?> </u> </strong>

              </div>



              <div class="card-body">





                <div class="row">



                  <div align="justify" style="font-size:18px; line-height:2">



                    <p> I am pleased to inform you that you have been offered provisional admission into the Delta State Polytechnic, Ogwashi-Uku as follows:</p>







                  </div>

                  <div class="container">

                    <div class="photo">

                      <img alt="Photo" src="<?= $header['path']; ?>" class="rounded-circle img-responsive mt-3" width="135" height="131" />

                    </div>

                    <div class="details">

                      <table>

                        <tr>

                          <td><strong>Name:</strong></td>

                          <td> <?= $biodetail->surname; ?> <?= $biodetail->firstname; ?> <?= $biodetail->othernames; ?></td>

                        </tr>

                        <tr>

                          <td><strong>Student Id:</strong></td>

                          <td> <?= $biodetail->student_id; ?></td>

                        </tr>

                        <tr>

                          <td><strong>Registration Number:</strong></td>

                          <td> <?= $biodetail->jambno; ?></td>

                        </tr>

                        <tr>

                          <td><strong>Study Course:</strong></td>

                          <td><?= $cosdetails[0]->programme_option; ?> (<?= $cosdetails[0]->deptcode; ?>)</td>

                        </tr>

                        <tr>

                          <td><strong>Department:</strong></td>

                          <td> <?= $cosdetails[0]->departments_name; ?></td>

                        </tr>

                        <tr>

                          <td><strong>Faculty:</strong></td>

                          <td><?= $cosdetails[0]->faculties_name; ?></td>

                        </tr>

                        <tr>

                          <td><strong>Study Mode:</strong></td>

                          <td> <?= $biodetail->programme_name; ?> <?= $biodetail->programmet_name; ?></td>

                        </tr>

                        <tr>

                          <td><strong>Entry Session:</strong></td>

                          <td><?= $header['admletteryear']; ?> / <?= $header['admletteryear'] + 1; ?></td>

                        </tr>

                      </table>

                    </div>





                    <?php

                    $data = $biodetail->surname . '|' .

                      $biodetail->firstname . '|' .

                      $biodetail->othernames . '|' .

                      $biodetail->student_id . '|' .

                      $biodetail->jambno . '|' .

                      $cosdetails[0]->programme_option . ' (' . $cosdetails[0]->deptcode . ')' . '|' .

                      $cosdetails[0]->departments_name . '|' .

                      $cosdetails[0]->faculties_name . '|' .

                      $biodetail->programme_name . '|' .

                      $biodetail->programmet_name . '|' .

                      $header['cs_session'];

                    $qrData = urlencode($data);

                    $qrImageUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=$qrData";

                    ?>





                    <div class="qr">

                      <img src="<?= $qrImageUrl ?>" alt="QR Code">

                    </div>

                  </div>



                <?php endforeach; ?>

              <?php endif; ?>



              <div align="justify" style="font-size:18px; line-height:2">



                <ol type="1">



                  <li>Duration: 2 years</li>



                  <li>This offer is conditional upon the confirmation of your qualification(s) as listed by you in the application form or which you claim to possess as at when this offer of admission was made and your meeting the minimum department entry requirement.</li>



                  <li>At the time of Registration, you will be required to produce the original copies of your certificates or any other acceptable evidence of the qualification(s), on which this offer of admission has been based.</li>



                  <li>If at any time after admission it is discovered that you do not possess any of the qualifications which you claimed to have obtained, you will be required to withdraw from the Polytechnic.</li>

                  <li>Please, note that resumption/registration starts immediately.</li>



                  <li>You are required to pay all the necessary fees, such as school fees, students' union fees, boarding fees (optional) and any other prescribed fees online and register immediately. Late registration will attract severe sanction such as payment of late registration fee of N10000 or outright withdrawal of offer of admission.</li>



                  <li>If you do not respond to this offer within two (2) weeks from the date of resumption, the Polytechnic will assume that you are not interested in the offer and may withdraw the offer to accommodate other candidates on awaiting list.</li>



                  <li>If you do not pay your school fees and register within the stipulated time frame for registration, you would not be allowed to write the Polytechnic's semester examinations. Should you mistakenly write the exams, your scripts would not be marked.</li>



                  <li>You are required to present at the time of registration, a letter of attestation from a clergy man, a lawyer, a senior civil servant (Level 13 and above) or any person of reputable standing in the society.</li>



                  <li>Before the commencement of registration, you will be required to undergo a medical examination which should be conducted in the Polytechnic clinic.</li>





                  <li>The information/instructions about facilities at the Polytechnic, including accommodation, can be obtained from the Polytechnic Portal. The Head of your School/Department at the Polytechnic will make the details of the programme available to you.</li>



                  <li>At the time of registration, you are required to sign an undertaking of non-involvement in cult-related activities and acts of vandalism.</li>



                  <li>We hope that you will be able to take advantage of this offer or provisional admission.</li>



                  <li>14.Please, accept our hearty congratulations.</li>

                </ol>



                <p><b>Admissions Officer</b><br>For: Registrar</p>



              </div>



                </div>



              </div>



            </div>



          </div>



</body>

</html>