@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- <a href="{{route('push')}}" class="btn btn-outline-primary btn-block">Make a Push Notification!</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>






{{-- Buying airtime section --}}
<!-- Modal for buying airtime -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Buy Airtime</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action=" http://localhost/mawingu/api/buy/airtime" id="airtimeForm" class="airtimeForm" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="FormControlPhoneNumber"><strong> Amount: </strong></label>
                        <input type="text" required  name="amount" class="form-control" id="amount" placeholder="Enter amount..">
                    </div>
                    
                    <div class="form-group own_mobile_number">
                        <label for="FormControlPhoneNumber"><strong>Mpesa Phone Number: [STK Push] </strong></label>
                        <input type="text" required name="mpesa_phone_number" class="form-control" id="mpesa_phone_number" placeholder="Enter mpesa mobile number"> 
                    </div>
                    <div class="form-group enter_mobile_number">
                        <label for="FormControlPhoneNumber"><strong>Recipient Phone Number: </strong></label>
                        <input type="text" required name="recipient_phone_number" class="form-control" id="recipient_phone_number" placeholder="Enter recipient mobile number">
                    </div>
                    <div class="form-group">
                        <label for="FormControlSurvey"><strong>Select Recipient Network:</strong></label>
                        <select class="form-select form-control" id="network" name="network" aria-label="Default select example">
                            <option value="Safaricom">Safaricom</option>
                            <option value="Airtel">Airtel</option>
                            <option value="Telkom">Telkom</option>
                            <option value="Equitel">Equitel</option>
                        </select>
                    </div>
                    <div id="errors" class="errors">

                    </div>
                    <div class="form-group ">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="airtime_confirmation" name="airtime_confirmation" value="confirmation" id="flexRadioDefault2">
                        <label class="form-check-label" for="flexRadioDefault2">
                          Confirm purchase of airtime
                        </label>
                      </div>
                    </div>
                </div>   
                <div class="modal-footer d-flex justify-content-center">
                    <button id="btnSubmit" class="btn btn-primary">Buy</button>
                </div>
            </form>  
       
        </div>
    </div>
</div>           
</div>
</div>

{{-- modal action button --}}
<div class="btn-group-fab" role="group" aria-label="FAB Menu">
    <span data-toggle="modal" data-target="#exampleModalCenter">
        <button type="button" class="btn btn-main btn-primary" data-toggle="tooltip" data-placement="top" title="Buy Airtime"> <i class="fa fa-money fa-3x" aria-hidden="true"></i> </button>
    </span>
</div>


{{-- Modal airtime confirmation  --}}
<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> <h3>Airtime Confirmation</h3></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              
              {{-- Amount --}}
              <p>Amount: <strong><span id="confirm_amount_to_buy" class="confirm_amount_to_buy"></span></strong></p>


              <p>Mpesa Phone Number: <strong><span id="confirm_mpesa_phone_number" class="confirm_mpesa_phone_number"></span></strong></p>

              <p>Recipient Phone Number: <strong><span id="confirm_recipient_phone_number" class="confirm_recipient_phone_number"></span></strong></p>

              <p>Network: <strong><span id="confirm_network" class="confirm_network"></span></strong></p>

            </div>
            <div class="modal-footer d-flex justify-content-center">
              <button id="update_button" class="btn btn-primary" data-dismiss="modal">Edit Details</button>
              <button id="confirm_button" class="btn btn-primary">Confirm</button>
              <button id="cancel_confirmation" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
  </div>           
  
  {{-- payment options --}}
  <div class="modal fade" data-backdrop="static" data-keyboard="false" id="payment_options" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <img src="https://www.standardmedia.co.ke/payments/assets/img/mpesa.png" height="50" alt=" mpesa logo">
            </div>
            <div class="modal-body">
              <h4 class="font-12">Payment option one</h4>
              <hr>
              <p><strong>Success:</strong> Check your mobile phone handset for an instant payment request from Safaricom M-PESA.</p>
              <p>Incase you did not get the request kindly use <strong>Payment option two</strong> below then click done.</p>

              <hr>
              <div class="mt-4 mb-2">
                <h4 class="font-12">Payment option two</h4>
                <hr>
                <p>Paybill No: <strong>505604</strong></p>
                <p>Account No: <strong><span id="account_number" class="account_number"></span></strong></p>
                <p>Amount: <strong><span id="amount_to_pay" class="amount"></span></strong></p>
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
              <button id="done" class="btn btn-primary" data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
  </div>     

@endsection
