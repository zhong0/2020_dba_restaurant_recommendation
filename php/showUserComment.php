<?php
	set_time_limit(0);
	error_reporting(E_ERROR);	//不希望顯示錯誤提示
	// 連接 SQL 的 function
	function connect_sql() {
		global $link;
		$hostname= "localhost";		// 主機名稱
		$username= "root";			// 資料庫登入帳號
		$password= "";		// 資料庫登入密碼
		$database= "dbafinal";		// 資料庫名稱
		$link = mysqli_connect( $hostname , $username , $password );
		// 改為 UTF8 以免亂碼
		mysqli_query($link, "SET NAMES 'UTF8'");
		mysqli_select_db($link, $database) or die("無法選擇資料庫");
	}

	// 連接 SQL
		connect_sql() ;
		$username = $_POST["username"];
		$rest = $_POST["rest"];


		$sql = "SELECT comment FROM table_comment as c
				JOIN table_user as u ON c.user_id = u.user_id
				JOIN table_show as s ON c.rest_id = s.rest_id
				WHERE username = '$username' and rest = '$rest'";

		$result = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($result);
		$comm = $row["comment"];
		$response=array();
		if($comm != NULL){
				array_push($response,array("userComment"=>$comm));
		}else{
				array_push($response,array("userComment"=>""));
		}
		echo json_encode($response,JSON_UNESCAPED_UNICODE);

	// 釋放空間
		mysqli_free_result($result);
		// 關閉 SQL
		mysqli_close($link);
?>
