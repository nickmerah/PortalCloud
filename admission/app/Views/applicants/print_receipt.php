<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
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
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            opacity: 0.1;
            background: url(<?= base_url('assets/img/logo.png'); ?>) no-repeat center center;
            background-size: 40% auto;
        }

        .content {
            position: relative;
            z-index: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: large;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background-color: #f2f2f2;
        }

        .table-image-cell {
            text-align: right;
            vertical-align: middle;
        }

        .table-image-cell img {
            display: inline-block;
        }

        .table {
            width: 100%;
            table-layout: fixed;
        }

        .table td {
            padding: 8px;
        }
    </style>
    
    <script language="JavaScript" type="text/JavaScript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}



</script>
<script>

function printWindow(){

   bV = parseInt(navigator.appVersion)

   if (bV >= 4) window.print()

}

</script>
</head>

<body>

    <div class="watermarked-page">
        <div class="watermark">
        </div>
        <?php if (isset($paydetails)) : ?>
            <?php foreach ($paydetails as $paydetail) : ?>
                <div class="content">
                    <div align="center"> <br>
                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="dspg" width="120" height="131">
                        <br>
                        <h2><?= strtoupper($schoolname); ?></h2>

                        <h3> <u><?= strtoupper($paydetail->fee_name); ?> - Payment Receipt</u> </h3>
                    </div>

                    <div class="card-body">

                        <br>

                        <table class="table table-bordered">

                            <tbody>
                                <tr>
                                    <td style="width: 25%;"><strong>Application No:</strong></td>
                                    <td style="width: 50%;"><span class="mb-3"><?= $paydetail->appno; ?></span></td>
                                    <td rowspan="3" class="table-image-cell" style="width: 25%;">
                                        <img alt="Photo" src="<?= $path; ?>" class="rounded-circle img-responsive mt-3" width="135" height="131" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Fullnames:</strong></td>
                                    <td><strong>
                                            <?= $paydetail->fullnames; ?> </strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Fee Name:</strong></td>
                                    <td><span class="mb-3">
                                            <?= $paydetail->fee_name; ?> </span></td>
                                </tr>
                                <tr>
                                    <td><span class="mb-3">
                                            <label class="form-label" for="inputUsername7"><strong>Transaction ID:</strong></label>
                                        </span></td>
                                    <td colspan="2"><span class="mb-3">
                                            <?= $paydetail->trans_no; ?> </span></td>
                                </tr>
                                <tr>
                                    <td><span class="mb-3">
                                            <label class="form-label" for="inputUsername7"><strong>RRR:</strong></label>
                                        </span></td>
                                    <td colspan="2"><span class="mb-3">
                                            <?= $paydetail->rrr; ?> </span></td>
                                </tr>
                                <tr>
                                    <td><span class="mb-3">
                                            <label class="form-label" for="inputUsername2"><strong>Session:</strong></label>
                                        </span></td>
                                    <td colspan="2"><span class="mb-3">
                                            <label class="form-label" for="inputUsername9"><strong></strong></label>
                                            <?= $paydetail->trans_year; ?> / <?= $paydetail->trans_year + 1; ?> </span></td>
                                </tr>
                                <tr>
                                    <td><span class="mb-3">
                                            <label class="form-label" for="inputUsername3"><strong>Amount:</strong></label>
                                        </span></td>
                                    <td colspan="2"><span class="mb-3">&#8358;
                                            <?= number_format($paydetail->total_fee_amount); ?> </span></td>
                                </tr>


                                <tr>
                                    <td><span class="mb-3">
                                            <label class="form-label" for="inputUsername6"><strong>Date:</strong></label>
                                        </span></td>
                                    <td colspan="2"><span class="mb-3">
                                            <?= $pt_date  = date("d-M-Y", strtotime($paydetail->t_date)); ?> </span></td>
                                </tr>
                                <tr>
                                    <td><span class="mb-3">
                                            <label class="form-label" for="inputUsername8"><strong>STATUS:</strong></label>
                                        </span></td>
                                    <td colspan="2"><span class="mb-3">
                                            <strong>
                                                <?= strtoupper($paydetail->trans_custom1); ?> </strong> </span></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    </div>
    
    <script>

printWindow()

</script>	

</body>

</html>