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
			$('.size-guide-link').fancybox();
		}
	};

	GS.Common = {
		wordpress: function( hook, data, callback, ajax ){
			if( xhr[hook] ) xhr[hook].abort();
			xhr[hook] = $.ajax( $.extend({
				url: ajax_url,
				type: 'POST',
				dataType: 'json',
				data: $.extend({action:hook},data),
				success: callback
			}, ajax||{} ) );
		}
	};	

	$(Common.init);

})(jQuery,global);