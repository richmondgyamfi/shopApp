<footer style="text-align: center;" class="text-center" id="footer">&copy; Copyright 2018-2019 Amine Studios</footer>

	
	<script>
		function detailsmodal(id){
			// alert(id)

			var data = {"id" : id};
			jQuery.ajax({
				//url : <?=BASEURL; ?>+'../shopApp/modal.php',
				url : '../shopApp/modal.php',
				method : "post",
				data : data,
				success : function(data){
					jQuery('body').append(data);
					jQuery('#details_modal').modal('toggle');
				},
				error : function(){
					alert("Something isn't right");
				}
			});
		}
	</script>


	<!-- <script type="text/javascript" src="js/cscsite.js"></script> -->
	<script type="text/javascript" src="js/material.min.js"></script>
	<script type="text/javascript" src="js/tether.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<!-- <script type="text/javascript" src="js/angular.min.js"></script> -->
</body>
</html>