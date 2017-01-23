<script>
$(document).ready(function() 
    { 
      
    
	$(document).on('show.bs.modal','#confirm-delete', function(e) {
    	$(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
		$(this).find('#title').html($(e.relatedTarget).data('title'));
	});	
	
	$('#sorttable').DataTable();
	
	$('#sorttable1').DataTable();
	
	$('#sorttable2').DataTable();
	
	$('#sorttable3').DataTable();
	
	$('#sorttable4').DataTable();
	
	

	

    } 
); 
</script>
<script type="text/javascript">
            $(function () {
                $('#datetimepicker').datetimepicker({
					
					format: 'MM/DD/YYYY'
				});
            });
			$('#datetimepicker3').datetimepicker({
                    format: 'LT'
                });
				
				$('#datetimepicker2').datetimepicker({
                    format: 'LT'
                });
        </script>