<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Collection;


class LoansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
       if (($file = fopen("loan_registry.csv", "r")) !== FALSE) {
           
           $csvs = [];
               while(! feof($file)) {
                  $csvs[] = fgetcsv($file);
               }
          
           $table_data = [];
           $column_names = [];
          
               foreach ($csvs[0] as $single_csv) {
                   $column_names[] = $single_csv;
               }
               
               foreach ($csvs as $key => $csv) {
                   if ($key === 0) {
                       continue;
                   }
               
               foreach ($column_names as $column_key => $column_name) {
                   $table_data[$key-1][$column_name] = $csv[$column_key];
               }
           }
          

           
          
           $loans = json_encode($table_data);
           $loans = (array)json_decode($loans);

      

           fclose($file);          
          
       }
     
      return view('admin', compact('loans'));
  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {   
        $this->validate($request, [

            'firstName' => 'required',
             'lastName' => 'required',
              'street' => 'required',
               'zipCode' => 'required|numeric|min:1',
                'city' => 'required',
                 'loanAmmount' => 'required|numeric|min:1',
                  'loanRepaymentPeriod' => 'required|numeric|min:1',
                   'promoCode' => 'required',

        ]);

        $file = fopen('loan_registry.csv', 'a');

        $input = array_except($request->all(), ['_token']);

        fputcsv($file, $input);

        fclose($file);

    }
  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      
      if ($request->ajax()) {
      $fLoanAmount = $request->loanAmmount; 
      $fAPR = 9;
      $iTerm = $request->loanRepaymentPeriod;
      $monthlyInterest = $fAPR/1200;


      $payment = round($this->calculateMonthlyPayments($fLoanAmount, $fAPR, $iTerm),2);
    
   
    
       $paymentPlan = [];
       $output="";
    
    for ($n = 0; $n < $iTerm; $n++) {

        $loanBalance = round($fLoanAmount,2);
        $monthlyInterest = round($loanBalance * $fAPR/1200,2);
        $monthlyBalanceRepayment = round($payment - $monthlyInterest,2);
        $fLoanAmount = round($loanBalance - $monthlyBalanceRepayment,2);

        if ($fLoanAmount < 2) {
          
          $monthlyInterest = round($monthlyInterest - $loanBalance + $monthlyBalanceRepayment,2);
          $monthlyBalanceRepayment = round($payment - $monthlyInterest,2);
          $fLoanAmount = round($loanBalance - $monthlyBalanceRepayment,2);

        }

        $paymentPlan[$n]['loanBalance'] = $loanBalance;
        $paymentPlan[$n]['monthlyInterest'] = $monthlyInterest;
        $paymentPlan[$n]['monthlyBalanceRepayment'] = $monthlyBalanceRepayment;
        $paymentPlan[$n]['payment'] = $payment;
        $paymentPlan[$n]['outstandingLoan'] = $fLoanAmount;

        

    }

          $paymentPlan = json_encode($paymentPlan);
          $paymentPlan = (array)json_decode($paymentPlan);

         
          $month = 0;
          foreach ($paymentPlan as $monthlyLine){

            $month ++;

            $output .= '<tr>'.

                            '<td style="text-align: right;" style="font-size: 10px;">'.$month.'</td>
                            <td style="text-align: right;">'.$monthlyLine->loanBalance.'</td>
                             <td style="text-align: right;">'.$monthlyLine->monthlyInterest.'</td>
                             <td style="text-align: right;">'.$monthlyLine->monthlyBalanceRepayment.'</td>
                             <td style="text-align: right;">'.$monthlyLine->payment.'</td>
                             <td style="text-align: right;">'.$monthlyLine->outstandingLoan.'</td'.

                        '</tr>';
          }



        return Response($output); 

      } 
        

    }

   

    
    public function calculateMonthlyPayments($amt , $i, $term)
    {

    $int = $i/1200; 
    $int1 = 1+$int;
    $r1 = pow($int1, $term);

    $pmt = $amt*($int*$r1)/($r1-1);

    return $pmt;
    }

    public function welcome()
    {

      return view('welcome');
   
    }


}
