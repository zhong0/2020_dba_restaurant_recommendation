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

		//常用隨機時要用到的參數
		// 要登入，才能連接到該使用者的常用隨機, 當$choose = 2

		//時區設定&抓使用者手機時間(註解掉，才能在網頁Echo)
		date_default_timezone_set('Asia/Taipei');
		$day=date("D");
		$time = date("H:i:s");

		// 條件隨機時要用到的參數
		$type=$_POST["type"];  // "type"是參數名稱
		$food=$_POST["food"];  // "food"是參數名稱，傳給你的資料會是 xxx;xxx;xxxx;然後用split函式分開讀取存進array
		$price=$_POST["price"];  // "price"是參數名稱
		$trans=$_POST["trans"];  // "trans"是參數名稱
		$rank=$_POST["rank"];  // "rank"是參數名稱

		//進資料庫查詢(先把資料庫有的東西都叫出來)
			//type: 1-義式料理 2-台式料理 3-日式料理 4-其他
			//food: 1-飯食 2-麵食 3-飯/麵 4-排餐 5-鍋物 6-其他
			//price: 1- 100以下 2- 100-200 3- 200-300 4-300以上
			//trans: 1-步行 2-騎車/搭車 3-步行/騎車/搭車

			//=======================================================================
			// split方法已停用，改用explode
			$type = explode(';', $type, 4);  //4: 限制分割後的元素數量
			// echo "type1: $type[0]";
			// echo "type2: $type[1]";
			// echo "type3: $type[2]";

			$food = explode(';', $food, 6);
			//echo "food1: $food[0]; food2: $food[1]; food3: $food[2]; food3: $food[3]; food4: $food[4]; food5: $food[5]";

			$price = explode(';', $price, 4);
			//echo "price1: $price[0]; price2: $price[1]; price3: $price[2]";

			$trans = explode(';', $trans, 3);
			//echo "trans1: $trans[0]; trans2: $trans[1]; trans3: $trans[2]";

			
			$sql="SELECT rest, type, rank FROM table_show
			JOIN table_choose AS c using (rest_id)
			JOIN table_type AS t ON c.type_id=t.type_id
			JOIN table_food AS f ON c.food_id=f.food_id
			JOIN table_price AS p ON c.price_id=p.price_id
			JOIN table_trans AS trs ON c.trans_id=trs.trans_id
			JOIN table_time AS tt ON tt.rest_id = table_show.rest_id
			WHERE (t.type='$type[0]' OR t.type='$type[1]' OR t.type='$type[2]' OR t.type='$type[3]')
			AND (f.food='$food[0]' OR f.food='$food[1]' OR f.food='$food[2]' OR f.food='$food[3]' OR f.food='$food[4]' OR f.food='$food[5]')
			AND (p.price='$price[0]' OR p.price='$price[1]' OR p.price='$price[2]' OR p.price='$price[3]')
			AND (trs.trans='$trans[0]' OR trs.trans='$trans[1]' OR trs.trans='$trans[2]')
			AND (rank >= '$rank')
			AND (day='$day' AND ((('$time' > begin) AND ('$time' < end) AND (end > begin)) or ((begin > end) AND (('$time' > begin) or ('$time' < end)))))
			ORDER BY RAND()
			LIMIT 3";
			
			/*$sql ="SELECT rest, type, rank FROM table_show 
			JOIN table_choose AS c using (rest_id) 
			JOIN table_type AS t ON c.type_id=t.type_id 
			JOIN table_food AS f ON c.food_id=f.food_id 
			JOIN table_price AS p ON c.price_id=p.price_id 
			JOIN table_trans AS trs ON c.trans_id=trs.trans_id 
			JOIN table_time AS tt ON tt.rest_id = table_show.rest_id 
			WHERE (t.type='台式料理' OR t.type='義式料理' OR t.type='其他' OR t.type='日式料理') 
			AND (f.food='飯食' OR f.food='麵食' OR f.food='飯/麵' OR f.food='鍋物' OR f.food='排餐' OR f.food='其他')
			AND (p.price='100以下' OR p.price='100-200' OR p.price='200-300' OR p.price='300以上') 
			AND (trs.trans='步行' OR trs.trans='騎車/搭車' OR trs.trans='步行/騎車/搭車') 
			AND (rank >= 0) 
			AND (day='Sat' AND ((('22:20:00' > begin) 
			AND ('22:20:00' < end) AND (end > begin)) or (begin > end AND ('22:20:00' > begin or '22:20:00' < end)))) ORDER BY RAND() LIMIT 3";*/

			$result=mysqli_query($link,$sql);
			$response=array();
			while($row=mysqli_fetch_array($result))
			{
				array_push($response,array("condRest"=>$row["rest"], "condType"=>$row["type"],"condRate"=>$row["rank"]));
			}
			echo JSON_ENCODE($response,JSON_UNESCAPED_UNICODE);



		// 釋放空間
		mysqli_free_result($result);


		// 關閉 SQL
		mysqli_close($link);

?>
