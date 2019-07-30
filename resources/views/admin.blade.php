<!doctype html>
<html lang="en">
   <head>
      @include('layouts/headscripts')
      <title>Cream Finance</title>
      @include('layouts/navigation')
   </head>
   <body>
      <div class="container">
         <table id="myTable" class="table table-sm table-hover" style="width:90%; margin-top: 40px;">
            <thead style="font-size: 14px;">
               <tr>
                  <th>No</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Street</th>
                  <th style="text-align: right">ZIP Code</th>
                  <th>City</th>
                  <th style="text-align: right">Ammount</th>
                  <th style="text-align: right">LRP</th>
                  <th style="text-align: right">Promo Code</th>
                  <th style="text-align: right">Repayment Plan</th>
               </tr>
            </thead>
            <tbody style="font-size: 13px;">
               @foreach ($loans as $loan)
               @if($loan->firstName != "")
               <tr>
                  <td style="text-align: center;">{{ $loop->index + 1 }}</td>
                  <td>{{ $loan->firstName }}</td>
                  <td>{{ $loan->lastName }}</td>
                  <td>{{ $loan->street }}</td>
                  <td style="text-align: right">{{ $loan->zipCode }}</td>
                  <td>{{ $loan->city }}</td>
                  <td style="text-align: right" id="loanAmmount-{{ $loop->index + 1 }}">{{ $loan->loanAmmount }}</td>
                  <td style="text-align: right" id="loanRepaymentPeriod-{{ $loop->index + 1 }}">{{  $loan->loanRepaymentPeriod }}</td>
                  <td style="text-align: right">{{  $loan->promoCode }}</td>
                  <td style="text-align: right"><a href="#" id="{{ $loop->index + 1 }}" class="planOpenButton" >Plan</a></td>
               </tr>
               @endif
               @endforeach
            </tbody>
            <tfoot>
               <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
               </tr>
            </tfoot>
         </table>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
         <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalScrollableTitle">Payment Plan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>

                  
               </div>
               <div class="modal-header" style="padding-bottom: 0px">
                  <table id="myTable" class="table table-borderless table-sm" style="width:100%; margin-bottom: 0px;">
                     <thead style="font-size: 10px;">
                        <tr>
                           <th>Month</th>
                           <th style="text-align: right">Balance month/start</th>
                           <th style="text-align: right">Interest repayment</th>
                           <th style="text-align: right">Balance repayment</th>
                           <th style="text-align: right">Total Payment</th>
                           <th style="text-align: right">Balance month/end</th>
                        </tr>
                     </thead>
                  </table>
               </div>
               <div class="modal-body">
                  <table id="myTable" class="table table-borderless table-sm" style="width:100%; margin-top: 0px;">     
                     <tbody style="font-size: 11px;" id="modalTableBody">      
                     </tbody>
                     <tfoot>
                        <tr>
                           <th></th>
                           <th></th>
                           <th></th>
                           <th></th>
                           <th></th>
                           <th></th>
                        </tr>
                     </tfoot>
                  </table>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
      @include('layouts/bottomscripts')
      @include('layouts/messages')
   </body>
   <script>
      $(document).ready( function () {
      
           
      
                $(".planOpenButton").click(function(event) {
                   event.preventDefault();
                   var value = event.target.id;
                   var loanAmmount = $("#loanAmmount-"+value).html();
                   var loanRepaymentPeriod = $("#loanRepaymentPeriod-"+value).html();
                   console.log(loanAmmount);
                   console.log(loanRepaymentPeriod);
                   // $('#exampleModalScrollable').modal('show');
                   
                   $.ajax({
                     type : 'get',
                     url : '{{URL::to('calc')}}',
                     data : {
                       'loanAmmount':loanAmmount,
                       'loanRepaymentPeriod':loanRepaymentPeriod,
      
                       },
                     success : function(data){
                       console.log(data);
                       $('#modalTableBody').html(data);
                       $('#exampleModalScrollable').modal('show');
                     }
      
                   });
      
           });
      
      });     
        
   </script>
</html>