<?php
namespace App;

class Transaction {

	private $cash_in_fee;
    private $cash_out_fee;
    private $rates;

    public function __construct(){
    	$this->setCashInFee(0.03);
    	$this->setCashOutFee(0.3);
        $this->rates = [
            'EUR' => 1
        ];
    }

    /**
    * Used to set value of $cash_in_fee
    *
    * @param $value
    */
    public function setCashInFee($value){
        $this->cash_in_fee = $value;
    }

    /**
    * Used to set value of $cash_out_fee
    *
    * @param $value
    */
    public function setCashOutFee($value){
        $this->cash_out_fee = $value;
    }

    /**
    * Used to get value of $cash_in_fee
    *
    * @param $value
    */
    public function getCashInFee(){
        return $this->cash_in_fee;
    }

    /**
    * Used to get value of $cash_out_fee
    *
    * @param $value
    */
    public function getCashOutFee(){
        return $this->cash_out_fee;
    }

    /**
    * Used to compute comission fee for cashing in 
    *
    * @param $operation_amount - value to calculate in commission fee
    */
    public function cashIn($operation_amount){
        // commission fee is 0.03% of operation_amount
    	$commission_fee =  $operation_amount * ($this->getCashInFee()/100);
    	// 5.00 EUR will be the maximum commission fee
        if($commission_fee > 5){
    		$commission_fee = 5;
    	}
    	return number_format($commission_fee,2);
    }

    /**
    * Used to compute comission fee for cashing out 
    *
    * @param $operation_amount - value to calculate in commission fee
    * @param $user_type - type of user for calculation of commission fee
    */
    public function cashOut($user_type, $operation_amount){
    	$commission_fee = 0;

        // commission fee is 0.3% of $operation_amount
    	if($user_type == "natural"){
 			$commission_fee = $operation_amount * ($this->getCashOutFee()/100);
 		}
 		else if($user_type == "legal"){  
            // commission fee is 0.3% of $operation_amount
			$commission_fee = $operation_amount * ($this->getCashOutFee()/100);	
            // lowest commision fee must be until 0.50 EUR only	
            if($commission_fee < 0.50){
                $commission_fee = 0.50;
            }
        }

 		return number_format($commission_fee,2);
    }

    /**
    * Used to compute comission fee for cashing out 
    *
    * @param $operation_type - type of operation to perform (cash in or cash out)
    * @param $operation_amount - value to calculate in commission fee
    * @param $user_type - type of user for calculation of commission fee
    */
    public function computeFee($operation_type, $user_type, $operation_amount){
    	if($operation_type == "cash_out"){
 			return $this->cashOut($user_type, $operation_amount);
 		}
 		else if($operation_type == "cash_in"){
 			return $this->cashIn($operation_amount);
 		}
    }

    public function checkFile($argv){
        if (isset($argv[1])) {
            if($argv[1] == "input.csv"){
                $file = $argv[1]; 
                return $file;
            }
            else {
                die('Filename must be input.csv');
            }
        }
        else {
            die("Kindly specify file path");
        }
    }

}