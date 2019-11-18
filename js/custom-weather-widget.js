(function ($, Drupal) {
  Drupal.behaviors.myModuleBehavior = {
    attach: function (context, settings) {
      $("#card").flip();
    }
  };
})(jQuery, Drupal);
