// var searchBox_1 = document.querySelector(".record-search");
// searchBox_1.addEventListener("keyup", function () {
//     var keyword = this.value;
//     keyword = keyword.toUpperCase();
//     var table_1 = document.getElementById("orders-table");
//     var all_tr = table_1.getElementsByTagName("tr");
//     for (var i = 0; i < all_tr.length; i++) {
//         var name_column = all_tr[i].getElementsByTagName("td")[0];
//         if (name_column) {
//             var name_value = name_column.textContent || name_column.innerText;
//             name_value = name_value.toUpperCase();
//             if (name_value.indexOf(keyword) > -1) {
//                 all_tr[i].style.display = ""; // show
//             } else {
//                 all_tr[i].style.display = "none"; // hide
//             }
//         }
//     }
// });

$(document).ready(function () {
    // Listen for changes in the "province" select box
    $('#order-city').on('change', function () {
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
                    $('#order-district').empty();

                    // Add the new options for the districts for the selected province
                    $.each(data, function (i, district) {
                        // console.log(district);
                        $('#order-district').append($('<option>', {
                            value: district.id,
                            text: district.name
                        }));
                    });
                    // Clear the options in the "wards" select box
                    $('#order-ward').empty();
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error: ' + errorThrown);
                }
            });
            $('#order-ward').empty();
        } else {
            // If no province is selected, clear the options in the "district" and "wards" select boxes
            $('#order-ward').empty();
            $('#order-district').empty();
        }
    });

    // Listen for changes in the "district" select box
    $('#order-district').on('change', function () {
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
                    $('#order-ward').empty();
                    // Add the new options for the awards for the selected district
                    $.each(data, function (i, wards) {
                        $('#order-ward').append($('<option>', {
                            value: wards.id,
                            text: wards.name
                        }));
                    });
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error: ' + errorThrown);
                }
            });
            $('#order-ward').empty();
        } else {
            // If no district is selected, clear the options in the "award" select box
            $('#order-ward').empty();
        }
    });

    $('#find-by').on('change', function () {
        var find_method = $(this).val();
        var find_by_status = document.getElementById('find-by-status');
        var find_by_date = document.getElementById('find-by-date');
        var find_by_address = document.getElementById('find-by-address');
        var find_submit_btn = document.getElementById('find-submit-btn');
        find_submit_btn.style.display = "block";
        switch (find_method) {
            case "tinh-trang":
                find_by_status.style.display = "block";
                find_by_date.style.display = "none";
                find_by_address.style.display = "none";
                break;
            case "thoi-gian-dat-hang":
                find_by_status.style.display = "none";
                find_by_date.style.display = "block";
                find_by_address.style.display = "none";
                break;
            case "dia-diem":
                find_submit_btn.style.display = "block";
                find_by_status.style.display = "none";
                find_by_date.style.display = "none";
                find_by_address.style.display = "block";
                break;
            case "0":
                find_by_status.style.display = "none";
                find_by_date.style.display = "none";
                find_by_address.style.display = "none";
            default:
                break;
        }
    })
});

