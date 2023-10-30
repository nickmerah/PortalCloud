<?php
$string = "w3programmings.com";

  // add the string in the Google Chart API URL
  $google_chart_api_url = "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=".$string."&choe=UTF-8";

  // let's display the generated QR code
  echo "<img src='".$google_chart_api_url."' alt='".$string."'>";