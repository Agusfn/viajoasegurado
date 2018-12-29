

$(document).ready(function() {


    countries_from = JSON.parse(countries_from);
    $("#country-from-input").typeahead({
        source: countries_from
    });


    /* Datepicker */
    $('input[name="date_start"]').datepicker({
        autoclose: true,
        startDate: '+0d',
        endDate: '+365d'
    });
    $('input[name="date_start"]').datepicker("setDate", "+0d");

    $('input[name="date_end"]').datepicker({
        autoclose: true,
        startDate: '+0d',
        endDate: '+365d'
    });
    $('input[name="date_end"]').datepicker("setDate", "+7d");



    $('input[name=travel_pregnant]').iCheck('uncheck');
    $('input[name=passenger_ammount][value="1"]').prop('checked', true);




    //***     Eventos         ****//


    $("#country-from-input").change(function() {
        var selected_option = $(this).typeahead("getActive");
        if(selected_option != null) {
            $("input[name='country_code_from']").val(selected_option.id);
        }
    });

    $('input[name="date_start"]').datepicker().on("changeDate", function(e) {
        $('input[name="date_end"]').datepicker("setStartDate", e.date);
        $('input[name="date_end"]').datepicker("setDate", e.date);
        $('input[name="date_end"]').focus();
    });


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
        $("#age1-input").parent().addClass("col-xs-5");
        $("#gestation-weeks-form-group").show()
    });

    $("input[name=travel_pregnant]").on("ifUnchecked", function() {
        $("#passg-ammt-1").parent().find(".btn").removeAttr("disabled");
        $("#age1-input").parent().removeClass("col-xs-5");
        $("#gestation-weeks-form-group").hide();
    });

    $("#submit-quote-btn").click(function() {
        if(validateQuoteForm())
            $("#quote-form").submit();
    });


});


function validateQuoteForm()
{

    cleanQuoteFormErrors();


    var valid = true;

    var country_name = $("#country-from-input").val();
    if(!valid_country(country_name))
    {
        $("#country-from-input").parent().addClass("has-error");
        $("#country-from-error").show();
        valid = false;
    }
    if($("select[name=region_code_to]").prop("selectedIndex") == 0)
    {
        $("select[name=region_code_to]").parent().addClass("has-error");
        $("#region-to-error").show();
        valid = false;
    }

    var date_start = moment($("input[name=date_start]").val(), "DD/MM/YYYY", true);
    var date_end = moment($("input[name=date_end]").val(), "DD/MM/YYYY", true);
    if(!date_start.isValid() || date_start.diff(moment()) < 0) {
        $("input[name=date_start]").parent().addClass("has-error");
        $("#date-start-error").show();
        valid = false;
    }
    if(!date_end.isValid() || date_end.diff(date_start) < 0) {
        $("input[name=date_end]").parent().addClass("has-error");
        $("#date-end-error").show();
        valid = false;
    }


    var passgs = parseInt($("input[name=passenger_ammount]:checked").val());
    for(i=1; i<=passgs; i++)
    {
        var age = parseInt($("#age"+i+"-input").val());
        if(!$.isNumeric(age) || !Number.isInteger(age) || age < 1 || age > 99)
        {
            $("#age1-input").parent().addClass("has-error");
            $("#ages-error").show();
            valid = false;
            break;
        }
    }

    if($("input[name=travel_pregnant]").is(":checked"))
    {
        var gest_weeks = parseInt($("input[name=gestation_weeks]").val());
        if(!$.isNumeric(gest_weeks) || !Number.isInteger(gest_weeks) || gest_weeks < 1 || gest_weeks > 36)
        {
            $("input[name=gestation_weeks]").parent().addClass("has-error");
            $("#gest-weeks-error").show();
            valid = false;
        }
    }

    if(!validateEmail($("input[name=email]").val()))
    {
        $("input[name=email]").parent().addClass("has-error");
        $("#email-error").show();
        valid = false;
    }

    /*if(!valid) {
        if($(".top-area").length) {
            //alert(1);
            $(".top-area").attr("style", "height: 800px");
        }
    }*/

    return valid;
}




function cleanQuoteFormErrors()
{
    $("#country-from-input").parent().removeClass("has-error");
    $("#country-from-error").hide();
    $("select[name=region_code_to]").parent().removeClass("has-error");
    $("#region-to-error").hide();

    $("input[name=date_start]").parent().removeClass("has-error");
    $("#date-start-error").hide();
    $("input[name=date_end]").parent().removeClass("has-error");
    $("#date-end-error").hide();

    $("#age1-input").parent().removeClass("has-error");
    $("#ages-error").hide();

    $("input[name=gestation_weeks]").parent().removeClass("has-error");
    $("#gest-weeks-error").hide();

    $("input[name=email]").parent().removeClass("has-error");
    $("#email-error").hide();
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


function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
