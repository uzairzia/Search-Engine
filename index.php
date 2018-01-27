<?php
	error_reporting(0);

	function multiexplode ($delimiters,$string) {
		
		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return  $launch;
	}

	ini_set('max_execution_time', 300);

	$xml = simplexml_load_file('smalldata.xml');
	
	echo '<br/>';
	/* Connect to the database: */

	// Create connection
	$conn = new mysqli("localhost", "root", "", "xmlextract");
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	echo "<div><table border='1' bordercolor='green' bgcolor='yellow' style='font-size:18px;font-weight:bold;width:100%;padding:10px;'>";
	
	echo "<tr style='padding:10px;'>
		<th style='padding:10px;'>Id</th>
		<th style='padding:10px;'>PostTypeId</th>
		<th style='padding:10px;'>Score</th>
		<th style='padding:10px;'>ViewCount</th>
		<th style='padding:10px;'>Title</th>
		<th style='padding:10px;'>Tags</th>
		</tr>";
		
	for ($x = 51; $x <= 70; $x++) {
		
		if($xml->row[$x]['PostTypeId'] == 1){
			echo "<tr style='vertical-align:top;padding:10px;'>
			<td style='padding:10px;'>".$xml->row[$x]['Id']."</td>
			<td style='padding:10px;'>".$xml->row[$x]['PostTypeId']."</td>
			<td style='padding:10px;'>".$xml->row[$x]['Score']."</td>
			<td style='padding:10px;'>".$xml->row[$x]['ViewCount']."</td>
			<td style='padding:10px;'>".$xml->row[$x]['Title']."</td>
			<td style='padding:10px;'>".$xml->row[$x]['Tags']."</td>
			</tr>";
		}
	}
	echo "</table></div>";
	
	//other one
	
	echo "<div><table border='1' bordercolor='blue' bgcolor='lightblue' style='font-size:18px;font-weight:bold;width:100%;padding:10px;'>";
	
	echo "<tr style='padding:10px;'>
		<th style='padding:10px;'>Id</th>
		<th style='padding:10px;'>word</th>
		<th style='padding:10px;'>wordId</th>
		<th style='padding:10px;'>frequency</th>
		</tr>";
		
	$wordId = 0;
	$wordCount = 1;
	for ($x = 51; $x <= 70; $x++) {
		
		if($xml->row[$x]['PostTypeId'] == 1){
			$exploded = multiexplode(array(
			", ", " ,", " " ,
			" [" , " ]", "[ " , "] ",
			" }" , " {", "} " , "{ ",
			" ;", "? " , "; ",
			" !" , " \"", "! " , "\" ",
			" ." , " |", ". " , "| ",
			" :" , " )", ": " , ") ",
			" (" , "( ","."
			),
			$xml->row[$x]['Title']);

			for($y = 0;$exploded[$y] != NULL ;$y++)
			{
				$fC = substr($exploded[$y], 0,1);
				$lC = substr($exploded[$y], -1);
				
				if(	$fC == " " || $fC == "," || $fC == "[" || $fC == "]" ||
					$fC == "}" || $fC == "{" || $fC == "?" || $fC == ";" ||
					$fC == "!" || $fC == "\"" || $fC == "." || $fC == "|" ||
					$fC == ":" || $fC == ")" || $fC == "("
				)$exploded[$y] = trim($exploded[$y], $fC);
				
				if(	$lC == " " || $lC == "," || $lC == "[" || $lC == "]" ||
					$lC == "}" || $lC == "{" || $lC == "?" || $lC == ";" ||
					$lC == "!" || $lC == "\"" || $lC == "." || $lC == "|" ||
					$lC == ":" || $lC == ")" || $lC == "("
				)$exploded[$y] = rtrim($exploded[$y], $lC);
				
				if( $exploded[$y] != NULL && 
					$exploded[$y] != "a" &&
					$exploded[$y] != "to" &&
					$exploded[$y] != "the" &&
					$exploded[$y] != "as" &&
					$exploded[$y] != "in" &&
					$exploded[$y] != "it" &&
					$exploded[$y] != "is" &&
					$exploded[$y] != "do" &&
					$exploded[$y] != "an" &&
					$exploded[$y] != "was" &&
					$exploded[$y] != "0" &&
					$exploded[$y] != "1" &&
					$exploded[$y] != "2" &&
					$exploded[$y] != "3" &&
					$exploded[$y] != "4" &&
					$exploded[$y] != "5" &&
					$exploded[$y] != "6" &&
					$exploded[$y] != "7" &&
					$exploded[$y] != "8" &&
					$exploded[$y] != "9" &&
					$exploded[$y] != "am" && $exploded[$y] != "are" && 
					$exploded[$y] != "were" && $exploded[$y] != "be" &&
					$exploded[$y] != "being" && $exploded[$y] != "been" &&
					$exploded[$y] != "have" && $exploded[$y] != "has" &&
					$exploded[$y] != "had" && $exploded[$y] != "having" &&
					$exploded[$y] != "do" && $exploded[$y] != "does" &&
					$exploded[$y] != "did" && $exploded[$y] != "done" &&
					$exploded[$y] != "could" && $exploded[$y] != "should" &&
					$exploded[$y] != "would" &&	$exploded[$y] != "can" &&
					$exploded[$y] != "shall" &&	$exploded[$y] != "will" &&
					$exploded[$y] != "may" && $exploded[$y] != "might" &&
					$exploded[$y] != "must" && 	
					$exploded[$y] != "above" &&
					$exploded[$y] != "at" &&
					$exploded[$y] != "by" &&
					$exploded[$y] != "but" &&
					$exploded[$y] != "for" &&
					$exploded[$y] != "from" &&
					$exploded[$y] != "into" &&
					$exploded[$y] != "like" &&
					$exploded[$y] != "of" &&
					$exploded[$y] != "off" &&
					$exploded[$y] != "on" &&
					$exploded[$y] != "onto" &&
					$exploded[$y] != "than" &&
					$exploded[$y] != "up" &&
					$exploded[$y] != "with")
				{
					echo "<tr style='vertical-align:top;padding:10px;'>
					<td style='padding:10px;'>".$xml->row[$x]['Id']."</td>
					<td style='padding:10px;'>".$exploded[$y]."</td>
					<td style='padding:10px;'>".$wordId."</td>
					<td style='padding:10px;'>".$wordCount."</td>
					</tr>";
					$wordId++;
				}
			}
		}
	}
	echo "</table></div>";
	


?>
