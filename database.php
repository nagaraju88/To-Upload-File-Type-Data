<?php
	$server = "localhost";
	$user = "root";
	$password = "";
	$con = new mysqli($server,$user,$password);
	$sql = "create database GramworkX";
	if($con->query($sql)){
		echo "database created";
	} else {
		echo "error" . $con->error;
	}
?>