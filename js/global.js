const addCartBtns = document.querySelectorAll('.add-to-cart');

addCartBtns.forEach(element => {
    element.addEventListener('click', function cartAdded() {
        alert('Thêm vào giỏ hàng thành công!')
    })
});