<!doctype html>
<html lang="en">
   <head>
      @include('layouts/headscripts')
      <title>Cream Finance</title>
      @include('layouts/navigation')
   </head>
   <body>
      <div class="container">
         <div class="form-group" style="margin-top: 30px;">
            <form id="basic-form">
               @csrf
               <div class="row">
                  <div class="col-4">
                     <label for="name" ><strong>First Name</strong></label>
                     <input type="text" class="form-control requiredInputField" id="firstName" placeholder="Enter your first name" >
                     <span id="firstNameSpan" style="font-size: 15px; font-style: italic; color: lightgrey;">required field</span>
                     <br><br>
                     <label for="lastname"><strong>Last Name</strong></label>
                     <input type="text" class="form-control requiredInputField" id="lastName" placeholder="Enter your last name">
                     <span id="lastNameSpan" style="font-size: 15px; font-style: italic; color: lightgrey;">required field</span>
                     <br><br>
                     <label for="street"><strong>Street adress</strong></label>
                     <input type="text" class="form-control requiredInputField" id="street" placeholder="Enter your street adress">
                     <span id="streetSpan" style="font-size: 15px; font-style: italic; color: lightgrey;">required field</span> 
                     <br><br>
                     <label for="exampleIn"><strong>ZIP Code</strong></label>
                     <input type="number" class="form-control requiredInputField" id="zipCode" placeholder="Enter ZIP code"> 
                     <span id="zipCodeSpan"style="font-size: 15px; font-style: italic; color: lightgrey;">required field</span>
                     <br><br>
                     <label for="name"><strong>City</strong></label>
                     <input type="text" class="form-control requiredInputField" id="city" placeholder="Enter your city">
                     <span id="citySpan"style="font-size: 15px; font-style: italic; color: lightgrey;">required field</span>
                  </div>
                  <div class="col-4">
                     <label for="loanAmmount"><strong>Loan Ammount</strong></label>
                     <input  class="form-control requiredInputField" id="loanAmmount"  step="0.01" min="1" type="number" placeholder='0.00' style="text-align: right;">
                     <span id="loanAmmountSpan" style="font-size: 15px; font-style: italic; color: lightgrey;">required field</span> 
                     <br><br>
                     <label for="name"><strong>Loan Repayment Period</strong> <span>(months)</span></label>
                     <input type="number" class="form-control requiredInputField" id="loanRepaymentPeriod" min="1" placeholder="Enter loan repayment period" style="text-align: right;"> 
                     <span id="loanRepaymentPeriodSpan" style="font-size: 15px; font-style: italic; color: lightgrey;">required field</span>
                     <br><br>
                     <label for="promoCodeLabel" id="promoCodeLabel" style="margin-top: 224px;"><strong>Do you have a promo code? </strong><button id="promoCodeButton" class="btn btn-info btn-sm" style="margin-top: 5px;">Click Here</button></label> 
                     <input id="promoCode" style="display: none; text-align: right;" class="form-control" placeholder="Enter your promo code">
                     <span id="promoCodeInfo" style="font-size: 15px; font-style: italic; color: lightgrey; display: none;">not required field</span>
                  </div>
               </div>
               <button id="submitFormButton" class="submit btn-primary" type="submit" style="margin-top: 20px; ">Request</button>
            </form>
         </div>
      </div>
      @include('layouts/bottomscripts')
      @include('layouts/messages')
   </body>
   <script>

      $(document).ready(function(){
      
          $('#loanAmmount').blur(function(){
               var num = parseFloat($(this).val());
               var cleanNum = num.toFixed(2);
               $(this).val(cleanNum);
      
          });

         

          $('.requiredInputField').blur(function(){
                
             var fieldId = event.target.id;       
          
               var value = $('#'+fieldId).val();
                 
                  if ( value.length < 1){
                      $('#'+fieldId+'Span').css("color", "red");
                  }else{
                      $('#'+fieldId+'Span').css("color", "lightgrey");
                  }

          });


         
      
      
          $(document).on('click', '#promoCodeButton', function(event) {
            event.preventDefault();
            $('#promoCode').toggle();
            $('#promoCodeInfo').toggle();
            $('#promoCodeButton').blur();
            
           });
      
      
          $('#submitFormButton').click(function(event) {
                $("#basic-form").submit(function(e){
                       e.preventDefault();
                   });

                 var inputFields = [

                 "#firstName",
                 "#lastName",
                 "#street",
                 "#zipCode",
                 "#city",
                 "#loanAmmount",
                 "#loanRepaymentPeriod"
  
                 ]; 

                 function check_if_span_red(fieldName) {
                
                    var value = $(fieldName).val();
                      if ( value.length < 1){
                        $(fieldName+'Span').css("color", "red");
                      }else{
                          $(fieldName+'Span').css("color", "lightgrey");
                      }

                  }

                  inputFields.forEach(check_if_span_red);
           

                 var firstName = $('#firstName').val();
                 var lastName = $('#lastName').val();
                 var street = $('#street').val();
                 var zipCode = $('#zipCode').val();
                 var city = $('#city').val();
                 var loanAmmount = $('#loanAmmount').val();
                 var loanRepaymentPeriod = $('#loanRepaymentPeriod').val();
                 var promoCode = $('#promoCode').val();   
                 if (!promoCode) {
                  var promoCode = 'No Code';
                 } 
      
                 
      
                      $.post('loans', {
                                  'firstName': firstName,
                                  'lastName': lastName,
                                  'street': street,
                                  'zipCode': zipCode,
                                  'city': city,
                                  'loanAmmount': loanAmmount,
                                  'loanRepaymentPeriod': loanRepaymentPeriod,
                                  'promoCode': promoCode,
                                  '_token': $('input[name=_token]').val()
                            }, function(data) {
      
                              $('#firstName').val("");
                              $('#lastName').val("");
                              $('#street').val("");
                              $('#zipCode').val("");
                              $('#city').val("");
                              $('#loanAmmount').val("");
                              $('#loanRepaymentPeriod').val("");
                              $('#promoCode').val("");
                              $('#submitFormButton').blur();
                              $("#successMessage").css("display", "").delay(3000).fadeOut(3000);
                              console.log(promoCode);
                               
                            
                      })
      
                      .fail( function(xhr, textStatus, errorThrown) {
                         
                          // alert( "Please fill all the required elements" );
                          $("#errorMessage").css("display", "").delay(3000).fadeOut(3000);
                          $('#submitFormButton').blur();   
                      });
                          
            });   
      
      
        });
    
      
   </script>
</html>