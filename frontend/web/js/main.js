$(document).ready(function(){
	$("#paymentForm").submit(function(e){
		e.preventDefault();
		var form = $(this);
		var btn = form.find("button[type='submit']");
		btn.button('loading');
		form.ajaxSubmit({
			success:function(r){
				if(r.success) window.location.assign(r.redirect)
				btn.button('reset');
			},
			dataType:'json',
			error:function(){
				btn.button('reset');
			}
		});
		
	});
	$("#cart table .delitem").click(function(e){
		e.preventDefault();
		var btn = $(this);
		$.get(btn.attr('href'),function(r){
			location.reload();
		},'json');
	});
	$(".item form").submit(function(e){
		e.preventDefault();
		var form = $(this);
		form.ajaxSubmit({
			success:function(r){
				if(r.success) window.location.assign('/carrito');
				else showAlert(r.error,false);
			},
			dataType:'json',
			error:function(){
				btn.button('reset');
			}
		});
	});
	$('#elementsPerPage').change(function(){
		$(this).closest('form').submit();
	});
	$(".validateForm").validate({
		debug: true,
		ignore: [],
		validClass:'has-success',
		errorClass: 'has-error',
		 highlight: function(element, errorClass, validClass) {
			$(element).parent().addClass(errorClass).removeClass(validClass);
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parent().removeClass(errorClass).addClass(validClass);
		},
		errorPlacement: function(error,element){

		}
	});
});

function showAlert (message,success) {
	var modal = $("#errorModal");
	modal.find('h3').text(message);
	var mbody = modal.find('.modal-body');
	if(success) mbody.removeClass('bg-danger').addClass('bg-success');
	else mbody.removeClass('bg-success').addClass('bg-danger');
	modal.modal('show');
}