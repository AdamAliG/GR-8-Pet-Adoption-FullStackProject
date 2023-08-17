document.getElementById("submit-quiz").addEventListener("click", submitQuiz);

function submitQuiz() {
  // Collect user's quiz answers and package them as an object
  const quizAnswers = {
    question1: document.querySelector('input[name="question1"]:checked').value,
    question2: document.querySelector('input[name="question2"]:checked').value,
    question3: document.querySelector('input[name="question3"]:checked').value,
    question4: document.querySelector('input[name="question4"]:checked').value,
    question5: document.querySelector('input[name="question5"]:checked').value,
  };

  console.log("Quiz Answers:", quizAnswers);

  fetch("match_pets.php", {
    method: "POST",
    body: JSON.stringify({ quizAnswers }), // Wrap quizAnswers in an object
  })
  .then(response => response.json())
  .then(data => {
    console.log("Received matching pets:", data);
    // Call a function to update UI with matched pets
    displayMatchedPets(data);
  });
}

function displayMatchedPets(matchedPets) {
  const matchedPetsList = document.getElementById("matched-pets-list");

  // Clear existing content
  matchedPetsList.innerHTML = "";

  matchedPets.forEach(petName => {
    const petItem = document.createElement("li");
    petItem.textContent = petName;
    matchedPetsList.appendChild(petItem);
  });
}
