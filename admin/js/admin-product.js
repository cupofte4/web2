function kiemTra() {

    return true;
}

var loadFile = function(event) {
    var image = document.getElementById('selected-img');
    image.src = URL.createObjectURL(event.target.files[0]);
};

function xacnhan() {
    if(confirm("Bạn có muốn tiếp tục?")) {
        return true;
    }
    return false;
}