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

		// php接到的參數
		$username=$_POST["username"];
		$code=$_POST["code"];

		// 時區設定&抓使用者手機時間(註解掉，才能在網頁Echo)
		date_default_timezone_set('Asia/Taipei');
		$day=date("D");
		$time = date("Y-m-d H:i:s");
		$sql = "SELECT rest_id FROM table_rest_qrcode WHERE code = '$code'"; //判定是否存在
		$result = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($result);

		if($row["rest_id"] != NULL){
				$sql1="SELECT user_id, rest_id, times, code_id FROM table_user
				LEFT JOIN table_user_frequency USING (user_id)
				LEFT JOIN table_rest_qrcode USING (rest_id)
				WHERE username='$username' AND (code = '$code' OR code IS NULL)";  // 主表一定有username, 若code_id=NULL代表沒有資料　→　要insert

				$result1 = mysqli_query($link,$sql1);
				$row1 = mysqli_fetch_array($result1);
				$user_id = $row1["user_id"];
				$rest_id = $row1["rest_id"];
				$times = $row1["times"];
				$code_id = $row1["code_id"];
				$response = array();
				//echo empty($code_id);  // empty($code_id): 若為empty會回傳1
				if ($code_id != NULL){
					$times = $times+1;
					//　要補放時間　,`latest`=$time
					$sql2="UPDATE table_user_frequency SET user_id='$user_id',rest_id='$rest_id',times='$times', latest= '$time'
					WHERE user_id= '$user_id' AND rest_id = '$rest_id;'";
					$result2=mysqli_query($link, $sql2);
					if ($times % 3 == 0){
							$sqlCoup = "SELECT coupon_id FROM table_coupon WHERE rest_id = '$rest_id' order by RAND() LIMIT 1";
							$resultCoup=mysqli_query($link, $sqlCoup);
							$rowC =  mysqli_fetch_array($resultCoup);
							$coupID = $rowC["coupon_id"];
							$sqlADD = "INSERT INTO table_user_coupon (coupon_pair_index,user_id, coupon_id) VALUES (NULL, $user_id, $coupID)";
							$resultAddCoup=mysqli_query($link, $sqlADD);
							array_push($response,array("addFrequencySuccess"=>"2"));
							echo json_encode($response, JSON_UNESCAPED_UNICODE);
					}else{
						array_push($response,array("addFrequencySuccess"=>"1"));
						echo json_encode($response, JSON_UNESCAPED_UNICODE);
					}
				}elseif ($code_id == NULL){
					$sqlFind = "SELECT user_id, rest_id FROM table_user
					JOIN table_rest_qrcode
					WHERE username = '$username' and code = '$code'";
					$resultF = mysqli_query($link,$sqlFind);
					$rowF = mysqli_fetch_array($resultF);
					$userID = $rowF["user_id"];
					$restID = $rowF["rest_id"];
					$sql3 = "INSERT INTO table_user_frequency (user_id, rest_id, times, latest) VALUES ($userID, $restID, 1, '$time')";
					$result3 = mysqli_query($link, $sql3);
					array_push($response,array("addFrequencySuccess"=>"1"));
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
				}
			}else{
				array_push($response,array("addFrequencySuccess"=>"0"));
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
			}
		// 釋放空間
		mysqli_free_result($result);
		mysqli_free_result($result2);
		mysqli_free_result($resultF);
		// 關閉 SQL
		mysqli_close($link);

?>
