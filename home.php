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
							<a class="nav-link" href="#">Profile</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">About</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="signin.php">Logout</a>
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

			$sql = $conn->query("SELECT * FROM region");
		?>
		<?php
		if(isset($_POST['submit'])){

		}
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
				<label class="col-sm-2 col-form-label">&nbsp;</label>
				<div class="col-sm-2">
					<input type="submit" name="submit" class="btn btn-success btn-md" value="Predict">
				</div>
			</div>
		</form>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    </body>
</html>