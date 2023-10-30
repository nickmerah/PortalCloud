
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2022 <div class="bullet"></div> The Oke-Ogun Polytechnic, Saki - TOPS
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>

<script>
// Set the date we're counting down to
var countDownDate = new Date("<?= $timer; ?>").getTime();

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
  document.getElementById("demo").innerHTML = "Online Application Closes in: " + days + "Days " + hours + "Hrs "
  + minutes + "Mins " + seconds + "Secs ";

  // If the count down is over, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "APPLICATION CLOSED";
  }
}, 1000);
</script>


  <!-- General JS Scripts -->
  <script src="<?= base_url('assets/js/app.min.js');?>"></script>
  <!-- JS Libraies -->
 
  <!-- Page Specific JS File -->
  <script src="<?= base_url('assets/js/page/index2.js');?>"></script>
  <script src="<?= base_url('assets/js/page/todo.js');?>"></script>
  <!-- Template JS File -->
  <script src="<?= base_url('assets/js/scripts.js');?>"></script>
  <!-- Custom JS File -->
  <script src="<?= base_url('assets/js/custom.js');?>"></script>
</body>

</html>
