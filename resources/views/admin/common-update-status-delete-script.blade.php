{!! Form::open(array( 'id '=> 'delete-record-form' , 'method' => 'post' ,  'url' => config("constants.REMOVE_RECORD_URL") )) !!}
	<input type="hidden" name="delete_record_id" value="">
	<input type="hidden" name="delete_module_name" value="">
{!! Form::close() !!}
		 
{!! Form::open([ 'id ' => 'manage-session-messages-form', 'method' => 'post', 'url' => config("constants.MANAGE_SESSION_MESSAGES_URL") ]) !!}
	<input type="hidden" name="session_redirect_module_url" value="">
	<input type="hidden" name="session_redirect_module_name" value="">
	<input type="hidden" name="session_redirect_module_action" value="add">
{!! Form::close() !!}

<script>

function updateRecordStatus(thisitem){
	event.preventDefault();
	var module_name = $.trim($(thisitem).attr('data-module-name'));
	var record_id = $(thisitem).attr("data-record-id");
	var	action_url = backend_site_url + module_name + "/updateStatus";
	var	current_row = $(thisitem);
	var	status = $.trim($(thisitem).parents('.status-class').find('.record-status').text());
	
	//temper module name for lookup_module
	var lookup_module_name = '';
	if( module_name == "{{ config('constants.LOOKUP_MASTER_MODULE') }}" ){
		lookup_module_name = $(thisitem).attr("data-lookup-module-name");
	}
	if( module_name == "{{ config('constants.CATEGORY_MASTER_MODULE') }}" ){
		lookup_module_name = $(thisitem).attr("data-lookup-module-name");
	}
	var confirm_update_msg = '';

	switch(status){
		case '{{ config("constants.ENABLE_STATUS") }}':
	        confirm_update_msg = "{{ trans ( 'messages.update-status-msg', [ 'module' => trans('messages.disable') ] ) }}";
			break;
		case '{{ config("constants.DISABLE_STATUS") }}':
		    confirm_update_msg = "{{ trans ( 'messages.update-status-msg', [ 'module' => trans('messages.enable') ] ) }}";
			break;
		case '{{ config("constants.ACTIVE_STATUS_TEXT") }}':
	        confirm_update_msg = "{{ trans ( 'messages.update-status-msg', [ 'module' => trans('messages.inactive') ] ) }}";
			break;
		case '{{ config("constants.INACTIVE_STATUS_TEXT") }}':
		    confirm_update_msg = "{{ trans ( 'messages.update-status-msg', [ 'module' => trans('messages.active') ] ) }}";
			break;
		default:
			alertifyMessage('error','{{ trans("messages.system-error") }}');
			break;
	}
	
	alertify.confirm('{{ trans("messages.update-status") }}', confirm_update_msg , function(){	
		
		//ajax reqeust
	   jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : action_url,
			data : { 'record_id' : record_id , 'current_status' : status , 'lookup_module_name' : lookup_module_name ,  'module_name' : module_name  },
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			beforeSend: function() {
		        //block ui
				showLoader();
		    },success:function(response){
		    	hideLoader();
				if(response.status_code == "{{ config('constants.SUCCESS_AJAX_CALL') }}") {
					if( $(document).find('.filter-button').length  > 0  ){
						filterData();
					}
					alertifyMessage('success',response.message);
					$(thisitem).parents('.status-class').find('.record-status' ).text(response.data.update_status) ;
					status = response.data.update_status;
				} else if(response.status_code == "{{ config('constants.ERROR_AJAX_CALL') }}") {
					alertifyMessage('error',response.message);
				} else {
					alertifyMessage('error','{{ trans("messages.system-error") }}');
				}
				
				switch(status){
				case '{{ config("constants.ENABLE_STATUS") }}':
					$(thisitem).prop('checked', true);
					break;
				case '{{ config("constants.DISABLE_STATUS") }}':
					$(thisitem).prop('checked', false);
					break;
				case '{{ config("constants.ACTIVE_STATUS_TEXT") }}':
					$(thisitem).prop('checked', true);
					break;
				case '{{ config("constants.INACTIVE_STATUS_TEXT") }}':
					$(thisitem).prop('checked', false);
					break;
				}
		    },error:function(){
		    	
		    }
	   });
	}, function(){
		
		switch(status){
			case '{{ config("constants.ENABLE_STATUS") }}':
				$(thisitem).prop('checked', true);
				break;
			case '{{ config("constants.DISABLE_STATUS") }}':
				$(thisitem).prop('checked', false);
				break;
			case '{{ config("constants.ACTIVE_STATUS_TEXT") }}':
				$(thisitem).prop('checked', true);
				break;
			case '{{ config("constants.INACTIVE_STATUS_TEXT") }}':
				$(thisitem).prop('checked', false);
				break;
		}
	});;
}

function deleteRecord(thisitem){
	var module_name = $.trim($(thisitem).attr('data-module-name'));
	var msg_module_name = $.trim($(thisitem).attr('data-msg-module-name'));
	
	var confirm_box = '{{ trans("messages.delete") }}' + ' ' + enumText(msg_module_name);
	var confirm_box_msg = '{{ trans("messages.common-module-confirm-js-msg") }}' + '{{ trans("messages.delete") }}' + ' This ' + enumText(msg_module_name) + '?';
	

	alertify.confirm(confirm_box, confirm_box_msg , function () {
		
		var record_id = $.trim($(thisitem).attr('data-record-id'));

		if( module_name != '' && module_name != null && record_id != null &&  record_id != "" ){

			$("[name='delete_module_name']").val(msg_module_name);
			
			$("[name='delete_record_id']").val(record_id);
			showLoader();

			var delete_url = backend_site_url + module_name + "/delete/" + record_id;
			
			$("#delete-record-form").attr('action' , delete_url);
			$("#delete-record-form").submit();
		}
	}, function () { });
}

</script>