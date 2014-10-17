	

	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-content/plugins/wp-postratings/postratings-jsfa27.js?ver=1.63'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/underscore.minaff7.js?ver=1.6.0'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/shortcode.min2e46.js?ver=3.9.2'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/backbone.mincfa9.js?ver=1.1.2'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/wp-util.min2e46.js?ver=3.9.2'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/wp-backbone.min2e46.js?ver=3.9.2'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/media-models.min2e46.js?ver=3.9.2'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/plupload/wp-plupload.min2e46.js?ver=3.9.2'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/jquery/ui/jquery.ui.core.min2c18.js?ver=1.10.4'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/jquery/ui/jquery.ui.widget.min2c18.js?ver=1.10.4'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/jquery/ui/jquery.ui.mouse.min2c18.js?ver=1.10.4'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/jquery/ui/jquery.ui.sortable.min2c18.js?ver=1.10.4'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/media-views.min2e46.js?ver=3.9.2'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/media-editor.min2e46.js?ver=3.9.2'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/media-audiovideo.min2e46.js?ver=3.9.2'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-includes/js/comment-reply.min2e46.js?ver=3.9.2'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-content/themes/wpcook/js/functions4a02.js?ver=2013-07-18'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-content/themes/wpcook/js/jquery.flexslider2e46.js?ver=3.9.2'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-content/themes/wpcook/js/jquery.easing.1.34a02.js?ver=2013-07-18'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-content/themes/wpcook/js/jquery.isotope.min4a02.js?ver=2013-07-18'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-content/code.jquery.com/ui/1.10.4/jquery-ui4a02.js?ver=2013-07-18'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-content/themes/wpcook/js/jquery.tools.min4a02.js?ver=2013-07-18'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-content/themes/wpcook/js/menu4a02.js?ver=2013-07-18'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-content/themes/wpcook/inc/like/i-like-this4a02.js?ver=2013-07-18'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-content/themes/wpcook/js/custom4a02.js?ver=2013-07-18'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-content/themes/wpcook/js/jquery.carouFredSel-6.2.1-packed4a02.js?ver=2013-07-18'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-content/themes/wpcook/js/classie4a02.js?ver=2013-07-18'></script>
	<script type='text/javascript' src='<?php echo base_url();?>assets/wp-content/themes/wpcook/js/AnimOnScroll4a02.js?ver=2013-07-18'></script>
	<?php
	if($this->session->userdata("msg") != ''){
		echo "<script>alert('".$this->session->userdata("msg")."')</script>";	

		$this->session->unset_userdata("msg");
	}
	?>
	</body>

</html>