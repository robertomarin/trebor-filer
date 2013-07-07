jQuery(document).ready(function($) {

  $(".stag-tabs").tabs();

  $(".stag-toggle").each( function () {
    if($(this).attr('data-id') == 'closed') {
      $(this).accordion({ header: '.stag-toggle-title', collapsible: true, active: false  });
    } else {
      $(this).accordion({ header: '.stag-toggle-title', collapsible: true});
    }
  });
});