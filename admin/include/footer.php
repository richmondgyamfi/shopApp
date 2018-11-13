<footer class="col-md-12 text-center" id="footer">&copy; Copyright 2018-2019 Amine Studios</footer>

	

<script>
	function updateSizes(id){
		var sizeString = '';
		for (var i=1; i <= 12; i++) {
			if(jQuery('#size'+i).val() != ''){
				sizeString += jQuery('#size' +i).val()+':' +jQuery('#qty' +i).val()+',';
			}
		}
		jQuery('#sizes').val(sizeString);
	}

	$(document).ready(function(){
		$('#parent').change(function(){
			var parentID = $(this).val();

			$.ajax({
				url: 'parsers/child_categories.php',
				method: 'POST',
				data: {parentID : parentID},
				success: function(data){
					window.alert(parentID);
					$('#child').html(data);
			},
			error: function(){
					alert("Something went wrong with the child option.")}
		});
	});
	});

</script>

	<!-- <script>
		function get_child_options(){
			var parentID = jQuery['#parent'];
			jQuery.ajax({
				url: 'parsers/child_categories.php',
				type: 'POST',
				data: {parentID : parentID},
				success: function(data){
					window.alert(parentID);
					jQuery('#child').html(data);
				},
				error: function(){
					alert("Something went wrong with the child option.")},
			});
		}
		jQuery('select[name="parent"]').change(get_child_options);
	</script> -->



	<!-- <script type="text/javascript" src="js/cscsite.js"></script> -->
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/material.min.js"></script>
	<script type="text/javascript" src="../js/tether.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<!-- <script type="text/javascript" src="js/angular.min.js"></script> -->
</body>
</html>