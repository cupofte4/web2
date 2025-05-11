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
            var $product = $(this).closest('.item');
            $product.addClass('d-none');
            deleteFromCart($product.data('product-id'));
        };
    });
});

function updateCart(product_id, quantity) {
    $.post('./update_cart.php', { product_id: product_id, quantity: quantity })
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
    $.post('./delete_from_cart.php', { product_id: product_id })
        .done(function (response) {
            // Xử lý dữ liệu trả về nếu cần
            console.log(response);
        })
        .fail(function () {
            // Xử lý khi có lỗi xảy ra
            console.log('Có lỗi xảy ra khi xóa sản phẩm.');
        });
}