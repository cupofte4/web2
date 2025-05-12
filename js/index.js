// Sticky Header
window.onscroll = function () { stickyHeader(); };
var header = document.querySelector(".sticky-header");
var sticky = header.offsetTop;
function stickyHeader() {
    if (window.scrollY > sticky) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
}

// Wishlist
document.addEventListener('DOMContentLoaded', function () {
    const wishlists = document.querySelectorAll('.wishlist');
    wishlists.forEach(wishlist => {
        wishlist.addEventListener('click', function () {
            this.classList.toggle('active');
        });
    });
});

// Search box
const searchIcon = document.querySelector('.search-icon');
const closeSearch = document.querySelector('#closeSearch');
const headerIcons = document.querySelector('.header-icons');

searchIcon.addEventListener('click', function (e) {
    e.preventDefault();
    headerIcons.classList.add('expanded');
});

closeSearch.addEventListener('click', function (e) {
    e.preventDefault();
    headerIcons.classList.remove('expanded');
});

// Search button
document.getElementById("applySearch").onclick = function () {
    window.location.href = "../pages/search.php";
};


// Toggle advanced search panel
advancedSearchToggle.addEventListener('click', () => {
    advancedSearch.classList.toggle('show');
});

// Close advanced search when clicking outside
document.addEventListener('click', (e) => {
    if (!advancedSearch.contains(e.target) && !advancedSearchToggle.contains(e.target)) {
        advancedSearch.classList.remove('show');
    }
});

// Giỏ hàng
document.addEventListener("DOMContentLoaded", function () {
    const cartToggle = document.querySelector(".js-toggle-cart");
    const cartDropdown = document.querySelector(".js-cart-dropdown");

    cartToggle.addEventListener("click", function (e) {
        e.stopPropagation();
        cartDropdown.classList.toggle("show");
    });

    // Ẩn dropdown nếu click bên ngoài
    document.addEventListener("click", function (e) {
        if (!cartDropdown.contains(e.target) && !cartToggle.contains(e.target)) {
            cartDropdown.classList.remove("show");
        }
    });
});

