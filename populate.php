<?php
/*
* populate.php
*
* Script for populating the search database with words,
* pages and word-occurences.
*/

	/* Connect to the database: */
	mysql_connect("localhost","root","") or die(mysql_error());
	
	mysql_select_db("search_eng") or die(mysql_error());

	/*URL defined, which will be crawled and parsed*/
	$url = addslashes( $_GET['url'] );

	/*If populate.php?url= empty then*/
	if(!$url){
		die(" There is no URL Entered, Please Enter a URL to be Processed ");
	}
	/*If URL is present but first 7 characters aren't http:// then add http:// before url*/
	else if( substr($url,0,7) != "http://" )
	{
		$url = "http://$url";
	}
	
	/*Checking if URL is already listed in Page table of Database ? */
	$result = mysql_query("SELECT page_id FROM page WHERE page_url = \"$url\"  ");
	if (!$result) 
	{
		echo 'Could not run query: ' . mysql_error();
	}
	else
	{
			//$row = mysql_fetch_array($result);
			//if( $row['page_id'] )
			//{
			//   /* If yes, use the old page_id: */
			//  $page_id = $row['page_id'];
			//}
			//else
			//{
			//   /* If not, create one: */
			//   mysql_query("INSERT INTO page (page_url) VALUES (\"$url\")");
			//  $page_id = mysql_insert_id();
			//}
			
			$row = mysql_fetch_array($result);
			
			if($row[0]){
				/*if yes, use old page id*/
				$page_id = $row[0];
			}else{
				/*if not then create new url, and use new page id */
				mysql_query("INSERT INTO page(page_url) VALUES (\"$url\")");
				$page_id = mysql_insert_id();
			}			
	}
	
	/*if url is not allowed to be opened */
		if( !($fd = fopen($url,"r")) ){
			die("Could not open the URL!!!");
		}
	
	/*Start dividing or parsing the text, words from lines, build index in DB*/
	while( $buf = fgets($fd,1024) )
	{
		/*trim or remove any whitespaces from starting or ending of out line or string*/
		$buf = trim($buf);
		
		/*Removing HTML Tags to extract Words*/
		$buf = strip_tags($buf);
		$buf = ereg_replace('/&\w;/','',$buf);
		
		/* Extract all words matching the regexp from the current line: */
		preg_match_all("/(\b[\w+]+\b)/",$buf,$words);
		
		/* Loop through all words/occurrences and insert them into the database: 
		2d matrix*/
		for($i = 0; $words[$i]; $i++)
		{
			for( $j = 0; $words[$i][$j]; $j++ )
			{
				/* Does the current word already have a record in the word-table? */
				 $cur_word = addslashes( strtolower($words[$i][$j]) );

				 $result = mysql_query("SELECT word_id FROM word 
										WHERE word_word = '$cur_word'");
				 $row = mysql_fetch_array($result);
				 if( $row['word_id'] )
				 {
					/* If yes, use the old word_id: */
					$word_id = $row['word_id'];
				 }
				 else
				 {
					/* If not, create one: */
					mysql_query("INSERT INTO word (word_word) VALUES (\"$cur_word\")");
					$word_id = mysql_insert_id();
				 }

				 /* And finally, register the occurrence of the word: */
				 mysql_query("INSERT INTO occurrence (word_id,page_id) 
							  VALUES ($word_id,$page_id)");
				 print "Indexing: $cur_word<br>";
				
			}
		}
	}
	
fclose($fd);
?>

<html> 
	<head> 
		<title> My search engine </title>
	 </head>
 <body> 
<form action = 'search.php' method = 'GET' > 
<center > 
<h1 > My Search Engine </h1 > 
<input type = 'text' size='90' name = 'search' > <br /> <br >
<input type = 'submit' name = 'submit' value = 'Search source code' > 

</center > </form >
 </body > 
 </html > 
