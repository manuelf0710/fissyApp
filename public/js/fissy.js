const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 4000,
	timerProgressBar: true,
	onOpen: (toast) => {
	  toast.addEventListener('mouseenter', Swal.stopTimer)
	  toast.addEventListener('mouseleave', Swal.resumeTimer)
	}
  })
$(function() {
$("[data-trigger]").on("click", function(e){
    e.preventDefault();
    e.stopPropagation();
    var offcanvas_id =  $(this).attr('data-trigger');
    $(offcanvas_id).toggleClass("show");
    $('body').toggleClass("offcanvas-active");
    $(".screen-overlay").toggleClass("show");
}); 

$(".btn-close, .screen-overlay").click(function(e){
    $(".screen-overlay").removeClass("show");
    $(".mobile-offcanvas").removeClass("show");
    $("body").removeClass("offcanvas-active");
}); 	
	
$('#body-row .collapse').collapse('hide'); 

// Collapse/Expand icon
$('#collapse-icon').addClass('fa-angle-double-left'); 

// Collapse click
$('[data-toggle=sidebar-colapse]').click(function() {
    SidebarCollapse();
});


//$('#fissy_table').DataTable().ajax.reload(null, false);

$("body").on("click", ".showmodalfissy", function(e){
	e.preventDefault();
	url = $(this).attr("data-url");
	$('#modal-fissy-details').modal('show');
	$("#modal-fissy-details .modal-body").html('');
	
	$("#modal-fissy-details .modal-body").load(url, function () {
		
	});
});	

$("body").on("click", ".folder-add-documents", function(e){
	e.preventDefault();
	url = $(this).attr("data-url");
	$('#modal-add-doc').modal('show');
	//$("#modal-fissy-details .modal-body").html('');
	
	/*$("#modal-fissy-details .modal-body").load(url, function () {
		
	});*/
});	

$("body").on("click", "#btn_aplicar_fissy", function(e){
	url = $(this).attr('data-url');
	
	Swal.fire({
	  title: '',
	  text: "Seguro que desea Aplicar a este Fissy?",
		showClass: {
		popup: '',
		icon: ''
	  },
	  hideClass: {
		popup: '',
	  },
	  showCancelButton: true,
	  showCloseButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  //confirmButtonText: 'Enviar!'
	  confirmButtonText:
		'<i class="fa fa-check"></i> Si Aplicar !',
	  cancelButtonText:
		'<i class="fa fa-close"></i> Cancelar',		  
	}).then((result) => {
	  if (result.value) {
				  disableButton('btn_aplicar_fissy');
				  var date = new Date();
				  var timestamp = date.getTime();
				  $.ajax({
					  type: 'GET',
					  url: url+"?_token="+$('input[name=_token]').val()+"&timestamp="+timestamp,
					  dataType: 'json',
					  success : function(r){
							  if(r.status == '200'){
								  displayToast("Has Aplicado correctamente a este fissy");
								  $("#btn_aplicar_fissy").remove();
							  }else{
								  displayToast("Error al aplicar a este Fissy", "error");
								  enableButton('btn_aplicar_fissy', 'Aplicar');
							  }
							  
						  },
					  data: {},
					  error   : function(XMLHttpRequest, textStatus, errorThrown){
					  alert("Respuesta del servidor "+XMLHttpRequest.responseText);
					  alert("Error "+textStatus);
					  alert(errorThrown);
					  }
				  });	
				}
	  })	
});

	 $(".card-pago").click(function(e){
	e.preventDefault();
	id = $(this).attr("data-id");
	removeSelected('.card-pago');
    $("#cardtipopago"+id).addClass("tipo-pago-selected");
	$("#tipo_pago").val(id);
	confirmFissy();
}); 

function confirmFissy(){
	setTimeout(function(){
		Swal.fire({
		  title: '',
		  text: "Seguro que desea Crear Este Fissy?",
		  //icon: 'warning',
		  //animation: false,
		    showClass: {
			popup: '',
			icon: ''
		  },
		  hideClass: {
			popup: '',
		  },
		  showCancelButton: true,
		  showCloseButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  //confirmButtonText: 'Enviar!'
		  confirmButtonText:
			'<i class="fa fa-check"></i> Crear !',
		  cancelButtonText:
			'<i class="fa fa-close"></i> Cancelar',		  
		}).then((result) => {
		  if (result.value) {
			document.form_fissy.submit();
		  }
		})
		
	}, 200);
}

function removeSelected(selector){
	$( ""+selector ).each(function( index,value ) {
	  $(this).removeClass("tipo-pago-selected");
	});	
}

function SidebarCollapse () {
    $('.menu-collapsed').toggleClass('d-none');
    $('.sidebar-submenu').toggleClass('d-none');
    $('.submenu-icon').toggleClass('d-none');
    $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');
    
    // Treating d-flex/d-none on separators with title
    var SeparatorTitle = $('.sidebar-separator-title');
    if ( SeparatorTitle.hasClass('d-flex') ) {
        SeparatorTitle.removeClass('d-flex');
    } else {
        SeparatorTitle.addClass('d-flex');
    }
    
    // Collapse/Expand icon
    $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right');
}
	  
    function formatRepo (repo) {
		console.log(repo);
      if (repo.loading) return repo.text;
		avatar = ' <i class="fa fa-user fa-2x" style="color:#b2b1b0"></i>';
		if(repo.avatar != null && repo.avatar != ''){
			avatar = "<img src='" + $("#rooturl").val()+'/avatar/'+ repo.avatar + "' width='30' height='30' style='border-radius:50%; border:solid 2px #dcdcdc;'/>";
		}
		stars	=	`<div class="stars-puntaje-dashboard-user text-left">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star text-dark" ></span>
                    <span class="fa fa-star text-dark" ></span>
                    <span class="fa fa-star text-dark" ></span>
                    <span class="fa fa-star text-dark" ></span>
                    <span class="fa fa-star text-dark" ></span>				
                </div>`;
      var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__avatar'>"+avatar +" "+repo.text +"  "+stars+"</div>" +
        "<div class='select2-result-repository__meta'></div></div>";

      if (repo.description) {
        //markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
      }


      return markup;
    }

    function formatRepoSelection (repo) {
      return repo.full_name || repo.text;
    }

	
	$('#conectar').select2({
		tags: false,
		tokenSeparators: [','],
		minimumInputLength: 3,
		closeOnSelect: false,
		allowClear: true,
		placeholder: 'Buscar Contactos',	
		ajax: {
			dataType: 'json',
			url: $("#rooturl").val()+'/users/conectar?_token='+$("input[name=_token]").val(),
			delay: 350,
			data: function(params) {
				return {
					term: params.term
				}
			},
		processResults: function(data) {
			return {
				results: $.map(data, function(obj) {
					return {
						id: obj.id,
						text: obj.name,
						avatar:obj.avatar,
						stars:obj.stars,
					};
				})
			};
		},
		},
      escapeMarkup: function (markup) { return markup; },
      templateResult: formatRepo,
      templateSelection: formatRepoSelection		
		
	});	
	
	
	$( "#btn-recomendar" ).click(function() {
	  setTimeout(function(){
		  $("#email_invitado").focus();
		  }, 150);
	});


	$(".btn-confirm-contact" ).click(function(event) {
	  event.preventDefault();
	 
		Swal.fire({
		  title: '',
		  text: "Seguro que desea realizar esta acción?",
		  //icon: 'warning',
		  //animation: false,
		    showClass: {
			popup: '',
			icon: ''
		  },
		  hideClass: {
			popup: '',
		  },
		  showCancelButton: true,
		  showCloseButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  //confirmButtonText: 'Enviar!'
		  confirmButtonText:
			'<i class="fa fa-check"></i> Aprobar!',
		  cancelButtonText:
			'<i class="fa fa-close"></i> Cancelar',		  
		}).then((result) => {
		  if (result.value) {
			document.form1.submit();
		  }
		})	  
	});	
	$(".btn-noconfirm-contact" ).click(function(event) {
	  event.preventDefault();
	 
		Swal.fire({
		  title: '',
		  text: "Seguro que desea realizar esta acción?",
		  //icon: 'warning',
		  //animation: false,
		    showClass: {
			popup: '',
			icon: ''
		  },
		  hideClass: {
			popup: '',
		  },
		  showCancelButton: true,
		  showCloseButton: true,
		  confirmButtonColor: '#d33',
		  cancelButtonColor: '#5a5757',
		  //confirmButtonText: 'Enviar!'
		  confirmButtonText:
			'<i class="fa fa-check"></i> No Aprobar!',
		  cancelButtonText:
			'<i class="fa fa-close"></i> Cancelar',		  
		}).then((result) => {
		  if (result.value) {
			document.form1.submit();
		  }
		})	  
	});	
});

