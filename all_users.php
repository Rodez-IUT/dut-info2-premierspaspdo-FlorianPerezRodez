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
			<form action="all_users.php" method="get">
				Start with letter: <input type="text" name="letter" value="" /> 
				and status is: 
				<select name="status">
				   <option value="Waiting for account validation">Waiting for account validation</option>
				   <option value="Active account" selected="selected">Active account</option>
				   <option value="Waiting for account deletion">Waiting for account deletion</option>
				</select>
				<input type="submit" value="OK" />
			</form>
		<?php
			if(isset($_GET['letter'])){
				// je suis passé par le formulaire, affichage du résultat de la requête.
				$lettreUsername = $_GET['letter'].'%';
				$statusState = $_GET['status'];
				echo "<table>";
				echo "<tr><th>Id</th><th>Username</th><th>Email</th><th>Status</th><th></th></tr>";			
				$stmt=$pdo->prepare('SELECT users.id as user_id, status_id, username, email, s.name as status
				FROM users join status s on users.status_id = s.id
				WHERE username LIKE :name 
				AND s.name = :status ORDER BY username');
				$stmt->execute(['name' => $lettreUsername, 'status' => $statusState]);
				while($row=$stmt->fetch()){
					echo "<tr><td>".$row['user_id']."</td>"."<td>".$row['username']."</td>"."<td>".$row['email']."</td>"."<td>".$row['status'];
					if ($row['status'] != 'Waiting for account deletion') {
						echo "</td><td><a onclick='' href='http://localhost:8080/dut-info2-premierspaspdo-FlorianPerezRodez/all_users.php?status_id=3&user_id=".$row['user_id']."&action=askDeletion'>ask deletion</a>";
					}						
					echo "</td></tr>";
				}
				echo "</table>";
			} else {
				// Affichage instruction
				echo "<table>";
				echo "<tr><th>Id</th><th>Username</th><th>Email</th><th>Status</th><th></th></tr>";
				$stmt=$pdo->query("SELECT * FROM users");
				while($row=$stmt->fetch()){
					echo "<tr><td>".$row['id']."</td>"."<td>".$row['username']."</td>"."<td>".$row['email']."</td>"."<td>";
					if ($row['status_id'] == 1) {
						echo 'Waiting for account validation'."</td><td><a onclick='' href='http://localhost:8080/dut-info2-premierspaspdo-FlorianPerezRodez/all_users.php?status_id=3&user_id=".$row['id']."&action=askDeletion'>ask deletion</a>";
					} else if ($row['status_id'] == 2) {
						echo 'Active account'."</td><td><a onclick='' href='http://localhost:8080/dut-info2-premierspaspdo-FlorianPerezRodez/all_users.php?status_id=3&user_id=".$row['id']."&action=askDeletion'>ask deletion</a>";
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