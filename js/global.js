const addCartBtns = document.querySelectorAll('.add-cart-btn');

addCartBtns.forEach(element => {
    element.addEventListener('click', function cartAdded() {
        alert('Thêm vào giỏ hàng thành công!')
    })
});