<?php
ob_start() ;
function ms_db_to_csv($table,$file){
$sql = "SELECT * FROM  ".$table."";
$results = mssql_query($sql." ");
while ($l = mssql_fetch_array($results, MSSQL_ASSOC)) {
	$out .= "INSERT INTO ".$table." VALUES( ";
	$i = 1;
    foreach($l AS $key => $value){
        $pos = strpos($value, '"');
        if ($pos !== false) {
            $value = str_replace( ' " ' , ' \" ' , $value);
        }
		if(is_numeric($value)){
		  if($i == 1){
			  $out .= " ".iconv('TIS-620','UTF-8',$value)." ";
		  }else{
			  $out .= ",".iconv('TIS-620','UTF-8',$value)."";
		  }
	    }else{
		  if($i == 1){
		      $out .= "'".iconv('TIS-620','UTF-8',$value)."'";
		  }else{
		      $out .= ",'".iconv('TIS-620','UTF-8',$value)."'";
		  }
		}
	 $i++;
    }
    $out .= " ); \n";
}
//mssql_free_result($results);
//mssql_close();
//header("Content-type: text/x-csv");
//header("Content-Disposition: attachment; filename=".$file.".csv");
//echo $out;
return $out;
}
 
?>

