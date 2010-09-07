// =============================================== 
// ! add "Search text" to civicrm all text search   
// =============================================== 

$(document).ready(function() {
    defaultText = $('#header #block-civicrm-7 h3').text();
	$('#header #block-civicrm-7 #text').attr('value', defaultText);
	$('#header #block-civicrm-7 #text').focus(function(){    
	   currentVal = $(this).attr('value');
	   if (currentVal == defaultText) {
	       $(this).attr('value', '');
	       }
	   });
    $('#header #block-civicrm-7 #text').blur(function(){    
	   currentVal = $(this).attr('value');
	   if (currentVal == "") {
	       $(this).attr('value', defaultText);
	       }
	   });
});