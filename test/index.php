<?php
phpinfo();
$con = mysqli_connect("localhost","camara_user","7H0whGMVFDw","camara_app");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
else{
    echo "connect";
    
echo $sql = "SELECT * FROM users ";
$result = mysqli_query($con,$sql);

// Numeric array
$row = mysqli_fetch_array($result, MYSQLI_NUM);
printf ("%s (%s)\n", $row[0], $row[1]);
 print_r($row);

// Free result set
mysqli_free_result($result);

mysqli_close($con);
}
?>