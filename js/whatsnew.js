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
        name: "Ishigaki Camouflage Inserted Daicock Slim Fit Jeans",
        price: "$385 USD",
        img: "/PICS/WHATSNEW/jean1.webp",
        description: "These distressed skinny jeans feature a classic blue wash, perfect for a casual yet trendy look."
    },
    {
        name: "Seagull Print and Hybrid Ishigaki Camouflage Regular Fit Shirt Jacket",
        price: "$385 USD",
        img: "/PICS/WHATSNEW/jacket1.webp",
        description: "A cozy oversized sweatshirt showcasing a bold graphic design, ideal for staying warm and stylish."
    },
    {
        name: "Floral-Pattern Seagull Embroidery High-Waist Skinny Jeans",
        price: "$325 USD",
        img: "/PICS/WHATSNEW/jean2.webp",
        description: "This classic black leather biker jacket features zipped pockets, perfect for adding an edgy touch to any outfit."
    },
    {
        name: "Seagull Print and Logo Tape Regular Fit Down Jacket",
        price: "$515 USD",
        img: "/PICS/WHATSNEW/jacket2.webp",
        description: "These relaxed fit mom jeans come with a high waist and frayed hem, combining comfort and style effortlessly."
    },
    {
        name: "Brushstroke Seagull Print Straight Fit Jeans",
        price: "$349 USD",
        img: "/PICS/WHATSNEW/jean3.webp",
        description: "A soft cotton fleece sweatshirt featuring an embroidered logo, perfect for a casual, sporty look."
    },
    {
        name: "Allover Logo Jacquard and Seagull Embroidery Boyfriend Fit Denim Shirt Jacket",
        price: "$385 USD",
        img: "/PICS/WHATSNEW/jacket3.webp",
        description: "This classic denim jacket features distressed details, making it a timeless piece for any wardrobe."
    },
    {
        name: "SLEEK PULLOVER SWEATSHIRT WITH RIBBED CUFFS",
        price: "$235 USD",
        img: "/PICS/WHATSNEW/sweatshirt1.webp",
        description: "A sleek pullover sweatshirt with ribbed cuffs, perfect for layering and staying warm on cooler days."
    },
    {
        name: "Deconstructed Contrast Relax Fit Sweatshirt",
        price: "$220 USD",
        img: "/PICS/WHATSNEW/sweatshirt2.webp",
        description: "This relaxed fit boxy jacket features utility pockets, providing both style and functionality for everyday wear."
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
                    <span class = "new">NEW ARRIVAL</span>
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
    window.location.href = 'whatsnew.html';
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
