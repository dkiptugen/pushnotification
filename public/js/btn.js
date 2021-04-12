$(function () {
  $('.btn-group-fab').on('click', '.btn', function () {
      $('.btn-group-fab').toggleClass('active');
  });
  $('[data-toggle="tooltip"]').tooltip();


  $('#mpesa_phone_number').on('change', function () {
      // Get the value of mpesa
      mpesa_phone_number = document.getElementById('mpesa_phone_number').value;

      //Get the confirmation inputs
      recipient_phone_number = document.getElementById('recipient_phone_number');

      // assign the values
      recipient_phone_number.value = mpesa_phone_number

  });

});

$("#airtimeForm").on('submit', function (e) {

  var airtime_confirmation = document.getElementById("airtime_confirmation").checked;
  if (airtime_confirmation == false) {
      $("#errors").html(
          `<div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Kindly check the confirmation first</strong>
      </div>`
      );

      return false
  }

  //show confirmation dialog
  amount = document.getElementById('amount').value;
  mpesa_phone_number = document.getElementById('mpesa_phone_number').value;
  recipient_phone_number = document.getElementById('recipient_phone_number').value;
  network = document.getElementById('network').value;

  //Get the confirmation inputs
  confirm_amount = document.getElementById('confirm_amount_to_buy');
  confirm_recipient_phone_number = document.getElementById('confirm_recipient_phone_number');
  confirm_mpesa_phone_number = document.getElementById('confirm_mpesa_phone_number');
  confirm_network = document.getElementById('confirm_network');

  // assign the values
  confirm_recipient_phone_number.value = recipient_phone_number;
  confirm_amount.value = amount;
  confirm_mpesa_phone_number.value = mpesa_phone_number;
  confirm_network.value = network;


  $('#confirmation').modal('show');
  $('#exampleModalCenter').modal('hide');


  // cancel button pressed
  $('#cancel_confirmation').on('click', function () {
      location.href = location.href
  });

  // update  button clicked
  $('#update_button').on('click', function () {
      $('#exampleModalCenter').modal('show');
  });


  $('#confirm_button').on('click', function () {

      //localhost
      //var url = "http://localhost/mawingu/api/buy/airtime"; // the script where you handle the form input.
      var url = "https://vas2.standardmedia.co.ke/airtime/api/buy/airtime";

      //disable other buttons
      $("#confirm_button").prop("disabled", true);
      $("#update_button").prop("disabled", true);
      $("#cancel_confirmation").prop("disabled", true);

      //Introduce the loading effect
      $("#confirm_button").html(
          `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
      );
      $.ajax({
          type: "POST",
          url: url,
          data: $("#airtimeForm").serialize(), // serializes the form's elements.
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },

          success: function (data) {

              $('#payment_options').modal('show');

              //Display the account number
              $("#account_number").text(data);
              $("#amount_to_pay").text(amount);

              $('#done').on('click', function () {
                  location.href = location.href
                  $('#confirmation').modal('hide');
              });
          },

          error: function (data) {
              // Display an error message incase of an issue
          },
          complete: function () {
              $("#confirm_button").prop("enabled", true);
          }
      }).done(function () {
          
      });

  })



  e.preventDefault(); // avoid to execute the actual submit of the form.
});
