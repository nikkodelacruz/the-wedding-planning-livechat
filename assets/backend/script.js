(function($){
	'use strict';

	$(document).ready(function(){

		
	 	// Material design datatables

	  	var table = $('.messages-table').DataTable({
	  	 	"ordering": false,
	  	});

	  	$('.custom-search').on('change', function () {
            table.search($(this).val()).draw() ;
        } );

	  	
        $('select').formSelect();
		$('.modal').modal();

	});

})(jQuery);