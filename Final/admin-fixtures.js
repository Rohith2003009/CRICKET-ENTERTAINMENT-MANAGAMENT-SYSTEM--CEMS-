document.addEventListener("DOMContentLoaded", function () {
    const matchCards = document.querySelectorAll(".match-card");

    matchCards.forEach((card, index) => {
        // Delayed fade-in effect for smooth entry animation
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";
        setTimeout(() => {
            card.style.transition = "opacity 0.6s ease-out, transform 0.6s ease-out";
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        }, index * 200);

        // Add hover animation for match card
        card.addEventListener("mouseenter", function () {
            card.style.transform = "scale(1.05)";
            card.style.boxShadow = "0 8px 20px rgba(0, 0, 0, 0.4)";
            showDetails(card);
        });

        card.addEventListener("mouseleave", function () {
            card.style.transform = "scale(1)";
            card.style.boxShadow = "0 6px 15px rgba(0, 0, 0, 0.3)";
            hideDetails(card);
        });
    });
});

// Function to show extra details with a fade-in effect
function showDetails(cardElement) {
    const extraDetails = cardElement.querySelector(".extra-details");
    if (extraDetails) {
        extraDetails.style.opacity = "0";
        extraDetails.style.display = "block";
        setTimeout(() => {
            extraDetails.style.transition = "opacity 0.5s ease-in-out";
            extraDetails.style.opacity = "1";
        }, 10);
    }
}

// Function to hide extra details with a fade-out effect
function hideDetails(cardElement) {
    const extraDetails = cardElement.querySelector(".extra-details");
    if (extraDetails) {
        extraDetails.style.transition = "opacity 0.5s ease-in-out";
        extraDetails.style.opacity = "0";
        setTimeout(() => {
            extraDetails.style.display = "none";
        }, 500);
    }
}
