$(document).ready(function () {
	
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
					$('.table-responsive').html(response.result);
				  }
	});
} 
