@php $index =  ( $pageNo - 1 ) * $perPageRecord @endphp
@if(count($recordDetails) > 0 )
	
	@foreach ($recordDetails as $key => $recordDetail) 
		<?php $encodeRecordId = Message::encode($recordDetail->i_id) ?> 
		<tr  class="has-record">
          <td class="sr-col">{{ ++$index }}</td>
          <td class="">{{  ( (checkNotEmptyString($recordDetail->loginInfo->v_name)) ? $recordDetail->loginInfo->v_name : '' )   }}</td>
          <td class="">{{  ( (!empty($recordDetail->dt_created_at)) ? clientDateTime ( $recordDetail->dt_created_at ) : '' )   }}</td>
          <td class="">{{  ( (!empty($recordDetail->v_ip)) ? ( $recordDetail->v_ip ) : '' )   }}</td>
   		</tr>                                  
@endforeach
	@if(!empty($pagination))
		<input name="current_page" type="hidden" value="{{ ( isset($pagination['current_page']) ? $pagination['current_page'] : '' ) }}">
        <input name="last_page" type="hidden"  value="{{ ( isset($pagination['last_page']) ? $pagination['last_page'] : '' )  }}">
        <input name="per_page" type="hidden"  value="{{ ( isset($pagination['per_page']) ? $pagination['per_page'] : '' )  }}">
	@endif
@else
      <tr class="text-center"><td colspan="6">{{ trans('messages.no-record-found') }} </td></tr>        
@endif
@include(  config('constants.ADMIN_FOLDER') . 'common-display-count' )

										