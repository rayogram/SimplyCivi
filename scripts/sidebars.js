$(document).ready(function() {
    $('#left-sidebar-handle').toggle(function(){
            $('#left-sidebar').addClass('left-sidebar-open');
            $('#left-sidebar-handle .ui-icon').removeClass('ui-icon-arrowthickstop-1-e');
            $('#left-sidebar-handle .ui-icon').addClass('ui-icon-arrowthickstop-1-w');
        }, function(){
            $('#left-sidebar').removeClass('left-sidebar-open');
            $('#left-sidebar-handle .ui-icon').removeClass('ui-icon-arrowthickstop-1-w');
            $('#left-sidebar-handle .ui-icon').addClass('ui-icon-arrowthickstop-1-e');
        });

    $('#right-sidebar-handle').toggle(function(){
            $('#right-sidebar').addClass('right-sidebar-open');
            $('#right-sidebar-handle .ui-icon').removeClass('ui-icon-arrowthickstop-1-w');
            $('#right-sidebar-handle .ui-icon').addClass('ui-icon-arrowthickstop-1-e');
        }, function(){
            $('#right-sidebar').removeClass('right-sidebar-open');
            $('#right-sidebar-handle .ui-icon').removeClass('ui-icon-arrowthickstop-1-e');
            $('#right-sidebar-handle .ui-icon').addClass('ui-icon-arrowthickstop-1-w');
        });	
    });