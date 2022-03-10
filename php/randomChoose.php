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

		// php接：1 / 2 / 3 (全隨機/常用隨機/條件隨機)
		$choose=$_POST["choose"];  // 1 / 2 / 3 (全隨機/常用隨機/條件隨機)
		//常用隨機時要用到的參數
		$username=$_POST["username"];  // 要登入，才能連接到該使用者的常用隨機, 當$choose = 2

		date_default_timezone_set('Asia/Taipei');
		$day=date("D");
		$time = date("H:i:s");
		//$time = ("18:00:00");

		// 條件隨機時要用到的參數
		//進資料庫查詢(先把資料庫有的東西都叫出來)
		//先試試看一個WHERE 參數
		if($choose == 1){
			$sql="SELECT rest, type, rank FROM table_show
			LEFT JOIN table_choose AS choose using (rest_id)
			LEFT JOIN table_type AS type ON choose.type_id=type.type_id
			LEFT JOIN table_food AS food ON choose.food_id=food.food_id
			LEFT JOIN table_price AS price ON choose.price_id=price.price_id
			LEFT JOIN table_trans AS trans ON choose.trans_id=trans.trans_id
			JOIN table_time ON table_show.rest_id = table_time.rest_id
			WHERE day='$day' AND ((('$time' > begin) AND ('$time' < end) AND (end > begin)) or ((begin > end) AND (('$time' > begin) or ('$time' < end))))
			ORDER BY RAND()
			LIMIT 3";
			$result=mysqli_query($link,$sql);
			$response=array();
			while($row=mysqli_fetch_array($result)){
				array_push($response,array("randRest"=>$row["rest"], "randType"=>$row["type"],"randRate"=>$row["rank"]));
			}
			echo JSON_ENCODE($response,JSON_UNESCAPED_UNICODE);

		}elseif($choose == 2){
			$sql="SELECT rest, type, rank FROM table_show as s
			JOIN table_choose AS c using (rest_id)
			JOIN table_type AS t ON c.type_id = t.type_id
			JOIN table_favorite as f ON s.rest_id = f.rest_id
			JOIN table_user as u ON u.user_id = f.user_id
			JOIN table_time ON s.rest_id = table_time.rest_id
			WHERE u.username = '$username' AND day='$day' AND ((('$time' > begin) AND ('$time' < end) AND (end > begin)) or ((begin > end) AND (('$time' > begin) or ('$time' < end))))
			ORDER BY RAND()
			LIMIT 3";
			$result=mysqli_query($link,$sql);
			$response=array();
			while($row=mysqli_fetch_array($result)){
				array_push($response,array("randRest"=>$row["rest"], "randType"=>$row["type"],"randRate"=>$row["rank"]));
			}
			echo JSON_ENCODE($response,JSON_UNESCAPED_UNICODE);
		
		}



		// 釋放空間
		mysqli_free_result($result);
		// 關閉 SQL
		mysqli_close($link);

?>
