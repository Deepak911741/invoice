<script>
function redirectPreviousPage() {
    window.history.back();
}

var datatable_per_page_record = 0;
function displayDataTable( class_name , pagination_url , search_data , table_columns , pagination_require = true , sort_order = [] , additional_custom_options = []   ){
	if(additional_custom_options.length === 0){
		var additional_custom_options = {};
		additional_custom_options['fixedHeader'] = {
                "header": true,
                "headerOffset": 40
            };
		additional_custom_options['scrollX'] = 100;
		additional_custom_options['scrollY'] = 'calc(100vh - 280px)';
        
		additional_custom_options['fnFooterCallback'] = function (nRow, aaData, iStart, iEnd, aiDisplay) {
            $(".dataTables_scrollBody").addClass('no-record');
            if (aiDisplay.length > 6) {
                $(".dataTables_scrollBody").removeClass('no-record');
            }
            else {
                $(".dataTables_scrollBody").addClass('no-record');
            }
        };
	}

	var common_options = {};
	common_options['bProcessing'] = true;
	common_options['iDisplayLength'] = 10;
	common_options['paging'] = pagination_require;
	common_options['searching'] = false;
	common_options['bDestroy'] = true;
	common_options['bServerSide'] = true;
	common_options['order'] = sort_order;
	common_options['dom'] = '<"top"b>rt<"bottom datatable-new-bottom"ilp><"clear">';
	common_options['ajax'] = {
        url : pagination_url,
        type: "post",
        data: search_data,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function() {
	        //block ui
			showLoader();
	    },
	    dataFilter: function(response) {
			hideLoader();
        	if( response != "" && response  != null ){
        		var response_json_data = JSON.parse(response);
        		var total_display_record = ( ( response_json_data.iTotalDisplayRecords != "" && response_json_data.iTotalDisplayRecords != null ) ? response_json_data.iTotalDisplayRecords : 0 );
        		$(".total-record-count").html( total_display_record.toLocaleString('en-IN'));

        		if(total_display_record > 0){
        			if($(".sort-order-btn").attr("data-sort-order") == '{{ config("constants.INACTIVE_STATUS") }}'){
        				$('.update-seq-div').show();
            		}
        		} else {
        			$('.update-seq-div').hide();
        		}

        		datatable_pagination_last_page = response_json_data.pageNo;
        		datatable_per_page_record = ($("[name='"+class_name+"_length']").length > 0 && $("[name='"+class_name+"_length']").val() != null && $("[name='"+class_name+"_length']").val() != '' ? $("[name='"+class_name+"_length']").val() : 0);
            } else {
            	$(".total-record-count").html(0);	
	        }
        	return response;
        },
        error: function(){
        	hideLoader();
        }
    };
	common_options['createdRow'] = function ( row, data, index ) {
    	var record_id = $(data.sr_no).attr('id');
		if( record_id != "" && record_id != null ){
			$(row).attr( 'id' , record_id);
		}
   	},
	common_options['columns'] = table_columns;
	
	var datatable_config_options = common_options;
    if( additional_custom_options != "" && additional_custom_options != null ){
    	var datatable_config_options = {
        	    ...common_options,
        	    ...additional_custom_options
        };
    }
    data_table = $('#'+class_name).DataTable(datatable_config_options);
}
</script>