<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Covid Parser Data</title>
<?php
	error_reporting(E_ALL & ~E_NOTICE);
	set_time_limit(0);
	include("baglanti.php");
	include('simple_html_dom.php');
	header('content-type:text/html; charset=utf-8');
	header('Access-Control-Allow-Origin: *');  

	$html = file_get_html('https://www.worldometers.info/coronavirus/');
	$coronavirusCases = array();
	$hucreler = array();
	$i = 0;
	
	foreach($html->find('table>tbody>tr>td') as $hucre) {
		$hucreler[] = $hucre->plaintext;
	}
	
	$array = array_filter($hucreler);
	
	for ($i = 152; $i <4214; $i += 19) { 
		 
		$post_data = array(
			  'ulkeSira' => empty($array[$i + 0]) ? "Null" : $array[$i + 0],
			  'Country' =>empty($array[$i + 1]) ? "Null" : $array[$i + 1] ,
			  'totalCases' =>empty($array[$i + 2]) ? "Null" : $array[$i + 2],
			  'newCases' =>empty($array[$i + 3]) ? "Null" : $array[$i + 3] ,
			  'totalDeaths' =>empty($array[$i + 4]) ? "Null" : $array[$i + 4] ,
			  'newDeaths' =>empty($array[$i + 5]) ? "Null" : $array[$i + 5],
			  'totalRecovered' =>empty($array[$i + 6]) ? "Null" : $array[$i + 6],
			  'newRecovered' =>empty($array[$i + 7]) ? "Null" : $array[$i + 7],
			  'activeCases' =>empty($array[$i + 8]) ? "Null" : $array[$i + 8],
			  'seriusCritical' =>empty($array[$i + 9]) ? "Null" : $array[$i + 9],
			  'totCases1MPOP' =>empty($array[$i + 10]) ? "Null" : $array[$i + 10],
			  'deaths1MPOP' =>empty($array[$i + 11]) ? "Null" : $array[$i + 11],
			  'totalTest' =>empty($array[$i + 12]) ? "Null" : $array[$i + 12],
			  'test1MPOP' =>empty($array[$i + 13]) ? "Null" : $array[$i + 13],
			  'population' =>empty($array[$i + 14]) ? "Null" : $array[$i + 14]			
		);
			
		//echo json_encode($post_data);
		
		$ulkeSira = $array[$i + 0];
		$Country = $array[$i + 1];
		$totalCases = str_replace(",","",$array[$i + 2]);
		$newCases = (empty($array[$i + 3]) || $array[$i + 3] == " " || $array[$i + 3] == "N/A") ? -1 : str_replace("+","",str_replace(",","",$array[$i + 3]));
		$totalDeaths = (empty($array[$i + 4]) || $array[$i + 4] == " " || $array[$i + 4] == "N/A") ? -1 : str_replace(",","",$array[$i + 4]);
		$newDeaths = (empty($array[$i + 5]) || $array[$i + 5] == " " || $array[$i + 5] == "N/A") ? -1 : str_replace("+","",str_replace(",","",$array[$i + 5]));
		$totalRecovered = (empty($array[$i + 6]) || $array[$i + 6] == " " || $array[$i + 6] == "N/A") ? -1 : str_replace(",","",$array[$i + 6]);
		$newRecovered = (empty($array[$i + 7]) || $array[$i + 7] == " " || $array[$i + 7] == "N/A") ? -1 : str_replace("+","",str_replace(",","",$array[$i + 7]));
		if($totalCases != -1 && $totalDeaths != -1)
			$deathRate = round(100*($totalDeaths/$totalCases),2);
		else
			$deathRate = "-1";
		$activeCases = (empty($array[$i + 8]) || $array[$i + 8] == " " || $array[$i + 8] == "N/A") ? -1 : str_replace(",","",$array[$i + 8]);
		$seriusCritical = (empty($array[$i + 9]) || $array[$i + 9] == " " || $array[$i + 9] == "N/A") ? -1 : str_replace(",","",$array[$i + 9]);
		$totCases1MPOP = (empty($array[$i + 10]) || $array[$i + 10] == " " || $array[$i + 10] == "N/A") ? -1 : str_replace(",","",$array[$i + 10]);
		$deaths1MPOP = (empty($array[$i + 11]) || $array[$i + 11] == " " || $array[$i + 11] == "N/A") ? -1 : str_replace(",","",$array[$i + 11]);
		$totalTest = (empty($array[$i + 12]) || $array[$i + 12] == " " || $array[$i + 12] == "N/A") ? -1 : str_replace(",","",$array[$i + 12]);
		$test1MPOP = (empty($array[$i + 13]) || $array[$i + 13] == " " || $array[$i + 13] == "N/A") ? -1 : str_replace(",","",$array[$i + 13]);
		$population = (empty($array[$i + 14]) || $array[$i + 14] == " " || $array[$i + 14] == "N/A") ? -1 : str_replace(" ","",str_replace(",","",$array[$i + 14]));	
		$kt=date("Y-m-d H:i:s");		  
		
		$insert = "UPDATE covidTableData SET ulkeSira=".$ulkeSira.",
															 Country='".$Country."',
															 totalCases=".$totalCases.",
															 newCases=".$newCases.",
															 totalDeaths=".$totalDeaths.",
															 newDeaths=".$newDeaths.",
															 totalRecovered=".$totalRecovered.",
															 newRecovered=".$newRecovered.",
															 deathRate=".$deathRate.",
															 activeCases=".$activeCases.",
															 seriusCritical=".$seriusCritical.",
															 totCases1MPOP=".$totCases1MPOP.",
															 deaths1MPOP=".$deaths1MPOP.",
															 totalTest=".$totalTest.",
															 test1MPOP=".$test1MPOP.",
															 population=".$population.",
															 updateDate='".$kt."' 
															 where covidID=".$ulkeSira."";
		
		//echo "<br><br>".$insert."<br><br>";
		
		$sql = mysqli_query($conn,$insert);
				
		if($sql){
			echo "Update Başarılı";
		}
		else{
			echo("Error description: " . $conn -> error);
			echo "Update Hatalı<br><br>";
		}
	}
		
				  
?>
