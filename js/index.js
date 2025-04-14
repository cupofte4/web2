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
        name: "allover crinkle logo print regular fit padded bomber jacket",
        price: "$385 USD",
        img: "/PICS/MEN/jacket1.jpg",
        description: "Crafted in a muted charcoal gray, this bomber jacket is adorned with subtle, wrinkled EK logo prints that add depth to its design. The front pocket features a refined orange brand woven label, elevating the jacket's overall distinction."
    },
    {
        name: "distressed edges inserted daicock baggy jeans",
        price: "$645 USD",
        img: "/PICS/MEN/jean1.webp",
        description: "These baggy cargo jeans feature an acid wash and multi-pockets, combined with a unique seagull print."
    },
    {
        name: "potassium spray seagull boxy long-sleeve t-shirt",
        price: "$175 USD",
        img: "/PICS/MEN/sweatshirt1.webp",
        description: "Relax in style with this sweatshirt featuring a logo and Ninja Daruma Daicock print for a bold, comfortable look."
    },
    {
        name: "Daruma Leather Patch Denim Jacket",
        price: "$499 USD",
        img: "/PICS/MEN/jacket2.jpg",
        description: "This reversible denim jacket features a vintage tweed and wave print. Perfect for a stylish, boxy fit."
    },
    {
        name: "Seagull Pocket and Slogan Print Relax Fit Sweatshirt",
        price: "$235 USD",
        img: "/PICS/MEN/sweatshirt2.webp",
        description: "Embrace comfort with this relaxed-fit sweatshirt featuring bold graphics and dragon embroidery for a standout look."
    },
    {
        name: "seagull print relax fit denim jacket",
        price: "$579 USD",
        img: "/PICS/MEN/jacket3.jpg",
        description: "This classic denim jacket features a mountain landscape print, providing a rugged yet fashionable look."
    },
    {
        name: "Rseagull and slogan embroidery oversized denim coach jacket",
        price: "$309 USD",
        img: "/PICS/MEN/jacket4.jpg",
        description: "This oversized denim jacket features a bold patchwork and graphic print design, adding a unique retro vibe to any outfit."
    },
    {
        name: "Seagull Metallic Embroidery Carrot Fit Jeans #2017",
        price: "$325 USD",
        img: "/PICS/MEN/jean2.webp",
        description: "These loose-fit jeans have a distressed faded blue wash and utility pockets, perfect for a rugged and stylish look."
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
    window.location.href = 'men.html';
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
