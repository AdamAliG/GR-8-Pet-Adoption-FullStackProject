<?php
    function fileUpload($pictures){

        if($pictures["error"] == 4){ 
            $pictureName = "avatar.png";

         

            $message = "No picture has been chosen, but you can upload an image later :)";
        }else{
            $checkIfImage = getimagesize($pictures["tmp_name"]); 
            $message = $checkIfImage ? "Ok" : "Not an image";
        }

        if($message == "Ok"){
            $ext = strtolower(pathinfo($pictures["name"],PATHINFO_EXTENSION)); 
            $pictureName = uniqid(""). "." . $ext; 
            $destination = "../pictures/{$pictureName}";

           
            move_uploaded_file($pictures["tmp_name"], $destination); 
        }

        return [$pictureName, $message]; 
    }

?>