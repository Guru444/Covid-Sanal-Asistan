<?php
	include("baglanti.php");
?>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">


<style>
body {
    background-color: #e9ebee;
}

.card {
    margin-top: 1em;
}

/* IMG displaying */
.person-card {
    margin-top: 5em;
    padding-top: 5em;
}
.person-card .card-title{
    text-align: center;
}
.person-card .person-img{
    width: 10em;
    position: absolute;
    top: -5em;
    left: 50%;
    margin-left: -5em;
    border-radius: 100%;
    overflow: hidden;
    background-color: white;
}
body {
 font-size: 18px;   
}
.orange-circle-button {
	box-shadow: 2px 4px 0 2px rgba(0,0,0,0.1);
	border: .5em solid #E84D0E;
	font-size: 1em;
	line-height: 1.1em;
	color: #ffffff;
	background-color: #e84d0e;
	margin: auto;
	border-radius: 50%;
	height: 7em;
	width: 7em;
	position: relative;
}
.orange-circle-button:hover {
	color:#ffffff;
    background-color: #e84d0e;
	text-decoration: none;
	border-color: #ff7536;
	
}
.orange-circle-button:visited {
	color:#ffffff;
    background-color: #e84d0e;
	text-decoration: none;
	
}
.orange-circle-link-greater-than {
    font-size: 1em;
}
.dataTables_wrapper no-footer{
	width: 100%;
}
</style>
<title>Covid Veri Girişi </title>
<head>  
<link rel="icon" href="https://image.flaticon.com/icons/png/512/128/128676.png">

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" href="sweetalert2.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="sweetalert2.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
		
