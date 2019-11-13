<?php 
	$host    ='localhost';
	$db      ='my_activities';
	$user    ='root';
	$pass    ='root';
	$charset ='utf8mb4';
	
	$dsn     ="mysql:host=$host;dbname=$db;charset=$charset";
	$options = [
	    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];
	try {
		$pdo = new PDO($dsn, $user, $pass, $options);
	} catch (PDOException $e){
		throw new PDOException($e->getMessage(),(int)$e->getCode());
	}
	
	$lettreUsername = 'e%';
	echo "<table>";
	echo "<tr><th>Id</th><th>Username</th><th>Email</th><th>Status</th></tr>";
	$stmt=$pdo->query("SELECT * FROM users WHERE username LIKE '$lettreUsername' AND status_id=2");
	while($row=$stmt->fetch()){
		echo "<tr><td>".$row['id']."</td>"."<td>".$row['username']."</td>"."<td>".$row['email']."</td>"."<td>";
		if ($row['status_id'] == 1) {
			echo 'Waiting for account confirmation';
		} else if ($row['status_id'] == 2) {
			echo 'Active account';
		} else if ($row['status_id'] == 3) {
			echo 'Waiting for account deletion';
		}			
		echo "</td></tr>";
	}
	echo "</table>";
?>