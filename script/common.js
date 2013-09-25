if( !global ){
	var global = {};
}

window.log = function(){
	if( window.console ){
		console.log( Array.prototype.slice.call( arguments ) );
	}
};

(function($,GS){

	var xhr = {};

	var Common = {
		init: function(){
			$('.size-guide-link').each(function() {
				$(this).attr('href', $(this).data('link'));
			});
			$('.size-guide-link').prettyPhoto();
            //Common.setupEmailValidation( '#checkout-form' );
		},
        setupEmailValidation: function(selector) {
            var $form = $(selector),
                $orderButton,
                $billingEmail,
                $validateEmail,
                $checkEmailMessage;
            if ( $form.length === 0 ) { return; }

            $orderButton = $('#place_order').addClass('button-disabled');
            $checkEmailMessage = $('#check-email-message');
            $billingEmail = $('#billing-email');
            $validateEmail = $('#billing-email-validate');

            Common.compareEmails($billingEmail.val(), $validateEmail.val(), $orderButton );
            $orderButton.click(function(evt) {
                if ( $orderButton.hasClass( 'button-disabled' ) ) {
                    evt.preventDefault();
                    if ( $billingEmail.val() === '' ) {
                        $billingEmail.focus();
                    } else {
                        $validateEmail.focus();
                    }
                }
            });
            $orderButton.hover(
                function() {
                    if ( $orderButton.hasClass( 'button-disabled' ) ) {
                        $checkEmailMessage.show();
                    }
                },
                function() {
                    $checkEmailMessage.hide();
                }
            );

            $billingEmail.keyup(function() {
                Common.compareEmails($billingEmail.val(), $validateEmail.val(), $orderButton );
            });
            $billingEmail.change(function() {
                Common.compareEmails($billingEmail.val(), $validateEmail.val(), $orderButton );
            });
            $validateEmail.keyup(function() {
                Common.compareEmails($billingEmail.val(), $validateEmail.val(), $orderButton );
            });
            $validateEmail.change(function() {
                Common.compareEmails($billingEmail.val(), $validateEmail.val(), $orderButton );
            });
        },
        compareEmails: function( email1, email2, $orderButton) {

            if ( email1 == email2 && email1 !== '' ) {
                console.log(email1, email2);
                $orderButton.removeClass('button-disabled');
            } else {
                $orderButton.addClass('button-disabled');
            }
        }
	};

	GS.Common = {

	};	

	$(Common.init);

})(jQuery,global);