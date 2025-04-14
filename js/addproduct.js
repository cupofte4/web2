document.addEventListener('DOMContentLoaded', function () {
    // Gắn sự kiện cho các nút "ADD TO CART"
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Lấy thông tin sản phẩm từ phần tử cha gần nhất có class "product"
            const productElement = this.closest('.product');
            const productDetails = getProductDetails(productElement);

            if (productDetails) {
                // Lấy giỏ hàng từ localStorage hoặc tạo mảng rỗng nếu chưa có giỏ hàng
                let cart = JSON.parse(localStorage.getItem('cart')) || [];

                // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
                const existingProduct = cart.find(item => item.id === productDetails.id);
                if (existingProduct) {
                    existingProduct.count += 1; // Tăng số lượng nếu sản phẩm đã có trong giỏ hàng
                } else {
                    productDetails.count = 1; // Khởi tạo số lượng là 1 nếu sản phẩm mới
                    cart.push(productDetails); // Thêm sản phẩm vào giỏ hàng
                }

                // Lưu lại giỏ hàng đã cập nhật vào localStorage
                localStorage.setItem('cart', JSON.stringify(cart));

                // Thông báo cho người dùng
                alert(`${productDetails.name} has been added to your cart!`);
            }
        });
    });

    // Hàm lấy thông tin sản phẩm
    function getProductDetails(productElement) {
        if (!productElement) return null;

        // Lấy tên sản phẩm và tạo ID dựa trên tên
        const productName = productElement.querySelector('h3 a').textContent.trim();
        const productId = generateIdFromName(productName);

        return {
            id: productId, // ID dựa trên tên sản phẩm
            name: productName, // Tên sản phẩm
            price: extractPrice(productElement.querySelector('.price-cart p').textContent.trim()), // Giá sản phẩm
            image: productElement.querySelector('img').src // Link hình ảnh sản phẩm
        };
    }

    // Hàm chuyển đổi tên sản phẩm thành ID hợp lệ
    function generateIdFromName(name) {
        return name
            .toLowerCase() // Chuyển thành chữ thường
            .replace(/[^a-z0-9\s-]/g, '') // Loại bỏ ký tự đặc biệt
            .replace(/\s+/g, '-') // Thay khoảng trắng bằng dấu gạch ngang
            .trim(); // Loại bỏ khoảng trắng thừa
    }

    // Hàm tách số từ chuỗi giá
    function extractPrice(priceString) {
        const price = priceString.match(/\d+/g); // Lấy tất cả các số từ chuỗi
        return price ? parseInt(price.join('')) : 0; // Chuyển đổi thành số nguyên
    }
});
