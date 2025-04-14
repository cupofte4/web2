
document.addEventListener('DOMContentLoaded', function () {
    const wishlists = document.querySelectorAll('.wishlist');
    wishlists.forEach(wishlist => {
        wishlist.addEventListener('click', function () {
            this.classList.toggle('active');
        });
    });
    // lưu vào localstore
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Lấy thông tin sản phẩm từ DOM
            const productElement = this.closest('.product');
            const product = {
                id: productElement.id,
                name: productElement.querySelector('h3').textContent.trim(),
                price: extractPrice(productElement.querySelector('.price-cart p').textContent.trim()),
                image: productElement.querySelector('img').src,
                count: 1
            };

            // Lấy giỏ hàng từ localStorage, hoặc tạo giỏ hàng mới nếu chưa có
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
            const existingProduct = cart.find(item => item.id === product.id);
            if (existingProduct) {
                existingProduct.count += 1;
            } else {
                cart.push(product);
            }

            // Lưu lại giỏ hàng đã cập nhật vào localStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // Thông báo cho người dùng
            alert('Product added to cart!');
        });
    });

    // Hàm tách số từ chuỗi giá
    function extractPrice(priceString) {
        const price = priceString.match(/\d+/g); // Lấy tất cả các số từ chuỗi
        return price ? parseInt(price.join('')) : 0; // Chuyển đổi thành số nguyên
    }
});
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
    window.location.href = "searchResult.html";
};

// Reset button
const resetButton = document.getElementById('resetSearch');
resetButton.addEventListener('click', () => {
    window.location.href = 'KID.html';
});

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
