$(document).ready(function () {
    $(".alert").slideDown(100).delay(5000).slideUp(500);
});

//DELETE CONFIRMATION
function confirmDelete() {
    return confirm("Are you sure you want to delete?");
}

function toggleCategoryField() {
    var roleId = document.getElementById("role_id").value;
    var categoryField = document.getElementById("categoryField");
    var productionHouse = document.getElementById("productionHouse");

    if (roleId == 3 || roleId == 4) {
        categoryField.style.display = "block";
    } else {
        categoryField.style.display = "none";
    }

    if (roleId == 13) {
        productionHouse.style.display = "block";
    } else {
        productionHouse.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    toggleCategoryField();
});

$(document).on("click", ".titleOfFilm", function (e) {
    let ip_id = $(this).data("ip_id");
    $.ajax({
        url: "{{ url('api/title_of_film') }}",
        type: "POST",
        data: {
            id: ip_id,
            _token: "{{ csrf_token() }}",
        },
        dataType: "json",
        success: function (result) {
            if (result.status == true) {
                console.log(result.data.title_of_film_in_roman);
                $(".title_of_film_in_roman").text(
                    result.data.title_of_film_in_roman
                );
                $(".title_of_film_in_devanagari").text(
                    result.data.title_of_film_in_devanagari
                );
                $(".english_translation_of_film").text(
                    result.data.english_translation_of_film
                );
                $(".title_of_script_langauge").text(
                    result.data.title_of_script_langauge
                );
            }
        },
    });
});

$(document).ready(function () {
    toggleStepSelection();
    $("#payment_status").change(function () {
        toggleStepSelection();
    });

    function toggleStepSelection() {
        var paymentStatus = $("#payment_status").val();
        if (paymentStatus == 1) {
            $("#step-selection").show();
        } else {
            $("#step-selection").hide();
        }
    }
});
