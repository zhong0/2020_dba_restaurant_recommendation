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

		// Idea:
		// 主表:table_favorite, 要join table_user才可以接username串到user_id ，才可以用user_id 在table_favorite刪除rest_id
		// 也要join table_show 因為才可用街道的 rest 查到 rest_id

		// php接到的資料
		$username=$_POST["username"];  // "type"是參數名稱
		$rest=$_POST["rest"];  // "food"是參數名稱

		//資料庫語法(優化:可能要一次刪掉多個)
		// 35: 悅來牛肉麵, 34:飽飽食府, 33:永康街左撇子, 32: 梁社漢排骨文山指南店, 31: 政大焿大王

		//method
		//$number_of_rows=mysqli_num_rows($result);

		$sql="DELETE f.* FROM table_favorite f
		LEFT JOIN table_user ON f.user_id=table_user.user_id
		LEFT JOIN table_show ON f.rest_id=table_show.rest_id
		WHERE username='$username' AND rest='$rest'";
		$response = array();
		$result=mysqli_query($link,$sql);
		array_push($response, array("deletefavoriteSuccess" => "1"));
		echo json_encode($response, JSON_UNESCAPED_UNICODE);

		// 釋放空間
		mysqli_free_result($result);


		// 關閉 SQL
		mysqli_close($link);

?>
