
jQuery(document).ready(function($) {

  $('.kwcl-link-div').on({
    "mouseover": function(e) {
      let textAreaDiv = $(this).find('div');

      $(this).removeClass('move-back');
      $(textAreaDiv).removeClass('close-textbox');

      $(textAreaDiv).addClass('show-text');
      $(this).addClass('move-down');

    },
    "mouseout": function(e) {
      let textAreaDiv = $(this).find('div');

      $(this).addClass('move-back');
      $(textAreaDiv).addClass('close-textbox');

      $(this).removeClass('move-down');
      $(textAreaDiv).removeClass('show-text');
    }
  });

});