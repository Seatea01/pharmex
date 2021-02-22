<?php
session_start();
if (!isset($_SESSION['pharmid'])) {
	header('location: ../login.php');
}
if ($_SESSION['level'] == 0) {
	header('location: ../login.php');
}
//print_r($_SESSION);
//die;
require_once('../classes/autoload.php');
include('../classes/images.php');
$DB = new database();
$image_class = new image();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<style type="text/css">
		 .profile_img{
  	width: 150px;
	border-radius: 50%;
	border: solid 2px white;
	margin-top: 120px;
  }
  .response {
		  z-index: 1;
		  font-size: 12px;
		  padding: 2px;
		  display: none;
		  border-radius: 2px;
		  margin-left: 80%;
		  color: #56a453;
		  margin-top: -25px;
		}
	.first_row{
		 min-height: 290px;
		 background-repeat: no-repeat;
	}
	span a{
		color: #f0f; 
		text-decoration: none;
		padding: 0.5px;
	}
	span a:hover{
		text-decoration: none;
	}
	</style>
</head>
<body>


<div class="container" style="margin: auto; max-width: 800px;">
<div class="container-fluid" style="padding-top: 50px; background-color: #f4f4f4; font-size: 15px;">
<div class="text-primary" style="text-align: center;"><h4>Update Profile</h4></div> <br>
	
				<?php
				$pharmid = $_SESSION['pharmid'];
		
				$query = "SELECT * from users where pharmid = '$pharmid' && level = 1 limit 1";
				$result = $DB->read($query);
				if (is_array($result)) {
					$user_data = $result[0];
				}
					$image = "../asset/cover_image.jpg";
					if (file_exists($user_data->cover_image)) {
					
						$image = $image_class->get_thumb_cover($user_data->cover_image);
					}

				?>
	<div class="container-fluid first_row" style="background-image: url(<?php echo $image; ?>);">
	<div class="row" style="background-color: rgba(0,0,0,0.6);">
		<div class="col-sm-3">
			<?php
					$image = "../asset/user_male.jpg";
					if ($user_data->gender == "female") 
					{
						$image = "../asset/user_female.jpg";
					}
					if (file_exists($user_data->profile_image)) {
					
						$image = $image_class->get_thumb_profile($user_data->profile_image);
					}

				?>
		<img class="profile_img" src="<?php echo $image; ?>"><div style="color: white; padding: 2px; text-align: center;"><?php echo $user_data->firstname.' '.$user_data->lastname;?></div>
		<span style="margin: auto; font-size: 12px; border-radius: 3px; background-color: rgba(255,255,255,0.7)"><a href="imageedit.php?change=profile">update profile</a> | <a href="imageedit.php?change=cover">update cover</a></span></div>
		<div class="col-sm-9" style="padding: 65px;">maximum size of 5mb, must be clear</div>
	</div>
	</div>
	<hr>

		<div class="container" style="max-width: 600px;">
			<h5>Consultancy Charge</h5><br>
			<form id="myform">
			<div class="row">
				<div class="col-sm-3"><i class="fas fa-box"></i></div>
				<div class="col-sm-9">
					<div class="row">
						<div class="col">
							
							Amount Charge in Naira<br>
							<input type="" value=""  id="price" class="form-control-sm form-control"><br>
							Subscription Duration<br>
							<input id="sub" value="monthly" type="radio" checked name="sub"> Monthly <br>
							<input id="sub" value="quartely" type="radio" name="sub"> Quartely <br>
							<input id="sub" value="yearly" type="radio" name="sub"> yearly <br>
						</div>
						<div class="col">Edit Area Address <br>
							<select class="form-control form-control-sm" id="area" name="area">
								<option value="North">Akure North</option>
								<option value="West">Akure West</option>
								<option value="South West">Akure SE</option>
								<option value="Noth West">Akure NW</option>
								<option value="South East">Akure SE</option>
								<option value="North East">Akure NE</option>
							</select><br>

							Choose State:<br><select class="form-control form-control-sm" name="state" id="state">
						<option value="abia">Abia</option>
						<option value="anambra">Anambra</option>
						<option value="bayelsa">Bayelsa</option>
						<option value="ekiti">Ekiti</option>
						<option value="ondo">Ondo</option>
						<option value="osun">Osun</option>
						<option value="ogun">Ogun</option>
						<option value="sokoto">Sokoto</option>
						<option value="plateau">Plateau</option>
						<option value="oyo">Oyo</option>
						<option value="rivers">Rivers</option>
						<option value="taraba">Taraba</option>
						<option value="yobe">Yobe</option>
					</select><br>
						</div>

					</div>
					<br>
					<input type="button" class="form-control-sm" id="update" value="update"><span id="response" class="response"></span>
				</div>
				
			</div>
			</form>

			<!-- section two-->	
			<hr>
				<h5>Area of Specialization</h5><br>
				<div class="row">
				<div class="col-sm-3"><i class="fas fa-pen"></i></div>
				<div class="col-sm-9">
					<form>
						<div class="row">
							<div class="col">
								
									Area of Specialization<br>
									<select class="form-control form-control-sm" id="specialization">
										<option value="malaria">Malaria</option>
										<option value="dietrician">Dietrician</option>
										<option value="optician">Optician</option>
										<option value="rx pharmacy">rx Pharmacy</option>
										<option value="nutrition">Nutrition</option>
										<option value="childcare">Child Care</option>
										<option value="others">Others</option>
									</select>
								
							</div>
							<div class="col">Upload your Certificate<br>
								<input class="form-control form-control-sm" type="file" name="file" id="file" placeholder="Choose File">
							</div>
						</div>
						<br>
						<input type="button" class="form-control-sm" id="update2" value="update"><span id="response2" class="response"></span>
					</form>
				</div>
				
			</div>

			<!-- section three for about pharmacist-->
			<hr>
				<h5>About Me</h5><br>
				<div class="row">
				<div class="col-sm-3"><i class="fas fa-pen"></i></div>
				<div class="col-sm-9">
					<form>
						<div class="row">
							<div class="col">
								
									Write about yourself<br>
									<textarea class="form-control-sm form-control" cols="5" id="about"></textarea>
								
							</div>
							<div class="col"></div>
						</div>
						<br>
						<input type="button" class="form-control-sm" id="about_update" value="update"><span id="response3" class="response"></span>
					</form>
				</div>
				
			</div>
			<!-- section three end -->
		</div>

	<hr>
	</div>
