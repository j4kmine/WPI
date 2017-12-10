<footer>
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12">
					<h3 class="text-center">Our Store</h3>
					<div class="google-maps">
						<iframe allowfullscreen frameborder="0" height="450" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15866.542079712912!2d106.842038!3d-6.179517!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd53ba5c0ac431d3e!2sIce+Cream+Baltic!5e0!3m2!1sid!2sid!4v1512019432903" style="border:0" width="600"></iframe>
					</div>
				</div>
				<ul class="social-media">
					<li>
						<a href="https://www.instagram.com/eskrimbaltic/" target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/ig.png"></a>
					</li>
					<li>
						<a href="https://www.facebook.com/Baltic-Es-Krim-1530736643894609/" target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/fb.png"></a>
					</li>
					<li>
						<a href="https://twitter.com/EskrimBaltic" target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/twitter.png"></a>
					</li>
					<li>
						<a href="https://plus.google.com/u/1/110802607939351532479" target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/gplus.png"></a>
					</li>
				</ul>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>

	<script type="text/javascript">
	                 $(function() {
	                 $(".rslides").responsiveSlides();
	                 var currentdate = new Date(); 
	                   $('#datetimepicker4').datetimepicker({
                    defaultDate: (currentdate.getDate()+1) +"/"+currentdate.getMonth()+"/"+currentdate.getFullYear(),
                    disabledDates: [
                        moment("12/25/2013"),
                        new Date(2013, 11 - 1, 21),
                        "11/22/2013 00:53"
                    ]
                });
	               });
	                 $(window).scroll(function(){
	 var sticky = $('.sticky'),
	     scroll = $(window).scrollTop();

	 if (scroll >= 100) sticky.addClass('fixed');
	 else sticky.removeClass('fixed');
	});
	function addtocart(id){
          displayOverlay("Redirecting...");
        $.ajax({
          url:'<?php echo get_site_url();?>/?add-to-cart='+id,
          type:'GET',
          success:function(response){
              window.location = "<?php echo get_site_url();?>/cart/";
          }
          
        });
      }
       function displayOverlay(text) {
          $("<table id='overlay'><tbody><tr><td>" + text + "</td></tr></tbody></table>").css({
              "position": "fixed",
              "top": "0px",
              "left": "0px",
              "width": "100%",
              "height": "100%",
              "background-color": "rgba(0,0,0,.5)",
              "z-index": "10000",
              "vertical-align": "middle",
              "text-align": "center",
              "color": "#fff",
              "font-size": "40px",
              "font-weight": "bold",
              "cursor": "wait"
          }).appendTo("body");
      }

	</script>
	<!-- Google Analytics -->
		<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-29552512-1', 'auto');
		ga('send', 'pageview');
		</script>
	<!-- End Google Analytics -->
</body>
</html>