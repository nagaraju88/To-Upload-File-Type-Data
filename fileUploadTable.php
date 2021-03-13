<?php
  $server = "localhost";
  $user = "root";
  $password = "";
  $database = "GramworkX";
  $con = new mysqli($server,$user,$password,$database);
  $sql = "create table FileUploadTable(model varchar(50),version varchar(50),filedata longblob,date varchar(100))";
  if($con->query($sql)) {
      echo "table created";
  } else {
      echo "error".$con->error;
  }
?>