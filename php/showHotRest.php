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
		connect_sql() ;

		$sql = "SELECT rest, type, rank FROM table_user_frequency AS uf
    JOIN table_show AS s ON  uf.rest_id = s.rest_id
    JOIN table_choose AS c ON c.rest_id = s.rest_id
    JOIN table_type AS t ON c.type_id = t.type_id
    group by uf.rest_id order by sum(uf.times) DESC LIMIT 3";

		$result = mysqli_query($link,$sql);
		$response = array();

		while($row = mysqli_fetch_array($result)){
      array_push($response, array("hotRest"=>$row["rest"], "hotType"=>$row["type"], "hotRank"=>$row["rank"]));
    }
		echo json_encode($response, JSON_UNESCAPED_UNICODE);


		// 釋放空間
		mysqli_free_result($result);
		// 關閉 SQL
		mysqli_close($link);

?>
