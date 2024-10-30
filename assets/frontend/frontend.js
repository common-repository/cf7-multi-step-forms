

jQuery( function( $ ) {

	/**
	 * Variations Price Matrix actions
	 */
	var cf7_wpms_frontend = {

		/**
		 * Initialize variations actions
		 */
		init: function() {
			$(document).on('click', '.cf7wpms-nav-left .btn', this.cf7ms_left);
			$(document).on('click', '.cf7wpms-nav-right .btn-cf7wpms-right', this.cf7ms_next);
			$(document).on('change', '.wpcf7-form', this.cf7wpms_form_change);
			$(document).on('click', '.btn-cf7wpms-submit', this.cf7wpms_form_submit);
			
			
			document.addEventListener( 'wpcf7submit', function( event ) {
				var $this = $('.btn-cf7wpms-submit.cf7wpms-loading');
				$this.removeClass('cf7wpms-loading');
				$this.prop( "disabled", false );
			}, false );

			this.first_load();
		},
		
		first_load: function(){
			var $count = $('#cf7wpms-progressbar li').length;
			
			if( $count > 1) {
				$('.btn-cf7wpms-right').css( "opacity", 1 );
			}
			
			
		},
		
		cf7wpms_form_change: function() {
			$('.cf7wpms-nav-right button').prop( "disabled", false );
			$('.cf7wpms-nav-right button').removeClass('cf7wpms-loading');
			$('.cf7wpms-error').removeClass('cf7wpms-error');
		},
		
		cf7ms_left: function() {
			var $this = $(this);
			$this.removeClass('cf7wpms-loading').addClass('cf7wpms-loading');
			$this.prop( "disabled", true );
			
			setTimeout(function(){
				var $prev = $('#cf7wpms-progressbar li.active').prev();
				$('#cf7wpms-progressbar li').removeClass('active');
				$prev.addClass('active');
				
				var $prev_tab = $prev.find('a').attr('href');
				$('.cf7wpms-panel').removeClass('active');
				$($prev_tab).addClass('active');
				
				$this.removeClass('cf7wpms-loading');
				$this.prop( "disabled", false );
				
				var $index = $('#cf7wpms-progressbar li.active').index() + 1;
				var $count = $('#cf7wpms-progressbar li').length;
				
				if($index == 1) {
					$('.btn-cf7wpms-left').css( "opacity", 0 );
				}
				
				var $submit_btn = $('.cf7wpms-panel.active .wpcf7-submit');
				
				if($submit_btn.length != 1) {
					$('.btn-cf7wpms-right').show();
					$('.btn-cf7wpms-submit').hide();
				}
			}, 1000);
			
			return false;
		},
		
		cf7ms_next: function() {
			var $this = $(this);
			$this.removeClass('cf7wpms-loading').addClass('cf7wpms-loading');
			$this.prop( "disabled", true );
			
			var error = false;
			
			
			$('.cf7wpms-panel.active .wpcf7-validates-as-required').each(function( i ) {
				var $type = $(this).attr('type');
				var $field = $(this);
				
				$('.wpcf7-not-valid-tip').remove();
				
				if( $type == 'text' || $field.is("textarea")) {
					if( ! $field.val() ) {
						
						setTimeout(function(){
							$field.addClass('cf7wpms-error');
							$field.after('<span role="alert" class="wpcf7-not-valid-tip">' + cf7wpms.invalid_required.default + '</span>');
						}, 1000);
						error = true;
					}
				}
	
		
				if( $type == 'file' ) {
					var $file = $field.get(0).files;
					var filename = $field.val();
					
					
					if( $file.length === 0) {
						setTimeout(function(){
							$field.addClass('cf7wpms-error');
							$field.after('<span role="alert" class="wpcf7-not-valid-tip">' + cf7wpms.invalid_required.default + '</span>');
						}, 1000);
						error = true;
					}else {
						var extension = filename.replace(/^.*\./, '.');
						var fileExtension = $field.attr('accept').split(',');
						
						console.log(extension);
						if ($.inArray(extension, fileExtension) == -1) {
							setTimeout(function(){
								$field.addClass('cf7wpms-error');
								$field.after('<span role="alert" class="wpcf7-not-valid-tip">' + cf7wpms.upload_failed.default + '</span>');
							}, 1000);
							 error = true;
						}
					}
				}
				
				if( $type == 'email' ) {
					
					if( ! $(this).val() ) {
						
						setTimeout(function(){
							$field.addClass('cf7wpms-error');
							$field.after('<span role="alert" class="wpcf7-not-valid-tip">' + cf7wpms.invalid_required.default + '</span>');
						}, 1000);
						error = true;
					}else{
					
						var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
						
						if ( ! filter.test( $(this).val() ) ) {
							setTimeout(function(){
								$field.addClass('cf7wpms-error');
							}, 1000);
							error = true;
						}
					}
				}
			});
			
			if( ! error ) {
				setTimeout(function(){
					var $next = $('#cf7wpms-progressbar li.active').next();
					$('#cf7wpms-progressbar li').removeClass('active');
					$next.addClass('active');
					
					var $next_tab = $next.find('a').attr('href');
					$('.cf7wpms-panel').removeClass('active');
					$($next_tab).addClass('active');
					
					$this.removeClass('cf7wpms-loading');
					$this.prop( "disabled", false );
					
					var $index = $('#cf7wpms-progressbar li.active').index() + 1;
					var $count = $('#cf7wpms-progressbar li').length;
					
					if($index == 2) {
						$('.btn-cf7wpms-left').css( "opacity", 1 );
					}
					
					var $submit_btn = $('.cf7wpms-panel.active .wpcf7-submit');
					
					if($submit_btn.length == 1) {
						$('.btn-cf7wpms-right').hide();
						$('.btn-cf7wpms-submit').show();
					}
						
					
					
					
					
					
					
				}, 1000);
			}else {
				setTimeout(function(){
					$this.removeClass('cf7wpms-loading');
					$this.prop( "disabled", false );
				}, 1000);
			}
			
			return false;
		},
		
		cf7wpms_form_submit: function() {
			var $this = $(this);
			$this.removeClass('cf7wpms-loading').addClass('cf7wpms-loading');
			$this.prop( "disabled", true );
			
			var error = false;
			$('.wpcf7-submit').trigger('click');
			

		},

	}
	
	cf7_wpms_frontend.init();
});