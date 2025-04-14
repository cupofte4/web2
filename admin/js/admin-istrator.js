function changeStatus() {
    if (confirm("Bạn có chắc chắn muốn tiếp tục?")) return true;
    return false;
}


function checkForm() {
    var userName = document.querySelector('#admin-username').value;
    var fullName = document.querySelector('#admin-fullname').value;
    var email = document.querySelector('#admin-email').value;
    var phone = document.querySelector('#admin-phone').value;
    var street = document.querySelector('#admin-street').value;
    var city = document.querySelector('#admin-city').value;
    var district = document.querySelector('#admin-district').value;
    var ward = document.querySelector('#admin-ward').value;
    var password1 = document.querySelector('#admin-password1').value;
    var password2 = document.querySelector('#admin-password2').value;


    if (userName === "") {
        alert("Vui lòng nhập tên tài khoản.");
        userName.focus();
        return false;
    }
    if (password1 !== password2) {
        alert("Xác nhận mật khẩu không đúng.");
        password2.focus();
        return false;
    }
    return true;
}


// function isEmpty() {
//     var isEmpty = false;
//     var userID = document.querySelector('#user-id').value;
//     var fullName = document.querySelector('#user-name').value;
//     var email = document.querySelector('#user-email').value;
//     var phone = document.querySelector('#user-phone').value;
//     var address = document.querySelector('#user-address').value;
//     var role = document.querySelector('#user-role').value;

//     if (userID === "" || fullName === "" || email === "" || phone === "" || role === "" || address === "") {
//         isEmpty = true;
//         alert("Vui lòng nhập đầy đủ.");
//     } else {
//         isEmpty = false;
//     }
//     return isEmpty;
// }

// function clearForm() {
//     document.querySelector('#user-id').value = "";
//     document.querySelector('#user-name').value = "";
//     document.querySelector('#user-email').value = "";
//     document.querySelector('#user-phone').value = "";
//     document.querySelector('#user-address').value = "";
//     document.querySelector('#user-role').value = "";

//     applyBtn.classList.add('btn-outline-secondary');
//     applyBtn.classList.add('pe-none');
//     applyBtn.classList.remove('btn-outline-dark');
// }


// // var searchBox_1 = document.querySelector(".record-search");
// // searchBox_1.addEventListener("keyup", function () {
// //     var keyword = this.value;
// //     keyword = keyword.toUpperCase();
// //     var table_1 = document.getElementById("user-table");
// //     var all_tr = table_1.getElementsByTagName("tr");
// //     for (var i = 0; i < all_tr.length; i++) {
// //         var name_column = all_tr[i].getElementsByTagName("td")[0];
// //         if (name_column) {
// //             var name_value = name_column.textContent || name_column.innerText;
// //             name_value = name_value.toUpperCase();
// //             if (name_value.indexOf(keyword) > -1) {
// //                 all_tr[i].style.display = ""; // show
// //             } else {
// //                 all_tr[i].style.display = "none"; // hide
// //             }
// //         }
// //     }
// // });

$(document).ready(function () {
    // Listen for changes in the "province" select box
    $('#admin-city').on('change', function () {
        var city_id = $(this).val();
        // console.log(city_id);
        if (city_id) {
            // If a province is selected, fetch the districts for that province using AJAX
            $.ajax({
                url: 'ajax_get_district.php',
                method: 'GET',
                dataType: "json",
                data: {
                    city_id: city_id
                },
                success: function (data) {
                    // Clear the current options in the "district" select box
                    $('#admin-district').empty();

                    // Add the new options for the districts for the selected province
                    $.each(data, function (i, district) {
                        // console.log(district);
                        $('#admin-district').append($('<option>', {
                            value: district.id,
                            text: district.name
                        }));
                    });
                    // Clear the options in the "wards" select box
                    $('#admin-ward').empty();
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error: ' + errorThrown);
                }
            });
            $('#admin-ward').empty();
        } else {
            // If no province is selected, clear the options in the "district" and "wards" select boxes
            $('#admin-ward').empty();
            $('#admin-district').empty();
        }
    });

    // Listen for changes in the "district" select box
    $('#admin-district').on('change', function () {
        var district_id = $(this).val();
        // console.log(district_id);
        if (district_id) {
            // If a district is selected, fetch the awards for that district using AJAX
            $.ajax({
                url: 'ajax_get_wards.php',
                method: 'GET',
                dataType: "json",
                data: {
                    district_id: district_id
                },
                success: function (data) {
                    // Clear the current options in the "wards" select box
                    $('#admin-ward').empty();
                    // Add the new options for the awards for the selected district
                    $.each(data, function (i, wards) {
                        $('#admin-ward').append($('<option>', {
                            value: wards.id,
                            text: wards.name
                        }));
                    });
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error: ' + errorThrown);
                }
            });
            $('#admin-ward').empty();
        } else {
            // If no district is selected, clear the options in the "award" select box
            $('#admin-ward').empty();
        }
    });
});
