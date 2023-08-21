<?php
function fileUpload($pictures, $type)
{

    if ($pictures["error"] == 4) {
        $pictureName = "avatar.png";
        $message = "No picture has been chosen, but you can upload an image later :)";
    } else {
        $checkIfImage = getimagesize($pictures["tmp_name"]);
        $message = $checkIfImage ? "Ok" : "Not an image";
    }

    if ($message == "Ok") {
        $ext = strtolower(pathinfo($pictures["name"], PATHINFO_EXTENSION));
        $pictureName = uniqid("") . "." . $ext;
        if ($type == 'pet') {
            $destination = "../public/images/pet_images/{$pictureName}";
        } else if ($type == 'user') {
            $destination = "../public/images/user_images/{$pictureName}";
        } else if ($type == 'story') {
            $destination = "../public/images/story_images/{$pictureName}";
        }


        move_uploaded_file($pictures["tmp_name"], $destination);
    }

    return [$pictureName, $message];
}
