var lastButtonForm=false;
var languageTable={
	search:"Buscar: ",
	infoEmpty: 'Mostrando 0 a 0 de 0 Registros',
	info : 'Mostrando _START_ a _END_ de _TOTAL_ Registros',
	infoFiltered: '(Filtrado de _MAX_ registros)',
	lengthMenu: '_MENU_ Registros por pagina',
	zeroRecords: 'No existen Registros',
	paginate: {
            first:      '<span aria-hidden="true">&laquo;</span>',
            previous:   '<span aria-hidden="true">&laquo;</span>',
            next:       '<span aria-hidden="true">&raquo;</span>',
            last:       '<span aria-hidden="true">&raquo;</span>'
        },
    processing: '<i class="icon-refresh icon-spin icon-2x"></i>'
}
$(document).ready(function(){
	alertify.set('notifier','position', 'top-right');
alertify.defaults.theme.ok = "btn btn-danger";
alertify.defaults.theme.cancel = "btn btn-default";
alertify.defaults.theme.input = "form-control input-sm input-sm";
alertify.defaults.notifier.delay = 100;

	$.fn.modalmanager.defaults['spinner'] = "<div class='loading-spinner fade in text-center' style='width: 200px; margin-left: -100px;color:#fff'><i class='icon-refresh icon-spin icon-4x'></i></div>";
	$.fn.modal.defaults['spinner'] = "<div class='loading-spinner fade in text-center' style='width: 200px; margin-left: -100px;'><i class='icon-refresh icon-spin icon-4x'></i></div>";
	// Evento que agrega un modal dinamico con contenido por Ajax
	$(document.body).on('click',"[data-toggle='modalDinamic']",function(e){
		e.preventDefault();
		var obj = $(this);
		var backdrop = obj.data('modal-backdrop');
		var width = obj.data('modal-width');
		var keyboard = obj.data('modal-keyboard');
		var path = obj.attr('href')?obj.attr('href'):obj.data('url');
		generateModal(obj,path,width,backdrop,keyboard);
	});

	 //Evento que se activa al seleccionar un archivo a cargar
	$(document).on('change', '.btn-file :file', function() {
    	var input = $(this),
    	numFiles = input.get(0).files ? input.get(0).files.length : 1,
    	label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    	input.trigger('fileselect', [numFiles, label]);
    });

	//Indica el nombre del archivo que se ha seleccionado
     $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
		//console.log(numFiles); //Muestra el número total de archivos seleccionados
		//console.log(label);  //Nombre del archivo seleccionado
		$(this).parent().parent().parent().find(".select-file").attr("placeholder",label);
	});
    $(document.body).on('change','.imgField',function(){
		// alert('asd');
		var next = $(this).next();
		var imgContent ;
		if(next.hasClass('imgPreview')){
			imgContent = next;
		}else{
			imgContent=$("<div class='imgPreview row' ></div>");
			imgContent.insertAfter($(this));
		}
		if(this.files && this.files.length>0){
			imgContent.html('');
			// console.log(this.files);
			var aux = 0;
			var imageCol = $(this).data('images-per-line')?12/parseInt($(this).data('images-per-line')):4; 
	  		for(var f in this.files){
				var reader = new FileReader();
				reader.onload = function(e){
					imgContent.append("<div class='text-center col-md-"+imageCol+"'><img src='"+e.target.result+"' style='max-width:95%'></div>")
					// imgContent.find('img').attr('src',e.target.result);
		  		};
	  			reader.readAsDataURL(this.files[f]);
	  			if(aux>this.files.length-2) break;
	  			aux++;
	  		}
		}
	});
	$(document.body).on('hidden.bs.modal',".modal-ajax",function(e){
		var m = $(this);
		setTimeout(function(){m.remove();},310);	
	});
	// El select con esta clase hace una peticion por POST enviando atributo "value" de la opcion seleccionada
	// y lo que recibe lo pega dentro del contenedor con el que concuerde el data-containerload
	$(document.body).on('change','select.load-content',function(){
		var obj = $(this);
		var url = obj.data('url');
		var container = $(obj.data('container'));
		if(container.length>0 && url!='' && obj.val()!=''){
			container.html("<div class='text-center'><i class='icon-refresh icon-spin icon-4x'></i></div>");
			container.load(url,{id:obj.val()});
		}
	});
	// El boton o link con esta clase, hace una peticion Ajax a la url especificada. "href" del "<a>" y "data-url" del "<button>".
	// el contenido devuelto lo pega en el contenedor con el selector especificado en "data-container"
	// Al dar click el boton cambia a su estado "loading" y al final regresa al estado original
	$(document.body).on('click','a.load-content,button.load-content',function(e){
		e.preventDefault();
		var obj = $(this);
		obj.button('loading');
		var container =$(obj.data('container')); 
		container.html("<i class='icon-refresh icon-spin icon-4x'></i>");
		container.load(obj.attr('href')?obj.attr('href'):obj.data('url'),function(r){
			obj.button('reset');
		});
	});

	// hace lo mismo que el anterior pero este agrega el contenido al contenedor
	$(document.body).on('click','a.append-content,button.append-content',function(e){
		e.preventDefault();
		var obj = $(this);
		obj.button('loading');
		$.get(obj.attr('href')?obj.attr('href'):obj.data('url'),function(r){
			$(obj.data('container')).append(r);	
		});
	});

	$(document.body).on('submit','form.load-content',function(e){
		e.preventDefault();
		var form = $(this);
		var btn = form.find("[type='submit']");
		btn.button('loading');
		form.ajaxSubmit({
			success:function(r){
				btn.button('reset');
				$(form.data('container')).html(r);
				applyToNewContainer($(form.data('container')));
			},
			error:function(){
				btn.button('reset');
				alert('Error del sistema :(');
			}
		});
	});
	// el boton con esa clase, agregara lo que contenta en el "data-element" en un contenedor con el selector
	//  escrito en "data-selector"
	$(document.body).on('click','.append-element',function(e){
		e.preventDefault();
		var selector=$(this).data('to-container');
		var element;
		if($(this).data('element')){
			element = $(this).data('element');
		}else if($(this).data('from-container')){
			element = $($(this).data('from-container')).html();
		}
		$(selector).append(element);
	});

	//El checkbox con esta clase, cambia el estado de un "<input> o <select>"
	//aplica un "disabled" si esta activo, si no, lo quita. 
	$(document.body).on('change',".enable-field",function(e){
		$($(this).data('selector')).prop('disabled',$(this).prop('checked')?false:'disabled');
	});

	//El checkbox con esta clase, cambia el estado de un "<input> o <select>"
	//aplica un "readonly" si esta activo, si no, lo quita. 
	$(document.body).on('change',".readonly-field",function(e){
		$($(this).data('selector')).prop('readonly',$(this).prop('checked')?false:'readonly');
	});

	// El checkbox con esta clase, activa otros checkbox segun el selector en "data-selector"
	// 
	$(document.body).on('change',".check-field",function(e){
		$($(this).data('selector')).prop('checked',$(this).prop('checked')?'checked':false);

	});

	// El checkbox con esta clase, abrira un contenedor al estar activado. usa .collapse de bootstrap
	$(document.body).on('change',".check-collapse",function(e){
		$($(this).data('container')).collapse($(this).prop('checked')?'show':'hide');
	});

	// El link o boton con esta clase, ejecuta un evento focus en el objeto con el selector definido en "data-selector"
	// Funciona para mostrar calendarios en inputs con datepicker
	$(document.body).on('click',".clickAndFocus",function(e){
		e.preventDefault();
		$($(this).data('selector')).focus();
	});
	$(document.body).on('click','form.ajaxSubmit button',function(e){
		lastButtonForm = $(this);
	});
	$(document.body).on('submit','form.ajaxSubmit',function(e){
		e.preventDefault();
		form = $(this);
		btn = $(this).find("button[type='submit'],button.submitButton");
		btn.data('loading-text',"<i class='icon-refresh icon-spin'></i>");
		var extraData={};
		if(form.valid()){
			if(lastButtonForm && lastButtonForm.attr('name')){
				extraData[lastButtonForm.attr('name')]= lastButtonForm.attr('value');
			}
			btn.button('loading');
			form.ajaxSubmit({
				data:extraData,
				success:function(r){
					btn.button('reset');
					if(r.success){
						showAlert(r.message?r.message:'Ok!','success',true);
						reloadAjaxTables();
					}
					else{
						showAlert(r.message?r.message:'Error!','error',true);
					}
					if(r.callbackScript){
						eval(r.callbackScript);
					}
				},
				dataType: 'json',
				error:function(){
					btn.button('reset');
					showAlert('Error!','error');
				}
			});
		}
	});
	$(document.body).on('click','.show-warning',function(e){
	    	e.preventDefault();
	    	var warningModal = $("#warning-modal");
	    	var btn = $(this);
	    	warningModal.find('.extra-message').html(btn.data('warning-message')?btn.data('warning-message'):'');
	    	
	    	var actionButtton = warningModal.find('.action-button');
	    	actionButtton.attr('href',btn.attr('href'));
	    	if(btn.hasClass('ajaxLink')){
	    		actionButtton.addClass('ajaxLink');
	    	}else{
	    		actionButtton.removeClass('ajaxLink');
	    	}
			warningModal.modal();
	});

	$(document.body).on('click','a.ajaxLink',function(e){
		e.preventDefault();
		var obj = $(this);
		if(!$(this).hasClass('show-warning'))
		{
			obj.button('loading');
			$.get(obj.attr('href'),function(r){
				obj.button('reset');
				if(r.success){
					if(obj.hasClass('action-button')){
						closeCurrentModal();					
					}
					showAlert(r.message?r.message:'Ok!');
				}
				else{
					showAlert(r.message?r.message:'Error!','error');
				}
				if(r.callbackScript){
					eval(r.callbackScript);
				}
			},'json').fail(function(){
				obj.button('reset');
				showAlert('Error!','error');
			});
		}
	});

	//Funcion que oculta o muestra el campo de configuraciones al crear un nuevo contribuyente
	$(document.body).on('change','select#select_rol',function(e){
		e.preventDefault();
		rol = $(this).find("option:selected").text();
		if (rol == "Receptor"){
			$("#config_emisor_data").hide("slow");
		}else{
			$("#config_emisor_data").show("slow");
		}
	});

	$(document.body).on('shown.bs.tab','.dinamicTab a[data-toggle="tab"]', function (e) {
		// console.log(e);
		var currentTarget = $(e.currentTarget);
		var index = currentTarget.parent().index();
		currentTarget.parent().parent().parent().parent().find('.tab-pane').hide();
		currentTarget.parent().parent().parent().parent().find('.tab-pane').eq(index).show();
	});


	applyToNewContainer($(document.body));
});
function generateModal(button,path,width,backdrop,keyboard){
	var modal = $("<div class='modal modal-ajax  modal-flex' tabindex='-1' data-focus-on='input:first'>");
	width = width?width:null;
	backdrop = backdrop?backdrop:null;
	keyboard = keyboard?keyboard:null;
	if(width!==null){
		if(width=='container'){
			modal.addClass('container');
		}else{
			modal.data('width',width);
		}
	}
	if(backdrop!==null){
		modal.data('backdrop',backdrop);
	}
	if(keyboard!==null){
		modal.data('keyboard',keyboard);
	}
	// fix solo para la gran nacion
	// modal.data('keyboard',keyboard);
	// modal.data('backdrop','static');
	if(path!=''){
		$(document.body).modalmanager('loading');
		modal.data('relatedButton',button);
		modal.data('relatedTarget',path);
		modal.load(path,function(response,status,xhr){
			if(status!='error'){
				$(document.body).append(modal);
				applyToNewContainer(modal);
				modal.modal();			
			}else{
				$(document.body).modalmanager('removeLoading');
				modal.remove();
				alert('Error del sistema :(');
			}
		});	
	}
}
function applyToNewContainer(container){
	applyValidation(container.find("form.validateForm"));
	applyDataTablesAjax(container.find('.hasDataTableAjax'));
	applyDataTables(container.find('.hasDataTable'));
	applyDatepickers(container.find('.calendarField'));
	applyHtmlBox(container.find('.content-section'));
	container.find('[data-toggle="tooltip"]').tooltip();
	container.find(".numberField").number(true,2);
	container.find('[data-toggle="popover"]').popover({html:true});
	container.find('.imgZoom').elevateZoom({scrollZoom:true});
}
function applyHtmlBox(elements){
		elements.trumbowyg({
		btnsDef: {
		    // Create a new dropdown
		    image: {
		        dropdown: ['insertImage', 'base64'],
		        ico: 'insertImage',
		        langs:'es',
		    }
		},
	  	btns: ['viewHTML',
	    '|', 'formatting',
	    '|', 'btnGrp-design',
	    '|', 'link',
	    '|', 'image',
	    '|', 'btnGrp-justify',
	    '|', 'btnGrp-lists',
	    '|', 'horizontalRule'],
		lang:'es',
	    fullscreenable: true,
	    removeformatPasted: true
	});
}
function applyDatepickers(elements){
	elements.datepicker({
		dateFormat:'yy-mm-dd',
	});
}

