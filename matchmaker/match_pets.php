<?php

header("Access-Control-Allow-Origin: http://localhost");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    


    if (isset($data["quizAnswers"])) {
        $quizAnswers = $data["quizAnswers"];
        
        $pets = [
            "dog" => [
                "living_situation" => ["house"],
                "dedicated_time" => ["lots"],
                "active_level" => ["very_active", "moderately_active"],
                "other_pets" => ["yes", "no"],
                "maintenance" => ["enjoy_grooming"]
            ],
            "cat" => [
                "living_situation" => ["apartment", "house"],
                "dedicated_time" => ["lots", "moderate"],
                "active_level" => ["moderately_active", "not_very_active"],
                "other_pets" => ["yes", "no"],
                "maintenance" => ["enjoy_grooming", "okay_with_grooming"]
            ],
            "bird" => [
                "living_situation" => ["house", "apartment"],
                "dedicated_time" => ["lots", "moderate", "little"],
                "active_level" => ["not_very_active"],
                "other_pets" => ["no"],
                "maintenance" => ["okay_with_grooming", "prefer_low_maintenance"]
            ],
            "hamster" => [
                "living_situation" => ["house", "apartment"],
                "dedicated_time" => ["moderate", "little"],e ma
                "active_level" => ["not_very_active"],
                "other_pets" => ["yes"],
                "maintenance" => ["prefer_low_maintenance"]
            ],
            "fish" => [
                "living_situation" => ["house", "apartment"],
                "dedicated_time" => ["little"],
                "active_level" => ["not_very_active"],
                "other_pets" => ["yes", "no"],
                "maintenance" => ["prefer_low_maintenance"]
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
