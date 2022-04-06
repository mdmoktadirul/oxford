;jQuery(document).ready(function ($) {

  $("#generateAccessToken").submit(function (e) {
    e.preventDefault();

    var oxford_username = $("#oxford_username").val()
    var oxford_password = $("#oxford_password").val()
    $('#oxford_username').next('p').remove();
    $('#oxford_password').next('p').remove();
    $('.form-table').next('p').remove();

    var settings = {
      url: js_handler.plugin_dir + "get_access_token.php",
      method: "POST",
      dataType: "json",
      async: true,
      cache: false,
      data: {
        oxford_username,
        oxford_password
      },
    };

    $.ajax(settings).done(function (response) {
      response = JSON.parse(response);
      console.log(response)
      $("#oxford_access_token").val(response.access_token)
      if (!response.status) {
        if (response.validation_error && response.validation_error.password)
          $("#oxford_password").after("<p style='color:red'>" + response.validation_error.password + "</p>");
        if (response.validation_error && response.validation_error.user_username)
          $("#oxford_username").after("<p style='color:red'>" + response.validation_error.user_username + "</p>");
        $(".form-table").after("<p style='color:red'>" + response.message + "</p>");
        return false;
      }

      var ajax_form_data = $("#generateAccessToken").serialize();
      console.log({ ajax_form_data })
      //add our own ajax check as X-Requested-With is not always reliable
      ajax_form_data = ajax_form_data + '&ajaxrequest=true&submit=Submit+Form';

      $.ajax({
        url: js_handler.ajax_url,
        type: 'post',
        data: {
          action: 'set_token',
          oxford_username,
          oxford_password,
          "oxford_access_token": response.access_token
        }
      })

        .done(function (response) {
          $(".form-table").after("<p style='color:green'>The request was successful </p><br>" + response);
        })

        // something went wrong  
        .fail(function () {
          $(".form-table").after("<h2>Something went wrong.</h2><br>");
        })
    });
  })

})
