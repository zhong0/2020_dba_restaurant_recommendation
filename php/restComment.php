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
		// php接: rest → table_show
		// php傳：rank、phone、address、intro(前四個都在table_show)、comment(table_comment)  &  time(table_time) → 中伶

		// php接到的資料 (table_time要補)
		$rest=$_POST["rest"];  // "rest"是參數名稱


		// 資料庫語法
		// (table_time要補)
		$sql="SELECT comment, username FROM table_show
		JOIN table_comment as c using (rest_id)
		JOIN table_user as u on c.user_id = u.user_id
		WHERE rest='$rest'";

		$result=mysqli_query($link,$sql);

		//method
		$response=array();
		while($row = mysqli_fetch_array($result))
		{
			array_push($response,array("restComment"=>$row["comment"],"usernameComment"=>$row["username"])); //
		}
		echo json_encode($response, JSON_UNESCAPED_UNICODE);


		// 釋放空間
		mysqli_free_result($result);


		// 關閉 SQL
		mysqli_close($link);

?>
