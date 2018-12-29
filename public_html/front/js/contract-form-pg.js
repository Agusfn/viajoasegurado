$(document).ready(function() {

	
	if($("#billing-information").length)
		$("select[name=billing_fiscal_condition]")[0].selectedIndex = 0;


	for(i=1; i<=passg_ammt; i++)
	{
		var input_date = $("input[name=passg"+i+"_birthdate]");
		var age = input_date.data("age");

		var birthdate_from = moment().subtract(age+1, "years").add(1, "day");
		var birthdate_to = moment().subtract(age, "years");

		input_date.datepicker({
			autoclose: true,
		    startView: 2,
		    startDate: birthdate_from._d,
		    endDate: birthdate_to._d
		});
	}


	/* Events */

	$("select[name=billing_fiscal_condition]").change(function() {
		var selected_val =  $(this)[0].selectedIndex;
		
		if(selected_val == 0 || selected_val == 1) {
			$("#billing-fullname-label").text("Nombre y apellido");
		} else if(selected_val == 2 || selected_val == 3) {
			$("#billing-fullname-label").text("Razón social");
		}
		if(selected_val == 0)
			$("#billing-tax-no-label").text("DNI");
		else
			$("#billing-tax-no-label").text("CUIT");	
	});

	$("#submit-form-btn").click(function() {
		if(validate_form())
			$("#contract-form").submit();
	});

});


function validate_form()
{
	clean_form_errors();


	/* Validamos datos de pasajeros */

	for(i=1; i<=passg_ammt; i++)
	{
		
		if($("input[name=passg"+i+"_name]").val().length == 0) {
			$("#passenger-name-error").show();
			$("input[name=passg"+i+"_name]").parent().addClass("has-error");
		}

		if($("input[name=passg"+i+"_surname]").val().length == 0) {
			$("#passenger-name-error").show();
			$("input[name=passg"+i+"_surname]").parent().addClass("has-error");
		}

		if($("input[name=passg"+i+"_document]").val().length == 0) {
			$("#passenger-document-error").show();
			$("input[name=passg"+i+"_document]").parent().addClass("has-error");
		}

		var date_birth = moment($("input[name=passg"+i+"_birthdate]").val(), "DD/MM/YYYY", true);
		if(!date_birth.isValid()) {
			$("#passenger-birthdate-error").show();
			$("input[name=passg"+i+"_birthdate]").parent().addClass("has-error");
		}

	}


	/* Validamos datos de facturación */
	if($("#billing-information").length)
	{

		if($("input[name=billing_fullname]").val() == "") {
			$("#billing-name-error").show();
			$("input[name=billing_fullname]").parent().addClass("has-error");
		}

		
		var billing_tax_no_input = $("input[name=billing_tax_number]");
		if($("#billing-tax-no-label").text() == "DNI")
		{
			if(!/^[0-9]{8,9}$/.test(billing_tax_no_input.val())) {
				$("#billing-tax-no-error").show();
				billing_tax_no_input.parent().addClass("has-error");
			}
		}
		else if($("#billing-tax-no-label").text() == "CUIT")
		{
			if(!/^[0-9]{2}-[0-9]{8,9}-[0-9]$/.test(billing_tax_no_input.val())) {
				$("#billing-tax-no-error").show();
				billing_tax_no_input.parent().addClass("has-error");
			}
		}

		if($("input[name=billing_address_street]").val() == "") {
			$("#billing-address-error").show();
			$("input[name=billing_address_street]").parent().addClass("has-error");
		}

		if($("input[name=billing_address_number]").val() == "") {
			$("#billing-address-error").show();
			$("input[name=billing_address_number]").parent().addClass("has-error");
		}

		if($("input[name=billing_address_city]").val() == "") {
			$("#billing-address-error").show();
			$("input[name=billing_address_city]").parent().addClass("has-error");
		}

		if($("input[name=billing_address_zip]").val() == "") {
			$("#billing-address-error").show();
			$("input[name=billing_address_zip]").parent().addClass("has-error");
		}

		if($("input[name=billing_address_state]").val() == "") {
			$("#billing-address-error").show();
			$("input[name=billing_address_state]").parent().addClass("has-error");
		}

	}


	/* Validamos datos de contacto */

	if(!/^[0-9\(\) \-\+\/]{1,30}$/.test($("input[name=contact_phone]").val())) {
		$("#contact-phone-error").show();
		$("input[name=contact_phone]").parent().addClass("has-error");
	}

	if(!validateEmail($("input[name=contact_email]").val())) {
		$("#contact-email-error").show();
		$("input[name=contact_email]").parent().addClass("has-error");
	}

	if($("input[name=emergency_contact_fullname]").val() == "") {
		$("#contact-emerg-name-error").show();
		$("input[name=emergency_contact_fullname]").parent().addClass("has-error");
	}

	if(!/^[0-9\(\) \-\+\/]{1,30}$/.test($("input[name=emergency_contact_phone]").val())) {
		$("#contact-phone-error").show();
		$("input[name=emergency_contact_phone]").parent().addClass("has-error");
	}




	if(!$("#contract-form .form-group").hasClass("has-error"))
		return true;
	else 
	{
		$("#error-list").show();
		$("#error-list")[0].scrollIntoView();
		return false;
	}


}


function clean_form_errors()
{	
	$("#error-list ul li").hide();
	$("#error-list").hide();
	$("#contract-form .form-group").removeClass("has-error");
}



function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