</div>

</body>
</html>

<script>

function image(){
	window.location = "change_image.php";
}
	function _(element){
		return document.getElementById(element);
	}
//collect data from the form



if (true) {
	var update = _("update");
update.addEventListener("click", function collect_data(){


	update.disabled = true;
	update.value = "Processing... Please wait...";

	var myform = _("myform");
	var inputs = myform.getElementsByTagName("SELECT");
	var price = _("price");
	//var sub = _("sub");
	var sub = myform.getElementsByTagName("INPUT");


		var data = {};
		data.price = price.value;
		//data.sub = sub.checked.value;
		
		

		for (var k = 0; k < sub.length; k++) {
		var key = sub[k].name;

			switch(key){
			case "sub":
			if (sub[k].checked) {
			data.sub = sub[k].value;
			}
			break;
			};
		}
			

	for (var i = 0; i < inputs.length; i++) {
		var key = inputs[i].name;
		
		switch(key){
			case "state":
			data.state = inputs[i].value;
			break;
			case "area":
			data.area = inputs[i].value;
			break;
		}
	}

	send_data(data, "update");
	//send_data(data, "login_pharm");

})
};

//send the collected data to the server
function send_data(data, type){

	var xml = new XMLHttpRequest();

	xml.onload = function(){
		if (xml.status == 200 && xml.readyState == 4) {
			//alert(xml.responseText);
			handle_result(xml.responseText);
			update.disabled = false;
			update.value = "update";
		}	
	}
	data.data_type = type;
	var data_string = JSON.stringify(data);
	xml.open("POST", "../servers/setup.php", true);
	xml.send(data_string);

}

