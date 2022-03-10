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
		$content=$_POST["content"];
		$code=$_POST["code"];


		$sql = "SELECT coupon_pair_index FROM table_user_coupon as us
 						JOIN table_user as u on us.user_id = u.user_id
    				JOIN table_coupon as c on c.coupon_id = us.coupon_id
    				JOIN table_show as s on c.rest_id = s.rest_id
            JOIN table_rest_qrcode as q on q.rest_id = s.rest_id
    				where username = '$username' and code = '$code' and content ='$content'
            LIMIT 1";

		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		$index = $row["coupon_pair_index"];


	$sql2 = "DELETE uc FROM table_user_coupon as uc
					JOIN table_coupon as c ON uc.coupon_id = c.coupon_id
					JOIN table_user as u ON uc.user_id = u.user_id
					WHERE u.username = '$username' AND uc.coupon_pair_index = '$index'";

		$result2 = mysqli_query($link,$sql2);
		$response = array();
		array_push($response,array("deleteSuccess"=>"1"));
		echo json_encode($response, JSON_UNESCAPED_UNICODE);


	// 釋放空間
		mysqli_free_result($result);
		mysqli_free_result($result2);

		// 關閉 SQL
		mysqli_close($link);
?>
