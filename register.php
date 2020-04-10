<?php
	require_once("connect.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tourism Predictions</title>

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
    <style type="text/css">
        body {font-family: Arial, Helvetica, sans-serif;}
        * {box-sizing: border-box;}

        .gambar{
            height: 100px;
            width: 100px;
        }
        .btn {
		  background-color: #28b78d;
		  color: white;
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
</head>
<body>
	<div class="content">

	<div class="container" style="margin-top:20px">
		<h2 align="center">REGISTER</h2>

		<hr>

		<?php
		if(isset($_POST['submit'])){
            $full_name			= $_POST['full_name'];
            $email              = $_POST['email'];
            $username           = $_POST['username'];
			$password			= md5($_POST['password']);
            $date_of_birth		= $_POST['date_of_birth'];
            $country            = $_POST['country'];

			$cek = mysqli_query($db, "SELECT * FROM user WHERE username='$username'") or die(mysqli_error($db));

			if(mysqli_num_rows($cek) == 0){
				$sql = mysqli_query($db, "INSERT INTO user(full_name, email, username, password, date_of_birth, country) VALUES('$full_name', '$email', '$username', '$password', '$date_of_birth', '$country')") or die(mysqli_error($db));

				if($sql){
					echo '<script>alert("Silahkan login kembali."); document.location="login.php";</script>';
				}else{
					echo '<div class="alert alert-warning">Maaf, registrasi ditolak.</div>';
				}
			}else{
				echo '<div class="alert alert-warning">Gagal, ID sudah terdaftar.</div>';
			}
		}
		?>
        <img class="gambar" src="logo.jpg">
		<form action="register.php" method="post">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Full Name</label>
                <div class="col-sm-10">
                    <input type="text" name="full_name" class="form-control" size="4" required>
                </div>
            </div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Email</label>
				<div class="col-sm-10">
					<input type="text" name="email" class="form-control" size="4" required>
				</div>
			</div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" name="username" class="form-control" size="4" required>
                </div>
            </div>
            <div class="form-group row">
				<label class="col-sm-2 col-form-label">Password</label>
				<div class="col-sm-10">
					<input type="password" name="password" class="form-control" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Confirm Password</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" required>
				</div>
			</div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Date Of Birth</label>
                <div class="col-sm-10">
                    <input type="date" name="date_of_birth" class="form-control" size="4" required>
                </div>
            </div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Country</label>
				<div class="col-sm-10">
					<select name="country" class="form-control" >
						<option value="">--Select Country--</option>
						<option value="1">Afghanistan</option>
						<option value="2">Albania</option>
						<option value="3">Algeria</option>
						<option value="3">American Samoa</option>
						<option value="3">Andorra</option>
						<option value="3">Angola</option>
						<option value="3">Antigua And Barbuda</option>
						<option value="3">Argentina</option>
						<option value="3">Armenia</option>
						<option value="3">Aruba</option>
						<option value="3">Australia</option>
						<option value="3">Austria</option>
						<option value="3">Azerbaijan</option>
						<option value="3">Bahamas</option>
						<option value="3">Bahrain</option>
						<option value="3">Bangladesh</option>
						<option value="3">Barbados</option>
						<option value="3">Belarus</option>
						<option value="3">Belgium</option>
						<option value="3">Belize</option>
						<option value="3">Benin</option>
						<option value="3">Bermuda</option>
						<option value="3">Bhutan</option>
						<option value="3">Bolivia, Pluralinational State Of</option>
						<option value="3">Bonaire</option>
						<option value="3">Bosnia And Herzegovina</option>
						<option value="3">Botswana</option>
						<option value="3">Brazil</option>
						<option value="3">British Virgin Islands</option>
						<option value="3">Brunei Darussalam</option>
						<option value="3">Bulgaria</option>
						<option value="3">Burkina Faso</option>
						<option value="3">Burundi</option>
						<option value="3">Cabo Verde</option>
						<option value="3">Cambodia</option>
						<option value="3">Cameroon</option>
						<option value="3">Canada</option>
						<option value="3">Cayman Islands</option>
						<option value="3">Central African Republic</option>
						<option value="3">Chad</option>
						<option value="3">Chile</option>
						<option value="3">China</option>
						<option value="3">Colombia</option>
						<option value="3">Comoros</option>
						<option value="3">Congo</option>
						<option value="3">Congo, Democratic Republic Of The</option>
						<option value="3">Cook Islands</option>
						<option value="3">Costa Rica</option>
						<option value="3">Cote D'Ivoire</option>
						<option value="3">Croatia</option>
						<option value="3">Cuba</option>
						<option value="3">Curacao</option>
						<option value="3">Cyprus</option>
						<option value="3">Czech Republic</option>
						<option value="3">Denmark</option>
						<option value="3">Djibouti</option>
						<option value="3">Dominica</option>
						<option value="3">Dominican Republic</option>
						<option value="3">Ecuador</option>
						<option value="3">Egypt</option>
						<option value="3">El Salvador</option>
						<option value="3">Equatorial Guinea</option>
						<option value="3">Eritrea</option>
						<option value="3">Estonia</option>
						<option value="3">Eswatini</option>
						<option value="3">Ethiopia</option>
						<option value="3">Fiji</option>
						<option value="3">Finland</option>
						<option value="3">France</option>
						<option value="3">French Guiana</option>
						<option value="3">French Polynesia</option>
						<option value="3">Gabon</option>
						<option value="3">Gambia</option>
						<option value="3">Georgia</option>
						<option value="3">Germany</option>
						<option value="3">Ghana</option>
						<option value="3">Greece</option>
						<option value="3">Grenada</option>
						<option value="3">Guadeloupe</option>
						<option value="3">Guam</option>
						<option value="3">Guatemala</option>
						<option value="3">Guinea</option>
						<option value="3">Guinea-Bissau</option>
						<option value="3">Guyana</option>
						<option value="3">Haiti</option>
						<option value="3">Honduras</option>
						<option value="3">Hong Kong, China</option>
						<option value="3">Hungary</option>
						<option value="3">Iceland</option>
						<option value="3">India</option>
						<option value="3">Indonesia</option>
						<option value="3">Iran, Islamic Republic Of</option>
						<option value="3">Iraq</option>
						<option value="3">Ireland</option>
						<option value="3">Israel</option>
						<option value="3">Italy</option>
						<option value="3">Jamaica</option>
						<option value="3">Japan</option>
						<option value="3">Jordan</option>
						<option value="3">Kazakhstan</option>
						<option value="3">Kenya</option>
						<option value="3">Kiribati</option>
						<option value="3">Korea, Republic Of</option>
						<option value="3">Kuwait</option>
						<option value="3">Kyrgyzstan</option>
						<option value="3">Lao People's Democratic Republic</option>
						<option value="3">Latvia</option>
						<option value="3">Lebanon</option>
						<option value="3">Lesotho</option>
						<option value="3">Liberia</option>
						<option value="3">Libya</option>
						<option value="3">Liechtenstein</option>
						<option value="3">Lithuania</option>
						<option value="3">Luxembourg</option>
						<option value="3">Macao, China</option>
						<option value="3">Madagascar</option>
						<option value="3">Malawi</option>
						<option value="3">Malaysia</option>
						<option value="3">Maldives</option>
						<option value="3">Mali</option>
						<option value="3">Malta</option>
						<option value="3">Marshall Islands</option>
						<option value="3">Martinique</option>
						<option value="3">Mauritania</option>
						<option value="3">Mauritius</option>
						<option value="3">Mexico</option>
						<option value="3">Micronesia, Federated States Of</option>
						<option value="3">Moldova, Republic Of</option>
						<option value="3">Monaco</option>
						<option value="3">Mongolia</option>
						<option value="3">Montenegro</option>
						<option value="3">Montserrat</option>
						<option value="3">Morocco</option>
						<option value="3">Mozambique</option>
						<option value="3">Myanmar</option>
						<option value="3">Namibia</option>
						<option value="3">Nauru</option>
						<option value="3">Nepal</option>
						<option value="3">Netherlands</option>
						<option value="3">New Caledonia</option>
						<option value="3">New Zealand</option>
						<option value="3">Nicaragua</option>
						<option value="3">Niger</option>
						<option value="3">Nigeria</option>
						<option value="3">Niue</option>
						<option value="3">North Macedonia</option>
						<option value="3">Northern Mariana Islands</option>
						<option value="3">Norway</option>
						<option value="3">Oman</option>
						<option value="3">Pakistan</option>
						<option value="3">Palau</option>
						<option value="3">Panama</option>
						<option value="3">Papua New Guinea</option>
						<option value="3">Paraguay</option>
						<option value="3">Peru</option>
						<option value="3">Philippines</option>
						<option value="3">Poland</option>
						<option value="3">Portugal</option>
						<option value="3">Puerto Rico</option>
						<option value="3">Qatar</option>
						<option value="3">Reunion</option>
						<option value="3">Romania</option>
						<option value="3">Russian Federation</option>
						<option value="3">Rwanda</option>
						<option value="3">Saba</option>
						<option value="3">Saint Kitts And Nevis</option>
						<option value="3">Saint Lucia</option>
						<option value="3">Saint Vincent And The Grenadines</option>
						<option value="3">Samoa</option>
						<option value="3">San Marino</option>
						<option value="3">Sao Tome And Principe</option>
						<option value="3">Saudi Arabia</option>
						<option value="3">Senegal</option>
						<option value="3">Serbia</option>
						<option value="3">Serbia And Montenegro</option>
						<option value="3">Seychelles</option>
						<option value="3">Sierra Leone</option>
						<option value="3">Singapore</option>
						<option value="3">Sint Eustatius</option>
						<option value="3">Sint Maarten (Dutch Part)</option>
						<option value="3">Slovakia</option>
						<option value="3">Slovenia</option>
						<option value="3">Solomon Islands</option>
						<option value="3">South Africa</option>
						<option value="3">South Sudan</option>
						<option value="3">Spain</option>
						<option value="3">Sri Lanka</option>
						<option value="3">State Of Palestine</option>
						<option value="3">Sudan</option>
						<option value="3">Suriname</option>
						<option value="3">Sweden</option>
						<option value="3">Switzerland</option>
						<option value="3">Syrian Arab Republic</option>
						<option value="3">Taiwan Province Of China</option>
						<option value="3">Tajikistan</option>
						<option value="3">Tanzania, United Republic Of</option>
						<option value="3">Thailand</option>
						<option value="3">Timor-Leste</option>
						<option value="3">Togo</option>
						<option value="3">Tonga</option>
						<option value="3">Trinidad And Tobago</option>
						<option value="3">Tunisia</option>
						<option value="3">Turkey</option>
						<option value="3">Turkmenistan</option>
						<option value="3">Turks And Caicos Islands</option>
						<option value="3">Tuvalu</option>
						<option value="3">Uganda</option>
						<option value="3">Ukraine</option>
						<option value="3">United Arab Emirates</option>
						<option value="3">United Kingdom</option>
						<option value="3">United States Of America</option>
						<option value="3">United States Virgin Islands</option>
						<option value="3">Uruguay</option>
						<option value="3">Uzbekistan</option>
						<option value="3">Vanuatu</option>
						<option value="3">Venezuela, Bolivarian Republic Of</option>
						<option value="3">Viet Nam</option>
						<option value="3">Yemen</option>
						<option value="3">Zambia</option>
						<option value="3">Zimbabwe</option>
						<option value="3">Other</option>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">&nbsp;</label>
				<div class="col-sm-10">
					<input type="submit" name="submit" class="btn" value="Register">
				</div>
			</div>
		</form>
		<h6 style="text-align: center;">Already have an account? <a href="login.php">Login Here</a> </h6>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


</body>
</html>