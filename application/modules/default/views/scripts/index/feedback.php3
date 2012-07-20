<a class="feedbackActivator" id="feedbackActivator" href="#" onclick="return feedbackShow();">Задать вопрос</a>
<div class="feedback" id="feedback" style="display:none;">
	<?php echo $this->form; ?>
	<div class="clear"></div>
</div>
<script>
function feedbackShow()
{
	var activator = $('feedbackActivator');
	var container = $('feedback');

	if (container.getStyle('display') == 'none') {
		container.show();
	} else {
		container.hide();
	}

	if(activator.hasClassName('feedbackActivator')) {
		activator.toggleClassName('feedbackActivatorActive');
	} else {
		activator.toggleClassName('feedbackActivator');
	}
	return false;
}

function sendData(form, page)
{
	if (form.tagName && form.tagName.toUpperCase() == 'FORM') {
		var par = form.serialize(true);
	} else {
		var par = form;
	}
	var errarray = $$('.error');
	
	new Ajax.Request(page, {
		method: 'post',
		parameters: par,
		onCreate : (function(){
			for (var e = 0; e < errarray.length; e++) {
				errarray[e].hide().update();
			}	
		}),
		onComplete : (function(response){
			var json = response.responseJSON;
			
			var errors = json['validationErrors'];
			var errcount = 0;
			var send = json['send'];
			if(send == 1) {
				$('feedback').update('<div class="success">Ваше сообщение успешно отправлено!</div>');
				setTimeout(function(){
					feedbackShow();
				}, 3000);
			} else {
				for (var error in errors) {
					if(errors[error].length > 0) {
						errcount++;
						for(var i = 0; i < errors[error].length; i++) {
							$(error + '_error').insert(errors[error][i]).insert('<br />');
						}
						$(error + '_error').show();
					}
				} 
			}
			
			
			
			//setTimeout(function(){window.location = '/';}, 2000);
			
		})
	});	
	return false;	
}
</script>
