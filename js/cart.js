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
// === HELP FUNCTIONS ===
// Random id
function randomId() {
    return Math.floor(Math.random() * 10000);
}

let products = [];

// Danh sách promotion code (Mã giảm giá)
let promotionCode = {
    GIAM10: 10,
    GIAM20: 20,
};

function Savedata(discountMoney, totalMoney, vat, totalAfterVat){
    const cartDetails = {
        discountMoney: discountMoney,
        totalMoney: totalMoney,
        vat: vat,
        totalAfterVat: totalAfterVat,
    };
    localStorage.setItem('cartDetails', JSON.stringify(cartDetails));
}


// === TRUY CẬP VÀO CÁC THÀNH PHẦN ===
let productsEle = document.querySelector('.products');

let subTotalEl = document.querySelector('.subtotal span');

let discount = document.querySelector('.discount');
let discountEle = document.querySelector('.discount span');
let totalEle = document.querySelector('.total span');

let btnPromotion = document.querySelector('.promotion button');
let inputPromotion = document.querySelector('#promo-code');
let vatEl = document.querySelector('.vat span');

// === MAIN FUNCTION ===
function renderUI(arr) {
    productsEle.innerHTML = '';

    // Cập nhật số lượng sản phẩm trong cart
    let countEle = document.querySelector('.count');
    countEle.innerText = `${updateTotalItem(arr)} items in the bag`;

    // Cập nhật tổng tiền
    updateTotalMoney(arr);

    if (arr.length == 0) {
        productsEle.insertAdjacentHTML(
            'afterbegin',
            '<li>Không có sản phẩm nào trong giỏ hàng</li>'
        );
        document.querySelector('.option-container').style.display = 'none';
        return;
    }

    for (let i = 0; i < arr.length; i++) {
        const p = arr[i];
        productsEle.innerHTML += `
            <li class="row">
                <div class="col left">
                    <div class="thumbnail">
                        <a href="/Html/product-detail.html">
                            <img src="${p.image}" alt="${p.name}">
                        </a>
                    </div>
                    <div class="detail">
                        <div class="name"><a href="/Html/product-detail.html">${p.name}</a></div>
                        <div class="price">$ ${p.price.toFixed(2)}</div> 
                    </div>
                </div>
                <div class="col right">
                    <div class="quantity">
                        <input 
                            type="number" 
                            class="quantity" 
                            step="1" 
                            value="${p.count}" 
                            onchange="changeTotalProduct('${p.id}', event)"
                        >
                    </div>
                    <div class="remove">
                        <span class="close" onclick="removeItem('${p.id}')">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </li>
        `;
    }
}


// Cập nhật số lượng sản phẩm
function updateTotalItem(arr) {
    let total = 0;
    for (let i = 0; i < arr.length; i++) {
        const p = arr[i];
        total += p.count;
    }
    return total;
}

// Remove item trong cart
function removeItem(id) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(product => product.id !== id);

    localStorage.setItem('cart', JSON.stringify(cart));

    products = cart;

    renderUI(products);
}

// Thay đổi số lượng sản phẩm
function changeTotalProduct(id, e) {
    if (Number(e.target.value) < 1) {
        e.target.value = 1;
    }
    for (let i = 0; i < products.length; i++) {
        if (products[i].id == id) {
            products[i].count = Number(e.target.value);
        }
    }
    localStorage.setItem('cart', JSON.stringify(products));
    updateTotalMoney(products);
    renderUI(products);
}

// Kiểm tra mã giảm giá
function checkPromotion() {
    let value = inputPromotion.value.trim();
    if (promotionCode[value]) {
        return promotionCode[value];
    }
    return 0;
}

// Cập nhật tổng tiền
function updateTotalMoney(arr) {
    // Tính tổng tiền cart
    let totalMoney = 0;
    let discountMoney = 0;

    for (let i = 0; i < arr.length; i++) {
        const p = arr[i];
        totalMoney += p.count * p.price;
    }

    // Kiểm tra mã giảm giá
    let discountPercent = checkPromotion();

    // Nếu mã hợp lệ, tính giảm giá
    if (discountPercent) {
        discountMoney = (totalMoney * discountPercent) / 100;
    }

    let vat = totalMoney * 0.08;

    // Tổng sau khi tính giảm giá và VAT
    let totalAfterVat = totalMoney - discountMoney + vat;
    
    // Lưu vào localStorage
    Savedata(discountMoney, totalMoney, vat, totalAfterVat);
    
    // Cập nhật UI, đảm bảo phần giảm giá luôn hiện
    subTotalEl.innerText = `$ ${totalMoney.toFixed(2)}`;
    discountEle.innerText = `$ ${discountMoney.toFixed(2)}`;
    vatEl.innerText = `$ ${vat.toFixed(2)}`;
    totalEle.innerText = `$ ${totalAfterVat.toFixed(2)}`;

    // Đảm bảo phần tử giảm giá không bị ẩn dù giá trị là 0
    discount.classList.remove('hide');
}

// Thêm sự kiện click cho nút áp dụng mã giảm giá
btnPromotion.addEventListener('click', function () {
    updateTotalMoney(products);
});

// Khi tải lại trang, lấy dữ liệu giỏ hàng từ localStorage
window.onload = function() {
    // Lấy dữ liệu giỏ hàng từ localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    products = cart;
    renderUI(cart);
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