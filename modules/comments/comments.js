function social_login(token) {
	console.log($('#id_section').val());
	$('#terms').load('/social_login.php?token=' + token + '&id_section=' + $('#id_section').val() + '&id_item=' + $('#id_item').val());
}

$(document).ready(function() {

	/*
	 * $('#addComment textarea').autoResize({ onResize : function() {
	 * $(this).css({ opacity : 0.8 }); }, animateCallback : function() {
	 * $(this).css({ opacity : 1 }); }, animateDuration : 300, extraSpace : 50 });
	 */

/*	$('#logout').live('click', function() {
		$('#terms').load('/social_login.php?logout');
		return false;
	});*/

	$("#addComment").submit(function() {
		var options = {
			/*
			 * beforeSubmit : function() { $('#err').html(''); },
			 */
			success : function(data) {
				if (data.indexOf('success') > 0) {
					$('.messageError').remove();
					$('div.feedback').load('/__comments/?cmd=list');
					$('#comments_message').html(data);
					$('#comments_message').fadeIn(1000);
					setTimeout("$('#comments_message').fadeOut(1000)", 3000);
					$("#addComment").resetForm();
				} else if (data.indexOf('error') > 0) {
					$('#comments_message').html(data);
					$('#comments_message').fadeIn(1000);
					setTimeout("$('#comments_message').fadeOut(1000)", 3000);
				} else {
					$('#comments_message').html(data);
					$('#comments_message').fadeIn(1000);
				}
			},
			url : "/__comments/?cmd=save"
		};

		$(this).ajaxSubmit(options);

		return false;
	});
});
