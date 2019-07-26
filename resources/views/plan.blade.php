



@foreach ($paymentPlan as $item) 
    
    Month {{$loop->index + 1}} |	{{$item->loanBalance}} | {{$item->monthlyInterest}}  |  {{$item->monthlyBalanceRepayment}}  |  {{$item->payment}}  |  {{$item->outstandingLoan}}  |<br>
   
@endforeach