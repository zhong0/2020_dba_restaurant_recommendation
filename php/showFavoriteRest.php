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


		$sql = "SELECT rest, type FROM table_show as s
				JOIN table_favorite as f ON s.rest_id = f.rest_id
				JOIN table_user as u ON u.user_id = f.user_id
				Join table_choose as c ON c.rest_id = f.rest_id
				Join table_type as t ON t.type_id = c.type_id
				WHERE u.username = '$username'";

		$result1=mysqli_query($link,$sql);

		$response=array();

		while($row=mysqli_fetch_array($result1))
		{
				array_push($response,array("favoriteRest"=>$row["rest"],"favoriteType"=>$row["type"]));
		}
		echo json_encode($response,JSON_UNESCAPED_UNICODE);

		//要echo所有常用店家的名字



	// 釋放空間
		mysqli_free_result($result);
		mysqli_free_result($result2);

		// 關閉 SQL
		mysqli_close($link);
?>