<link href="css/addons/datatables.min.css" rel="stylesheet">
<script type="text/javascript" src="js/addons/datatables.min.js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </head>
<div class="container" style="margin-top: 1em;">
        <div class="card person-card">
            <div class="card-body">
                <img id="img_person" class="person-img"
                    src="https://visualpharm.com/assets/217/Life%20Cycle-595b40b75ba036ed117d9ef0.svg">
                <h2 id="who_message" class="card-title">Covid ChatBot Veri Girişi</h2>
		    <button type="submit" class="btn btn-default orange-circle-button" style="height: 9em; width: 9em; float: right;" target="_blank"  onclick="window.location='https://api.bilisimkulubu.online/chatbot.html'">Covid<br />Sanal Asistan<br /></button>
            </div>
        </div>
		<!-- Soru-Cevap Etiket Kelimeleri  -->	
        <div class="row">
            <div class="col-md-12" style="padding=0.5em;">
                <div class="card">
				<form action="" method="post">
                    <div class="card-body">
                        <h2 class="card-title">Soru-Cevap Etiket Kelimeleri </h2>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Etiket</label>
                            <input type="text" class="form-control" name="soruEtiketVerisi[]" id="email" placeholder="örn(Covid)" required>
                            <div class="email-feedback">
                            </div>
                        </div>
                        <div class="form-group">
						
                        </div>
							<div class="form-group  mt-10">
							  <button type="submit" name="soruEtiketEkle" class="btn btn-primary btn-lg btn-block">Soru-Etiket Ekle</button>
							</div>
						</div>
					</form>
                </div>
            </div>
			<?php
				if (isset($_POST['soruEtiketEkle'])) 
					{
						$soruEtiketVerisi=$soruID="";
						$etiketArray = array();
						$etiketArray = $_POST['soruEtiketVerisi'];
						$convertArray= implode(",",$etiketArray);
						$dilimler = explode(",",$convertArray);
						$count = count($etiketArray);
						$conn->set_charset("utf8");
						
						foreach ($dilimler as $etiket){ 
						$sql = mysqli_query($conn,"insert into etiketler (etiketKeyword) values('".$etiket."')");
						}
						if($sql){   
						?>
						<script>
						swal("Soru-Etiket Ekleme Başarılı", "İşlem başarılı", "success");
						</script>
					<?php  }
						else
							echo "Soru-Etiket Ekleme Hatasi";
					}
					?>	
				<?php
				if (isset($_POST['soruAlternatifEtiketEkle'])) 
					{
						$etiketID="";
						$etiketArray = array();
						$etiketArray = $_POST['soruAlternatifEtiketVerisi'];
						$convertArray= implode(",",$etiketArray);
						$dilimler = explode(",",$convertArray);
						$count = count($etiketArray);
						$etiketID = htmlspecialchars(addslashes ($_POST['etiketID']));
						$conn->set_charset("utf8");

						foreach ($dilimler as $etiket){ 
						$sql = mysqli_query($conn,"insert into etiketAlternatif (alternatifWord,etiketID) values('".$etiket."','".$etiketID."')"); 
						}
					if($sql){   
						?>
						<script>swal("Alternatif Etiket Ekleme Başarılı Ekip Aynen Çalışmaya Devam", "İşlem başarılı", "success");</script>
					<?php }
						else				
							echo "Ekleme Hatasi";
						}
					?>						
				<?php
				if (isset($_POST['soruEtiketEslestir'])) 
					{
						$etiketID = htmlspecialchars(addslashes ($_POST['etiketID']));
						$soruID = htmlspecialchars(addslashes ($_POST['soruID']));
						$conn->set_charset("utf8");
						$sql = mysqli_query($conn,"insert into soruEtiket (soruID, etiketID) values('".$soruID."','".$etiketID."')"); 
					if($sql){   
						?>
						<script>swal("Alternatif Etiket Ekleme Başarılı", "İşlem başarılı", "success");</script>
					<?php }
						else				
							echo "Alternatif Etiket Ekleme Hatasi";	
					}
				
					?>	
        </div>
 <!-- Soru Etiket Eşleştir  -->		
	<div class="row" style="margin-bottom:10px;">
		 <div class="col-md-6" style="padding=1.5em;">
                <div class="card">
				<form action="" method="post">
                    <div class="card-body">
                        <h2 class="card-title">Soru Etiket Eşleştir</h2>           	
                        <div class="form-group"> 
						    <label for="email" class="col-form-label">Sorular</label>
							<select class="browser-default custom-select" name="soruID">
									<option selected="">Lütfen soru seçiniz</option>
						<?php
						$conn->set_charset("utf8");
						$etiketKelimeler = array();
						$query = mysqli_query($conn,"SELECT * FROM soruCevap order by soruID");					
						while($oku=mysqli_fetch_array($query))	
						{	 
						?>
						<option value="<?php echo $oku["soruID"]?>"><?php echo $oku["soruID"].") ".$oku["covidSoru"]?></option>
						<?php
						}	
						?> 
								  </select>                        
                        </div>
                        <div class="form-group"> 
						    <label for="email" class="col-form-label">Etiketler</label>
								<select class="browser-default custom-select" name="etiketID">
									<option selected="">Lütfen etiket seçiniz</option>
						<?php
						$conn->set_charset("utf8");
						$etiketKelimeler = array();
						$query = mysqli_query($conn,"SELECT * FROM etiketler order by etiketKeyword");					
						while($oku=mysqli_fetch_array($query))	
						{	 
						?>
						<option value="<?php echo $oku["etiketID"]?>"><?php echo $oku["etiketKeyword"]?></option>
						<?php
						}	
						?> 
							</select>                   
                        </div>
							<div class="form-group  mt-10">
							  <button type="submit" name="soruEtiketEslestir" class="btn btn-primary btn-lg btn-block">Eşleştir</button>
							</div>
						</div>
					</form>
                </div>
            </div>
			
			  <div class="col-md-6">
                <div class="card"> 
				<form action="" method="post">
                    <div class="card-body">
                        <h2 class="card-title">Soru Ekle</h2>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Soru Cümlesi</label>
                            <input type="text" class="form-control" name="soruCumlesi" id="password" placeholder="Soru giriniz" required>
                            <div class="password-feedback">
                            
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_conf" class="col-form-label">Soru Cevabı</label>
                            <input type="text" class="form-control" name="soruCevabi" id="password_conf" placeholder="Soru Cevabı giriniz" required>
                            <div class="password_conf-feedback">
                            </div>
                        </div>
							<div class="form-group">
							  <button type="submit" name="soruEkle" class="btn btn-primary btn-lg btn-block">Soru Ekle</button>
							</div>
						</div>
					</form>
                </div>
            </div>
		</div>	
		
	<!-- /Soru Etiket Eşleştir/  -->	
			<dl>
					<?php
						$conn->set_charset("utf8");
						$query = mysqli_query($conn,"SELECT * FROM soruCevap order by soruID");					
						while($oku=mysqli_fetch_array($query))	
						{	
						?>
						  <dt><?php echo $oku["soruID"]."-".$oku["covidSoru"]?></dt>
						  <dd><?php echo $oku["cevapSoru"]?></dd>
						<dd>
						<?php
						$queryEtiket = mysqli_query($conn,"SELECT * FROM etiketler inner JOIN soruEtiket on etiketler.etiketID=soruEtiket.etiketID INNER JOIN soruCevap on soruEtiket.soruID=soruCevap.soruID where soruCevap.soruID=".$oku["soruID"]."");					
						while($okuEtiket=mysqli_fetch_array($queryEtiket))	
						{
							echo "<ul><li>".$okuEtiket["etiketKeyword"]."</li></ul>";
						}
						?>
						</dd>
						<?php
						}	
					?>
		</dl>
	</div>
			<?php
				if (isset($_POST['soruEkle'])){
						$soruCumlesi=$soruCevabi="";
						$soruCumlesi = htmlspecialchars(addslashes ($_POST['soruCumlesi']));
						$soruCevabi = htmlspecialchars(addslashes ($_POST['soruCevabi']));
						$hatalar=array('Oyun ekleme hatası','En az bir sistem gereksinimi bilgisi giriniz.','Boş alan bırakmayınız.');
						$conn->set_charset("utf8");
						$sql = mysqli_query($conn,"insert into soruCevap (covidSoru,cevapSoru) values('".$soruCumlesi."','".$soruCevabi."')");
					if($sql){   
						?>
					<script>swal("Soru Ekleme", "İşlem başarılı", "success");</script>
			<?php 	}
				}	?>
				
<div class="container">	
	<div class="row">	
		<div class="col-md-12">
		<table id="myTable" class="table table-striped" >
			<thead>
				<tr>
				  <th class="th-sm">LogID</th>
				  <th class="th-sm">UserID</th>
				  <th class="th-sm">UserSoru</th>
				  <th class="th-sm">UserSoruCevap</th>
				</tr>
			</thead>
				<tbody>
  <?php
  $query = mysqli_query($conn,"SELECT * FROM logUser order by logID");					
						while($oku=mysqli_fetch_array($query))	
						{	
						?>
						<tr>
						  <td><?php echo $oku["logID"]?></td>
						  <td><?php echo $oku["userID"]?></td>
						  <td><?php echo $oku["userSoru"]?></td>
						  <td><?php echo $oku["userSoruCevap"]?></td>
						</tr>
	
			<?php   }  ?>
			</tbody>
			</table>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
    $('#myTable').dataTable();
});
</script>