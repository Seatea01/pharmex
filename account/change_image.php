<?php
session_start();
require_once('../classes/autoload.php');
include('../classes/images.php');
$DB = new database();


$pharmid = $_SESSION['pharmid'];
$query = "SELECT * from users where pharmid = '$pharmid' limit 1";
$result = $DB->read($query);
if (is_array($result)) {

	$user_data = $result[0];
	//$user_data = $result[0];
	//print_r($user_data->firstname);
	//die;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
			
			if ($_FILES['file']['type'] == "image/jpeg") 
			{
			//echo "nice work";
			//die;
				$allowedsize = (1024 * 1024) * 1;
				if ($_FILES['file']['size'] < $allowedsize) {
				
				$folder = "uploads/" . $user_data->pharmid . "/";

				//create folder here
				if (!file_exists($folder)) 
				{
					mkdir($folder, 0777, true);
					file_put_contents($folder. "index.php", "");
				}


					$image = new image();

				$filename = $folder . $image->generate_filename(15) . ".jpg";
				move_uploaded_file($_FILES['file']['tmp_name'],  $filename);


				$change = "profile";

						//check for mode
						if (isset($_GET['change'])) 
						{

							$change = $_GET['change'];

						}


						if ($change == "cover") 
						{
							if (file_exists($user_data->cover_image)) 
							{
								unlink($user_data->cover_image);
							}
							$image->resize_image($filename, $filename, 1500, 1500);
						}
						else
						{
							if (file_exists($user_data->profile_image)) 
							{
								unlink($user_data->profile_image);
							}
							$image->resize_image($filename, $filename, 1500, 1500);
						}

					if (file_exists($filename)) {

						$pharmid  = $user_data->pharmid;
						

						if ($change == "cover") 
						{
							$query = "UPDATE users SET cover_image = '$filename' WHERE pharmid = '$pharmid' LIMIT 1";
							//$_POST['is_cover_image'] = 1;
						}else
						{
							$query = "UPDATE users SET profile_image = '$filename' WHERE pharmid = '$pharmid' LIMIT 1 ";
							//$_POST['is_profile_image'] = 1;
						}
						
						
				
						$DB = new Database();
						$DB->write($query);

						//create a post
						//$post = new post();
						//$post->create_post($userid, $_POST, $filename);



						//header("Location: profile.php");
						//die;
					}

				}else{
					echo "<script>alert('only image size of 3mb or lower is allowed!')</script>";
				}
			}else{
				echo "<script>alert('invalid image type')</script>";
			}

	}else{
			echo "<script>alert('Please add a valid image')</script>";
		}
		
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
</head>
<body>
<div class="container">
	<div class="container" style="max-width: 500px;">
			<?php 
					
						//check for mode
						if (isset($_GET['change']) && $_GET['change'] == "cover") 
						{

							$change = $_GET['change'];
							echo "<img src='$user_data->cover_image' style='max-width: 500px;' >";

						}else
						{
							echo "<img src='$user_data->profile_image' style='max-width: 500px;' >";
						}
						
						
						

						?>
		<br><br>
		<form method="post" enctype="multipart/form-data">
		<span><input type="file" id="file" name="file"> <input type="submit"></span>
		</form>
	</div>
	
</div>
</body>
</html>
