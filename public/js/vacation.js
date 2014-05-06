
  /**
   * query the xml file to see if vacation is enabled
   * @param  {string} xpath xpath including attribute name
   * @return {boolean}       true or false
   */
  function getMessageStatus(xpath) {
    return $.ajax({
      type:"POST",
      url: "admin/getattrib.php",
      data: { value:xpath }
    });
  }

  /**
   * update vcation enabled status
   * @param {boolean} attrValue true or false
   */
  function setMessageStatus(attrValue) { 
    return $.ajax({
      type:"POST",
      url: "admin/updatestatus.php",
      data: { value:attrValue }
    });
  }
  
  
  $(document).ready(function() {

    /*
      Can't return anything from a function that is asynchronous
      so we return a promise (http://goo.gl/BjFdg2 Stackoverflow)
    */
   
    // disable save button until data changes
    $('#button').prop("disabled", true); 

    // UI tweaks called on page load
    var promise1 = getMessageStatus("//vacation/@enabled");
      promise1.success(function (data) {
        if (data == 1 ) {
          $(".onoffswitch-checkbox").prop('checked', true);
          $(".on_off").html("Vacation is currently enabled!&nbsp;&nbsp;");
        } else {
          $(".onoffswitch-checkbox").prop('checked', false);
          $(".on_off").html("Vacation is currently disabled!&nbsp;&nbsp;");
        }
    });

    // only enable the save button when there's a change
    $('#txtSubject, #txtAreaMessage').keydown(function() {  
      $('#button').prop("disabled", false);
      $('.onoffswitch').hide();
    });

    $(".onoffswitch").click(function() {

      var promise = getMessageStatus("//vacation/@enabled");
      promise.success(function (data) {
        // $("#debug").html(data);
        if (data == 1 ) {
          var promise1 = setMessageStatus(0);
          promise1.success(function (data) {
            $(".on_off").html("Vacation has been disabled!&nbsp;&nbsp;");
            // $('#debug1').html(data);
          });
        } else {
          var promise2 = setMessageStatus(1);
          promise2.success(function (data) {
            $(".on_off").html("Vacation has been enabled!&nbsp;&nbsp;");
            // $('#debug1').html(data);
          });          
        }
      });      
    });


    // using serialized data here rather than asynchronous ajax
    // it's a lot easier for multiple post variables in the php file
    var request;
    $('#msg_form').submit(function(event) {
      // $('#debug').html('submitted');

    // abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = $(this);
    // select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");
    // serialize the data in the form
    var serializedData = $form.serialize();

    // disable the inputs for the duration of the ajax request
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);

    // fire off the request php
    request = $.ajax({
        url: "admin/savemsg.php",
        type: "post",
        data: serializedData
    });

    // callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        $('.onoffswitch').show();
    });

    // callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
      // to do
    });

    // callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // reenable the inputs
        $inputs.prop("disabled", false);
        // except for the save button
        $('#button').prop("disabled", true);
    });

    // prevent default posting of form
      event.preventDefault() ;
    });
  
  });