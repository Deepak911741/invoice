$(window).scroll(function() {
    var last_page = $("[name='last_page']").val();
    var current_page = $("[name='current_page']").val();
    current_page = parseInt(current_page) + 1 ;
 
    var scrollTop = $(window).scrollTop();
 
    scrollTop = parseFloat(scrollTop).toFixed(0);
 
    if(($(window).scrollTop() + $(window).height()) >= ( $(document).height() - $(".navbar").outerHeight() ) ) { 

    	if(last_page >= current_page ){
	
			var search_fields = searchField();
			
			search_fields.page = current_page;
			
			var response = searchAjax( pagination_url , search_fields  , true);
			   
			if( response != false ) { 
				$("[name='current_page']").val(current_page);
			}
		}
    }

});