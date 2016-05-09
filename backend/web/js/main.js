$(document).ready(function(){

	// $('.forSection').on('click',function(e){

	// 	e.preventDefault();
	// 	var end_url = $('.formContent').attr('data-url');
	// 	var section_title = $('#content-title').val();
	// 	var section_text = $('.content-section').trumbowyg('html');
	// 	alert(section_text);
	// 	$.ajax({
	// 		type: "post",
	// 		url: end_url,
	// 		data: {
	// 			title: section_title,
	// 			text: section_text
	// 		},
	// 		success: function(result){
	// 			console.log(result);
	// 		}
	// 	});

	// });

	$('.subnavbar').find ('li').each (function (i) {
		var mod = i % 3;
		if (mod === 2) {
			$(this).addClass ('subnavbar-open-right');
		}
	});	
	$(document.body).on('click','#promotion-items-modal td button',function(e){
		var btn = $(this);
		var itemsTable = $("#promotionItems");
		if(!itemsTable.data('items')){
			var items = {};
		}else{
			var items = itemsTable.data('items');
		}
		var itemId= btn.data('item-id');
		if(!(itemId in items)){
			items[itemId]=btn.data('item-tr');
			itemsTable.data('items',items);
			promotionDrawTable();
			btn.button('selected');
			btn.removeClass('btn-warning').addClass('btn-success');
		}
	});
	$(document.body).on('click','.promotion-type',function(e){
		$(this).closest('form').find("input[name='Promotion[type]']").val($(this).data('type'));
	});
	$(document.body).on('click','#promotionItems td button',function(e){
		var itemid = $(this).data('item-id');
		$(this).parent().parent().remove();
		var itemsTable = $("#promotionItems");
		var items = itemsTable.data('items');
		var btnItem = $("#promotion-items-modal button[data-item-id='"+itemid+"']");
		btnItem.button('reset');
		btnItem.removeClass('btn-success').addClass('btn-warning');
		delete items[itemid];
		itemsTable.data('items',items);
		promotionDrawTable();
	});
	$(document.body).on('change','.color-select',function(e){
		var option = $(this).find('option:selected');
		$(this).css('background-color',option.data('color'));
	});

	$(document.body).on('keyup','#guideNumberInput',function(e){
		$("#guideNumberMessage").text($(this).val());
	});
});
function promotionDrawTable(){
	var itemsTable = $("#promotionItems");
	itemsTable.find('tbody').html('');
	var items = itemsTable.data('items');
	for(var i in items){
		itemsTable.find('tbody').append(items[i]);
	}
}

function getwysiwyg(id){
	$("."+id).trumbowyg({
		lang:'es',
	    fullscreenable: true,
	    closable: true,
	    btns: ['bold', 'italic', '|', 'insertImage']
	});

}