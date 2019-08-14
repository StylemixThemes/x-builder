"use strict";

var contentSaved = false;
var x_builder_content = '';
document.addEventListener("x_content_saved", function (e) {
  if (!contentSaved) return true;
  jQuery('#publish').click();
  contentSaved = false;
});

(function () {
  document.body.className += ' folded';
  $(document).ready(function () {
    var $form_post = $('form[name="post"]');
    var $save_button = $('.btn-x-save');
    $('form[name="post"] input[type="submit"]').on('click', function (e) {
      if (contentSaved) return true;
      e.preventDefault();
      e.stopPropagation();
      $save_button.attr('ref', 'save').trigger('click');
      contentSaved = true;
    });
    /*Preview*/

    var $preview = $('#preview-action #post-preview');
    var preview_text = $preview.text();
    var screen_reader_text = $preview.find('span').text();
    preview_text = preview_text.replace(screen_reader_text, '');
    /**
     * Hide WP Preview Button and add fake x-builder preview button
     * for saving x-builder content before preview
     */

    $preview.css({
      opacity: 0,
      display: 'none',
      visibility: 'hidden'
    }).after('<a href="#" class="button x-builder-preview">' + preview_text + '</a>');
    $('#preview-action').on('click', '.x-builder-preview', function (e) {
      e.preventDefault();
      e.stopPropagation();
      console.log(x_builder_content);
      jQuery.ajax({
        url: x_builder_endpoints.save_content + '?preview=1',
        type: "POST",
        data: JSON.stringify(x_builder_content),
        dataType: "json",
        contentType: 'application/json',
        success: function success(result) {
          $preview.trigger('click');
        }
      });
    });
  });
})(jQuery);