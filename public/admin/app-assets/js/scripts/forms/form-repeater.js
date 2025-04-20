/*=========================================================================================
    File Name: form-repeater.js
    Description: form repeater page specific js
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
  'use strict';

  // form repeater jquery
  $('.appointment-repeater').repeater({

    show: function () {
        $(this).slideDown();
      // Feather Icons
      if (feather) {
        feather.replace({ width: 14, height: 14 });

      }
        var divs = $('.appointments_div > .data-repeater-item');
        var divs_length = divs.length;
        var last_div = $('.appointments_div > .data-repeater-item:last');
        var all_checkboxes = $('.appointments_div > .data-repeater-item:last input[type=checkbox]');
        var all_labels = $('.appointments_div > .data-repeater-item:last label');
        all_checkboxes.each(function () {
            var item_id = $(this).attr('id');
             $(this).attr('id',item_id+'-'+parseInt(divs_length) +1)
        });
        all_labels.each(function () {
            var labels_id = $(this).attr('for');
             $(this).attr('for',labels_id+'-'+parseInt(divs_length) +1)
        });

    },
    hide: function (deleteElement) {
      if (confirm('هل انت متأكد من حذف الموعد ؟')) {
        $(this).slideUp(deleteElement);
      }
    }
  });
});
