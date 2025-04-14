const toggleButton = document.getElementById('toggleButton');
const toggleButtonopen = document.getElementById('toggleButtonopen');
const sidebar = document.getElementById('sidebar');

toggleButton.addEventListener('click', () => {
    if (sidebar.style.display === 'block') {
        sidebar.style.display = 'none'; // Ẩn sidebar
    } else {
        sidebar.style.display = 'block'; // Hiện sidebar
    }
});
toggleButtonopen.addEventListener('click', () => {
    if (sidebar.style.display === 'block') {
        sidebar.style.display = 'none'; // Ẩn sidebar
    } else {
        sidebar.style.display = 'block'; // Hiện sidebar
    }
});
