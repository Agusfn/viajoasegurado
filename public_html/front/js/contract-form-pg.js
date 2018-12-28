$(document).ready(function() {

	if($("#billing-information").length)
		$("select[name=billing_fiscal_condition]")[0].selectedIndex = 0;


	$('input.date-pick-years').datepicker({
	    startView: 2
	});


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

	var errors_html = "";

	/* Validamos datos de pasajeros */

	for(i=1; i<=passg_ammt; i++)
	{
		
		var name_input = $("input[name=passg"+i+"_name]");
		if(name_input.val().length == 0) {
			errors_html += "<li>Ingresa el nombre del pasajero #"+i+".</li>";
			name_input.parent().addClass("has-error");
		}

		var surname_input = $("input[name=passg"+i+"_surname]");
		if(surname_input.val().length == 0) {
			errors_html += "<li>Ingresa el apellido del pasajero #"+i+".</li>";
			surname_input.parent().addClass("has-error");
		}

		var document_number_input = $("input[name=passg"+i+"_document]");
		if(document_number_input.val().length == 0) {
			errors_html += "<li>Ingresa el numero de documento del pasajero #"+i+".</li>";
			document_number_input.parent().addClass("has-error");
		}

		var date_birth_input = $("input[name=passg"+i+"_birthdate]");
		var date_birth = moment(date_birth_input.val(), "DD/MM/YYYY", true);
		if(!date_birth.isValid()) {
			errors_html += "<li>Ingresa una fecha de nacimiento correcta del pasajero #"+i+".</li>";
			date_birth_input.parent().addClass("has-error");
		}

	}


	/* Validamos datos de facturación */
	if($("#billing-information").length)
	{

		var billing_fullname_input = $("input[name=billing_fullname]");
		if(billing_fullname_input.val() == "") {
			errors_html += "<li>Ingresa el nombre o razón social de facturación.</li>";
			billing_fullname_input.parent().addClass("has-error");
		}

		
		var billing_tax_no_input = $("input[name=billing_tax_number]");
		if($("#billing-tax-no-label").text() == "DNI")
		{
			if(!/^[0-9]{8,9}$/.test(billing_tax_no_input.val())) {
				errors_html += "<li>Ingresa un DNI correcto.</li>";
				billing_tax_no_input.parent().addClass("has-error");
			}
		}
		else if($("#billing-tax-no-label").text() == "CUIT")
		{
			if(!/^[0-9]{2}-[0-9]{8,9}-[0-9]$/.test(billing_tax_no_input.val())) {
				errors_html += "<li>Ingresa un CUIT correcto (con guiones).</li>";
				billing_tax_no_input.parent().addClass("has-error");
			}
		}

		var billing_street_input = $("input[name=billing_address_street]");
		if(billing_street_input.val() == "") {
			errors_html += "<li>Ingresa la calle de la dirección de facturación.</li>";
			billing_street_input.parent().addClass("has-error");
		}

		var billing_st_height_input = $("input[name=billing_address_number]");
		if(billing_st_height_input.val() == "") {
			errors_html += "<li>Ingresa la altura de la calle de la dirección de facturación.</li>";
			billing_st_height_input.parent().addClass("has-error");
		}

		var billing_city_input = $("input[name=billing_address_city]");
		if(billing_city_input.val() == "") {
			errors_html += "<li>Ingresa la localidad de la dirección de facturación.</li>";
			billing_city_input.parent().addClass("has-error");
		}

		var billing_zip_input = $("input[name=billing_address_zip]");
		if(billing_zip_input.val() == "") {
			errors_html += "<li>Ingresa el código postal de la dirección de facturación.</li>";
			billing_zip_input.parent().addClass("has-error");
		}

		var billing_state_input = $("input[name=billing_address_state]");
		if(billing_state_input.val() == "") {
			errors_html += "<li>Ingresa la provincia de la dirección de facturación.</li>";
			billing_state_input.parent().addClass("has-error");
		}

	}


	/* Validamos datos de contacto */

	var phone_input = $("input[name=contact_phone]");
	if(!/^[0-9\(\) \-\+\/]{1,30}$/.test(phone_input.val())) {
		errors_html += "<li>Ingresa un número de teléfono de contacto válido.</li>";
		phone_input.parent().addClass("has-error");
	}

	var email_input = $("input[name=contact_email]");
	if(!validateEmail(email_input.val())) {
		errors_html += "<li>Ingresa un e-mail de contacto válido.</li>";
		email_input.parent().addClass("has-error");
	}

	var emerg_name_input = $("input[name=emergency_contact_fullname]");
	if(emerg_name_input.val() == "") {
		errors_html += "<li>Ingresa el nombre y apellido del contacto de emergencia.</li>";
		emerg_name_input.parent().addClass("has-error");
	}

	var emerg_phone_input = $("input[name=emergency_contact_phone]");
	if(!/^[0-9\(\) \-\+\/]{1,30}$/.test(emerg_phone_input.val())) {
		errors_html += "<li>Ingresa un número de teléfono de contacto de emergencia válido.</li>";
		emerg_phone_input.parent().addClass("has-error");
	}




	if(errors_html === "")
		return true;
	else 
	{
		$("#error-list ul").append(errors_html);
		$("#error-list").show();
		$("#error-list")[0].scrollIntoView();
		return false;
	}


}


function clean_form_errors()
{
	$("#error-list ul").empty();
	$("#error-list").hide();

	for(i=1; i<=passg_ammt; i++)
	{
		$("input[name=passg"+i+"_name]").parent().removeClass("has-error");
		$("input[name=passg"+i+"_surname]").parent().removeClass("has-error");
		$("input[name=passg"+i+"_document]").parent().removeClass("has-error");
		$("input[name=passg"+i+"_birthdate]").parent().removeClass("has-error");
	}
	if($("#billing-information").length) {
		$("input[name=billing_fullname]").parent().removeClass("has-error");
		$("input[name=billing_tax_number]").parent().removeClass("has-error");
		$("input[name=billing_address_street]").parent().removeClass("has-error");
		$("input[name=billing_address_number]").parent().removeClass("has-error");
		$("input[name=billing_address_city]").parent().removeClass("has-error");
		$("input[name=billing_address_zip]").parent().removeClass("has-error");
		$("input[name=billing_address_state]").parent().removeClass("has-error");
	}
	$("input[name=contact_phone]").parent().removeClass("has-error");
	$("input[name=contact_email]").parent().removeClass("has-error");
	$("input[name=emergency_contact_fullname]").parent().removeClass("has-error");
	$("input[name=emergency_contact_phone]").parent().removeClass("has-error");
}



function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
