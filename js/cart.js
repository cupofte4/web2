
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
          // Nếu là thẻ <a> thì không gọi addToCart
    if ($(this).prop("tagName").toLowerCase() === 'a') {
        return; // để trình duyệt tự chuyển hướng tới login.php
    }

    var $product = $(this);
    addToCart($product.data('product-id'));
    });
    $('.btn-cart').click(function () {
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