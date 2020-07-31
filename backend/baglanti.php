<?php
	$servername = "localhost";
	$username = "root";
	$password = "Sunucu Bağlanti Şifreniz";
	$dbname = "Veritabanı Adınız";
	$conn= new mysqli($servername, $username, $password, $dbname);
	$conn->set_charset("utf8");


?>