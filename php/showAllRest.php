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


		$order = $_POST["order"];

		if($order == 0){
			$sql = "SELECT rest, type, rank FROM table_show as s
			JOIN table_choose as c on s.rest_id = c.rest_id
			JOIN table_type as t on c.type_id = t.type_id
			Order by money desc";
		}else if($order == 1){
			$sql = "SELECT rest, type, rank FROM table_show as s
			JOIN table_choose as c on s.rest_id = c.rest_id
			JOIN table_type as t on c.type_id = t.type_id
			Order by type desc";
		}else if($order == 2){
			$sql = "SELECT rest, type, rank FROM table_show as s
			JOIN table_choose as c on s.rest_id = c.rest_id
			JOIN table_type as t on c.type_id = t.type_id
			Order by rank desc";
		}else if($order == 3){
			$sql = "SELECT rest, type, rank FROM table_show as s
			JOIN table_choose as c on s.rest_id = c.rest_id
			JOIN table_type as t on c.type_id = t.type_id
			JOIN table_trans as tr on c.trans_id = tr.trans_id
			Order by trans ASC";
		}

		$result1=mysqli_query($link,$sql);

		$response=array();

		while($row=mysqli_fetch_array($result1))
		{
			array_push($response,array("allRest"=>$row["rest"], "allType"=>$row["type"], "allRate"=>$row["rank"]));
		}
		echo json_encode($response,JSON_UNESCAPED_UNICODE);



	// 釋放空間
		mysqli_free_result($result1);
		// 關閉 SQL
		mysqli_close($link);
?>
