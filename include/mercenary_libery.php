<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<?PHP
ob_start();
@session_start();
	 function ms_chk_login($user,$pwd,$table,$filduser,$fildpwd,$fildsta){
     $sql_qly_login = mssql_query("SELECT * FROM ".$table." WHERE ".$filduser." = '".$user."' AND ".$fildpwd." = '".$pwd."'");
	 $put_login = mssql_fetch_array($sql_qly_login);
	 $user_sess = $put_login["".$filduser.""];
	 $pwd_ses = $put_login["".$fildpwd.""];
	 $status = $put_login["".$fildsta.""];
	   if($user == $user_sess && $pwd == $pwd_ses && $status == '1'){	
		$_SESSION["user_sess"] = $user_sess;
		$_SESSION["pwd_ses"] = $pwd_ses;
	    echo "<script>alert(\"Wellcome  ".$_SESSION["user_sess"]."  \")</script>";
	    echo("<meta http-equiv='refresh' content='0;url=index.php' />");
	   }else{
	    echo("<meta http-equiv='refresh' content='0;url=login.php?login=error' />");
	   }	 
     }	
	 //---------------------------------------LOGIN---------------------------------------------------------------------------
	 function ms_chk_login_encode($user,$pwd,$table,$filduser,$fildpwd,$fildsta){
	 $user_enc = md5($user);
	 $pwd_enc  = md5($pwd);
     $sql_qly_login = mssql_query("SELECT * FROM ".$table." WHERE ".$filduser." = '".$user_enc."' AND ".$fildpwd." = '".$pwd_enc."'");
	 $put_login = mssql_fetch_array($sql_qly_login);
	 $user_sess = $put_login["".$filduser.""];
	 $pwd_ses = $put_login["".$fildpwd.""];
	 $status = $put_login["".$fildsta.""];
	   if($user == $user_sess && $pwd == $pwd_ses && $status == '1'){	
		$_SESSION["user_sess"] = $user_sess;
		$_SESSION["pwd_ses"] = $pwd_ses;
	    echo "<script>alert(\"Wellcome  ".$_SESSION["user_sess"]."  \")</script>";
	    echo("<meta http-equiv='refresh' content='0;url=index.php' />");
	   }else{
	    echo("<meta http-equiv='refresh' content='0;url=login.php?login=error' />");
	   }	 
     }	
	 //---------------------------------------LOGIN----ENCODE-----------------------------------------------------------------
	 function select_max($fild,$table,$num){
	  $sql_qly = mssql_query("SELECT  ISNULL(MAX(".$fild."),0)+1 AS is_run_max  FROM ".$table." ");
	  $arr = mssql_fetch_array($sql);  	 
	  $run_id = sprintf("%0".$num."d", $arr[0]); 
	  return $run_id;
	 }
	 //---------------------------------------count max-----------------------------------------------------------------SELECT
	 function select_rows($fild,$table){
	  $sql_qly = mssql_query("SELECT  ".$fild."  FROM ".$table." ");
	  $rows = mssql_num_rows($sql);  	 
	  return $rows;
	 }
	 //---------------------------------------count rows----------------------------------------------------------------SELECT
	 function getdd($day,$dat){
		$arr = explode("".$dat."",$day);
		return $arr[2]; 
	 }
	 function getmm($day,$dat){
		$arr = explode("".$dat."",$day);
		return $arr[1]; 
	 }
	 function getyy($day,$dat){
		$arr = explode("".$dat."",$day);
		return $arr[0]; 
	 }
	 //---------------------------------------date--------------------------------------------------------------------DATETIME
	 function number_to_stringTH($number){ 
        $txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ'); 
        $txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน'); 
	  	$number = str_replace(",","",$number); 
		$number = str_replace(" ","",$number); 
        $number = str_replace("บาท","",$number);  
		$number = explode(".",$number); 
			if(sizeof($number)>2){ 
                return 'Error'; 
			    exit; 
	        } 
		$strlen = strlen($number[0]); 
		$convert = ''; 
			for($i=0;$i<$strlen;$i++){ 
				$n = substr($number[0], $i,1); 
					if($n!=0){ 
						if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; } 
						elseif($i==($strlen-2) AND $n==2){  $convert .= 'ยี่'; } 
						elseif($i==($strlen-2) AND $n==1){ $convert .= ''; } 
						else{ $convert .= $txtnum1[$n]; } 
						$convert .= $txtnum2[$strlen-$i-1]; 
						} 
					} 
						$convert .= 'บาท'; 
					if($number[1]=='0' OR $number[1]=='00' OR 
						$number[1]==''){ 
						$convert .= 'ถ้วน'; 
					}else{ 
					$strlen = strlen($number[1]); 
						for($i=0;$i<$strlen;$i++){ 
							$n = substr($number[1], $i,1); 
								if($n!=0){ 
									if($i==($strlen-1) AND $n==1){$convert .= 'เอ็ด';} 
									elseif($i==($strlen-2) AND $n==2){$convert .= 'ยี่';} 
									elseif($i==($strlen-2) AND $n==1){$convert .= '';} 
									else{$convert .= $txtnum1[$n];} 
									$convert .= $txtnum2[$strlen-$i-1]; 
								} 
	  					} 
						$convert .= 'สตางค์ '; 
	  				} 
	 		return ceil($convert); 
		} 
	 //---------------------------------------count rows----------------------------------------------------------------CONVERS
	 
	 
	 
	 
	 
?>