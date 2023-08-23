<?php

session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: ../user_auth/login.php");
}

require_once "../db_connect.php";
require_once "../file_upload.php";

header("Access-Control-Allow-Origin: http://localhost");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    


    if (isset($data["quizAnswers"])) {
        $quizAnswers = $data["quizAnswers"];
        
        $pets = [
            "dog" => [
                "question1" => ["house", "apartment"],
                "question2" => ["lots"],
                "question3" => ["very_active", "moderately_active"],
                "question4" => ["yes", "no"],
                "question5" => ["enjoy_grooming"]
            ],
            "cat" => [
                "question1" => ["apartment", "house"],
                "question2" => ["lots", "moderate"],
                "question3" => ["moderately_active", "not_very_active"],
                "question4" => ["yes", "no"],
                "question5" => ["enjoy_grooming", "okay_with_grooming"]
            ],
            "bird" => [
                "question1" => ["house", "apartment"],
                "question2" => ["lots", "moderate", "little"],
                "question3" => ["very_active", "moderately_active", "not_very_active"],
                "question4" => ["no"],
                "question5" => ["enjoy_grooming", "okay_with_grooming", "prefer_low_maintenance"]
            ],
            "hamster" => [
                "question1" => ["house", "apartment"],
                "question2" => ["lots", "moderate", "little"],
                "question3" => ["very_active", "moderately_active", "not_very_active"],
                "question4" => ["yes", "no"],
                "question5" => ["prefer_low_maintenance"]
            ],
            "fish" => [
                "question1" => ["house", "apartment"],
                "question2" => ["lots", "moderate", "little"],
                "question3" => ["very_active", "moderately_active", "not_very_active"],
                "question4" => ["yes", "no"],
                "question5" => ["prefer_low_maintenance"]
            ],
        ];

        $matchingPets = [];

        foreach ($pets as $pet => $criteria) {
            $matches = true;
            foreach ($quizAnswers as $question => $answer) {
                if (isset($criteria[$question]) && !in_array($answer, $criteria[$question])) {
                    $matches = false;
                    break;
                }
            }

            if ($matches) {
                $matchingPets[] = $pet;
            }
        }

        // Respond with a list of matching pets
        echo json_encode($matchingPets);
    } else {
        echo json_encode(["error" => "Invalid data"]);
    }
}

error_log("Script execution reached this point");

?>
