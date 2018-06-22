
$("#mas_make").on("change", function () {

        $make = this.value;
        $.ajax({
            "url": "scrappedpanel/getModelList",
            type: 'POST',
            data: {make: $make},
            dataType: 'JSON',
            async: false,
            success: function (obj)
            {


                $('#mas_model').html('<option value="">Select make first</option>');
                $.each(obj, function (i, value) {

                    $.each(value, function (i, value1) {

                        $('#mas_model').append($('<option>').text(value1).attr('value', value1));
                    });

                });
            }
        });

    });
    $("#mas_model").on("change", function () {

        $model = this.value;
        $.ajax({
            "url":  "scrappedpanel/getVersionList",
            type: 'POST',
            data: {model: $model},
            dataType: 'JSON',
            async: false,
            success: function (obj)
            {

                console.log(obj);
                $('#mas_version').html('<option value="">Select model first</option>');
                $.each(obj, function (i, value) {
                    console.log(value);

                    if (value.uc_fuel_type == "" && value.uc_body_type == "")
                        $('#mas_version').append($('<option>').text(value.db_version).attr('value', value.db_version));
                    else if (value.uc_body_type == "")
                        $('#mas_version').append($('<option>').text(value.db_version + " (" + value.uc_fuel_type + " )").attr('value', value.db_version));
                    else if (value.uc_fuel_type == "")
                        $('#mas_version').append($('<option>').text(value.db_version + " (" + value.uc_body_type + " )").attr('value', value.db_version));
                    else
                        $('#mas_version').append($('<option>').text(value.db_version + " (" + value.uc_fuel_type, value.uc_body_type + " )").attr('value', value.db_version));

                });
            }
        });

    });





    $(document).ready(function () {

        $('#flashmsg').show(0).delay(2000).hide(0);
        $('#flashmsgerror').show(0).delay(2000).hide(0);
        $("button").click(function () {
            $var = this.id;
            $.ajax({
                type: 'POST',
                url:  "scrappedpanel/getPopUp",
                data: {id: $var},
                dataType: 'JSON',
                async: false,
                success: function (response) {

                    if (response)
                    {
                        $("#bsModal3").modal('show');
                        $('#labelmake').text(response.make);
                        $('#labelmodel').text(response.model);
                        $('#labelversion').text(response.version);
                        $('#labeldisplacement').text(response.displacement_1);
                        $('#labeltransmission').text(response.transmission);
                        $('#labeseatcap').text(response.seating_capacity);
                        $('#ins_make').text(response.make).attr('value', response.make);
                        $('#ins_model').text(response.make).attr('value', response.model);
                        $('#ins_version').text(response.make).attr('value', response.version);
                        $('#ins_source').text(response.make).attr('value', response.portal_name);
                        $('#ins_tt').text(response.make).attr('value', response.transmission);
                        $('#ins_id').text(response.id).attr('value', response.id);
                        var i;
                        $('#count').html(response.Image_url.length);
                        var html = '';
                        for (i = 0; i < response.Image_url.length; i++)
                        {
                            if (i != 0) {
                                var displaysat = 'style="display:none"';
                            }
                            html += '<div class="mySlides " ' + displaysat + '><img src="' + response.Image_url[i] + '" id="image_url' + i + '" height="250" width="300"></div>';
                        }
                        $('#slider-image').html(html);
                    }
                }
            });
        });
    });
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
    }