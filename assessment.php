<?php 


function extractLowest(&$numsArr){
	$l = count($numsArr);
	$min = $numsArr[0];
	$index = 0;
	$newArr = array();
	if($l > 1){
		for($i = 1; $i < $l; $i +=1){
			if($numsArr[$i] < $min){
				$index = $i;
				$min = $numsArr[$i];
			}
		}
		/*
			Take out number at pos $index from $numsArr
		*/
		for($i = 0; $i < $l; $i +=1){
					
			if($i != $index){
				$newArr[] = $numsArr[$i];
			}
		}
	}
	//If there was only 1 number in the original array then return to the caller an empty array,
	//else return the array minus the lowest number removed from it.
	$numsArr = $newArr;
	
	return $min;
}

function draw($qty,$maxRange, $type){
	$minRange = 1;
	$sortedNumsArr = array();
	$unsortedNumsArr = array();

	/*
		Fill an array with 10 unique random unsorted numbers in the range 1 to 100
	*/
	for($i = 0; $i < $qty; $i +=1 ){
		$isFound;
		//Generate a random number. If the new random number is already in the array,
		//then generate a new random number and check again.
		do{
			$rand = rand($minRange, $maxRange);
			$isFound = in_array($rand, $unsortedNumsArr);
		}while($isFound);									
															
		$unsortedNumsArr[] = $rand;			
	}

	/*
		Create a Sorted array by filling a new array with the extracted lowest number
		from the old array each time, until there are no numbers left in the old array.
	*/
	do{
		$sortedNumsArr[] = extractLowest($unsortedNumsArr);
	}while( count($unsortedNumsArr));

	$l = count($sortedNumsArr);
	$sNums = "";
	for($i = 0; $i < $l; $i +=1){
		$sNums .= $sortedNumsArr[$i];
		if($i+1 < $l){
			$sNums .= ", ";
		}
	}

	$spc = "                                                                 ";
	$l = strlen($sNums);
	
	$sNums .= substr($spc, 0, 20 - $l);
	

    $fileData = $sNums."--".date('d-m-y h:m:s');
    $myfile = file_put_contents('logs-'.$type.'.txt', $fileData.PHP_EOL , FILE_APPEND | LOCK_EX);

	return $sNums;
}
$lottoFile = 'logs-lotto.txt';
$powerballFile = 'logs-powerball.txt';

if (file_exists($lottoFile))  
{ 
    $topTenLottoNumbers = file($lottoFile);
    $winningLottoNumbers = array_slice($topTenLottoNumbers , -10);
} 

if (file_exists($powerballFile))  
{ 
	$topTenPowerBallNumbers = file($powerballFile);
	$winningPowerBallNumbers = array_slice($topTenPowerBallNumbers , -10);
}




if (isset($_REQUEST['max'])) {
	$max = $_REQUEST['max'];
}
if (isset($_REQUEST['qty'])) {
	$qty = $_REQUEST['qty'];
}
if(isset($_REQUEST['type'])){
	$type=$_REQUEST['type'];
}
?>


