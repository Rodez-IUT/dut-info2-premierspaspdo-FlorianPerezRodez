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
	
	echo "<table>";
	echo "<tr><th>Id</th><th>Username</th><th>Email</th><th>Status</th></tr>";
	$stmt=$pdo->query('SELECT * FROM users');
	while($row=$stmt->fetch()){
		echo "<tr><td>".$row['id']."</td>"."<td>".$row['username']."</td>"."<td>".$row['email']."</td>"."<td>".$row['status_id']."</td></tr>";
	}
	echo "</table>";
?>