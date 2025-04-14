// === CHÈN SẢN PHẨM TỪ LOCALSTORAGE VÀO HIS.HTML ===
window.onload = function () {
    // Lấy dữ liệu từ localStorage
    let purchaseHistory = JSON.parse(localStorage.getItem('purchaseHistory')) || [];
    let purchaseListEle = document.querySelector('.purchase-list');

    // Nếu có sản phẩm trong lịch sử mua hàng
    if (purchaseHistory.length > 0 && purchaseListEle) {
        // Xóa nội dung cũ (nếu có)
        purchaseListEle.innerHTML = '';

        // Lặp qua các sản phẩm và thêm vào purchase-list
        purchaseHistory.forEach(transaction => {
            const productHtml = `
                <div class="purchase-card">
                    <div class="purchase-content">
                        <img src="${transaction.image}" alt="${transaction.productName}" class="product-image" loading="lazy">
                        <div class="product-details">
                            <div class="product-info">
                                <div class="product-main">
                                    <h2 class="product-name">${transaction.productName}</h2>
                                    <p class="quantity">Quantity: ${transaction.quantity}</p>
                                </div>
                                <div class="price-info">
                                    <p class="date">Order Date: ${transaction.orderDate}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            purchaseListEle.insertAdjacentHTML('beforeend', productHtml);
        });
    } else {
        // Trường hợp không có sản phẩm nào
        purchaseListEle.innerHTML = '<p>Không có sản phẩm nào trong lịch sử mua hàng</p>';
    }
};

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

// Reset button
const resetButton = document.getElementById('resetSearch');
resetButton.addEventListener('click', () => {
    window.location.href = 'home.html';
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

