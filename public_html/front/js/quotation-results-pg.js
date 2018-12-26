$(document).ready(function() {

    var quot_url_code = $('meta[name="url-code"]').attr('content');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
   
    /*$.ajax({
        url: $('meta[name="req-url"]').attr('content'),

        type: 'POST',

        data: {_token: CSRF_TOKEN, url_code: quot_url_code},

        dataType: 'JSON',
        
        beforeSend: function() {
            $("#loading").show();
        },

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
    });*/


});