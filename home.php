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

    $timeout = 30;
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

				//ambil data expenditure in sesuai span
				$data_expenditure_in = mysqli_query($conn, "SELECT expenditure_in FROM tbl_expenditure_in ORDER BY tbl_expenditure_in.expenditure_in ASC LIMIT $limit,$span");

				while ($array_expenditure_in = mysqli_fetch_array($data_expenditure_in)){
					$expenditure_in[] = $array_expenditure_in['expenditure_in'];
				}

				//ambil data expenditure out sesuai span
				$data_expenditure_out = mysqli_query($conn, "SELECT expenditure_out FROM tbl_expenditure_out ORDER BY tbl_expenditure_out.expenditure_out ASC LIMIT $limit,$span");

				while ($array_expenditure_out = mysqli_fetch_array($data_expenditure_out)){
					$expenditure_out[] = $array_expenditure_out['expenditure_out'];
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

				//ambil nilai Yt expenditure in
				$yt_expenditure_in = mysqli_query($conn,"SELECT expenditure_in FROM tbl_expenditure_in LIMIT $spanyear,1");
				$now_expenditure_in = mysqli_fetch_array($yt_expenditure_in);

				//ambil nilai Yt expenditure out
				$yt_expenditure_out = mysqli_query($conn,"SELECT expenditure_out FROM tbl_expenditure_out LIMIT $spanyear,1");
				$now_expenditure_out = mysqli_fetch_array($yt_expenditure_out);

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

				//expenditure in
				$ht_expenditure_in = 0;
				$temp_expenditure_in = 0;
				$weight_expenditure_in = $_POST['span'];

				//expenditure out
				$ht_expenditure_out = 0;
				$temp_expenditure_out = 0;
				$weight_expenditure_out = $_POST['span'];

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

				//data*bobot expenditure in
				for ($k = 0; $k < $span; $k++){
					$tourist_expenditure_in[$k] = $expenditure_in[$k] * $weight_expenditure_in;
					$temp_expenditure_in += $tourist_expenditure_in[$k];

					$weight_expenditure_in--;
				}

				//data*bobot expenditure out
				for ($l = 0; $l < $span; $l++){
					$tourist_expenditure_out[$l] = $expenditure_out[$l] * $weight_expenditure_out;
					$temp_expenditure_out += $tourist_expenditure_out[$l];

					$weight_expenditure_out--;
				}

				//mencari nilai bagi
				$jumlah = 0;
				for ($m = 1; $m <= $span; $m++){
					$jumlah += $m;
				}

				//mencari nilai Ht arrival
				$htarrival = $temparrival / $jumlah ;

				//mencari nilai Ht departure
				$ht_departure = $temp_departure / $jumlah ;

				//mencari nilai Ht expenditure in
				$ht_expenditure_in = $temp_expenditure_in/ $jumlah ;

				//mencari nilai Ht expenditure out
				$ht_expenditure_out = $temp_expenditure_out/ $jumlah ;

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

				//mencari nilai wema expenditure in
				$wema_expenditure_in = round(($alpha * $now_expenditure_in['expenditure_in']) + ((1 - $alpha) * $ht_expenditure_in), 2);

				//mencari nilai error expenditure in
				$error_expenditure_in = abs($now_expenditure_in['expenditure_in'] - $wema_expenditure_in);

				//mencari nilai wema expenditure out
				$wema_expenditure_out = round(($alpha * $now_expenditure_out['expenditure_out']) + ((1 - $alpha) * $ht_expenditure_out), 2);

				//mencari nilai error expenditure out
				$error_expenditure_out = abs($now_expenditure_out['expenditure_out'] - $wema_expenditure_out);

				//input table predict
				$insertpredict = mysqli_query($conn, "INSERT INTO tbl_predict(series,wema_arrival,error_arrival,wema_departure,error_departure,wema_expenditure_in,error_expenditure_in,wema_expenditure_out,error_expenditure_out) VALUES ('$year_string', '$wema_arrival', '$error_arrival','$wema_departure','$error_departure','$wema_expenditure_in','$error_expenditure_in','$wema_expenditure_out','$error_expenditure_out')");
			}

			echo '<h4 align="center">Inbound Tourism</h4>';

			echo '<hr>';
			//output arrival
			echo '<h6 align="center">Arrival - Thousands</h6>';
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
				$res = $conn->query("SELECT * FROM tbl_predict LEFT JOIN tbl_arrival ON tbl_predict.series = tbl_arrival.series UNION SELECT * FROM tbl_predict RIGHT JOIN tbl_arrival ON tbl_predict.series = tbl_arrival.series ORDER BY 11");


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

			//output expenditure in
			echo '<h6 align="center">Tourism Expenditure In The Country - US$ </h6>';
			echo '<table id="dataTablesExpenditureIn" class="display" cellspacing="0" width="100%">';
				echo "<thead>";
					echo "<tr>";
						echo "<th>No</th>";
						echo "<th>Series</th>";
						echo "<th>Tourism Expenditure</th>";
						echo "<th>Predict</th>";
						echo "<th>Error</th>";

					echo "</tr>";
				echo "</thead>";

				echo "<tbody>";
				$no = 1;
				$res = $conn->query("SELECT * FROM tbl_predict LEFT JOIN tbl_expenditure_in ON tbl_predict.series = tbl_expenditure_in.series UNION SELECT * FROM tbl_predict RIGHT JOIN tbl_expenditure_in ON tbl_predict.series = tbl_expenditure_in.series ORDER BY 11");


					while($response = $res->fetch_assoc()){
						echo "<tr>";

						echo "<td>".$no."</td>";
						echo "<td>".$response['series']."</td>";
						echo "<td>".$response['expenditure_in']."</td>";
						echo "<td>".$response['wema_expenditure_in']."</td>";
						echo "<td>".$response['error_expenditure_in']."</td>";
						echo "</tr>";

						$no++;
					}


				echo "</tbody>";
				echo "<tfoot>";
					echo "<tr>";
						echo "<th>No</th>";
						echo "<th>Series</th>";
						echo "<th>Tourism Expenditure</th>";
						echo "<th>Predict</th>";
						echo "<th>Error</th>";
					echo "</tr>";
				echo "</tfoot>";
			echo "</table>";

			//mencari nilai mape expenditure in
			$expenditure_in_all = mysqli_query($conn, "SELECT expenditure_in FROM tbl_expenditure_in ORDER BY series ASC LIMIT $span,$alldata");

			while ($expenditure_in_sigma = mysqli_fetch_array($expenditure_in_all)){
				$insigma[] = $expenditure_in_sigma['expenditure_in'];
			}

			$errormape_expenditure_in = mysqli_query($conn, "SELECT error_expenditure_in FROM tbl_predict ORDER BY series ASC");

			while ($errorsigma_expenditure_in = mysqli_fetch_array($errormape_expenditure_in)){
				$errsigma_expenditure_in[] = $errorsigma_expenditure_in['error_expenditure_in'];
			}

			$allsigma_expenditure_in = 0;

			for($y = 0; $y < $alldata; $y++){
				$sigma_expenditure_in[$y] =  $errsigma_expenditure_in[$y] / $insigma[$y];
				$allsigma_expenditure_in += $sigma_expenditure_in[$y];
			}

			$mape_expenditure_in = round((((1/$alldata)*$allsigma_expenditure_in)*100), 2);

			echo "<br>MAPE: ";
			echo $mape_expenditure_in."%";

			echo '<h4 align="center">Outbound Tourism</h4>';

			echo '<hr>';

			//output departure
			echo '<h6 align="center">Departure - Thousands</h6>';
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
				$res = $conn->query("SELECT * FROM tbl_predict LEFT JOIN tbl_departure ON tbl_predict.series = tbl_departure.series UNION SELECT * FROM tbl_predict RIGHT JOIN tbl_departure ON tbl_predict.series = tbl_departure.series ORDER BY 11");


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

			//output expenditure out
			echo '<h6 align="center">Tourism Expenditure In Other Countries - US$ </h6>';
			echo '<table id="dataTablesExpenditureOut" class="display" cellspacing="0" width="100%">';
				echo "<thead>";
					echo "<tr>";
						echo "<th>No</th>";
						echo "<th>Series</th>";
						echo "<th>Tourism Expenditure</th>";
						echo "<th>Predict</th>";
						echo "<th>Error</th>";

					echo "</tr>";
				echo "</thead>";

				echo "<tbody>";
				$no = 1;
				$res = $conn->query("SELECT * FROM tbl_predict LEFT JOIN tbl_expenditure_out ON tbl_predict.series = tbl_expenditure_out.series UNION SELECT * FROM tbl_predict RIGHT JOIN tbl_expenditure_out ON tbl_predict.series = tbl_expenditure_out.series ORDER BY 11");


					while($response = $res->fetch_assoc()){
						echo "<tr>";

						echo "<td>".$no."</td>";
						echo "<td>".$response['series']."</td>";
						echo "<td>".$response['expenditure_out']."</td>";
						echo "<td>".$response['wema_expenditure_out']."</td>";
						echo "<td>".$response['error_expenditure_out']."</td>";
						echo "</tr>";

						$no++;
					}


				echo "</tbody>";
				echo "<tfoot>";
					echo "<tr>";
						echo "<th>No</th>";
						echo "<th>Series</th>";
						echo "<th>Tourism Expenditure</th>";
						echo "<th>Predict</th>";
						echo "<th>Error</th>";
					echo "</tr>";
				echo "</tfoot>";
			echo "</table>";

			//mencari nilai mape expenditure out
			$expenditure_out_all = mysqli_query($conn, "SELECT expenditure_out FROM tbl_expenditure_out ORDER BY series ASC LIMIT $span,$alldata");

			while ($expenditure_out_sigma = mysqli_fetch_array($expenditure_out_all)){
				$outsigma[] = $expenditure_out_sigma['expenditure_out'];
			}

			$errormape_expenditure_out = mysqli_query($conn, "SELECT error_expenditure_out FROM tbl_predict ORDER BY series ASC");

			while ($errorsigma_expenditure_out = mysqli_fetch_array($errormape_expenditure_out)){
				$errsigma_expenditure_out[] = $errorsigma_expenditure_out['error_expenditure_out'];
			}

			$allsigma_expenditure_out = 0;

			for($z = 0; $z < $alldata; $z++){
				$sigma_expenditure_out[$z] =  $errsigma_expenditure_out[$z] / $insigma[$z];
				$allsigma_expenditure_out += $sigma_expenditure_out[$z];
			}

			$mape_expenditure_out = round((((1/$alldata)*$allsigma_expenditure_out)*100), 2);

			echo "<br>MAPE: ";
			echo $mape_expenditure_out."%";

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
	<script>
	$(document).ready(function() {
		$('#dataTablesExpenditureIn').DataTable();
	} );
	</script>
	<script>
	$(document).ready(function() {
		$('#dataTablesExpenditureOut').DataTable();
	} );
	</script>
    </body>
</html>