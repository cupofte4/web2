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

$(document).ready(function () {
    $('.spinner-next').click(function () {
        var $input = $(this).closest('.spinner').find('.spinner-number');
        var value = parseInt($input.val());
        $input.val(value + 1);
        updateCart($input.data('product-id'), $input.val());
    });

    $('.spinner-prev').click(function () {
        var $input = $(this).closest('.spinner').find('.spinner-number');
        var value = parseInt($input.val());
        if (value > 1) {
            $input.val(value - 1);
        }
        updateCart($input.data('product-id'), $input.val());
    });

    $('.delete-from-cart').click(function () {
        if (confirm("Bạn có chắc muốn xóa sản phẩm khỏi giỏ hàng?")) {
            var $product = $(this).closest('.cart-dropdown-item');
            $product.addClass('d-none');
            deleteFromCart($product.data('product-id'));
        };
    });

    $('.add-to-cart').click(function () {
        var $product = $(this);
        addToCart($product.data('product-id'));
    });
});

function updateCart(product_id, quantity) {
    $.post('./pages/update_cart.php', { product_id: product_id, quantity: quantity })
        .done(function (response) {
            // Xử lý dữ liệu trả về nếu cần
            console.log(response);
        })
        .fail(function () {
            // Xử lý khi có lỗi xảy ra
            console.log('Có lỗi xảy ra khi cập nhật giỏ hàng.');
        });
}

function deleteFromCart(product_id) {
    $.post('./pages/delete_from_cart.php', { product_id: product_id })
        .done(function (response) {
            // Xử lý dữ liệu trả về nếu cần
            console.log(response);
        })
        .fail(function () {
            // Xử lý khi có lỗi xảy ra
            console.log('Có lỗi xảy ra khi xóa sản phẩm.');
        });
}

function addToCart(product_id) {
    $.post('./pages/add_to_cart.php', { product_id: product_id})
        .done(function (response) {
            // Xử lý dữ liệu trả về nếu cần
            alert("Thêm thành công!");
            location.reload();
        })
        .fail(function () {
            // Xử lý khi có lỗi xảy ra
            console.log('Có lỗi xảy ra khi cập nhật giỏ hàng.');
        });
}