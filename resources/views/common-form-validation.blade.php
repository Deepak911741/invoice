@if (isset($errors) && count($errors) > 0)
	@foreach ($errors->messages() as $errorField =>  $error)
        @php
        	$fieldName = $errorField;
            $formEror = ( isset($error[0]) ? $error[0] : '' );
        @endphp
		<script>
		$(function(){
			if( $('[name="<?php echo $fieldName ?>"]').hasClass('select2')  != false ){
				$('<label class="error invalid-input"><?php echo  $formEror ?></label>').insertAfter($('[name="<?php echo $fieldName ?>"]').parents('.form-group').find('.select2-container'));
			} else if( $('[name="<?php echo $fieldName ?>"]').hasClass('form-check-input')  != false  ){
				$('<label class="error invalid-input"><?php echo  $formEror ?></label>').insertAfter($('[name="<?php echo $fieldName ?>"]').parents('.form-group').find('.custom-control:last'));
			} else {
				$('<label class="error invalid-input"><?php echo  $formEror ?></label>').insertAfter($('[name="<?php echo $fieldName ?>"]'));
			}
		});
		</script>
	@endforeach 
 @endif