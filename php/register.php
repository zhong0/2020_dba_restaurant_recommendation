<?php
	set_time_limit(0);
	error_reporting(E_ERROR);	//不希望顯示錯誤提示
	// 連接 SQL 的 function
	function connect_sql() {
		global $link;
		$hostname= "localhost";		// 主機名稱
		$username= "root";			// 資料庫登入帳號
		$password= "";		// 資料庫登入密碼(目前沒有設置)
		$database= "dbafinal";		// 資料庫名稱
		$link = mysqli_connect( $hostname , $username , $password );
		// 改為 UTF8 以免亂碼
		mysqli_query($link, "SET NAMES 'UTF8'");
		mysqli_select_db($link, $database) or die("無法選擇資料庫");
	}

		// 連接 SQL
		connect_sql() ;

		// 從網址輸入取得用戶輸入的資料
		$username=$_POST["username"];  // "username"是參數名稱

		//進資料庫查詢(先把資料庫有的東西都叫出來)
		$x="SELECT username FROM table_user";  //資料庫有的
		$result=mysqli_query($link,$x);
		$row=mysqli_fetch_array($result, MYSQLI_NUM);
		//print_r($row);// 只輸出第一個

		$num = 0;
		// while 就可以存進所有的data
		while ($row=mysqli_fetch_array($result)){
			if($row['username'] == $username){
				$num++ ;
			}
		};

		$response = array();
		if($num > 0){
			array_push($response, array("registerSuccess" => '0'));
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
		}else{
			$sql = "INSERT INTO table_user (user_id, username) VALUES (NULL, '$username')";
			mysqli_query($link,$sql);

			array_push($response, array("registerSuccess" => '1'));
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
		}

		// 釋放空間
		mysqli_free_result($result);
		mysqli_free_result($result2);

		// 關閉 SQL
		mysqli_close($link);

?>
