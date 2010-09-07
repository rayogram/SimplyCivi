(function($){ $.fn.crmtooltip = function(){
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
				$(this).children().children('.crm-tooltip')
					.html('<div class="crm-loading-element"></div>')
					.load(this.href+'&snippet=4'); /* different from civicrm: add snippet designation */
			}
		},
		function(){
		  $(this).removeClass('crm-tooltip-active');
		  $(this).removeClass('crm-tooltip-down');
		  }
		)
	.click(function() {return false});	
	
	};
	})(jQuery);
