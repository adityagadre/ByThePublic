<?php
phpinfo();
function deliver_response($status, $status_message, $data) {
	header ( "HTTP/1.1 $status $status_message" );
	$response ['status'] = $status;
	$response ['status_meassage'] = $status_message;
	$response ['data'] = $data;
	
	$json_response = json_encode ( $response );
	echo $json_response;
}
$server='127.0.0.1:3306';
$user='root';
$passwd='by-the-public';
header ( "Content-Type:application/json" );
if ($_SERVER ['REQUEST_METHOD'] === 'GET')
	if (isset ( $_GET ["cmd"] )) {
		$cmd = $_GET ["cmd"];
		if ($cmd == 1) {
			$arr = $_GET;
			// Connecting, selecting database
			$link = mysql_connect ( $server, $user, $passwd ) or die ( 'Could not connect: ' . mysql_error () );
			mysql_select_db ( 'bythepublic' ) or die ( 'Could not select database' );
			
			$insData = array (
					'latitude' => $arr ["lat"],
					'longitude' => $arr ["long"],
					'url' => $arr ["url"],
					'category' => $arr ["cat"],
					'optional' => $arr ["opt"],
					'Average_rating' => 0,
					'post_spam' => 'false',
					'view_count' => 0 
			);
			
			$columns = implode ( ", ", array_keys ( $insData ) );
			$escaped_values = array_map ( 'mysql_real_escape_string', array_values ( $insData ) );
			$values = implode ( ", ", $escaped_values );
			$sql = "INSERT INTO POST($columns) VALUES ($arr[lat],
			$arr[long],'$arr[url]', '$arr[cat]','$arr[opt]',0,false,0)";
			
			if (mysql_query ( $sql )) {
				deliver_response ( 200, "Success", null );
			} else {
				deliver_response ( 400, "Invalid Request", null );
			}
			
			// Closing connection
			mysql_close ( $link );
			
			deliver_response ( 200, "Success", null );
		} else if ($cmd == 2) {
			$arr = $_GET;
			// Connecting, selecting database
			$link = mysql_connect ( $server, $user, $passwd ) or die ( 'Could not connect: ' . mysql_error () );
			mysql_select_db ( 'bythepublic' ) or die ( 'Could not select database' );
			
			$insData = array (
					'USER_ID' => $arr ["uid"],
					'USER_NAME' => $arr ["uname"] 
			);
			
			$columns = implode ( ", ", array_keys ( $insData ) );
			$escaped_values = array_map ( 'mysql_real_escape_string', array_values ( $insData ) );
			$values = implode ( ", ", $escaped_values );
			$sql = "INSERT INTO USERS($columns) VALUES ($arr[uid],'$arr[uname]')";
			
			if (mysql_query ( $sql )) {
				deliver_response ( 200, "Success", null );
			} else {
				deliver_response ( 400, "Invalid Request", null );
			}
			
			// Closing connection
			mysql_close ( $link );
		} else if ($cmd == 3) {
			$arr = $_GET;
			// Connecting, selecting database
			$link = mysql_connect ( $server, $user, $passwd ) or die ( 'Could not connect: ' . mysql_error () );
			mysql_select_db ( 'bythepublic' ) or die ( 'Could not select database' );
			
			$insData = array (
					'POST_ID' => $arr ["pid"],
					'USER_ID' => $arr ["uid"],
					'CONTENT' => $arr ["content"],
					'COMMENT_SPAM' => false 
			);
			
			$columns = implode ( ", ", array_keys ( $insData ) );
			$escaped_values = array_map ( 'mysql_real_escape_string', array_values ( $insData ) );
			$values = implode ( ", ", $escaped_values );
			$sql = "INSERT INTO COMMENTS($columns) VALUES ($arr[pid],$arr[uid],'$arr[content]',false)";
			
			if (mysql_query ( $sql )) {
				deliver_response ( 200, "Success", null );
			} else {
				deliver_response ( 400, "Invalid Request", null );
			}
			
			// Closing connection
			mysql_close ( $link );
		} else if ($cmd == 4) {
			$arr = $_GET;
			// Connecting, selecting database
			$link = mysql_connect ( $server, $user, $passwd ) or die ( 'Could not connect: ' . mysql_error () );
			mysql_select_db ( 'bythepublic' ) or die ( 'Could not select database' );
			
			$sql = "select * from POST where latitude >= $arr[latup] and latitude <= $arr[latdown] and longitude >= $arr[longup] and longitude <= $arr[longdown]";
			$res = mysql_query ( $sql );
			if ($res) {
				$values = array ();
				for($i = 0; $i < mysql_num_rows ( $res ); ++ $i)
					array_push ( $values, mysql_fetch_assoc ( $res ) );
				
				deliver_response ( 200, "Success", $values );
			} else {
				deliver_response ( 400, "Invalid Request", null );
			}
			
			// Closing connection
			mysql_close ( $link );
		} else if ($cmd == 5) {
			$arr = $_GET;
			// Connecting, selecting database
			$link = mysql_connect ( $server, $user, $passwd ) or die ( 'Could not connect: ' . mysql_error () );
			mysql_select_db ( 'bythepublic' ) or die ( 'Could not select database' );
			
			$sql = "select * from POST where post_id='$arr[pid]'";
			$res = mysql_query ( $sql );
			if ($res) {
				$values = array ();
				for($i = 0; $i < mysql_num_rows ( $res ); ++$i)
					array_push ( $values, mysql_fetch_assoc ( $res ) );
				
				deliver_response ( 200, "Success", $values );
			} else {
				deliver_response ( 400, "Invalid Request", null );
			}
			
			// Closing connection
			mysql_close ( $link );
		}  else if ($cmd == 6) {
			$arr = $_GET;
			// Connecting, selecting database
			$link = mysql_connect ( $server, $user, $passwd ) or die ( 'Could not connect: ' . mysql_error () );
			mysql_select_db ( 'bythepublic' ) or die ( 'Could not select database' );
			
			$sql = "select * from POST where url='$arr[url]'";
			$res = mysql_query ( $sql );
			if ($res) {
				$values = array ();
				for($i = 0; $i < mysql_num_rows ( $res ); ++ $i)
					array_push ( $values, mysql_fetch_assoc ( $res ) );
				
				deliver_response ( 200, "Success", $values );
			} else {
				deliver_response ( 400, "Invalid Request", null );
			}
			
			// Closing connection
			mysql_close ( $link );
		}   else if ($cmd == 7) {
			$arr = $_GET;
			// Connecting, selecting database
			$link = mysql_connect ( $server, $user, $passwd ) or die ( 'Could not connect: ' . mysql_error () );
			mysql_select_db ( 'bythepublic' ) or die ( 'Could not select database' );
			
			$sql = "select comment_id,content,comment_spam,comment_time,user_name from comments inner join users on comments.USER_ID=users.USER_ID where post_id=$arr[pid]";
			$res = mysql_query ( $sql );
			if ($res) {
				$values = array ();
				for($i = 0; $i < mysql_num_rows ( $res ); ++ $i)
					array_push ( $values, mysql_fetch_assoc ( $res ) );
				
				deliver_response ( 200, "Success", $values );
			} else {
				deliver_response ( 400, "Invalid Request", null );
			}
			
			// Closing connection
			mysql_close ( $link );
		} else {
			echo "Hello";
		}
	}

?>

