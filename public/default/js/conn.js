/*nav*/
$(function(){
		$(".nav>li").hover(function(){
			$(this).children('ul').stop(true,true).show(400);
		},function(){
			$(this).children('ul').stop(true,true).hide(400);
		})
	});

/*search*/
$(function(){ 
$(".search_ico").click(function(){ 
$(".search_bar").toggleClass('search_open'); 
var keys = $("#keyboard").val(); 
if(keys.length>2){ 
$("#keyboard").val(''); 
$("#searchform").submit(); 
}else{ 
return false; 
} 
}); 
}); 

/*banner*/
$(function() {
	$('#ban').easyFader();
});

