function CartDATA() {
    // Lấy dữ liệu từ localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let cartDetails = JSON.parse(localStorage.getItem('cartDetails'));
    let summaryContent = document.querySelector('.summary-content');

    if (cart.length > 0 && summaryContent) {
        // Xóa nội dung cũ nếu có, để tránh việc lặp lại các sản phẩm cũ
        summaryContent.innerHTML = '';

        // Thêm sản phẩm từ giỏ hàng vào phần "Order Summary"
        cart.forEach(product => {
            // Tạo phần tử HTML cho mỗi sản phẩm trong giỏ hàng
            let productItem = document.createElement('div');
            productItem.classList.add('product-item');
            productItem.innerHTML = `
                <div>
                    <h5>${product.name}</h5>
                    <p>Qty: ${product.count}</p>
                </div>
                <span>$${(product.price * product.count).toFixed(2)}</span>
            `;

            summaryContent.appendChild(productItem);
        });

        if (cartDetails) {
            let discountRow = document.createElement('div');
            discountRow.classList.add('summary-row');
            discountRow.innerHTML = `
                <span>Discount</span>
                <span>-$${cartDetails.discountMoney.toFixed(2)}</span>
            `;
            summaryContent.appendChild(discountRow);

            // Thêm VAT
            let vatRow = document.createElement('div');
            vatRow.classList.add('summary-row');
            vatRow.innerHTML = `
                <span>VAT (8%)</span>
                <span>$${cartDetails.vat.toFixed(2)}</span>
            `;
            summaryContent.appendChild(vatRow);

            // Thêm tổng tiền sau khi tính giảm giá và VAT
            let totalRow = document.createElement('div');
            totalRow.classList.add('total-row');
            totalRow.innerHTML = `
                <span>Total</span>
                <span>$${cartDetails.totalAfterVat.toFixed(2)}</span>
            `;
            summaryContent.appendChild(totalRow);
        }

    } else {
        // Nếu không có sản phẩm nào, hiển thị thông báo rỗng
        summaryContent.innerHTML = '<p>No items in your cart</p>';
    }
}

// Khi trang được tải, kiểm tra và hiển thị giỏ hàng nếu đang ở trang thanh toán
window.onload = function() {
    if (window.location.pathname.includes('payment.html')) {
        CartDATA();
    }
};

// === Chuyển dữ liệu từ localStorage của Payment sang Purchase History chỉ với thông tin cần thiết ===
function completePurchase() {
    // Lấy dữ liệu từ localStorage
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (cart.length > 0) {
        // Tạo danh sách đơn hàng để lưu vào "purchaseHistory"
        const purchaseHistory = JSON.parse(localStorage.getItem('purchaseHistory')) || [];

        // Lưu thông tin cho từng sản phẩm trong giỏ hàng
        cart.forEach(product => {
            let newTransaction = {
                orderDate: new Date().toLocaleDateString(), // Ngày đặt hàng
                productName: product.name, // Tên sản phẩm
                quantity: product.count, // Số lượng sản phẩm
                image: product.image // Đường dẫn hình ảnh sản phẩm
            };

            // Thêm giao dịch mới vào lịch sử mua hàng
            purchaseHistory.push(newTransaction);
        });

        // Lưu lại vào localStorage với tên "purchaseHistory"
        localStorage.setItem('purchaseHistory', JSON.stringify(purchaseHistory));

        // Xóa giỏ hàng sau khi hoàn thành giao dịch
        localStorage.removeItem('cart');
        localStorage.removeItem('cartDetails');
        alert("Purchase completed successfully!");

        // Chuyển hướng về trang lịch sử mua hàng
        window.location.href = "/Html/his.html";
    } else {
        alert("Your cart is empty or there is an issue with payment.");
    }
}

// Gắn sự kiện click cho nút "Complete Purchase"
document.querySelector('.purchase-btn').addEventListener('click', completePurchase);
