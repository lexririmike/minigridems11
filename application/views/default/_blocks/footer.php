<!--footer-->
		<div class="footer">
		   <p>&copy; 2016 EMS| 
		   <a href="https://serc.strathmore.edu/" target="_blank">SERC</a> |
		   <a href="https://www.giz.de/en/worldwide/317.html" target="_blank">GIZ</a></p>
	
		</div>
        <!--//footer-->
	</div>
	<!-- Classie -->
	<?php if(!empty($js))
{echo $js;}
?>
		<script src="<?php echo base_url('asset/js/classie.js');?>"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			
			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
	<!--scrolling js-->
	<script src="<?php echo base_url('asset/js/jquery.nicescroll.js');?>"></script>
	<script src="<?php echo base_url('asset/js/scripts.js');?>"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="<?php echo base_url('asset/js/bootstrap.js');?>"> </script>
   
   

   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSj-5cG2nxoGjeq3g7alli8adJBUxPYFI&callback=initMap"
  async defer>
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
 
</body>
</html>