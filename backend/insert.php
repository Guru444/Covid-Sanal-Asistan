
   

   <?php 
   include("baglanti.php");
   header('Access-Control-Allow-Origin: *');  
   $conn->set_charset("utf8");
   //Log Dosyası
   $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
   $parts = parse_url($actual_link);
   parse_str($parts['query'], $query);
   
	   $userID = @$query['userID'];
	   $userSoru = @$query['userSoru'];
	   $userSoruCevap = @$query['userSoruCevap'];

						
		$sql = mysqli_query($conn,"insert into logUser (userID,userSoru,userSoruCevap) values('".$userID."','".$userSoru."','".$userSoruCevap."')"); 
		if($sql){
			$post_data = array('basarili' => "LogInsertGood");
		}
		echo json_encode($post_data);

   
   mysqli_close($conn);


   
?>
   
   

