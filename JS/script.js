document.addEventListener('DOMContentLoaded', () => {
    let currentVisitorCount = Math.floor(Math.random() * 101) + 100;

    const updateVisitorCount = () => {
        const variation = Math.floor(Math.random() * 21) - 10; 
        currentVisitorCount = Math.max(1, currentVisitorCount + variation);

        const visitorCountElement = document.getElementById('visitorCount');
        if (visitorCountElement) {
            visitorCountElement.innerText = `${currentVisitorCount}`;
        }
    };

    updateVisitorCount();
    setInterval(updateVisitorCount, 5000);
});

document.addEventListener('DOMContentLoaded', () => {
    const nameInput = document.getElementById('name');
    const submitBtn = document.getElementById('submitBtn');

    nameInput.addEventListener('input', () => {
        if (nameInput.value.trim() !== '') {
            submitBtn.classList.add('visible');
        } else {
            submitBtn.classList.remove('visible');
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const goToRegisterBtn = document.getElementById('goToRegister');
    const loginContainer = document.querySelector('.form-container');
    const registerContainer = document.getElementById('registerContainer');

    goToRegisterBtn.addEventListener('click', () => {
        loginContainer.style.display = 'none';
        registerContainer.style.display = 'block';
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var loggedIn = document.cookie.split(';').some(function(item) {
        return item.trim().indexOf('loggedin=') == 0;
    });

    if (loggedIn) {
        document.getElementById('authBtn').style.display = 'none';
        document.getElementById('cmdBtn').style.display = 'block';
        document.getElementById('logoutBtn').style.display = 'block';
        document.getElementById('resBtn').style.display = 'block';
    } else {
        document.getElementById('authBtn').style.display = 'block';
        document.getElementById('cmdBtn').style.display = 'none';
        document.getElementById('logoutBtn').style.display = 'none';
        document.getElementById('resBtn').style.display = 'none';
    }
});