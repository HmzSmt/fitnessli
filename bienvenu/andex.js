// Add to your andex.js file
const typedTextElement = document.getElementById("typed-text");
const textToType = "bienvenue";
let currentIndex = 0;

function type() {
  if (currentIndex < textToType.length) {
    typedTextElement.innerHTML += textToType.charAt(currentIndex);
    currentIndex++;
    setTimeout(type, 200); // Adjust the typing speed by changing the 200ms value
  } else {
    document.getElementById("cursor").style.display = "none"; // Hide the cursor after typing is complete
  }
}

setTimeout(type, 1000); // Start the typing animation after a 1s delay