var searchTimmer;
function applyDataTables(tables){
	tables.dataTable({
		language:languageTable,
		dom:"<'row'<'col-xs-6'l><'col-xs-6 text-right'f>r>" + "t" + "<'row'<'col-xs-6'i><'col-xs-6 text-right'p>>",
	});		
}
function applyDataTablesAjax(tables){
	tables.each(function(index,table){
		var tableAux = $(table);
		var filters = false;
		var aux = $(table).DataTable({
			language:languageTable,
			processing:true,
			serverSide:true,
			order:[[0,"desc"]],
			stateSave: true,
			dom:'<"row"<"col-md-5"il><"col-md-1"r><"col-md-6 text-right"p>>t<"exportTable text-right">',
			stateLoadParams:function(settings,data){
				filters = data;
			},
			ajax: function(data,callback,settings){
				var url = $(this).data('ajax-url');
				$.get(url,data,function(r){
					callback(r);
				},'json');
			},
		});

	    aux.columns().eq(0).each(function(colIdx){
	    	if(filters){
	    	 	$('input,select',aux.column(colIdx).header()).val(filters.columns[colIdx].search.search);
	    	}
			// var search = filters.columns.eq(colIdx).
	        $('input,select',aux.column(colIdx).header()).on('keyup change',function(e){
	        	var value = this.value;
	        	clearTimeout(searchTimmer);
	        	searchTimmer = setTimeout(function(){
	            	aux.column(colIdx).search(value).draw();
	        	},500);
	        });
			$('input,select',aux.column(colIdx).header()).on('click',function(e){
				e.stopPropagation();
			});
	    });
	});
}
function reloadCurrentModal(parameters,callback){
	var best_modal = getCurrentModal();

	parameters = typeof parameters !== 'undefined'?parameters:{};
	var url_params = jQuery.param(parameters);
	var callback = typeof callback !=='undefined'?callback:function(r){};
	best_modal.modal('loading');
	best_modal.load(best_modal.data('relatedTarget'),parameters,function(r){
		best_modal.modal('removeLoading');
		callback(r);
		applyToNewContainer(best_modal);
		// best_modal.find(".txtEditor").Editor();
	});
}
function getCurrentModal(){
	var open_modals = $('.modal.in');
	var highest = 0;
	var best_modal = open_modals.eq(0); 
	open_modals.each(function(index,value){
		var zindex = parseInt($(this).parent().css('zIndex'),10);
		if(zindex>highest){
			highest=zindex;
			best_modal = open_modals.eq(index);
		}	
	});
	return best_modal;
}
function closeCurrentModal(callback){
	callback = callback || function(){};
	var m = getCurrentModal();
	m.on('hidden.bs.modal',function(){
		setTimeout(callback,330);//espera los 3ms de efecto de css
	}).modal('hide');
}
// Esta funcion aplica una validacion de "jquery.validatio" solo para la estructura de formularios de bootstrap
function applyValidation(objects){
	if(objects.length>0){
		objects.each(function(){
			$(this).validate({
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
	}
}
function reloadAjaxTables(){
	$(".hasDataTableAjax").DataTable().draw();
}
// Bootstrap fixes
function showAlert(message,type,closeOthers,showClose){
	type = type || 'success';
	message = message || 'Ok!';
	showClose = showClose || true;
    if(type=='success'){
    	if(closeOthers){
    		alertify.success(message).dismissOthers();
    	}else{
    		alertify.success(message);	
    	}
    }else{
    	if(closeOthers){
    		alertify.error(message).dismissOthers();
    	}else{
    		alertify.error(message);	
    	}    	
    }
}