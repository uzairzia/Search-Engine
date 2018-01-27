<!DOCTYPE html>
<html>
<head>
<style>
body{
    min-height: 720px;
    display: block;
    width: 98%;
    background-color :#bb9bac ;
}
.sth {
    top: 15px;
    margin: 1% 0px;
    padding: 10px 0px;
    display: inline-block;
    width: 100%;
    position: relative;
}
.ds {
    width: 100%;
    float: left;
	font-weight: 900;
    font-family: cursive;
}
.data {
    display: inline;
    margin: 0% 5% 2.5%;
    padding: 0;
	max-width: 100%;
    font-weight: 100;
}
input[type=text] {
    width: 55%;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: white;
    background-image: url('searchicon.png');
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 20px 12px 40px;
    -webkit-transition: width 0.4s ease-in-out;
    transition: width 0.4s ease-in-out;
}

input[type=text]:focus {
    width: 75%;
}
#f1{
 max-width: 65%;
    margin: 0px auto;
    top: 5px;
    display: block;
    position: relative;
    left: 150px;
}
.button {
  border-radius: 4px;
    background-color: #f4511e;
    border: none;
    color: #FFFFFF;
    text-align: center;
    font-size: 28px;
    padding: 6px 10px;
    width: 150px;
    transition: all 0.5s;
    cursor: pointer;
    margin: 5px 6px 1px;
    top: 4px;
    position: relative;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}
.noresult{
	text-align:center;
	margin-top:100px;
	font-family:Helvetica;
	font-weight:bold;
	font-style:italic;
	font-size:26px;
}

</style>
</head>
<title>
Search Engine
</title>
<body>


<form id="f1" action="search_page.php" method="post">
<h1 style="
    font-size: 225%;
    font-family: fantasy;
    font-weight: lighter;
">Search Engine for Stack Overflow Questions</h1>
<input type="text" name="search" placeholder="Type here a word.." />
<input class="button" type="submit" value="Go" />
</form>
</body>
</html>


<?php
	error_reporting(0);
	ini_set('max_execution_time', 300);

	function multiexplode ($delimiters,$string) {
		
		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return  $launch;
	}
	echo '<br/>';
	// Connect to the database: 
	
	// Create connection
	$conn = new mysqli("localhost", "root", "");
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	mysqli_select_db($conn, 'xmlextract') or die(mysqli_error($conn));

	$output = '';//rows
	
	if(isset($_POST['search'])){
	$searchq = $_POST['search'];
	//$searchq = preg_replace ("#[^0-9a-z]#i","",$searchq);

	if($searchq == '')
		{
			echo "\n Oh! you didnt type anything!";
		}
	else
	{
		
			
		//parsing the string
		$exploded = explode(" ", $searchq);
		$y = '';
		$query = '';
		$count = '';       
		$countSearch = count($exploded);
		$construct1 = "";
		$construct2 = "";
		
		for($y = 0;$exploded[$y] != NULL ;$y++)
		{
				if( $exploded[$y] != NULL && 
				$exploded[$y] != "a" &&	$exploded[$y] != "to" && $exploded[$y] != "the" && $exploded[$y] != "as" && $exploded[$y] != "in" && $exploded[$y] != "it" && $exploded[$y] != "is" && $exploded[$y] != "do" && $exploded[$y] != "an" && $exploded[$y] != "was" && $exploded[$y] != "0" && $exploded[$y] != "1" && $exploded[$y] != "2" && $exploded[$y] != "3" && $exploded[$y] != "4" && $exploded[$y] != "5" && $exploded[$y] != "6" && $exploded[$y] != "7" && $exploded[$y] != "8" && $exploded[$y] != "9" && $exploded[$y] != "am" && $exploded[$y] != "are" && $exploded[$y] != "were" && $exploded[$y] != "be" &&	$exploded[$y] != "being" && $exploded[$y] != "been" && $exploded[$y] != "have" && $exploded[$y] != "has" && $exploded[$y] != "had" && $exploded[$y] != "having" &&	$exploded[$y] != "do" && $exploded[$y] != "does" &&	$exploded[$y] != "did" && $exploded[$y] != "done" && $exploded[$y] != "could" && $exploded[$y] != "should" && $exploded[$y] != "would" &&	$exploded[$y] != "can" && $exploded[$y] != "shall" &&	$exploded[$y] != "will" && $exploded[$y] != "may" && $exploded[$y] != "might" && $exploded[$y] != "must" && $exploded[$y] != "above" && $exploded[$y] != "at" && $exploded[$y] != "by" && $exploded[$y] != "but" &&$exploded[$y] != "for" && $exploded[$y] != "from" && $exploded[$y] != "into" && $exploded[$y] != "like" && $exploded[$y] != "of" &&	$exploded[$y] != "off" && $exploded[$y] != "on" && $exploded[$y] != "onto" && $exploded[$y] != "than" && $exploded[$y] != "up" &&
				$exploded[$y] != "with")
			{		
				// $construct = "";
				// //single word search
				// $construct .= "Word LIKE '{$exploded[$y]}'";
				// $sql = "SELECT * FROM xmlextract.xmlword WHERE ".$construct.";";
				// //single word old
				// $query[$y] = $conn->query($sql) or die(mysqli_error($conn));
				// $count[$y] = mysqli_num_rows($query[$y]);
			}
		}
		
		$x = 0;
        foreach ($exploded as $search_each) {
            $x++;
            if ($x == 1){
                $construct1 .= "xmlword.Word LIKE '{$search_each}'";
				$construct2 .= "xmlpost.Title LIKE '%{$search_each}%'";
				
			}
            else{
				$construct1 .= " OR xmlword.Word LIKE '{$search_each}'";
				$construct2 .= " AND xmlpost.Title LIKE '%{$search_each}%'";
			}
        }
		
        //$construct = "SELECT DISTINCT(PostId) FROM xmlword WHERE $construct ";
		$construct1 = "SELECT * from xmlextract.xmlpost 
						WHERE xmlpost.PostId IN 
							(SELECT xmlpost.PostId FROM xmlextract.xmlpost 
                         WHERE $construct2
						 OR 
                         PostId IN (SELECT xmlword.PostId FROM xmlextract.xmlword 
                            WHERE $construct1)) ORDER BY xmlpost.rank DESC";
		
		//echo $construct;
        $sql       = $conn->query($construct1);
        $foundnum  = mysqli_num_rows($sql);
		
		$condition = true;
		while($row = $sql->fetch_assoc()) {		
			$condition = false;
			
			$sql1 = "Select * from xmlextract.xmlanswer where ParentId = ". $row["PostId"] ." ";			
			$result1 = $conn->query($sql1);
				
			$row1 = $result1->fetch_assoc();
			echo
			'<div class="sth">'
			
			."<span class='ds'>PostId:<span class='data'>".$row["PostId"] ."</span>
			Rank:<span class='data'>".$row["rank"] ."</span>
			AcceptedAnswerId:<span class='data'>".$row["AcceptedAnswerId"] ."</span>
			Score:<span class='data'>".$row["Score"] ."</span>
			ViewCount:<span class='data'>".$row["ViewCount"] ."</span>"
			."<br><div class='ds'>Title: <div class='data'><a href='#' id ='title'>".$row["Title"]."</a></div></div>";
			// if ( isset( $_POST['#title'] ) ) { }
			echo
			"<br><div class='ds hid'>Answer: <div class='data'>".$row1["Body"]."</div></div>"
			
			.'</div>';
		}
		if($condition){
			echo "<div class='noresult'>Sorry! No result found.</span></div>";
		}
	}
	
}

?>