jQuery(document).ready(function ($) {
    $('#send').click(function () {
        $('.error').fadeOut('slow'); // Oculta errores anteriores
        $('#ajaxsuccess').hide(); // Oculta éxito previo si hubiera

        let error = false;

        const name = $('input#name').val().trim();
        if (name === "") {
            $('#err-name').fadeIn('slow');
            error = true;
        }

        const email_compare = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/;
        const email = $('input#email').val().trim();
        if (email === "") {
            $('#err-email').fadeIn('slow');
            error = true;
        } else if (!email_compare.test(email)) {
            $('#err-emailvld').fadeIn('slow');
            error = true;
        }

        if (error) {
            $('#err-form').slideDown('slow');
            return false;
        }

        const data_string = $('#ajax-form').serialize();

        // Desactivar botón y mostrar animación
        $('#send').prop('disabled', true);
        const originalText = $('#send #btnText').text();
        $('#send #btnText').text('Sending...');

        $.ajax({
            type: "POST",
            url: $('#ajax-form').attr('action'),
            data: data_string,
            timeout: 20000, // Aumentamos tiempo de espera a 20 segundos

			error: function(request,error) {
				if (error == "timeout") {
					$('#err-timedout').slideDown('slow');
				}
				else {
					$('#err-state').slideDown('slow');
					$("#err-state").html('An error occurred: ' + error + '');
				}
			},

			success: function() {
				$('#ajax-form').slideUp('slow');
				$('#ajaxsuccess').slideDown('slow');
			}

        });

        return false;
    });
});

