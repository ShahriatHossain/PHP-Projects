(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $(document).ready(function(){

	 	var defaultNoticeType = $('input[name=notice_type]:checked', '#create_notice_section').val();
	 	switch(defaultNoticeType){
	 		case 'text':
	 			$('#notice_text').show();
	 		break;
	 		case 'image':
	 			$('#notice_image').show();
	 		break;
	 		case 'pdf':
	 			$('#notice_pdf').show();
	 		break;
	 	}

	 	var $selectAll = $( "input:radio[name=notice_type]" );
	    $selectAll.on( "change", function() {
	         if ($(this).val() == "text" && $(this).is(":checked")) {
		        $('#notice_pdf').hide();
		        $('#notice_image').hide();
		        $('#notice_text').show();
		    }
		    else if ($(this).val() == "image" && $(this).is(":checked")) {
		    	$('#notice_text').hide();
		    	$('#notice_pdf').hide();
		        $('#notice_image').show();
		    }
		    else if ($(this).val() == "pdf" && $(this).is(":checked")) {
		        $('#notice_text').hide();
		    	$('#notice_image').hide();
		    	$('#notice_pdf').show();
		    }
	    });

	    $('#is_voting_enabled').on('change',function(){
		    if($("#is_voting_enabled").prop('checked')) {
			    $('#voting_last_date').attr('disabled', false);
			} else {
			    $('#voting_last_date').attr('disabled', true);
			}
		});

		$('#unsubscribe_channel_notice').on('click', function(){

			if (confirm("Do you want to unsubscribe this channel?")){
		         $( "#noticeBoard" ).submit();
		      }
		});

		$.fn.NoticeUpVote = function(noticeId) {
            if (confirm("Do you want to vote this notice?")){
		        $( "#noticeBoardUpVote"+noticeId ).submit();
		    }
        };

        $.fn.NoticeDownVote = function(noticeId) {
            if (confirm("Do you want to vote this notice?")){
		        $( "#noticeBoardDownVote"+noticeId ).submit();
		    }
        };

        $('#search').keyup(function(){	
			var current_query = $('#search').val();
			if (current_query !== "") {
				$(".list-group li").hide();
				$(".list-group li").each(function(){
					var current_keyword = $(this).find('.channelName').text();
					if (current_keyword.indexOf(current_query) >=0) {
						$(this).show();    	 	
					};
				});    	
			} else {
				$(".list-group li").show();
			};
		});
		
	 });

})( jQuery );