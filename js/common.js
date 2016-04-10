/**
  * Cosmetic and not really SIP2 related stuff
  */
$(document).ready(function() {
    // Load foundation
    $(document).foundation();

    // Monitor Minimize buttons
    $('.minimize_form').on('click', function( event ) {
        event.preventDefault();
        $(this).text(function(i, text){
          if (text === 'Show form') {
            $('#connection_forms form').removeClass('small-6').addClass('small-12');
            return 'Hide form';
          } else {
            $('#connection_forms form').removeClass('small-12').addClass('small-6');
            return 'Show form';
          }
        });

        $(this).closest('form').children('fieldset').toggle();
    });

    // Hide and monitor more options buttons
    $('.more_options').toggle(); //(via css it looks strange)
    $('.form_more_options').on('click', function( event ) {
        event.preventDefault();
        $(this).text(function(i, text){
          return text === 'More options' ? 'Less options' : 'More options';
        });

        $(this).closest('fieldset').children('.more_options').toggle();
    });


    // Load test settings
    testConfig();

});