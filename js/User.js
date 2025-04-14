document.addEventListener('DOMContentLoaded', function () {
const userIcon = document.querySelector('.fa-user');
const userMenu = document.getElementById('userMenu');

// Toggle User Menu
userIcon.addEventListener('click', function (e) {
    e.preventDefault();
    userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
});

// Close User Menu when clicking outside
document.addEventListener('click', function (e) {
    if (!userMenu.contains(e.target) && !userIcon.contains(e.target)) {
        userMenu.style.display = 'none';
    }
});
});
