<?php

//error_reporting(1);

$NEDM = new mysqli('localhost', 'user', 'pass', 'DB') or die("nome");

// CSV file
$csv_file = "sites.csv"; 
$count = '';

if (($handle = fopen($csv_file, "r")) !== FALSE) {
   fgetcsv($handle);
   while (($data = fgetcsv($handle, 60, ";")) !== FALSE) {
       echo $num = count($data);
        for ($c=0; $c < $num; $c++) {
          $col[$c] = $data[$c];
        }

		$stmt = $NEDM->prepare("INSERT INTO `Accounts` (
				`Domain`, 
				`License Date`, 
				`Expiration Date`, 
				`Username`, 
				`First Name`, 
				`Last Name`, 
				`Email`, 
				`Country`) VALUES(?,?,?,?,?,?,?,?)");
			if ( false===$stmt ) die('prepare() failed: ' . htmlspecialchars($NEDM->error));
			   
			$rc = $stmt->bind_param("ssssssss", 
				$col[0],
				$col[1],
				$col[2],
				$col[3],
				$col[4],
				$col[5],
				$col[6],
				$col[7]
				);
			if ( false===$rc ) die('bind_param() failed: ' . htmlspecialchars($stmt->error));
			    
			$rc = $stmt->execute();
			if ( false===$rc ) die('execute() failed: ' . htmlspecialchars($stmt->error));
			   
			$stmt->close();
			$count++;



 	}
    fclose($handle);
}
echo "<br />fin.";
mysqli_close($NEDM);
