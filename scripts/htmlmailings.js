$(document).ready(function() {
 //$('.SimplyCivi_import_htmlmailings-section').remove();
 if ($('.SimplyCivi_import_htmlmailings-section').length == 0){
 $('.crm-html_email-accordion .html').prepend('<div class="section SimplyCivi_import_htmlmailings-section"><div class="label"><label for="SimplyCivi_import_htmlmailings">URL of page to import: </label></div><div class="content"><input type="text" class="form-text" id="SimplyCivi_import_htmlmailings" name="SimplyCivi_import_htmlmailings" size="100"/> <input type="button" id="SimplyCivi_import_htmlmailings-button" value="Get URL"/><div class="description">This must be a <em>local</em> url, as in should start with http://'+document.domain+'/ - after entering the URL click the "Get URL" button and the page will load for you.</div></div><div class="clear"/></div>');
 }
 $('#SimplyCivi_import_htmlmailings').focus(function() {
    $('#cke_html_message').hide();
 });

 $('#SimplyCivi_import_htmlmailings').blur(function() {
    $('#cke_html_message').show();
 });
 $('#SimplyCivi_import_htmlmailings-button').click(function(){
    generateMessage($('#SimplyCivi_import_htmlmailings').val()); 
 });
    
});





function generateMessage(mailing_url) {
    cj('#cke_html_message').remove();
    cj('#html_message').removeClass();
    if ( CKEDITOR.instances['html_message'] ) {
        CKEDITOR.remove(CKEDITOR.instances['html_message']);
    }
    if ($('.crm_loaded_content').length == 0){
        $('body').append('<div id="crm_loaded_content"></div>')
    }
    $("#crm_loaded_content").load(mailing_url, function(response, status, xhr) {
          if (status == "error") {
            var msg = "Sorry but there was an error: ";
            $("#error").html(msg + xhr.status + " " + xhr.statusText);
          } else {
          cj('#html_message').val(response);
            if ( cj('#html_message').val( ) == '' ) cj('#html_message').val('&nbsp;');
            CKEDITOR.replace( 'html_message' );
            var editor = CKEDITOR.instances['html_message'];
            if ( editor ) {
                editor.on( 'key', function( evt ){
                    global_formNavigate = false;
                } );
                editor.config.width  = '94%';
                editor.config.height = '400';
                editor.mode = 'source';
            }
          
          }
        });
    }