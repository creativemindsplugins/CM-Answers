jQuery( document ).ready(function($) {
	$('.multiselect_experts').multiselect({
		columns: 2,
		placeholder: 'Select Experts',
	});
	$('.multiselect_categories').multiselect({
		columns: 2,
		placeholder: 'Select Categories',
	});
});