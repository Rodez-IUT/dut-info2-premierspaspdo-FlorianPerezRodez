<!DOCTYPE hmtl>
	<head>
		<meta charset="utf-8">
		<title>Users</title>
	  
		<link href="css/monStyle.css" rel="stylesheet">
		
		<!-- Bootstrap CSS -->
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="font-awesome/css/font-awesome.css" rel="stylesheet">
	</head>
	<body>
		<?php 
			$host    ='localhost';
			$port    ='3306'; // My sql écoute le port
			$db      ='my_activities';
			$user    ='root';
			$pass    ='root';
			$charset ='utf8mb4';
			
			$dsn     ="mysql:host=$host;port=$port;dbname=$db;charset=$charset";
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
		?>
			<form action="all_users.php" method="post">
				Start with letter: <input type="text" name="letter" value="" /> 
				and status is: 
				<select name="status">
				   <option value="1">Waiting for account confirmation</option>
				   <option value="2" selected="selected">Active account</option>
				   <option value="3">Waiting for account deletion</option>
				</select>
				<input type="submit" value="OK" />
			</form>
		<?php
			if(isset($_POST['letter'])){
				// je suis passé par le formulaire, affichage du résultat de la requête.
				$lettreUsername = $_POST['letter'].'%';
				$statusNumber = $_POST['status'];
				echo "<table>";
				echo "<tr><th>Id</th><th>Username</th><th>Email</th><th>Status</th></tr>";
				$stmt=$pdo->query("SELECT * FROM users WHERE username LIKE '$lettreUsername' AND status_id=$statusNumber ORDER BY username");
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
			} else {
				// Affichage instruction
				echo "<table>";
				echo "<tr><th>Id</th><th>Username</th><th>Email</th><th>Status</th></tr>";
				$stmt=$pdo->query("SELECT * FROM users");
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
			}	
		?>
	</body>
</html>