<?php
session_start();

require_once('../classes/autoload.php');
include('../classes/images.php');
$DB = new database();

//print_r($_FILES);
//die;
/*
Array
(
    [cover] => Array
        (
            [name] => acfmlogo_2.jpg
            [type] => image/jpeg
            [tmp_name] => C:\xampp\tmp\php25A9.tmp
            [error] => 0
            [size] => 33558
        )

)
*/
$pharmid = $_SESSION['pharmid'];
$query = "SELECT * from users where pharmid = '$pharmid' limit 1";
$result = $DB->read($query);
if (is_array($result)) {

	$user_data = $result[0];
}
$info = (Object)[];


				
$folder = "uploads/" . $user_data->pharmid . "/";;

if (!file_exists($folder)) {
	mkdir($folder,0777,true);
	file_put_contents($folder. "index.php", "");
}				

$image = new image();
$filename = $folder .$image->generate_filename(15). ".jpg";
//$filename = glob($folder . "*.{jpeg,JPEG,jpg,png,PNG,JPG}", GLOB_BRACE);

if (isset($_FILES['cover']) && $_FILES['cover']['name'] != "" && $_FILES['cover']['error'] == 0) {

		$allowedsize = (1024 * 1024) * 1;
		if ($_FILES['cover']['size'] < $allowedsize) {
			
			//$destination = $folder . $_FILES['file']['name'];
			move_uploaded_file($_FILES['cover']['tmp_name'], $filename);

			if (file_exists($user_data->cover_image)) 
				{
					unlink($user_data->cover_image);
					//unlink($filename);
				}
				$image->resize_image($filename, $filename, 500, 500);

				if (file_exists($filename)) {

						$pharmid  = $user_data->pharmid;
					
						$query = "UPDATE users SET cover_image = '$filename' WHERE pharmid = '$pharmid' LIMIT 1";
							//$_POST['is_cover_image'] = 1;
						
						$DB = new Database();
						$DB->write($query);
					}

				//$files = glob($filename . "*.{jpeg,JPEG,jpg,png,PNG,JPG}", GLOB_BRACE);
				echo json_encode($filename);
			}else{
			$info->message = "File size of 3Mb or lower is permitted!";
			$info->data_type = "error";
			echo json_encode($info);
			}
		}elseif (isset($_FILES['profile']) && $_FILES['profile']['name'] != "" && $_FILES['profile']['error'] == 0) {

			$allowedsize = (1024 * 1024) * 1;
		if ($_FILES['profile']['size'] < $allowedsize) {
			
			//$destination = $folder . $_FILES['file']['name'];
			move_uploaded_file($_FILES['profile']['tmp_name'], $filename);

			if (file_exists($user_data->profile_image)) 
				{
					unlink($user_data->profile_image);
					//unlink($filename);
				}
				$image->resize_image($filename, $filename, 500, 500);

				if (file_exists($filename)) {

						$pharmid  = $user_data->pharmid;
					
						$query = "UPDATE users SET profile_image = '$filename' WHERE pharmid = '$pharmid' LIMIT 1";
							//$_POST['is_cover_image'] = 1;
						
						$DB = new Database();
						$DB->write($query);
					}

				//$files = glob($filename . "*.{jpeg,JPEG,jpg,png,PNG,JPG}", GLOB_BRACE);
				echo json_encode($filename);
			}else{
			$info->message = "File size of 3Mb or lower is permitted!";
			$info->data_type = "error";
			echo json_encode($info);
			}
		}else{
		echo json_encode($filename);
	}


