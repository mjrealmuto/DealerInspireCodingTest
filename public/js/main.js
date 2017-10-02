$(function( ){
	
	$("form[name=contact-form]").submit( function( event ){
		
		$("#form_submit")
		.prop("disabled", "true")
		.html("Submitting...");
		
		var postPackage = {};
		
		postPackage = {
			full_name : $("#full_name").val( ),
			email_address : $("#email_address").val( ),
			phone_number : $("#phone_number").val( ),
			message   : $("#message").val( )
		}	
		
		$(".form-group").find(".alert").addClass("hidden")
			
		$.post("inc/process.php", postPackage, function( resp ){
			
			if( resp.status == 0 ){
				for( var x in resp.error ){
					$(".danger-" + x)
					.html(resp.error[x])
					.removeClass("hidden");
				}
			}else if( resp.status == -1 ){
				
				$(".admin-error-message")
				.html(resp.message)
				.removeClass("hidden");
			}else{
				
				$("form[name=contact-form]")[0].reset();
				
				$(".success-message")
				.html(resp.message)
				.removeClass("hidden");
			}
			$("#form_submit")
			.removeAttr("disabled")
			.html("Submit");
		}, "json");
		
		event.preventDefault( );	
	});
	
});