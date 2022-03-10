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

		$sql = "SELECT username, count(rest_id) from table_user_frequency as uf
		JOIN table_user as u on uf.user_id = u.user_id
		where rest_id in (select rest_id from table_user_frequency as uf
			JOIN table_user AS u on uf.user_id = u.user_id
			where username = '$username') and username != '$username' group by uf.user_id order by count(rest_id) desc LIMIT 1";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$matchID = $row["username"];
	

		$sql2 = "SELECT rest, type, rank from table_user_frequency as uf
		JOIN table_user as u on uf.user_id = u.user_id
		JOIN table_show as s on uf.rest_id = s.rest_id
		JOIN table_choose as c on s.rest_id = c.rest_id
		JOIN table_type as t on t.type_id = c.type_id
		where uf.rest_id not in
		(select rest_id from table_user_frequency as uf
			JOIN table_user AS u on uf.user_id = u.user_id
			where username = '$username') and username = '$matchID'";
		$result2 = mysqli_query($link,$sql2);
		$response = array();
		while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
			array_push($response, array("matchRest" => $row2["rest"], "matchType"=> $row2["type"], "matchRank"=>$row2["rank"]));
		}
		echo json_encode($response, JSON_UNESCAPED_UNICODE);
	// 釋放空間
		mysqli_free_result($result);
		mysqli_free_result($result2);

		// 關閉 SQL
		mysqli_close($link);
?>
