$(document).ready(function() {


    var quot_url_code = $('meta[name="url-code"]').attr('content');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


   $.ajax({
        url: $('meta[name="get-quot-url"]').attr('content'),
        type: 'POST',
        data: {_token: CSRF_TOKEN, url_code: quot_url_code, lang: lang},
        dataType: 'JSON',
        
        success: function (data) {

            console.log(data);
        	$("#loading").hide();

            if(data.success)
            {
                if(data.products.length > 0)
                {
                    $("#search-results").show();
                    $("#product-count").text(data.products.length);
                    $("#country-from").text(data.country_from);
                    $("#region-to").text(data.region_to);
                    $("#trip-date-from").text(data.date_from);
                    $("#trip-date-to").text(data.date_to);
                    $("#passg-count").text(data.passenger_count);
            		data.products.forEach(function(product) {
                        appendInsuranceProduct(product);
    				});
                }
                else
                    $("#no-results-found").show();
            }
            else
                $("#error-loading").show();
        }
    });



   /* Events */

    $("body").on("click", ".booking-item", function(event) {


        if ($(event.target).closest('.select-insurance-btn').length || $(event.target).closest('.insurance-terms-url').length) {
            return;
        }

        var item = $(this);

        if (item.hasClass('active')) {
            item.removeClass('active');
            item.parent().removeClass('active');
        } else {
            item.addClass('active');
            item.parent().addClass('active');

            if(!item.hasClass("viewed")) {
                item.addClass('viewed');

                var product_atv_id = item.data("product-id");

                $.ajax({
                    url: $('meta[name="get-coverage-url"]').attr('content'),
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, quot_url_code: quot_url_code, product_atv_id: product_atv_id},
                    dataType: 'JSON',
                    beforeSend: function() {
                        item.parent().find(".coverage-loading").show();
                    },
                    success: function (data) {
                        item.parent().find(".coverage-loading").hide();
                        //console.log(data);
                        if(data.success)
                        {
                            var details_html = "";
                            data.coverage.forEach(function(elem) {
                                details_html += elem.description + ": <strong>" + elem.ammount + "</strong><br/>";
                            }); 
                            item.parent().find(".coverage-details").html(details_html);
                        }
                    },

                });
            }
        }



    });



});


function appendInsuranceProduct(product)
{   
    var elem = $("#copy-quote-element").clone().removeAttr("id").show();

    elem.find(".booking-item").data("product-id", product.product_atv_id);
    elem.find(".insurer-name").text(product.provider_name);
    elem.find(".insurer-img").attr("src", product.img_url).attr("alt", product.provider_name);
    elem.find(".insurance-product-name").text(product.product_name);
    elem.find(".accident-coverage").text(product.accident_insured_amt);
    elem.find(".disease-coverage").text(product.disease_insured_amt);
    elem.find(".baggage-coverage").text(product.baggage_insured_amt);
    elem.find(".insurance-terms-url").attr("href", product.terms_url);
    elem.find(".booking-item-price").text(product.price);
    elem.find(".insurance-currency").text(product.price_currency_code);

    var contract_form_url = $('meta[name="contract-form-url"]').attr('content');
    var quot_url_code = $('meta[name="url-code"]').attr('content');
    elem.find(".select-insurance-btn").attr("href", contract_form_url+"/"+quot_url_code+"/"+product.product_atv_id);

    $("#insurance-list").append(elem);
}