<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delta State Polytechnic, Ogwashi-Uku - ND Entry Requirements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        header {
            background-color: #003366;
            color: white;
            text-align: center;
            padding: 1em 0;
        }

        .header-content {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            width: 50px;
            height: 50px;
            margin-right: 1em;
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 1em;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        main {
            margin: 2em;
        }

        h2 {
            color: #F7941D;
            text-align: center;
        }

        .guidelines {
            background-color: #f2f2f2;
            padding: 2em;
            border-radius: 5px;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 1em;
        }

        .guidelines h3 {
            color: #003366;
            margin-bottom: 1em;
        }

        .guidelines p {
            margin-bottom: 1em;
            line-height: 1.5em;
            color: #333;
        }
    </style>
</head>

<body>
    <header>
       <div class="header-content">
            <img src="<?= base_url('assets/img/logox.png'); ?>" alt="College Logo" class="logo">
            <h1><?php echo isset($schoolname) ? $schoolname : "DPSG" ?></h1>
        </div>
        <nav>
            <ul>
                <li><a href="<?= base_url('/home'); ?>">Home</a></li>
                <li> <a href="<?= base_url('home/startpart'); ?>">Start Application</a></li>
                <li><a href="<?= base_url('/home/starting'); ?>">Continue Application</a></li>
            </ul>
        </nav>
    </header>

   <main>
        <h2>ND ENTRY REQUIREMENTS</h2>
        <div class="guidelines">
            <h3>Eligibility Criteria</h3>
            <p>
                i. Candidates must have at least (5) five credits in SSCE (WAEC &amp; NECO), G.C.E. O’Level, NABTEB or its equivalent in relevant subjects including English Language and Mathematics in not more than two (2) sittings.
            </p>
            <p>
                ii. Candidates who sat for 2024 UTME in the relevant subjects to the course of study.
            </p>

            <h3>Eligibility for Participation</h3>
            <p>
                i. Candidates who chose Delta State Polytechnic, Ogwashi-Uku as first or second choice and scored 100 and above in the 2024 UTME Exercise.
            </p>
            <p>
                ii. Candidates who did not choose Delta State Polytechnic, Ogwashi-Uku, but now wish to be considered for admission and scored 100 and above in the 2024 UTME.
            </p>
            <p>
                iii. Candidates who did not choose Delta State Polytechnic, Ogwashi-Uku as first choice in JAMB must log on to <a href="https://caps.jamb.gov.ng" target="_blank">CAPS@jamb.gov.ng</a> and complete the change of Institution procedure before application.
            </p>
            <p>
                iv. Candidates whose choice of course in UTME differs from what they are applying for must log on to <a href="https://caps.jamb.gov.ng" target="_blank">CAPS@jamb.gov.ng</a> and complete the change of course procedure before application.
            </p>
            <p class="note">
                NOTE: CANDIDATES WHO DO NOT COMPLY WITH THE ABOVE PROCEDURES WILL NOT BE CONSIDERED FOR ADMISSION.
            </p>
        </div>

        <h2>HND ENTRY REQUIREMENTS</h2>
        <div class="guidelines">
            <h3>Eligibility Criteria</h3>
            <p>
                i. A National Diploma (ND) obtained with a minimum of Lower Credit in the relevant disciplines from institutions with accredited programmes by the National Board for Technical Education (NBTE), with a minimum of one (1) year Industrial Training in accordance with your field of study.
            </p>
            <p>
                ii. Candidates who obtained ND at Pass Level with a minimum of two (2) years Industrial Training in the field of study.
            </p>
            <p>
                iii. At least five (5) credit passes in SSCE (WAEC &amp; NECO), GCE O’Level, NABTEB or its equivalent in relevant subjects including English Language and Mathematics in not more than two sittings.
            </p>
            <p>
                iv. Candidates who were admitted to the ND Programme through JAMB, inclusive of items (i) to (iii) above.
            </p>
        </div>
    </main>
</body>

</html>
