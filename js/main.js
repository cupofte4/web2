
document.addEventListener('DOMContentLoaded', function() {
    initializeStickyHeader();
    initializeUserMenu();
    initializeSearch();
    initializeWishlist();
});


function initializeStickyHeader() {
    const header = document.querySelector(".sticky-header");
    if (!header) return;

    const sticky = header.offsetTop;
    window.onscroll = function() {
        if (window.scrollY > sticky) {
            header.classList.add("sticky");
        } else {
            header.classList.remove("sticky");
        }
    };
}


function initializeUserMenu() {
    const userIcon = document.querySelector('.fa-user');
    const userMenu = document.getElementById('userMenu');
    
    if (!userIcon || !userMenu) return;

    userIcon.addEventListener('click', function(e) {
        e.preventDefault();
        userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
    });

 
    document.addEventListener('click', function(e) {
        if (!userMenu.contains(e.target) && !userIcon.contains(e.target)) {
            userMenu.style.display = 'none';
        }
    });
}


function initializeSearch() {
    const searchIcon = document.querySelector('.search-icon');
    const searchBox = document.querySelector('.search-box');
    const closeBtn = document.querySelector('#closeSearch');
    const headerIcons = document.querySelector('.header-icons');
    const searchInput = document.querySelector('#searchInput');
    const advancedSearchToggle = document.querySelector('#advancedSearchToggle');
    const advancedSearch = document.querySelector('#advancedSearch');
    const categoryFilter = document.querySelector('#categoryFilter');
    const minPrice = document.querySelector('#minPrice');
    const maxPrice = document.querySelector('#maxPrice');
    const applySearch = document.querySelector('#applySearch');
    const resetSearch = document.querySelector('#resetSearch');

    if (!searchIcon || !searchBox || !closeBtn || !headerIcons) return;

 
    searchIcon.addEventListener('click', function(e) {
        e.preventDefault();
        headerIcons.classList.add('expanded');
        searchBox.style.display = 'block';
        searchInput.focus();
    });

    closeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        headerIcons.classList.remove('expanded');
        searchBox.style.display = 'none';
        advancedSearch.classList.remove('show');
    });


    if (advancedSearchToggle && advancedSearch) {
        advancedSearchToggle.addEventListener('click', function(e) {
            e.preventDefault();
            advancedSearch.classList.toggle('show');
        });

     
        document.addEventListener('click', function(e) {
            if (!advancedSearch.contains(e.target) && !advancedSearchToggle.contains(e.target)) {
                advancedSearch.classList.remove('show');
            }
        });
    }

  
    if (applySearch) {
        applySearch.addEventListener('click', function(e) {
            e.preventDefault();
            performSearch();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });
    }

    if (resetSearch) {
        resetSearch.addEventListener('click', function(e) {
            e.preventDefault();
            searchInput.value = '';
            if (categoryFilter) categoryFilter.value = '';
            if (minPrice) minPrice.value = '';
            if (maxPrice) maxPrice.value = '';
            performSearch();
        });
    }


    if (categoryFilter) {
        categoryFilter.addEventListener('change', performSearch);
    }
}


function performSearch() {
    const searchInput = document.querySelector('#searchInput');
    const categoryFilter = document.querySelector('#categoryFilter');
    const minPrice = document.querySelector('#minPrice');
    const maxPrice = document.querySelector('#maxPrice');
    const productsContainer = document.querySelector('.products');

    if (!productsContainer) {
        console.error('Products container not found');
        return;
    }

    const query = searchInput.value;
    const category = categoryFilter.value;
    const minPriceValue = minPrice.value;
    const maxPriceValue = maxPrice.value;


    productsContainer.innerHTML = '<div class="loading">Đang tìm kiếm...</div>';

    const searchParams = new URLSearchParams();
    if (query) searchParams.append('query', query);
    if (category) searchParams.append('category', category);
    if (minPriceValue) searchParams.append('min_price', minPriceValue);
    if (maxPriceValue) searchParams.append('max_price', maxPriceValue);

   
    fetch(`pages/search.php?${searchParams.toString()}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.message);
            }
            displaySearchResults(data.products);
        })
        .catch(error => {
            console.error('Search error:', error);
            productsContainer.innerHTML = `<p class="no-results">Có lỗi xảy ra: ${error.message}</p>`;
        });
}


function displaySearchResults(products) {
    const productsContainer = document.querySelector('.products');
    if (!productsContainer) return;

    if (!products || products.length === 0) {
        productsContainer.innerHTML = '<p class="no-results">Không tìm thấy sản phẩm nào.</p>';
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
            <a href="pages/product-detail.php?id=${product.id}">
                <img src="images/products/${product.image}" alt="${product.name}" />
            </a>
            <i class="far fa-heart wishlist"></i>
            <div class="card-info">
                <h3>
                    <a href="pages/product-detail.php?id=${product.id}">${product.name}</a>
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
}


function initializeWishlist() {
    const wishlists = document.querySelectorAll('.wishlist');
    wishlists.forEach(wishlist => {
        wishlist.addEventListener('click', function() {
            this.classList.toggle('active');
           
        });
    });
} 