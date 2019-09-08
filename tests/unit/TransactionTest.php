<?php
namespace Tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Transaction;
class TransactionTest extends TestCase {


    public function testCashInFee(){
    	$transaction = new Transaction();
    	$cash_in_fee = $transaction->getCashInFee();
    	$this->assertEquals(0.03, $cash_in_fee);
    }

    public function testCashOutFee(){
    	$transaction = new Transaction();
    	$cash_out_fee = $transaction->getCashOutFee();
    	$this->assertEquals(0.3, $cash_out_fee);
    }

    public function testCashIn(){
    	$transaction = new Transaction();
    	$operation_amount = 200;
	   	$commission_fee =  $operation_amount * ($transaction->getCashInFee()/100);
    	if($commission_fee > 5){
    		$commission_fee = 5;
    	}
    	$commission_fee = number_format($commission_fee,2);
    	$this->assertEquals(0.06, $commission_fee);
    }

    public function testCashOutNatural(){
    	$transaction = new Transaction();
	 	$commission_fee = 0;
	 	$user_type = "natural";
	 	$operation_amount = 1200;
    	if($user_type == "natural"){
 			$commission_fee = $operation_amount * ($transaction->getCashOutFee()/100);
 		}
 		else if($user_type == "legal"){
			$commission_fee = $operation_amount * ($transaction->getCashOutFee()/100);		
 		}
 		$commission_fee = number_format($commission_fee,2);
 		$this->assertEquals(3.60, $commission_fee);
    }

    public function testCashOutLegal(){
    	$transaction = new Transaction();
	 	$commission_fee = 0;
	 	$user_type = "legal";
	 	$operation_amount = 300;
    	if($user_type == "natural"){
 			$commission_fee = $operation_amount * ($transaction->getCashOutFee()/100);
 		}
 		else if($user_type == "legal"){
			$commission_fee = $operation_amount * ($transaction->getCashOutFee()/100);	
			if($commission_fee < 0.50){
                $commission_fee = 0.50;
            }	
 		}
 		$commission_fee = number_format($commission_fee,2);
 		$this->assertEquals(0.90, $commission_fee);
    }

    public function testComputeFeeNaturalCashOut(){
    	$transaction = new Transaction();
    	$operation_type = "cash_out";
    	$user_type = "natural";
    	$operation_amount = 1000;
    	$comission_fee = $transaction->computeFee($operation_type, $user_type, $operation_amount);
    	$this->assertEquals(3.00, $comission_fee);
    }

    public function testComputeFeeNaturalCashIn(){
    	$transaction = new Transaction();
    	$operation_type = "cash_in";
    	$user_type = "natural";
    	$operation_amount = 200;
    	$comission_fee = $transaction->computeFee($operation_type, $user_type, $operation_amount);
    	$this->assertEquals(0.06, $comission_fee);
    }

    public function testComputeFeeLegalCashIn(){
    	$transaction = new Transaction();
    	$operation_type = "cash_in";
    	$user_type = "legal";
    	$operation_amount = 1000000;
    	$comission_fee = $transaction->computeFee($operation_type, $user_type, $operation_amount);
    	$this->assertEquals(5.00, $comission_fee);
    }

    public function testComputeFeeLegalCashOut(){
    	$transaction = new Transaction();
    	$operation_type = "cash_out";
    	$user_type = "legal";
    	$operation_amount = 300;
    	$comission_fee = $transaction->computeFee($operation_type, $user_type, $operation_amount);
    	$this->assertEquals(0.90, $comission_fee);
    }


}
?>