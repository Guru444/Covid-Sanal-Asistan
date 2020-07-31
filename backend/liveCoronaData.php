<?php
	//JsonAPI Covid19 ülke verileri
	include("baglanti.php");
	$conn->set_charset("utf8");				
	$query = mysqli_query($conn, "SELECT * FROM covidTableData");					
	$emparray = array();
	   while($row =mysqli_fetch_assoc($query))
	   {
	   $emparray[] = $row;
	   }
	   echo json_encode($emparray);
   mysqli_close($conn);
?>

