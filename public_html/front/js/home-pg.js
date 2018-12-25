$(document).ready(function() {


    countries_from = JSON.parse(countries_from);
    $("#country-from-input").typeahead({
        source: countries_from
    });

    $("#country-from-input").change(function() {
        var selected_option = $(this).typeahead("getActive");
        if(selected_option != null) {
            $("input[name='country_code_from']").val(selected_option.id);
        }
    });

    $('input.date-pick, .input-daterange input[name="date_start"]').datepicker('setDate', 'today');
    $('.input-daterange input[name="date_end"]').datepicker('setDate', '+7d');

    $('input[name=travel_pregnant]').iCheck('uncheck');



    //*     Eventos         *//

    $("input[name=passenger_ammount]").on("change", function() {
        var val = parseInt($('input[name=passenger_ammount]:checked').val());
        $("#age2-input,#age3-input,#age4-input,#age5-input").hide();
        for(var i=1; i<(val+1); i++) {
            $("#age"+i+"-input").css('display', 'inline');
        }
    });

    $("input[name=travel_pregnant]").on("ifChecked", function() {
        $("#passg-ammt-1").trigger("click");
        $("#passg-ammt-1").parent().find(".btn").attr("disabled", "disabled");
        $("#gestation-weeks-form-group").css("display", "inline-block");
    });

    $("input[name=travel_pregnant]").on("ifUnchecked", function() {
        $("#passg-ammt-1").parent().find(".btn").removeAttr("disabled");
        $("#gestation-weeks-form-group").hide();
    });

    $("#submit-quote-btn").click(function() {
        if(validateQuoteForm())
            $("#quote-form").submit();
    });


});


function validateQuoteForm()
{

    var format = "DD/MM/YYYY";

    // clean errors.

    var country_name = $("#country-from-input").val();
    if(!valid_country(country_name))
    {
        $("#country-from-input").parent().addClass("has-error");
        $("#country-from-error").show();
    }
    if($("select[name=region_code_to]").prop("selectedIndex") == 0)
    {
        $("select[name=region_code_to]").parent().addClass("has-error");
        $("#region-to-error").show();
    }

    var date_start = moment($("input[name=date_start]").val(), format, true);
    var date_end = moment($("input[name=date_end]").val(), format, true);
    if(!date_start.isValid() || date_start.diff(moment()) < 0) {
        $("input[name=date_start]").parent().addClass("has-error");
        $("#date-start-error").show();
    }
    if(!date_end.isValid() || date_end.diff(date_start) < 0) {
        $("input[name=date_end]").parent().addClass("has-error");
        $("#date-end-error").show();
    }


    








    return false;
    //alert($("input[name=country_code_from]").val());
}




function cleanQuoteFormErrors()
{

}


function valid_country(country_name)
{
    for(var country of countries_from) {
        if(country.name == country_name) {
            return true;
        }
    }
    return false;
}


function valid_dates(start, end)
{   

    var format = "DD/MM/YYYY";

    start = moment(start, format, true);
    end = moment(end, format, true);

    if(start.isValid() && end.isValid())
    {
        if(start.diff(moment()) > 0 && end.diff(start) > 0)
            return true;
        else
            return false;
    }
    else
        return false;
}