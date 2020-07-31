<?php 
   include("baglanti.php");
   header('Access-Control-Allow-Origin: *');  
   $conn->set_charset("utf8");
   //URL parser
   $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
   $parts = parse_url($actual_link);
   parse_str($parts['query'], $query);
	   $postKelimeler = @$query['kelimeler'];
	   $postCountryID = @$query['countryID'];
	   $postKeyword = @$query['Keyword'];
	   $postMinMax = @$query['minmaxDurum'];

	   if(empty($postCountryID) && empty($postKeyword)){
		   $sql = "SELECT sc1.soruID,sc1.cevapsoru, COUNT(*) /	(SELECT COUNT(*) 	FROM etiketler e0
		   INNER JOIN soruEtiket se0 on e0.etiketID = se0.etiketID
		   INNER JOIN soruCevap sc0 on se0.soruID = sc0.soruID 
		   WHERE sc1.soruID = sc0.soruID
		   GROUP BY sc0.soruID) AS ORAN
					FROM etiketler e1
						INNER JOIN soruEtiket se1 on e1.etiketID = se1.etiketID 
						INNER JOIN soruCevap sc1 on se1.soruID = sc1.soruID 
						WHERE sc1.soruID IN		(SELECT sc2.soruID FROM etiketler e2
						INNER JOIN soruEtiket se2 on e2.etiketID = se2.etiketID 
						INNER JOIN soruCevap sc2 on se2.soruID = sc2.soruID 
						WHERE e1.etiketKeyword in ($postKelimeler))
							GROUP BY sc1.soruID
							ORDER BY COUNT(*) DESC
							LIMIT 1";
	   }
	   else if($postCountryID==0){
		   
		$postKeyword = @$query['Keyword'];
		$postMinMax = @$query['minmaxDurum'];
		$convertArrayDataTitle = array();
		$convertArrayMinMax = array();

		$arrayKeyword = array();
		$arrayMaxMin = array();
		$arrayKeyword[] = $postKeyword;
		$arrayMaxMin[] = $postMinMax;
		 
		$convertArrayDataTitle= implode(",",$arrayKeyword);
		$parseKeyword = explode(",",$convertArrayDataTitle);

		$convertArrayMinMax= implode(",",$arrayMaxMin);
		$parseMaxMix = explode(",",$convertArrayMinMax);

		$lastArray = array();
			for($i=0 ; $i < count($parseKeyword); $i++) { 
				for($k=0; $k < count($parseMaxMix); $k++){
				$kelime = $parseKeyword[$i];
				if($parseMaxMix[$k]== "min"){
					$sqlMinResult = "SELECT $kelime,FORMAT(MIN($kelime),0) as $parseMaxMix[$k] FROM `covidTableData`  where $kelime >=0";
					$result = mysqli_query($conn, $sqlMinResult);
					while ($row = mysqli_fetch_assoc($result)) {
						$lastArray[] = $row;
					}
				} 
				if($parseMaxMix[$k] == "max"){
					$sqlMaxResult = "SELECT $kelime,FORMAT(MAX($kelime),0) as $parseMaxMix[$k] FROM `covidTableData`  where $kelime >=0";
					$result = mysqli_query($conn, $sqlMaxResult);
					while ($row = mysqli_fetch_assoc($result)) {
						$lastArray[] = $row;
					}	
				}
			}
		}
			echo json_encode($lastArray);
		}
	    else{
			$sql = "SELECT FORMAT(totalCases,0) as totalCases,
					FORMAT(newCases,0) as newCases,
					FORMAT(totalDeaths,0) as totalDeaths,
					FORMAT(newDeaths,0) as newDeaths,
					FORMAT(totalRecovered,0) as totalRecovered,newRecovered,
					deathRate,activeCases,seriusCritical,totCases1MPOP,deaths1MPOP,totalTest,test1MPOP,population
					FROM covidTableData where covidID=$postCountryID";
		}
			
	if(!empty($sql)){	
	$result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));
	$emparray = array();
	   while($row =mysqli_fetch_assoc($result))
	   {
	   $emparray[] = $row;
	   }
	 }   
	else if(empty($lastArray))
	   $post_data = array('hataMesaji' => "Hangi ülkenin durumunu öğrenmek istiyorsunuz");
	else
		$post_data = array('hataMesaji' => "Sizi anlayamadık ! Lütfen daha açık yazar mısınız :) ");
	
   if(!empty($emparray) && !empty($sql))
	  echo json_encode($emparray);
   else if(empty($lastArray))
	  echo json_encode($post_data);
   
   mysqli_close($conn);


   
?>
   
   

