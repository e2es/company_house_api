jQuery(document).ready(function() {

	jQuery('body').on('click', '.accordion-toggle', function () {
		jQuery(this).next().slideToggle('fast');
		jQuery(".accordion-content").not(jQuery(this).next()).slideUp('fast');

	});

	jQuery('body').on('submit','.e2es-ch-form',function(e) {
		e.preventDefault();
		let queryText = jQuery('.e2es_ch_q').val();
		e2es_ch_query({q: queryText}).then((text) => {
			jQuery('.display_ch').html(text);
		});
	});
});