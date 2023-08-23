<?php
session_start();
require_once "../db_connect.php";
require_once "../file_upload.php";
require_once "../public/functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <title>Resources</title>
</head>

<body>
    <?php
    if (isset($_SESSION["user"])) {
        require_once "../navbar_sub.php";
    }
    if (isset($_SESSION["admin"])) {
        require_once "../navbar_admin_sub.php";
    }
    ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="row">
                        <p class="card-title fs-4 fw-semibold text-center">Perfect nutrition for you pet</p>
                    </div>
                    <div class="row mt-5">
                        <div class="col">
                            <p>Providing optimal nutrition for your newly adopted pet is paramount for their well-being and happiness. A wholesome diet tailored to their species, age, and health requirements lays the foundation for a vibrant life. Whether you've welcomed a playful puppy, a curious kitten, or a feathered friend, research their dietary needs and consult a veterinarian for guidance.</p>
                            <hr>
                            <p>For canines and felines, a balanced mix of high-quality protein, essential fats, and vital nutrients supports growth and vitality. Introduce them to their new diet gradually to avoid digestive upsets. Herbivores like rabbits or guinea pigs thrive on fresh hay, leafy greens, and limited pellets rich in fiber. Birds, depending on their species, may need seeds, fruits, vegetables, and occasional protein sources. Remember, portion control is key to preventing obesity.</p>
                            <hr>
                            <p>In conclusion, investing time to understand your pet's nutritional requirements ensures a rewarding companionship journey. A proper diet boosts their immune system, energy levels, and overall happiness, ensuring you both share many joyful and healthy years together.</p>
                        </div>
                        <div class="col">
                            <img class="img-fluid rounded" src="https://www.boredpanda.com/blog/wp-content/uploads/2016/01/funny-animals-eating-52__605.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="row">
                        <p class="card-title fs-4 fw-semibold text-center">Find the best training for your animal</p>
                    </div>
                    <div class="row mt-5">
                        <div class="col">
                            <img class="img-fluid rounded" src="https://www.thestar.co.uk/webimg/b25lY21zOmQ1NDNmZjNhLWJlZDMtNDAzNC04OWRjLWQ2NGE3NzJmYjA5NjpjNThhMDYxNC1mMGUwLTRmMDYtYTg3My0wNTcxMjAwODdjNDE=.jpg?crop=3:2&width=640" alt="">
                        </div>
                        <div class="col">
                            <p>Engaging your adopted pet in interactive training sessions is not only a rewarding bonding experience but also crucial for their mental and physical well-being. For dogs, positive reinforcement techniques like treats and praise can teach commands, foster obedience, and enhance communication. Regular walks and engaging games like fetch ensure they stay active and happy.</p>
                            <hr>
                            <p>Cats thrive on mental stimulation, benefiting from puzzle toys and agility training. Teaching tricks like high fives keeps their minds sharp. Enrich their environment with scratching posts and climbing structures. Small pets like guinea pigs enjoy clicker training, creating a unique channel of communication. Interactive toys and obstacle courses keep them mentally engaged. Tailoring activities to your pet's species and personality ensures a fulfilling companionship while strengthening the human-animal bond.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="row">
                        <p class="card-title fs-4 fw-semibold text-center">Get the right supplies for your pet</p>
                    </div>
                    <div class="row mt-5">
                        <div class="col">
                            <img class="img-fluid rounded" src="https://static.independent.co.uk/s3fs-public/thumbnails/image/2020/04/06/15/online-pet-stores-delivering-lockdown.jpg?quality=75&width=990&crop=3%3A2%2Csmart&auto=webp" alt="">
                        </div>
                        <div class="col">
                            <p>When welcoming an adopted pet into your home, ensuring you have the right supplies is crucial for their comfort and well-being. For a dog or cat, essentials include food and water bowls, a cozy bed, appropriate toys for mental stimulation, a collar and leash, grooming tools, and a litter box for cats. Researching your pet's specific breed or needs can guide you in selecting the right items.</p>
                            <hr>
                            <p>For a small pet like a guinea pig, you'll need a spacious cage, bedding material, a water bottle, hay rack, and guinea pig-specific food. A hideout and toys can help keep them entertained. Adopting a bird demands a spacious cage, perches of varying textures and sizes, a balanced diet, water and food dishes, and mentally enriching toys. No matter the adopted pet, a visit to the veterinarian is crucial to ensure they are up-to-date on vaccinations and to discuss any other specific requirements.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>