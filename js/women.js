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

//Products
const products = [
    {
        name: "Dip-dyed Oversize Sweatshirt",
        price: "$235 USD",
        img: "/PICS/WOMEN/sweatshirt1.webp",
        description: "A lightweight, loose-fit blouse adorned with delicate floral embroidery, perfect for achieving a boho-chic look."
    },
    {
        name: "Embossed Slogan Cropped Sweatshirt",
        price: "$219 USD",
        img: "/PICS/WOMEN/sweatshirt2.webp",
        description: "Classic high-waisted straight-leg jeans featuring a vintage wash, offering a timeless and versatile style."
    },
    {
        name: "Graffiti Kamon Print Sweatshirt",
        price: "$259 USD",
        img: "/PICS/WOMEN/sweatshirt3.webp",
        description: "A sleek leather biker jacket with studded details, adding an edgy vibe to any ensemble."
    },
    {
        name: "Deconstructed Seagull Embossed Fashion Fit Skirt-Jeans",
        price: "$385 USD",
        img: "/PICS/WOMEN/jean1.webp",
        description: "A sleek leather biker jacket featuring studded details and an asymmetrical zip, perfect for an edgy, bold look."
    },
    {
        name: "Pixel Seagull Embroidery Relax Jeans",
        price: "$370 USD",
        img: "/PICS/WOMEN/jean2.webp",
        description: "A cozy, oversized hoodie with a vibrant tie-dye design, offering both comfort and style for casual outings."
    },
    {
        name: "Cut-Line Fashion Fit Boot Cut Jeans",
        price: "$330 USD",
        img: "/PICS/WOMEN/jean3.webp",
        description: "Elegant wide-leg palazzo trousers featuring a flowing silhouette, versatile for both formal and casual settings."
    },
    {
        name: "Seagull and Logo Laser Print Fashion Fit Denim Corset Jacket",
        price: "360 USD",
        img: "/PICS/WOMEN/jacket1.webp",
        description: "Trendy denim overalls with multiple front pockets and adjustable straps, giving a playful and practical look."
    },
    {
        name: "Allover Rhinestone Seagull Loose Fit Denim Jacket",
        price: "625 USD",
        img: "/PICS/WOMEN/jacket2.webp",
        description: "A classic slip dress with a satin finish and delicate spaghetti straps, ideal for elegant evening wear or layering."
    }
];

const productsContainer = document.querySelector('.products');
products.forEach((product, index) => {
    const productHTML = (`
                <div class="product" data-aos="zoom-in" data-aos-duration="1500">
                    <a href="product-detail.html?id=${index}">
                        <img alt="${product.name}" src="${product.img}" />
                    </a>
                    <i class="far fa-heart wishlist"></i>
                    <div class="card-info">
                        <h3>
                            <a href="product-detail.html?id=${index}">${product.name}</a>
                        </h3>
                        <div class="price-cart">
                            <p>${product.price}</p>
                            <a class="add-to-cart" href="#">ADD TO CART</a>
                        </div>
                    </div>
                </div>
            `);
    productsContainer.innerHTML += productHTML;
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
    window.location.href = "searchResult.html";
};

// Reset button
const resetButton = document.getElementById('resetSearch');
resetButton.addEventListener('click', () => {
    window.location.href = 'women.html';
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
