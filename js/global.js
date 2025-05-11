$(document).ready(function () {
    // Listen for changes in the "province" select box
    $('#customer-city').on('change', function () {
        var city_id = $(this).val();
        // console.log(city_id);
        if (city_id) {
            // If a province is selected, fetch the districts for that province using AJAX
            $.ajax({
                url: '../admin/admin_function/ajax_get_district.php',
                method: 'GET',
                dataType: "json",
                data: {
                    city_id: city_id
                },
                success: function (data) {
                    // Clear the current options in the "district" select box
                    $('#customer-district').empty();

                    // Add the new options for the districts for the selected province
                    $.each(data, function (i, district) {
                        // console.log(district);
                        $('#customer-district').append($('<option>', {
                            value: district.id,
                            text: district.name
                        }));
                    });
                    // Clear the options in the "wards" select box
                    $('#customer-ward').empty();
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error: ' + errorThrown);
                }
            });
            $('#customer-ward').empty();
        } else {
            // If no province is selected, clear the options in the "district" and "wards" select boxes
            $('#customer-ward').empty();
            $('#customer-district').empty();
        }
    });

    // Listen for changes in the "district" select box
    $('#customer-district').on('change', function () {
        var district_id = $(this).val();
        // console.log(district_id);
        if (district_id) {
            // If a district is selected, fetch the awards for that district using AJAX
            $.ajax({
                url: '../admin/admin_function/ajax_get_wards.php',
                method: 'GET',
                dataType: "json",
                data: {
                    district_id: district_id
                },
                success: function (data) {
                    // Clear the current options in the "wards" select box
                    $('#customer-ward').empty();
                    // Add the new options for the awards for the selected district
                    $.each(data, function (i, wards) {
                        $('#customer-ward').append($('<option>', {
                            value: wards.id,
                            text: wards.name
                        }));
                    });
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error: ' + errorThrown);
                }
            });
            $('#customer-ward').empty();
        } else {
            // If no district is selected, clear the options in the "award" select box
            $('#customer-ward').empty();
        }
    });
});