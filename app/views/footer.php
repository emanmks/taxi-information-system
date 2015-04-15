</div>
<!-- End of Content -->
	
	<!-- Footer
	================================================== -->
	<footer class="footer">
		<div class="container">
			<p class="pull-right">Unggul Informatika</p>
			<p>PT. Gempita Gemintang Gemilang</p>
		</div>
	</footer>
	<!-- End of Footer -->

	
	<!-- Javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	
	<script type="text/javascript">
		var site = "<? echo URL; ?>";
		var loading_image_large = "<? echo URL;?>assets/img/loading_large.gif";
        var loading_image_small = "<? echo URL;?>assets/img/loading.gif";
		function logout()
		{
			dummyload('index/logout');
			alert('Logout Sukses. Sampai Jumpa!');
			window.location = '<? echo URL; ?>';
		}
		function printArea()
		{
			$("div#printArea").printElement(
	        {
	            leaveOpen:true,
	            printMode:'popup'
	        });
		}
	</script>
	</body>

</html>