//section for update2 
var update2 = _("update2");
update2.addEventListener("click", function collect_data2(){


	update2.disabled = true;
	update2.value = "Processing... Please wait...";

	var myform = _("myform");
	var specialization = _("specialization");
	var file = _("file");


		var data = {};
		data.specialization = specialization.value;
		data.file = file.value;


	send_data2(data, "update2");
	//send_data(data, "login_pharm");

})


function send_data2(data, type){

	var xml = new XMLHttpRequest();

	xml.onload = function(){
		if (xml.status == 200 && xml.readyState == 4) {
			//alert(xml.responseText);
			handle_result(xml.responseText);
			update2.disabled = false;
			update2.value = "update";
		}	
	}
	data.data_type = type;
	var data_string = JSON.stringify(data);
	xml.open("POST", "../servers/setup.php", true);
	xml.send(data_string);

}

//section for about update 
var about_update = _("about_update");
about_update.addEventListener("click", function collect_data_about(){


	about_update.disabled = true;
	about_update.value = "Processing... Please wait...";

	//var myform = _("myform");
	var about = _("about");
	//var file = _("file");


		var data = {};
		data.about = about.value;
		//data.file = file.value;


	send_about(data, "about");
	//send_data(data, "login_pharm");

})


function send_about(data, type){

	var xml = new XMLHttpRequest();

	xml.onload = function(){
		if (xml.status == 200 && xml.readyState == 4) {
			//alert(xml.responseText);
			handle_result(xml.responseText);
			about_update.disabled = false;
			about_update.value = "update";
		}	
	}
	data.data_type = type;
	var data_string = JSON.stringify(data);
	xml.open("POST", "../servers/setup.php", true);
	xml.send(data_string);

}
//section for image update/edit
/*
var edi = _("edit");
edit.addEventListener("click", function collect_data_edit(){


	edit.disabled = true;
	edit.value = "Processing... Please wait...";
	var file = _("file");


		var data = {};
		data.file = file.value;


	send_data_img(data, "edit");
	//send_data(data, "login_pharm");

})
*/

function send_data_img(data, type){

	var xml = new XMLHttpRequest();

	xml.onload = function(){
		if (xml.status == 200 && xml.readyState == 4) {
			alert(xml.responseText);
			//handle_result(xml.responseText);
			edit.disabled = false;
			edit.value = "update";
		}	
	}
	data.data_type = type;
	var data_string = JSON.stringify(data);
	xml.open("POST", "../servers/setup.php", true);
	xml.send(data_string);

}

//general handle request for the three above
function handle_result(result)
{
	var data = JSON.parse(result);
	if (data.data_type == "info") {
		var info = _("response");
		info.innerHTML = data.message;
		info.style.display = "block";
		info.style.backgroundColor = "#D4EDDA";
		info.style.borderLeft = "3px solid #3AD66E";
	}else if(data.data_type == "info2"){
		var info = _("response2");
		info.innerHTML = data.message;
		info.style.display = "block";
		info.style.backgroundColor = "#D4EDDA";
		info.style.borderLeft = "3px solid #3AD66E";
	}else if(data.data_type == "info3"){
		var info = _("response3");
		info.innerHTML = data.message;
		info.style.display = "block";
		info.style.backgroundColor = "#D4EDDA";
		info.style.borderLeft = "3px solid #3AD66E";
	}
	else{
			var error = _("response");
			error.innerHTML = data.message;
			error.style.display = "block";
			error.style.backgroundColor = "#FFF3CD";
			error.style.borderLeft = "3px solid #FFA502";
		}
}
</script>