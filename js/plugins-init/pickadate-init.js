(function ($) {
  "use strict";

  //date picker classic default
  $(".datepicker-default").pickadate({
    formatSubmit: "yyyy-mm-dd",
    min: new Date()
  });
})(jQuery);
