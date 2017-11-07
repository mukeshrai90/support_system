$(document).ready(function () {
	
	try{
		if(hideTopBckBtn != undefined){
			$('.hideTopBckBtn').hide();
		}
	} catch(Error){}
	
	$.validator.addMethod('alphaSpace', function (value, element) {		
		var matchText = /^[A-Za-z\s]+$/i;
		return this.optional(element) || matchText.test(value);;
	}, "Please enter only alphabets with space");
	
	$.validator.addMethod('alphaNumeric', function (value, element) {		
		var matchText = /^[A-Za-z0-9]+$/i;
		return this.optional(element) || matchText.test(value);;
	}, "Please enter only alphabets with space");
	
	$.validator.addMethod('validAddress', function (value, element) {		
		var matchText = /^[A-Za-z\s\.\#\-\,]+$/i;
		return this.optional(element) || matchText.test(value);;
	}, "Only . and , and # and - special Chars are allowed");
    
	$.validator.addMethod("exactlength", function(value, element, param){
    	return this.optional(element) || value.length == param;
    },("Please enter exactly {0} characters"));
	
	$.validator.addMethod("validAmount", function(value, element, param){
    	var matchText = /^[0-9\.]+$/i;
		return this.optional(element) || matchText.test(value);;
    },("Please enter valid amount"));
	
	$(document).on('click','.search-btn',function(){
        reloadSearch();
	});
	
	$(document).on('click','.refresh-all',function(e){
		e.preventDefault();
		var url = $(this).attr('data-url');
		window.location.href = url;
	});
	
	$(document).on('input','.only-char',function(){ 		
		var $this = $(this);
		var regexp = /[^a-zA-Z]/g;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
	
	$(document).on('input','.only-char-space',function(){ 		
		var $this = $(this);
		var regexp = /[^a-zA-Z ]/g;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
	
	$(document).on('input','.only-number',function(){ 		
		var $this = $(this);
		var regexp = /[^0-9]/g;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
	
	$(document).on('input','.only-float',function(){ 		
		var $this = $(this);
		var regexp = /[^0-9\.]/g;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
	
	$(document).on('input','.only-alphaNum',function(){ 		
		var $this = $(this);
		var regexp = /[^a-zA-Z0-9]/g;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
	
	$(document).on('input','.only-alphaNum-space',function(){ 		
		var $this = $(this);
		var regexp = /[^a-zA-Z0-9\s]/g;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
	
	$(document).on('click','.paginate_button a',function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		
		history.pushState({isMine:true},pageTitle,url);
		
		showCustomLoader(true);
		$.ajax({
			type : 'POST',
			url : url,				
			dataType : 'json',
			error : function(){
				showCustomLoader(false);
			},
			success : function(response){
						 showCustomLoader(false);
						 $('.table-responsive').html(response.result);
					  }
		});
	});
	
	
	$(document).on('click','.print_page',function(e){
		//e.preventDefault();
		
		var thisRel = $(this).attr('rel');
		
		var current_url = window.location.href;
		var reg = /[\=\&]/;
		if(reg.test(current_url)){
			current_url = current_url + '&print=YES';
		} else {
			current_url = current_url + '?print=YES';
		}
		
		$(this).attr('href', current_url);
		//console.log(current_url);
	});
	
	$(document).on('click','.inc_comm_detls_load_ajx',function(e){
		e.preventDefault();
		
		var href = $(this).attr('href');
		if(href != ''){
			$('#myIncCommDtlsModal').modal('toggle');
			var ldrHtml = '<div class="row" id="prod_loader_div" style="text-align:center;margin:28px 0px;">'+
								'<div class="col-lg-12">'+
									'<img alt="loading" src="'+ASSETS_URL+'img/ajax_loader11.gif"/>'+
								'</div>'+
							'</div>';
							
			$('#myIncCommDtlsModal').find('.modal-body').html(ldrHtml);
			//return false;
			$.ajax({
				type : 'POST',
				url : href,				
				dataType : 'json',
				error : function(){
					customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
					$('#myIncCommDtlsModal').find('.modal-body').html('');
				},
				success : function(response){
					 $('#myIncCommDtlsModal').find('.modal-title').html(response.pageTitleNew);
					 $('#myIncCommDtlsModal').find('.modal-body').html(response.result);
				}
			});
			return false;
		}
	});
});

function reloadSearch() 
{	
	var pageUrlTemp = pageUrl.split('?');
	if(pageUrlTemp[1] != undefined){
		var url = pageUrl+'&'+$('#search-form').serialize();
	} else {
		var url = pageUrl+'?'+$('#search-form').serialize();
	}
	
	
	history.pushState({isMine:true},pageTitle,url);
	
	showCustomLoader(true);
	$.ajax({
		type : 'POST',
		url : url,				
		dataType : 'json',
		error : function(){
			showCustomLoader(false);
		},
		success : function(response){
					showCustomLoader(false);
					try {
						if(response.subPageTitle != undefined){
							$('.subPageTitle').html(response.subPageTitle);
						} 
						$('.table-responsive').html(response.result);
					} catch(Error){ 
						$('.table-responsive').html(response.result);
					}
				  }
	});
} 
