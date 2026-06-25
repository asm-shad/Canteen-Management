<?php
	class cls_user_login{
		public function con(){
			$connect = new cls_dbconfig();
			return $connect->connection();
		}
		
		public function user_access($uname,$pass){
			$no = "no";
			$yes = "yes";
			
			
			$result = $this->con()->query("SELECT * FROM user WHERE username = '$uname' and password = md5('$pass')");
			$check = $result->num_rows;
			if($check == 0){
				return $no;
			}
			
			$row = $result->fetch_assoc();
			// session_start();
			//$_SESSION['id'] = $row['id'];
			$_SESSION['login_id'] = $row['id'];
			$_SESSION['user_name'] = $row['username'];
			$_SESSION['name'] = $row['name'];
			$_SESSION['employeeID'] = $row['employeeID'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['user_role'] = $row['user_role'];
			return $yes;
		}
		
	}
?>