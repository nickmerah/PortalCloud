<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : "DPSG" ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            /* White background to match the logo background */
        }

        header {
            background-color: #003366;
            /* Navy blue from the logo */
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
            text-align: center;
            margin: 2em 0;
        }

        .notice {
            background-color: #f2f2f2;
            /* Light grey for notices */
            padding: 1em;
            font-size: 1.2em;
            margin-bottom: 2em;
            color: #003366;
            /* Navy blue text */
        }

        .applications {
            display: flex;
            justify-content: space-around;
            margin: 2em 0;
        }

        .applications div {
            border: 1px solid #ccc;
            padding: 2em;
            width: 30%;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            /* White background for application sections */
        }

        .applications h2 {
            margin-top: 0;
            color: #F7941D;
            /* Orange from the logo */
        }

        button {
            background-color: #003366;
            /* Navy blue background for buttons */
            color: white;
            border: 1px solid #003366;
            /* Navy blue border */
            padding: 0.5em 1em;
            cursor: pointer;
        }

        button:hover {
            background-color: #002244;
            /* Darker navy blue on hover */
        }

        .application-status {
            font-size: 1.5em;
            color: #ce7305;
            /* Orange text for application status */
            font-weight: bold;
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
                <li><a href="<?= base_url('home/admreq'); ?>">Instructions/Guidelines</a></li>
                <li> <a href="<?= base_url('home/startpart'); ?>">Start Application</a></li>
                <li><a href="<?= base_url('/home/starting'); ?>">Continue Application</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <p class="notice">
            <marquee> <?= $marquee; ?> </marquee>
        </p>
        <section class="applications">
            <div class="app-instruction">
                <h2>Application Instructions</h2>
                <button onclick="window.location.href='<?= base_url('home/admreq'); ?>'">Click Here for Application Guidelines</button>
            </div>
            <div class="start-app">
                <h2>Start Application</h2>
                <button onclick="window.location.href='<?= base_url('home/startpart'); ?>'">Click Here to start a new Application</button>
            </div>
            <div class="continue-app">
                <h2>Continue Application</h2>
                <button onclick="window.location.href='<?= base_url('home/starting'); ?>'">Click Here to Continue your Application</button>
            </div>
        </section>
        <p id="demo" class="application-status" style="text-align:center; font-weight:bold; font-size: 16px;color:green"> </p>

    </main>
</body>
<script>
    // Set the date we're counting down to
    var countDownDate = new Date("<?= $pumeenddate; ?>").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        document.getElementById("demo").innerHTML = "Online Application Closes in: " + days + "Days " + hours + "Hrs " +
            minutes + "Mins " + seconds + "Secs ";

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "";
        }
    }, 1000);
</script>

</html>