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

		$username=$_POST["username"];
		$rest=$_POST["rest"];


		$sql = "SELECT * from table_favorite as f
		JOIN table_user as u on u.user_id = f.user_id
		JOIN table_show as s on f.rest_id = s.rest_id
		where username = '$username' and rest = '$rest'";

		$result = mysqli_query($link,$sql);
		$count = 0;
		while	($row = mysqli_fetch_array($result)){
			$count++;
		}
		$response = array();
		if($count == 0){
			array_push($response, array("alreadyFav" => '0'));
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
		}else{
			$response = array();
			array_push($response, array("alreadyFav" => '1'));
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
		}



	// 釋放空間
		mysqli_free_result($result);

		// 關閉 SQL
		mysqli_close($link);
?>
