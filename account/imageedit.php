<?php
session_start();


if ($_SESSION['level'] == 0) {
header('location: ../login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>uploader</title>
</head>
<style type="text/css">
	#wrapper{
		font-size: 13px;
		font-family: verdana;
		border: solid thin grey;
		margin: auto;
		margin-top: 100px;
		padding: 10px;
		max-width: 800px;
		border-radius: 5px;
	}
	#gallery{
		border: solid thin grey;
		margin: auto;
		margin-top: 10px;
		padding: 10px;
		border-radius: 5px;
	}
	#gallery div{
		width: 150px;
		height: 150px;
		margin: 4px;
		overflow: hidden;
		display: inline-block;
		min-height: 200px;
	}
	#gallery div img{
		width: 100%;
	}
	.button{
		background-color: #67adec;
		color: white;
		cursor: pointer;
		border-radius: 5px;
		padding: 1em;
		border: none;
		display: inline-block;
	}
	#uploader{
		border: dashed 2px grey;
		width: 400px;
		height: 150px;
		padding: 1em;
		text-align: center;
		font-size: 20px;
		background-color: #eee;
		position: absolute;
		display: none;
	}
	#checkbox:checked ~ #uploader{
		display: block;
	}
	#progress_bar{
		height: 20px;
		background-color: lightblue;
		width: 0%;
		color: white;
	}
</style>
<body>
<div id="wrapper">
	<label for="checkbox" class="button">upload</label>
	<div><div id="progress_bar"></div></div>
	<input type="checkbox" id="checkbox" style="display: none;">
	<div id="uploader">
		Drag and drop files or select<br><br>
		<input onchange="handle_files(this.files)" id="file" type="file" name="file" style="display: none;">
		<label for="file" class="button">Select</label>
	</div>
	<div id="gallery">
		
	</div>

	<?php
	if (isset($_GET['change'])) {$change = $_GET['change'];}
	?>
</div>
</body>
</html>

<script>
	
	var uploader = document.getElementById("uploader");

	uploader.addEventListener("dragover", handle_drag);
	uploader.addEventListener("dragleave", handle_drag);
	uploader.addEventListener("drop", handle_drag);

	function handle_drag(e) {

		e.preventDefault();

		switch(e.type){
			case "dragover":
			uploader.style.borderColor = "red";
			break;
			case "dragleave":
			uploader.style.borderColor = "grey";
			break;
			case "drop":
				var files = e.dataTransfer.files;
				handle_drop(files);
			break;

			default:
		}
	}


	function handle_drop(files){
		 
		for (var i = 0; i < files.length; i++) {
			//change = files[i].value
			send_data(files[i]);
			
		}
	}

	function send_data(file){
		var ajax = new XMLHttpRequest();
		var data = new FormData();
		
		data.append("<?php echo $change;?>", file);
		//data.append("type", get);

		ajax.addEventListener("readystatechange", function(e){
			if (ajax.status == 200 && ajax.readyState == 4) {
				//alert(ajax.responseText);
				handle_result(ajax.responseText);
				var checkbox = document.getElementById("checkbox");
				checkbox.checked = false;
					
			}
		});
		ajax.open("POST", "api.php", true);
		ajax.send(data);
	}

	function handle_result(result){
		var obj = JSON.parse(result);
		var gallery = document.getElementById("gallery");
		//gallery.innerHTML = "";
		gallery.innerHTML = "<div><img src='obj' /></div>";
		//for (var key in obj) {
		//	gallery.innerHTML +="<div><img src='" +obj[key]+"' /></div>";
		//}
	}

	//read_data();
	function read_data(){
		var ajax = new XMLHttpRequest();


		ajax.addEventListener("readystatechange", function(e){
			if (ajax.status == 200 && ajax.readyState == 4) {
				//alert(ajax.responseText);
				handle_result(ajax.responseText);
				var progress_bar = document.getElementById("progress_bar");
					progress_bar.style.width = "0%";
			}
		});

		ajax.addEventListener("progress", function(e){
			var percent = (e.loaded / e.total * 100) || 100; 
			var progress_bar = document.getElementById("progress_bar");
			progress_bar.style.width = percent + "%";
			progress_bar.innerHTML = percent + "%";
		});

		ajax.open("POST", "api.php", true);
		ajax.send();
	}

	function handle_files(files){
		for (var i = 0; i < files.length; i++) {
			send_data(files[i]);
		}
	}

</script>