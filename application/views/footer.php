
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="http://duacreation.com/" target="_blank">infosolution</a> 2020</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="<?= base_url() ?>/vendor/global/global.min.js"></script>
	<script src="<?= base_url() ?>/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="<?= base_url() ?>/vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="<?= base_url() ?>/js/custom.min.js"></script>
	<script src="<?= base_url() ?>/js/deznav-init.js"></script>
	<script src="<?= base_url() ?>/vendor/owl-carousel/owl.carousel.js"></script>
	
	<!-- Chart piety plugin files -->
    <script src="<?= base_url() ?>/vendor/peity/jquery.peity.min.js"></script>
	
	<!-- Apex Chart -->
	<script src="<?= base_url() ?>/vendor/apexchart/apexchart.js"></script>
	
	<!-- Dashboard 1 -->
	<script src="<?= base_url() ?>/js/dashboard/dashboard-1.js"></script>
	<!-- Datatable -->
	<script src="<?= base_url() ?>vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>js/plugins-init/datatables.init.js"></script>
	<script>
		function carouselReview(){
			/*  testimonial one function by = owl.carousel.js */
			jQuery('.testimonial-one').owlCarousel({
				loop:true,
				autoplay:true,
				margin:30,
				nav:false,
				dots: false,
				left:true,
				navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
				responsive:{
					0:{
						items:1
					},
					484:{
						items:2
					},
					882:{
						items:3
					},	
					1200:{
						items:2
					},			
					
					1540:{
						items:3
					},
					1740:{
						items:4
					}
				}
			})			
		}
		jQuery(window).on('load',function(){
			setTimeout(function(){
				carouselReview();
			}, 1000); 
		});
	</script>            
        <!-- Jquery Validation -->
        <script src="<?= base_url() ?>vendor/jquery-validation/jquery.validate.min.js"></script>
        <!-- Form validate init -->
        <script src="<?= base_url() ?>js/plugins-init/jquery.validate-init.js"></script>

        <script>
        jQuery(document).ready(function(){
            
            jQuery('.show-pass').on('click',function(){
                jQuery(this).toggleClass('active');
                if(jQuery('#dz-password').attr('type') == 'password'){
                    jQuery('#dz-password').attr('type','text');
                }else if(jQuery('#dz-password').attr('type') == 'text'){
                    jQuery('#dz-password').attr('type','password');
                }
            });
            
            

        });
        </script>	
</body>
</html>