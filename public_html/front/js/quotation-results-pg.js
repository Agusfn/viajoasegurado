$(document).ready(function() {

	/*$("#loading").show();
   
    $.ajax({
        url: "{{ url()->to('quotation/getquotation') }}",

        type: 'POST',

        data: {_token: CSRF_TOKEN, url_code: quot_url_code},

        dataType: 'JSON',
        success: function (data) {

        	$("#loading").hide(); 
            console.log(data);

            if(data.success)
            {

        		data.products.forEach(function(entry) {
        			// entry tiene todos los datos expuestos
        			var elem = createProductElement(entry, quot_url_code);
        			$("#product-list").append(elem);
				});

            }
        }
    }); */

});