(function () {
	var no = $('#file');
	$('div.content').hide();
	no.on('click' , function(){
		$(this).next().slidDown('fast');
	})

});