/**
 *
 * Confirm password.
 *
 */

(function($) {
  // Function for hiding password confirmation text.
  function passwordConfirm() {
    if(!$('input.js-password-field').val()) {
      $('div.js-password-confirm').css("visibility", "hidden");
    }
  }
  $(document).ready(function () {
    passwordConfirm();
  });
})(jQuery);
