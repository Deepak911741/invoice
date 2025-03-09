<script>

<?php  if( isset($totalRecordCount) ) {  ?>
	$('.total-record-count').html('{{ decimalAmount($totalRecordCount) }}');
<?php } ?>
</script>