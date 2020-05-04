<?php 
   $conn = mysqli_connect('localhost', 'yueh', 'test1234', 'php_project1');

   // check connection
   if(!$conn){
       echo 'Connection error: ' . mysqli_connect_error();
   }
?> 