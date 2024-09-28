<?php

namespace App\Controllers;

class Webcam extends BaseController
{
    function capture(){
        $data_uri = $this->request->getPost('data_uri');

        // Process and save the image as needed
        $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data_uri));
        $filename = time().'_'.session()->get('user_id').'.jpg';
        file_put_contents(WRITEPATH . 'uploads/' . $filename, $image_data);
        
        return $this->response->setJSON(['message' => "$filename"]);
    }

    public function show($imageName)
    {
        $path = WRITEPATH . 'uploads/' . $imageName;

        // Check if the file exists
        if (file_exists($path)) {
            // Set the appropriate MIME type
            $mimeType = mime_content_type($path);
            header('Content-Type: ' . $mimeType);

            // Display the image
            readfile($path);
        } else {
            // Handle the case when the image doesn't exist
            return "Image not found";
        }
    }
}