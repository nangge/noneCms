var loading = false;

$(document).bind("mobileinit", function(){
	$.mobile.defaultPageTransition = 'none';
	$.mobile.loadingMessage = 'loading';
	$.mobile.fixedToolbars.setTouchToggleEnabled(false);
	$.event.special.swipe.horizontalDistanceThreshold = 130;
}).bind('pagechange',function(e,d){
	if(d.options.reverse){
		$('ul.zzp-lists a.touch').removeClass('touch');
	}

	$('ul.zzp-lists').undelegate().delegate('a','click',function(){
	  		var $this=$(this);
	  		$this.closest('ul.zzp-lists').find('a.touch').removeClass('touch');
	  		$this.addClass('touch');
	})
});

function getContext(){
	return $("div:jqmData(role='page'):last");
}

function debug(content){
	//console.log(content);
}

function initCategory(){
	var context = getContext();
	jQuery("#menu-second",context).hide();
	jQuery("#InfoCate",context).click(function(){		
		if(jQuery(".ui-page-active #menu-second").css('display') == 'none'){
			jQuery(".ui-page-active #menu-second").show();
			jQuery(".ui-page-active #InfoCate").removeClass("fold");
			jQuery(".ui-page-active #InfoCate").addClass("expand");
		}else{
			jQuery(".ui-page-active #menu-second").hide();
			jQuery(".ui-page-active #InfoCate").removeClass("expand");
			jQuery(".ui-page-active #InfoCate").addClass("fold");
		}
		
		return false;
	});
}

function initProduct(){
	var context = getContext();
	var count=3;	
	if(jQuery("#pmcCountTime",context).val()=='time'){
    var timer=window.setInterval(function(){
		count--;
		if(count<=0){
			clearInterval(timer);
			//璺宠浆
			window.history.back(-1); //0绉掓椂杩斿洖涓婁竴姝�
		}
	},1000);
}
	jQuery("#category_s",context).click(function(){
	      if(jQuery(".ui-page-active #category_l").css('display') == 'none'){
			jQuery(".ui-page-active #category_l").show();
			jQuery(".ui-page-active #category_s").removeClass("fold");
			jQuery(".ui-page-active #category_s").addClass("expand");
		}else{
			jQuery(".ui-page-active #category_l").hide();
			jQuery(".ui-page-active #category_s").removeClass("expand");
			jQuery(".ui-page-active #category_s").addClass("fold");
		}
	});	
}

$(".page_index").live('pageinit',function(event){
	loading = false;	
	initCategory();

	$(".page_index").unbind("swipeleft swiperight").bind("swipeleft", function( event, data ){
		debug(".page_index swipeleft");
	
	}).bind("swiperight", function( event, data ){
		debug(".page_index swiperight");
		
	});
});	

$(".page_products_list").live('pageinit',function(event){
	loading = false;	
	initProduct();

	
	});
$(".page_news_list").live( 'pageinit',function(event){
	loading = false;	
	initCategory();

});


$(".page_products_detail").live( 'pageinit',function(event){	
	debug(".page_products_detail pageinit");	
	
	loading = false;	
	initProduct();	

	
	}).bind("swiperight", function( event, data ){
		debug(".page_products_detail swiperight");
		
});

$(".page_news_detail").live( 'pageinit',function(event){
	debug(".page_news_detail pageinit");
	
	loading = false;	
	initCategory();
	

	}).bind("swiperight", function( event, data ){
		debug(".page_news_detail swiperight");
			
	
});

function setCurrentColumn(clickColumn){
	sessionStorage["currentColumn"]=clickColumn;
}

function submitTotalSearch(){
	sessionStorage["currentColumn"]='1';
	$('.ui-page-active #totalSearch').submit()
}