<?php 
	namespace App\Libraries;
	require_once __DIR__ . '/kitupload/vendor/autoload.php';
	use ImageKit\ImageKit;
    
	Class Uploadkit{
		function uploaddata($image_path,$image_name,$folder){
			$public_key = 'public_S6VJbQufRnOZr2autxpjmhFhQM8=';
    		$your_private_key = 'private_apQK+q2mRVX7Wy7LmhA02QK1w/E=';
    		$url_end_point = 'https://ik.imagekit.io/digicommunity';
			$sample_file_path = $image_path;

			$imageKit = new ImageKit(
				$public_key,
				$your_private_key,
				$url_end_point
			);

			$img = file_get_contents($image_path);

			$encodedImageData = base64_encode($img);
			$uploadFile = $imageKit->uploadFile([
				'file' => $encodedImageData,
				'fileName' => $image_name,
				'folder' => $folder,
				'tags' => implode(['abd', 'def']),
				'useUniqueFileName' => false,
				'customCoordinates' => implode(',', ['10', '10', '100', '100'])
			]);
			//$respone = json_decode($uploadFile);
			return $uploadFile->result->url;
		}
	}
?>
