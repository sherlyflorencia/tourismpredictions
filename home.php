<?php
	require_once("connect.php");
?>

<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }else{
        $username = $_SESSION['username'];
    }

    $timeout = 5;
    $logout_redirect_url = "login.php";

    $timeout = $timeout * 60;

    if (isset($_SESSION['start_time'])) {
        $elapsed_time = time() - $_SESSION['start_time'];
        if ($elapsed_time >= $timeout) {
            session_destroy();
            echo "<script>alert('Session Anda Telah Habis!'); window.location = '$logout_redirect_url'</script>";
        }
    }
    $_SESSION['start_time'] = time();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tourism Predictions</title>
        <style>
            .gambar{
                height: 100px;
                width: 100px;
            }
            body {font-family: Arial, Helvetica, sans-serif;}
            .btn {
                background-color: #28b78d;
                color:  #28b78d;
                padding: 15px 20px;
                border: none;
                cursor: pointer;
                width: 100%;
                opacity: 0.9;
            }

            .btn:hover {
                opacity: 1;
            }

        </style>
        <link rel="stylesheet" type="text/css" href="style.css">
        <!-- menghubungkan dengan file jquery -->
        <script type="text/javascript" src="jquery.js"></script>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
	    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
        <script type="text/javascript" src="js/bootstrap.js"></script>
    </head>
    <body>
        <div class="header">
			<nav class="navbar navbar-expand-lg navbar-light">
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="home.php">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="about.php">About</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="logout.php">Logout</a>
						</li>
					</ul>
					<nav class="nav navbar-nav navbar-right">
						<a class="navbar-brand" href="home.php">
							<img src="logo.jpg" width="50" height="50" alt="">
						</a>
					</nav>
				</div>
			</nav>
        </div>

        <div class="content">

	<div class="container" style="margin-top:20px">
		<h2 align="center">PREDICTIONS</h2>

		<hr>

		<?php
			$conn = new mysqli("localhost", "root", "", "dbtourism");
			if ($conn->connect_errno) {
				echo "Failed to connect to MySQL: " . $conn->connect_error;
			}

			$sql = $conn->query("SELECT * FROM tbl_region");
		?>
		<form action="home.php" method="post">

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Region</label>
				<div class="col-sm-10">
					<select name="region_name" class="form-control" >
						<option disabled selected>--Select Region--</option>
						<?php if(mysqli_num_rows($sql) > 0) {?>
							<?php while ($row = mysqli_fetch_array($sql)) {?>
								<option><?php echo $row['region_name']?></option>
							<?php }?>
						<?php }?>
					</select>
				</div>
			</div>


			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Span</label>
				<div class="col-sm-10">
					<select name="span" class="form-control" >
						<option disabled selected>--Select Span--</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
			</div>


			<div class="form-group row">
				<label class="col-sm-2 col-form-label">&nbsp;</label>
				<div class="col-sm-2">
					<input type="submit" name="submit" class="btn btn-success btn-md" value="Predict">
				</div>
			</div>
		</form>

		<?php
		if(isset($_POST['submit'])){
			echo "<br>Region: ";
			echo $_POST['region_name'];
			echo "<br>Span: ";
			echo $_POST['span'];

			echo "<br><br>";

			$region_name = $_POST['region_name'];
			$span 		 = $_POST['span'];
			$spanyear 	 = $_POST['span'];


			//cek table arrival
			$cekarrival = mysqli_query($conn, "SELECT * FROM tbl_arrival") or die (mysqli_error($db));

			if(mysqli_num_rows($cekarrival) != 0 ){
				mysqli_query($conn,"TRUNCATE TABLE tbl_arrival");
			}

			//masukin data ke table arrival
			$insertarrival = mysqli_query($conn, "INSERT INTO tbl_arrival (series,arrival) SELECT series,arrival FROM tbl_region as r RIGHT OUTER JOIN tbl_tourist as t ON r.region_id = t.region_id WHERE r.region_name = '$region_name' ORDER BY t.series ASC");

			//cek table departure
			$cekdeparture = mysqli_query($conn, "SELECT * FROM tbl_departure") or die (mysqli_error($db));

			if(mysqli_num_rows($cekdeparture) != 0 ){
				mysqli_query($conn,"TRUNCATE TABLE tbl_departure");
			}

			//masukin data ke table departure
			$insertdeparture = mysqli_query($conn, "INSERT INTO tbl_departure (series,departure) SELECT series,departure FROM tbl_region as r RIGHT OUTER JOIN tbl_tourist as t ON r.region_id = t.region_id WHERE r.region_name = '$region_name' ORDER BY t.series ASC");

			//cek table expenditure in
			$cekexpenditurein = mysqli_query($conn, "SELECT * FROM tbl_expenditure_in") or die (mysqli_error($db));

			if(mysqli_num_rows($cekexpenditurein) != 0 ){
				mysqli_query($conn,"TRUNCATE TABLE tbl_expenditure_in");
			}

			//masukin data ke table expenditure in
			$insertexpenditurein = mysqli_query($conn, "INSERT INTO tbl_expenditure_in (series,expenditure_in) SELECT series,expenditure_in FROM tbl_region as r RIGHT OUTER JOIN tbl_tourist as t ON r.region_id = t.region_id WHERE r.region_name = '$region_name' ORDER BY t.series ASC");

			//cek table expenditure out
			$cekexpenditureout = mysqli_query($conn, "SELECT * FROM tbl_expenditure_out") or die (mysqli_error($db));

			if(mysqli_num_rows($cekexpenditureout) != 0 ){
				mysqli_query($conn,"TRUNCATE TABLE tbl_expenditure_out");
			}

			//masukin data ke table expenditure out
			$insertexpenditureout = mysqli_query($conn, "INSERT INTO tbl_expenditure_out (series,expenditure_out) SELECT series,expenditure_out FROM tbl_region as r RIGHT OUTER JOIN tbl_tourist as t ON r.region_id = t.region_id WHERE r.region_name = '$region_name' ORDER BY t.series ASC");

			//cek table predict
			$cekpredict = mysqli_query($conn, "SELECT * FROM tbl_predict") or die (mysqli_error($db));

			if(mysqli_num_rows($cekpredict) != 0 ){
				mysqli_query($conn,"TRUNCATE TABLE tbl_predict");
			}

			//pengulangan sampai data habis
			$alldata = (11 - $span);
			$limit = 0;

			for ($x = 0; $x < $alldata; $x++){

				//ambil data arrival sesuai span
				$dataarrival = mysqli_query($conn, "SELECT arrival FROM tbl_arrival ORDER BY tbl_arrival.arrival ASC LIMIT $limit,$span");

				while ($arrayarrival = mysqli_fetch_array($dataarrival)){
					$arrival[] = $arrayarrival['arrival'];
				}

				//ambil data departure sesuai span
				$datadeparture = mysqli_query($conn, "SELECT departure FROM tbl_departure ORDER BY tbl_departure.departure ASC LIMIT $limit,$span");

				while ($arraydeparture = mysqli_fetch_array($datadeparture)){
					$departure[] = $arraydeparture['departure'];
				}

				//limit akan bertambah
				$limit ++;

				//ambil tahun
				$temp_year = mysqli_query($conn, "SELECT series FROM tbl_arrival LIMIT $spanyear,1");
				$year = mysqli_fetch_array ($temp_year);
				$year_string  = implode($year);

				//ambil nilai Yt arrival
				$ytarrival = mysqli_query($conn,"SELECT arrival FROM tbl_arrival LIMIT $spanyear,1");
				$now_arrival = mysqli_fetch_array($ytarrival);

				//ambil nilai Yt departure
				$ytdeparture = mysqli_query($conn,"SELECT departure FROM tbl_departure LIMIT $spanyear,1");
				$now_departure = mysqli_fetch_array($ytdeparture);

				//span year akan bertambah
				$spanyear++;

				//arrival
				$predicttourist = 0;
				$htarrival = 0;
				$temparrival = 0;
				$weightarrival = $_POST['span'];

				//departure
				$ht_departure = 0;
				$temp_departure = 0;
				$weight_departure = $_POST['span'];

				//data*bobot arrival
				for ($i = 0; $i < $span; $i++){
					$touristarrival[$i] = $arrival[$i] * $weightarrival;
					$temparrival += $touristarrival[$i];

					$weightarrival--;
				}

				//data*bobot departure
				for ($j = 0; $j < $span; $j++){
					$tourist_departure[$j] = $departure[$j] * $weight_departure;
					$temp_departure += $tourist_departure[$j];

					$weight_departure--;
				}

				//mencari nilai bagi
				$jumlah = 0;
				for ($k = 1; $k <= $span; $k++){
					$jumlah += $k;
				}

				//mencari nilai Ht arrival
				$htarrival = $temparrival / $jumlah ;

				//mencari nilai Ht departure
				$ht_departure = $temp_departure / $jumlah ;

				//mencari nilai alpha
				$alpha = 0;
				$alpha = 2 / ($span + 1);

				//mencari nilai wema arrival
				$wema_arrival = round(($alpha * $now_arrival['arrival']) + ((1 - $alpha) * $htarrival), 2);

				//mencari nilai error arrival
				$error_arrival = abs($now_arrival['arrival'] - $wema_arrival);

				//mencari nilai wema departure
				$wema_departure = round(($alpha * $now_departure['departure']) + ((1 - $alpha) * $ht_departure), 2);

				//mencari nilai error departure
				$error_departure = abs($now_departure['departure'] - $wema_departure);

				//input table predict
				$insertpredict = mysqli_query($conn, "INSERT INTO tbl_predict(series,wema_arrival,error_arrival,wema_departure,error_departure) VALUES ('$year_string', '$wema_arrival', '$error_arrival','$wema_departure','$error_departure')");
			}


			//output arrival
			echo '<h5 align="center">Arrival</h5>';
			echo '<table id="dataTables" class="display" cellspacing="0" width="100%">';
				echo "<thead>";
					echo "<tr>";
						echo "<th>No</th>";
						echo "<th>Series</th>";
						echo "<th>Arrival</th>";
						echo "<th>Predict</th>";
						echo "<th>Error</th>";

					echo "</tr>";
				echo "</thead>";

				echo "<tbody>";
				$no = 1;
				$res = $conn->query("SELECT * FROM tbl_predict LEFT JOIN tbl_arrival ON tbl_predict.series = tbl_arrival.series UNION SELECT * FROM tbl_predict RIGHT JOIN tbl_arrival ON tbl_predict.series = tbl_arrival.series ORDER BY 7");


					while($response = $res->fetch_assoc()){
						echo "<tr>";

						echo "<td>".$no."</td>";
						echo "<td>".$response['series']."</td>";
						echo "<td>".$response['arrival']."</td>";
						echo "<td>".$response['wema_arrival']."</td>";
						echo "<td>".$response['error_arrival']."</td>";
						echo "</tr>";

						$no++;
					}


				echo "</tbody>";
				echo "<tfoot>";
					echo "<tr>";
						echo "<th>No</th>";
						echo "<th>Series</th>";
						echo "<th>Arrival</th>";
						echo "<th>Predict</th>";
						echo "<th>Error</th>";
					echo "</tr>";
				echo "</tfoot>";
			echo "</table>";


			//mencari nilai mape arrival
			$arrivalmape = mysqli_query($conn, "SELECT arrival FROM tbl_arrival ORDER BY series ASC LIMIT $span,$alldata");

			while ($arrivalsigma = mysqli_fetch_array($arrivalmape)){
				$arvsigma[] = $arrivalsigma['arrival'];
			}

			$errormape_arrival = mysqli_query($conn, "SELECT error_arrival FROM tbl_predict ORDER BY series ASC");

			while ($errorsigma_arrival = mysqli_fetch_array($errormape_arrival)){
				$errsigma_arrival[] = $errorsigma_arrival['error_arrival'];
			}

			$allsigma_arrival = 0;

			for($w = 0; $w < $alldata; $w++){
				$sigma_arrival[$w] =  $errsigma_arrival[$w] / $arvsigma[$w];
				$allsigma_arrival += $sigma_arrival[$w];
			}

			$mape_arrival = round((((1/$alldata)*$allsigma_arrival)*100), 2);

			echo "<br>MAPE: ";
			echo $mape_arrival."%";

			//output departure
			echo '<h5 align="center">Departure</h5>';
			echo '<table id="dataTablesdeparture" class="display" cellspacing="0" width="100%">';
				echo "<thead>";
					echo "<tr>";
						echo "<th>No</th>";
						echo "<th>Series</th>";
						echo "<th>Departure</th>";
						echo "<th>Predict</th>";
						echo "<th>Error</th>";

					echo "</tr>";
				echo "</thead>";

				echo "<tbody>";
				$no = 1;
				$res = $conn->query("SELECT * FROM tbl_predict LEFT JOIN tbl_departure ON tbl_predict.series = tbl_departure.series UNION SELECT * FROM tbl_predict RIGHT JOIN tbl_departure ON tbl_predict.series = tbl_departure.series ORDER BY 7");


					while($response = $res->fetch_assoc()){
						echo "<tr>";

						echo "<td>".$no."</td>";
						echo "<td>".$response['series']."</td>";
						echo "<td>".$response['departure']."</td>";
						echo "<td>".$response['wema_departure']."</td>";
						echo "<td>".$response['error_departure']."</td>";
						echo "</tr>";

						$no++;
					}


				echo "</tbody>";
				echo "<tfoot>";
					echo "<tr>";
						echo "<th>No</th>";
						echo "<th>Series</th>";
						echo "<th>Departure</th>";
						echo "<th>Predict</th>";
						echo "<th>Error</th>";
					echo "</tr>";
				echo "</tfoot>";
			echo "</table>";

			//mencari nilai mape departure
			$departure_all = mysqli_query($conn, "SELECT departure FROM tbl_departure ORDER BY series ASC LIMIT $span,$alldata");

			while ($departure_sigma = mysqli_fetch_array($departure_all)){
				$depsigma[] = $departure_sigma['departure'];
			}

			$errormape_departure = mysqli_query($conn, "SELECT error_departure FROM tbl_predict ORDER BY series ASC");

			while ($errorsigma_departure = mysqli_fetch_array($errormape_departure)){
				$errsigma_departure[] = $errorsigma_departure['error_departure'];
			}

			$allsigma_departure = 0;

			for($x = 0; $x < $alldata; $x++){
				$sigma_departure[$x] =  $errsigma_departure[$x] / $depsigma[$x];
				$allsigma_departure += $sigma_departure[$x];
			}

			$mape_departure = round((((1/$alldata)*$allsigma_departure)*100), 2);

			echo "<br>MAPE: ";
			echo $mape_departure."%";

		}
		?>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
	<script src="http://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
	<script>
	$(document).ready(function() {
		$('#dataTables').DataTable();
	} );
	</script>
	<script>
	$(document).ready(function() {
		$('#dataTablesdeparture').DataTable();
	} );
	</script>
    </body>
</html>