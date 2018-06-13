<?php


  $countryID = 3;

  if(isset($_GET['countryID'])){
    $countryID = intval($_GET['countryID']);
  }

      if(isset($_POST['month'], $_POST['personType'], $_POST['gender'])){
      $url = '../php/results.php?countryID='. $countryID . '&month=' . $_POST['month'] . '&personType=' . $_POST['personType'] . '&gender=' . $_POST['gender'];
      header('Location: '. $url);

      exit();
    }

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="..\css\PaginaCriteriiStyle.css">

</head>


	<div id = "sidebar" style="top:2%; left: 6%;">
		<div>
			<div><p class = "menu"><img src="../images/empty.png" class = "icon"></p></div>
			<div><a href = "../php/profile.php"><p class = "menu"><img src="../images/profile.png" class = "icon zoom"></p></a></div>
			<div><a href = "../php/home.php"><p class = "menu"><img src="../images/search.png" class = "icon zoom"></p></a></div>
			<div><a href='logout.php'><p class = "menu"><img src="../images/logout.png" class = "icon zoom"></p></a></div>
		</div>
	</div>

	<div id = "sidebarSecond">
		
	</div>


<div class="slideshow-container">
<div class="mySlides fade">
  
  <img src="..\images\imag2.jpg"  style="width:100%">

</div>

<div class="mySlides fade">
  
  <img src="..\images\img2.jpg" style="width:100%">
 
</div>

<div class="mySlides fade">
  
  <img src="..\images\imag1.jpg" style="width:100%">

</div>



<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>

</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div>

<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script>

 



 <div class="mob col-12"><h1>Make your custom choice</h1></div>

<div class="row"> 
<div class="div2 col-5">

  <form  method = "post">
    <label for="fname">Choose a month:</label>
      <select id="month" name="month">
      <option value="1">January</option>
      <option value="2">February</option>
      <option value="3">March</option>
	    <option value="4">April</option>
      <option value="5">May</option>
      <option value="6">June</option>
	    <option value="7">July</option>
      <option value="8">August</option>
      <option value="9">September</option>
	    <option value="10">October</option>
      <option value="11">November</option>
      <option value="12">December</option>
	</select>  
	
    <label for="fname">Insert age of person:</label>
    <input type="text" id="fname" name="personType" placeholder="Age">

<label for="fname">Gender:</label> <br><br>
  <input class="col-2" type="radio" name="gender" value="1" checked> Male<br>
  <input class="col-2" type="radio" name="gender" value="2"> Female <br><br>

  <input type="submit" value="Submit">

</form>

</div>
<h1>
<div class="div3 col-7"> Make your </div> <br>
<div class="div3 col-4"> 
  <span>custom choice</span>
</div>

</div>

</div>


</body>
</html> 