function displayMsg(msg='La operación fue realizada de manera exitosa', type='success'){
	Swal.fire({
		position: 'top-end',
		icon: type,
		title: msg,
		showConfirmButton: false,
		timer: 3000
	});
}

function displayToast(msg='La operación fue realizada de manera exitosa', type='success'){
    Toast.fire({
        icon: type,
        title: msg,
    })  
}
function disableButton(btn_id){
	$("#"+btn_id).attr("disabled", true);
	$("#"+btn_id).html('Procesando <i class="fa fa-spin fa-refresh" >');
}
function enableButton(btn_id, text='Procesando'){
	$("#"+btn_id).attr("disabled", false);
	$("#"+btn_id).html(text);
}

function setValueContacto(action, cod_contact){
	$("#data_action").val(action);
	$("#data_contacto").val(cod_contact);
}
function calcularCard4(monto, periodo, interes){
	pago_mensual = 0;
	pago_final = parseFloat((monto * (Math.pow(1+interes, periodo))).toFixed(2));
	$("#pagom4").html('$0');
	$("#pagof4").html('$'+new Intl.NumberFormat("de-DE").format(pago_final));
}
function calcularCard5(monto, periodo, interes){
	pago_mensual = parseFloat((monto * interes).toFixed(2));
	$("#pagom5").html('$'+new Intl.NumberFormat("de-DE").format(pago_mensual));
	$("#pagof5").html('$'+new Intl.NumberFormat("de-DE").format(monto));
}
function calcularCard6(monto, periodo, interes){
	pago_mensual = parseFloat((monto * ( (interes * (Math.pow(1+interes, periodo))) / ( (Math.pow(1+interes, periodo)) -1 ) )).toFixed(2));
	if(isNaN(pago_mensual)){ pago_mensual = 0; }
	$("#pagom6").html('$'+new Intl.NumberFormat("de-DE").format(pago_mensual));
	$("#pagof6").html('$0');
	console.log("pago mensual "+pago_mensual);
}

function showInfoCards(){
	monto = parseInt($("#monto").val());
	periodo =  parseInt($("#periodo").val());
	interes = parseFloat($("#interes").val())/100;
	interes2 = parseFloat($("#interes").val())
	$("#containertipopago").css("visibility","hidden");
	
	if(monto > 0 && periodo > 0 && interes >=0){
			$( ".montocard" ).each(function( index,value ) {
			  $(this).html('$'+ new Intl.NumberFormat("de-DE").format(monto));
			 
			});
			$( ".interescard" ).each(function( index,value ) {
			  $(this).html(interes2+'%');
			});
			calcularCard4(monto, periodo, interes); /*>Interes y Capital y final al del periodo*/
			calcularCard5(monto, periodo, interes);/*Pago de intereses mensuales y capital al final*/
			calcularCard6(monto, periodo, interes); /*Pago de intereses y capital mensualmente*/
			$("#containertipopago").css("visibility","visible");
	}
}


function goToScroll(id){
	$("html, body").animate({ scrollTop: $("#"+id).offset().top }, 1500);
}