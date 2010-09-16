$(document).ready(function() {
	$('#recently-viewed a') /* different from civicrm: change target a tag */
	.addClass('crm-processed')
	.hover(
		function(e)  {
		    $(this).addClass('crm-tooltip-active');
		    topDistance = e.pageY - $(window).scrollTop();
		    if (topDistance < 300 | topDistance < $(this).children('.crm-tooltip-wrapper').height()) {
		          $(this).addClass('crm-tooltip-down');
		      }
			if ($(this).children('.crm-tooltip-wrapper').length == '') {
				$(this).append('<div class="crm-tooltip-wrapper"><div class="crm-tooltip"></div></div>');
				itemurl = this.href.replace('contact', 'profile')+'&snippet=4&gid=8';
				$(this).children().children('.crm-tooltip')
					.html('<div class="crm-loading-element"></div>')
					.load(itemurl); /* different from civicrm: add snippet designation */
			}
		},
		function(){
		  $(this).removeClass('crm-tooltip-active');
		  $(this).removeClass('crm-tooltip-down');
		  }
		)	
	});
