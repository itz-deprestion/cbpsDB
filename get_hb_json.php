<?php
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	/*$email = $request->user;
	$email2 = addslashes($request->user);
	if ($email != $email2) die("Invalid email");
	$pass = $request->password;
	$password2 = addslashes($request->password);
	if ($pass != $password2) die("Invalid password");*/
	$id = $request->hid;
	$id2 = addslashes($request->hid);
	if ($id != $id2) die("Invalid id");
	include 'config.php';

	// Create connection
	$con = mysqli_connect($servername, $username, $password, $dbname);
	
	// Check connection
	if (mysqli_connect_errno()){
		die("Connection failed: " . mysqli_connect_error());
	} 
	
	//$sth = mysqli_query($con,"SELECT * FROM vitadb_users WHERE email='$email' AND password='$pass'");
	//if ($sth){
		$sth = mysqli_query($con,"SELECT * FROM vitadb WHERE id = '$id'");
		if ($sth){
			$rows = array();
			while($r = mysqli_fetch_assoc($sth)) {
				
				// Downloads counter support
				$masked_link = "https://vitadb.rinnegatamante.it/get_hb_link.php?id=" . $r['id'];
				unset($r['url']);
				$r['url'] = $masked_link;
				
				$rows[] = $r;
			}
			echo json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		} else {
			echo("An error occurred: " . mysqli_error($con));
		}
	//} else {
	//	echo("An error occurred: " . mysqli_error($con));
	//}
	mysqli_close($con);
?>