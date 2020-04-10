<?php
   session_start();
   if(isset($_SESSION['username'])) {
   header('location:home.php'); }
   require_once("connect.php");
?>

<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tourism Predictions</title>
<style type="text/css">
 body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

.input-container {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  width: 100%;
  margin-bottom: 15px;
}

.icon {
  padding: 10px;
  background: #545454;
  color: white;
  min-width: 50px;
  text-align: center;
}

.input-field {
  width: 100%;
  padding: 10px;
  outline: none;
}

.input-field:focus {
  border: 2px solid dodgerblue;
}

/* Set a style for the submit button */
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


.gambar{
  height: 100px;
  width: 100px;
}

#right{
  width:40%;
  height:100px;
  float:right;
}

#left {
  width:60%;
  height:100px;
  float:left;
}

.slider {
  border: 10px solid #efefef;
  position: relative;
  overflow: hidden;
  background: #efefef;
}

.slider {
  margin:110px auto;
  width: 768px;
  height: 450px;
}
.image-slider img {
  width: 768px;
  height: 450px;
  float: left;
}

.image-slider {
  position: absolute;
  width:3900px;

  /*pengaturan durasi lama tampil gambar bisa di atur di bawah ini*/
  animation-name:slider;
  animation-duration:25s;
  animation-timing-function: ease-in-out;
  animation-iteration-count:infinite;
  -webkit-animation-name:slider;
  -webkit-animation-duration:25s;
  -webkit-animation-timing-function: ease-in-out;
  -webkit-animation-iteration-count:infinite;
  -moz-animation-name:slider;
  -moz-animation-duration:25s;
  -moz-animation-timing-function: ease-in-out;
  -moz-animation-iteration-count:infinite;
  -o-animation-name:slider;
  -o-animation-duration:25s;
  -o-animation-timing-function: ease-in-out;
  -o-animation-iteration-count:infinite;
}

.image-slider:hover {
  -webkit-animation-play-state:paused;
  -moz-animation-play-state:paused;
  -o-animation-play-state:paused;
  animation-play-state:paused; }


.image-slider img {
  float: right;
}

.slider:after {
  font-size: 150px;
  position: absolute;
  z-index: 12;
  color: rgba(255,255,255, 0);
  left: 300px; top: 80px;
  -webkit-transition: 1s all ease-in-out;
  -moz-transition: 1s all ease-in-out;
  transition: 1s all ease-in-out;
}

.slider:hover:after {
  color: rgba(255,255,255, 0.6);
}

@-moz-keyframes slider {
  0% {
    left: 0; opacity: 0;
  }
  2% {
    opacity: 1;
  }
  20% {
    left: 0; opacity: 1;
  }
  21% {
    opacity: 0;
  }
  24% {
    opacity: 0;
  }
  25% {
    left: -768px; opacity: 1;
  }
  45% {
    left: -768px; opacity: 1;
  }
  46% {
    opacity: 0;
  }
  48% {
    opacity: 0;
  }
  50% {
    left: -1536px; opacity: 1;
  }
  70% {
    left: -1536px; opacity: 1;
  }
  72% {
    opacity: 0;
  }
  74% {
    opacity: 0;
  }
  75% {
    left: -2304px; opacity: 1;
  }
  95% {
    left: -2304px; opacity: 1;
  }
  97% {
    left: -2304px; opacity: 0;
  }
  100% {
    left: 0; opacity: 0;
  }
}

@-webkit-keyframes slider {
  0% {
    left: 0; opacity: 0;
  }
  2% {
    opacity: 1;
  }
  20% {
    left: 0; opacity: 1;
  }
  21% {
    opacity: 0;
  }
  24% {
    opacity: 0;
  }
  25% {
    left: -768px; opacity: 1;
  }
  45% {
    left: -768px; opacity: 1;
  }
  46% {
    opacity: 0;
  }
  48% {
    opacity: 0;
  }
  50% {
    left: -1536px; opacity: 1;
  }
  70% {
    left: -1536px; opacity: 1;
  }
  72% {
    opacity: 0;
  }
  74% {
    opacity: 0;
  }
  75% {
    left: -2304px; opacity: 1;
  }
  95% {
    left: -2304px; opacity: 1;
  }
  97% {
    left: -2304px; opacity: 0;
  }
  100% {
    left: 0; opacity: 0;
  }
}


@keyframes slider {
  0% {
    left: 0; opacity: 0;
  }
  2% {
    opacity: 1;
  }
  20% {
    left: 0; opacity: 1;
  }
  21% {
    opacity: 0;
  }
  24% {
    opacity: 0;
  }
  25% {
    left: -768px; opacity: 1;
  }
  45% {
    left: -768px; opacity: 1;
  }
  46% {
    opacity: 0;
  }
  48% {
    opacity: 0;
  }
  50% {
    left: -1536px; opacity: 1;
  }
  70% {
    left: -1536px; opacity: 1;
  }
  72% {
    opacity: 0;
  }
  74% {
    opacity: 0;
  }
  75% {
    left: -2304px; opacity: 1;
  }
  95% {
    left: -2304px; opacity: 1;
  }
  97% {
    left: -2304px; opacity: 0;
  }

  100% {
    left: 0; opacity: 0;
  }
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>
  <div id="left">
    <div class="slider">
      <div class="image-slider">
        <img src="image/image1.jpg" alt="Image 1">
        <img src="image/image2.jpg" alt="Image 2">
        <img src="image/image3.jpg" alt="Image 3">
        <img src="image/image4.jpg" alt="Image 4">
        <img src="image/image5.jpg" alt="Image 5">

      </div>
    </div>
  </div>
  <div id="right">
    <form action="proseslogin.php" method="post" style="max-width:500px;margin:30px;">
      <img class="gambar" src="logo.jpg">
      <br><br><br>
      <h2 align="center">LOGIN</h2>
      <div class="input-container">
        <i class="fa fa-user icon"></i>
        <input class="input-field" type="text" placeholder="Enter Username. . ." name="username" required>
      </div>


      <div class="input-container">
        <i class="fa fa-key icon"></i>
        <input class="input-field" type="password" placeholder="Enter Password. . ." name="password" required>
      </div>

      <button value="Login" type="submit" class="btn">Login</button>
    </form>
    <h5 style="text-align: center;">Don't have an account? <a href="register.php">Register Here</a> </h5>
  </div>

</body>