<?php

/*
* search.php
*
* Script for searching a database populated with keywords by the
* populate.php-script.

*/

print '<html><head><title>My Search Engine</title></head><body> <br />';

if($_POST['keyword'])
{
   /* Connect to the database: */
	mysql_connect("localhost","root","") or die(mysql_error());
	
	mysql_select_db("search_eng") or die(mysql_error());


   /* Get timestamp before executing the query: */
   $start_time = getmicrotime();

   /* Set $keyword and $results, and use addslashes() to
    *  minimize the risk of executing unwanted SQL commands: */
   $keyword = addslashes( $_POST['keyword'] );
   $results = addslashes( $_POST['results'] );

   /* Execute the query that performs the actual search in the DB: */
   $result = mysql_query(" SELECT p.page_url AS url,
                           COUNT(*) AS occurrences 
                           FROM page p, word w, occurrence o
                           WHERE p.page_id = o.page_id AND
                           w.word_id = o.word_id AND
                           w.word_word = \"$keyword\"
                           GROUP BY p.page_id
                           ORDER BY occurrences DESC
                           LIMIT $results" );

   /* Get timestamp when the query is finished: */
   $end_time = getmicrotime();

   /* Present the search-results: */
   print "<h2>Search results for '".$_POST['keyword']."':</h2>\n";
   for( $i = 1; $row = mysql_fetch_array($result); $i++ )
   {
      print "$i. <a href='".$row['url']."'>".$row['url']."</a>\n";
      print "(occurrences: ".$row['occurrences'].")<br><br>\n";
   }

   /* Present how long it took the execute the query: */
   print "query executed in ".(substr($end_time-$start_time,0,5))." seconds.";
}
else
{
   /* If no keyword is defined, present the search page instead: */
   print "<form method='post'> Keyword: 
          <input type='text' size='20' name='keyword'>\n";
   print "Results: <select name='results'><option value='5'>5</option>\n";
   print "<option value='10'>10</option><option value='15'>15</option>\n";
   print "<option value='20'>20</option></select>\n";

   print "<input type='submit' value='Search'></form>\n";
}

print "</body></html>\n";

/* Simple function for retrieving the current timestamp in microseconds: */
function getmicrotime()
{
   list($usec, $sec) = explode(" ",microtime());
   return ((float)$usec + (float)$sec);
}

?>