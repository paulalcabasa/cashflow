 <?php
require "vendor/autoload.php";

use App\Transaction;

$transaction = new Transaction();

$filename = $transaction->checkFile($argv);

// open files for reading
$file = fopen($filename,"r");
// loops each row on file
while(! feof($file)) {

	// reads the file 
	$data = fgetcsv($file);

	// stores file data to readable variables
 	$operation_date 	= $data[0];
 	$user_id 			= $data[1];
 	$user_type 			= $data[2];
 	$operation_type 	= $data[3];
 	$operation_amount 	= $data[4];
 	$operation_currency = $data[5];

 	fwrite(
 		STDOUT, 
 		$transaction->computeFee(
 			$operation_type, 
 			$user_type, 
 			$operation_amount
 		) . "\n"
 	);
 		
}

// closes file
fclose($file);
?> 