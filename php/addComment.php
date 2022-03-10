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

		$rest = $_POST["rest"];
		$username = $_POST["username"];
		$comment = $_POST["comment"];

		$sql = "SELECT comment FROM table_comment AS c
		JOIN table_user AS u ON c.user_id = u.user_id
		JOIN table_show AS s ON c.rest_id = s.rest_id
		WHERE rest = '$rest' and username = '$username'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$comm = $row["comment"];

		$sql2 = "SELECT user_id FROM table_user WHERE username='$username'" ;
		$result2 = mysqli_query($link,$sql2);
		$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
		$user_id = $row2["user_id"];

		$sql3 = "SELECT rest_id FROM table_show WHERE rest = '$rest'" ;
		$result3 = mysqli_query($link,$sql3);
		$row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);
		$rest_id = $row3["rest_id"];
		$response = array();

		if($comm != NULL){
			$sqlUpdate = "UPDATE table_comment SET comment = '$comment'
			WHERE rest_id = '$rest_id' and user_id = '$user_id'";
			mysqli_query($link, $sqlUpdate);
			array_push($response, array("addCommentSuccess" => '1'));
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
		}else{
			$sqlInsert="INSERT INTO table_comment(rest_id,user_id,comment) values('$rest_id','$user_id','$comment')";
			mysqli_query($link,$sqlInsert);
			array_push($response, array("addCommentSuccess" => '2'));
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
		}

	// 釋放空間
		mysqli_free_result($result);
		mysqli_free_result($result2);
		mysqli_free_result($result3);

		// 關閉 SQL
		mysqli_close($link);
?>