<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Lotto Draw</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
        	<h1>Lotto Assessment PHP Question 1:</h1>
            <div class="row">
                <div class="col-lg-6">
                    <form>
                        <div class="form-group">
                            <div class="alert alert-warning" role="alert" id="lotto-max-notification" style="display: none;">Please enter a valid number between 40 and 49</div>
                            <label for="lotto-max">Maximum number:</label>
                            <input type="number" class="form-control" id="lotto-max"  aria-describedby="maxHelp" placeholder="Enter Max Number" name="max" minlength="40" maxlength="49">
                                <small id="maxHelp" class="form-text text-muted">Maximum = 49 and Minimun = 40</small>
                        </div>
                        <div class="form-group">
                            <div class="alert alert-warning" role="alert" id="lotto-qty-notification" style="display: none;">Please enter a valid number between 5 and 7 </div>
                            <label for="lotto-qty">Quantity of Balls</label>
                            <input type="number" class="form-control" id="lotto-qty" placeholder="Quantity" name="qty">
                            <small id="qtyHelp" class="form-text text-muted">Maximum = 7 and Minimun = 5</small>
                            <input type="hidden" name="type" value="lotto">
                        </div>
                        <button type="submit" class="btn btn-primary" id="lotto-draw">Draw</button>
                        
                    </form>
                    <br/>
                    <?php
						if ( isset($_REQUEST['type'])) {
							if($_REQUEST['type'] == 'lotto'){
								echo "<h5>Your lotto numbers are: ". draw($qty, $max, $type)."</h5>";
							}						
							
						}
					?> 
					<br/>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" colspan="2">Last 10 Winning Numbers for Lotto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            	if(isset($winningLottoNumbers)){
		                            $count = 1;

		                            foreach ($winningLottoNumbers as $value) {
		                            echo "<tr><td>".$count."</td><td>".$value."</td></tr>";
		                            $count ++;
		                            }
                            	}

                            ?>
                        </tbody>
                    </table>
                    <?php
	                    if(isset($winningLottoNumbers)){
	                    	echo '<a href="logs-lotto.txt" download>Export Lotto Winning Number</a>';
	                	}
                	?>
                    
                </div>                
                <div class="col-lg-6">
                    <form>
                        <div class="form-group">
                            <div class="alert alert-warning" role="alert" id="powerball-max-notification" style="display: none;">Please enter a valid number between 5 and 49</div>
                            <label for="max">Maximum number:</label>
                            <input type="number" class="form-control" id="powerball-max"  aria-describedby="maxHelp" placeholder="Enter Max Number" name="max" minlength="40" maxlength="49">
                                <small id="maxHelp" class="form-text text-muted">Maximum = 49 and Minimun = 5</small>
                        </div>
                        <div class="form-group">
                            <div class="alert alert-warning" role="alert" id="powerball-qty-notification" style="display: none;">Please enter a valid number between 0 and 3</div>
                            <label for="powerball-qty">Quantity of Balls</label>
                            <input type="number" class="form-control" id="powerball-qty" placeholder="Quantity" name="qty">
                                <small id="qtyHelp" class="form-text text-muted">Maximum = 3 and Minimun = 0</small>
                                <input type="hidden" name="type" value="powerball">
                        </div>
                        <button type="submit" class="btn btn-primary" id="powerball-draw">Draw</button>

                    </form>
                    <br/>
                    <?php
						if ( isset($_REQUEST['type'])) {
							if($_REQUEST['type'] == 'powerball'){
								echo "<h5>Your lotto numbers are: ". draw($qty, $max, $type)."</h5>";
							}						
							
						}
					?> 
					<br/>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" colspan="2">Last 10 Winning Numbers for Powerball</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
	                            if(isset($winningPowerBallNumbers)){
		                            $count = 1;

		                            foreach ($winningPowerBallNumbers as $value) {
		                            echo "<tr><td>".$count."</td><td>".$value."</td></tr>";
		                            $count ++;
		                            }
	                        	} 

                            ?>
                        </tbody>
                    </table>
                    <?php
                     	if(isset($winningPowerBallNumbers)){
							echo '<a href="logs-powerball.txt" download>Export Powerball Winning Number</a>';
             			}
             		?>                    
                </div>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
	$( document ).ready(function() {
    	$("#powerball-draw").on('click',function(e){
    		if($("#powerball-max").val() == ''){
    			e.preventDefault();
    			$("#powerball-max-notification").css('display','block');
    		}
    		if($("#powerball-qty").val() == ''){
    			e.preventDefault();
    			$("#powerball-qty-notification").css('display','block');
    		}
    	});

    	$("#lotto-draw").on('click',function(e){
    		if($("#lotto-max").val() == ''){
    			e.preventDefault();
    			$("#lotto-max-notification").css('display','block');
    		}
    		if($("#lotto-qty").val() == ''){
    			e.preventDefault();
    			$("#lotto-qty-notification").css('display','block');
    		}
    	});
	});
</script>
