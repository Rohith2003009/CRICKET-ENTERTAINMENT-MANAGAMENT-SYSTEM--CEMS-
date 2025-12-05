document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('.squad-container');
    setTimeout(() => {
        container.classList.add('show'); // Make div appear smoothly on page load
    }, 200);
});

document.getElementById('omanButton').addEventListener('click', function () {
    showPlayers('oman');
});

document.getElementById('indiaButton').addEventListener('click', function () {
    showPlayers('india');
});

function showPlayers(team) {
    const container = document.querySelector('.squad-container');
    const omanPlayers = document.getElementById('omanPlayers');
    const indiaPlayers = document.getElementById('indiaPlayers');

    // Hide with smooth effect before switching
    container.classList.remove('show');

    setTimeout(() => {
        if (team === 'oman') {
            omanPlayers.style.display = 'flex';
            indiaPlayers.style.display = 'none';
            setActiveButton('omanButton');
        } else {
            indiaPlayers.style.display = 'flex';
            omanPlayers.style.display = 'none';
            setActiveButton('indiaButton');
        }
        
        // Show again after switching
        container.classList.add('show');
    }, 300);
}

function setActiveButton(activeButtonId) {
    const buttons = document.querySelectorAll('.pill-button');
    buttons.forEach(button => {
        button.classList.remove('active');
    });
    document.getElementById(activeButtonId).classList.add('active');
}
