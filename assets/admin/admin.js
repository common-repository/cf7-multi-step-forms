jQuery.fn.selectText = function(){
   var doc = document;
   var element = this[0];
   console.log(this, element);
   if (doc.body.createTextRange) {
       var range = document.body.createTextRange();
       range.moveToElementText(element);
       range.select();
   } else if (window.getSelection) {
       var selection = window.getSelection();        
       var range = document.createRange();
       range.selectNodeContents(element);
       selection.removeAllRanges();
       selection.addRange(range);
   }
};

jQuery( function( $ ) {

	/**
	 * Variations Price Matrix actions
	 */
	var cf7_wpms_admin = {

		/**
		 * Initialize variations actions
		 */
		init: function() {
			$(document).on('click', '.cf7ms-tab li', this.cf7ms_tab_click);
			$(document).on("dblclick", ".cf7ms-tab li:not(.cf7ms-addtab) a", this.cf7ms_tab_dbclick);
			$(document).on("focusout", ".cf7ms-tab li:not(.cf7ms-addtab) a", this.cf7ms_tab_focusout);
			$(document).on("keyup", ".cf7ms-tab li:not(.cf7ms-addtab) a", this.cf7ms_keyup);
			$(document).on('click', '.cf7ms-tab li .icon-remove', this.cf7ms_icon_remove);
			
			$(document).on('click', '#cf7wpms-enable', this.cf7wpms_enable);
			
			$('input.cf7wpms-color-field').wpColorPicker();
			
			this.load_form();
			
			
		},
		
		load_form: function() {
			$( "#tag-generator-list a" ).each(function( index ) {
				if( $( this ).text() == 'multistep') {
					$(this).addClass('is-cf7wpms');
					$(this).attr('href', '#');
					$(this).removeClass('thickbox');
				}
				
			});
			
			$('.cf7ms-wrap.active .cf7wpms-content > textarea').removeAttr('id');
			jQuery('#sortable-list').sortable({
				opacity: 0.7,
				update: function() {
					console.log('ok');
				}
			});
		},
		
		cf7wpms_enable: function() {
			if ($(this).is(":checked")) {
				$('.cf7ms-wrap').addClass('active');
				$('.cf7ms-wrap.active .cf7wpms-content > textarea').removeAttr('id');
				$('.cf7ms-wrap .cf7wpms-panel.active textarea').attr('id', 'wpcf7-form');
				$('.cf7wpms-panel.active').removeClass('active');
				
				var $tab = $('.cf7ms-tab li.active a').attr('href');
				$($tab).addClass('active');
			}else {
				$('.cf7ms-wrap').removeClass('active');
				$('.cf7ms-wrap .cf7wpms-content textarea').removeAttr('id');
				$('.cf7ms-wrap .cf7wpms-content > textarea').attr('id', 'wpcf7-form');
				$('.cf7wpms-panel.active').removeClass('active');
			}
		},
		
		cf7ms_icon_remove: function() {
			var $li = $(this).closest('li');
			var $id = $li.find('a').attr('href');
			
			$li.remove();
			$($id).remove();
			
			$(".cf7ms-tab li:not(.cf7ms-addtab)").removeClass('active');
			$(".cf7ms-tab li:not(.cf7ms-addtab)").first().addClass('active');
			
			$(".cf7wpms-content .cf7wpms-panel").removeClass('active');
			$(".cf7wpms-content .cf7wpms-panel").first().addClass('active');
			return false;
		},
		
		cf7ms_tab_dbclick: function() {
			var $this = $(this);
			
			$('.cf7ms-tab li a').not($this).attr('contenteditable', false);
			$(this).attr('contenteditable', true);
			$(this).selectText();
		},
		
		cf7ms_tab_focusout: function() {
			$(this).attr('contenteditable', false);
		},
		
		cf7ms_tab_click: function() {

				
			if( $(this).hasClass('cf7ms-addtab') ) {
				alert('This options only available for Premium version.');
			}else {
				var $id = $(this).find('a').attr('href');
				var count = $('.cf7ms-tab li:not(.cf7ms-addtab)').length + 1;
				$('.cf7ms-tab li:not(.cf7ms-addtab)').removeClass('active');
				$('.cf7wpms-content .cf7wpms-panel').removeClass('active');
				
				$('.cf7wpms-panel textarea').removeAttr('id');
				
				var $tab_id = $(this).find('a').attr('href');

				$(this).addClass('active');
				$($tab_id).addClass('active');
				
				$($id + ' textarea').attr('id', 'wpcf7-form');
			}
		
			return false;
		},
		
		cf7ms_keyup: function() {
			var $val = $(this).text();
			$(this).closest('li').find('.input-cf7wpms-tab').val($val);
		}

	}
	
	cf7_wpms_admin.init();
});