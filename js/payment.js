$(document).ready(function () {
    // Listen for changes in the "province" select box
    $('#receiver-city').on('change', function () {
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
                    $('#receiver-district').empty();

                    // Add the new options for the districts for the selected province
                    $.each(data, function (i, district) {
                        // console.log(district);
                        $('#receiver-district').append($('<option>', {
                            value: district.id,
                            text: district.name
                        }));
                    });
                    // Clear the options in the "wards" select box
                    $('#receiver-ward').empty();
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error: ' + errorThrown);
                }
            });
            $('#receiver-ward').empty();
        } else {
            // If no province is selected, clear the options in the "district" and "wards" select boxes
            $('#receiver-ward').empty();
            $('#receiver-district').empty();
        }
    });

    // Listen for changes in the "district" select box
    $('#receiver-district').on('change', function () {
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
                    $('#receiver-ward').empty();
                    // Add the new options for the awards for the selected district
                    $.each(data, function (i, wards) {
                        $('#receiver-ward').append($('<option>', {
                            value: wards.id,
                            text: wards.name
                        }));
                    });
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error: ' + errorThrown);
                }
            });
            $('#receiver-ward').empty();
        } else {
            // If no district is selected, clear the options in the "award" select box
            $('#receiver-ward').empty();
        }
    });
});