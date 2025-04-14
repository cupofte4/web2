
document.addEventListener('DOMContentLoaded', function() {
    initializeProducts();
    initializeAddToCart();
});


function initializeProducts() {
    const productsContainer = document.querySelector('.products');
    if (!productsContainer) return;

   
    const isIndexPage = window.location.pathname.endsWith('index.php');
    const categoryId = new URLSearchParams(window.location.search).get('category_id');

    if (isIndexPage) {
 
        return;
    } else if (categoryId) {
      
        loadCategoryProducts(categoryId);
    }
}


function loadCategoryProducts(categoryId) {
    const productsContainer = document.querySelector('.products');
    if (!productsContainer) return;

    productsContainer.innerHTML = '<div class="loading">Đang tải sản phẩm...</div>';

    fetch(`get_products.php?category=${categoryId}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(products => {
            displayProducts(products);
        })
        .catch(error => {
            console.error('Error loading products:', error);
            productsContainer.innerHTML = '<p class="error">Error loading products. Please try again later.</p>';
        });
}


function displayProducts(products) {
    const productsContainer = document.querySelector('.products');
    if (!productsContainer) return;

    if (!products || products.length === 0) {
        productsContainer.innerHTML = '<p class="no-results">Không có sản phẩm nào.</p>';
        return;
    }

    productsContainer.innerHTML = '';
    products.forEach(product => {
        const productElement = document.createElement('div');
        productElement.className = 'product';
        productElement.setAttribute('data-aos', 'zoom-in');
        productElement.setAttribute('data-aos-duration', '1500');

        const formattedPrice = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(product.price);

        productElement.innerHTML = `
            <a href="product-detail.php?id=${product.id}">
                <img src="../images/products/${product.image}" alt="${product.name}" />
            </a>
            <i class="far fa-heart wishlist"></i>
            <div class="card-info">
                <h3>
                    <a href="product-detail.php?id=${product.id}">${product.name}</a>
                </h3>
                <div class="price-cart">
                    <p>${formattedPrice}</p>
                    <a class="add-to-cart" href="#" data-product-id="${product.id}">ADD TO CART</a>
                </div>
            </div>
        `;

        productsContainer.appendChild(productElement);
    });

    initializeWishlist();
    initializeAddToCart();
}


function initializeAddToCart() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            addToCart(productId);
        });
    });
}


function addToCart(productId) {
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Sản phẩm đã được thêm vào giỏ hàng!');
         
        } else {
            throw new Error(data.message || 'Có lỗi xảy ra khi thêm vào giỏ hàng');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message);
    });
} 