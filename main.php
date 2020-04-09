<h1>MAIN</h1>

<?php
if (isset($_POST["user_name"]) && isset($_POST["password"])) {
   $servername = "localhost:3306";
   $username = "root";
   $password = "password";
   // Create connection
   $conn = new mysqli($servername, $username, $password);
   // Check connection
   if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
    }
    $loginpassword = $_POST["password"];
	$sql = "SELECT AES_DECRYPT(password,SHA2(CONCAT('$loginpassword',salt),256),salt) FROM 18022038d.user WHERE username='"
		.$_POST["user_name"]."';";
			
	//$sql = "SELECT name, password FROM lab1.USER WHERE name='1'";
	printf("The SQL Statement:<br> $sql<br/></br>");


    $resultSet = $conn->query($sql);
      if (!$resultSet) {
      trigger_error('Invalid query: ' . $conn->error);
      }

      if ($resultSet->num_rows > 0) {
     	# $row = $resultSet ->fetch_assoc(); //fetch a result row as an associative array
      	echo "<h2> Welcome: ".$row["username"]."</h2>";
      }
      else {
      	echo "<h2>Invalid username/password!</h2>";
      }

	$conn->close();
}
?>

<style>form {
  margin:0 auto;
  width:300px
}
input {
  margin-bottom:3px;
  padding:10px;
  width: 100%;
  border:1px solid #CCC
}
button {
  padding:10px
}
label {
  cursor:pointer
}
#form-switch {
  display:none
}
#register-form {
  display:none
}
#form-switch:checked~#register-form {
  display:block
}
#form-switch:checked~#login-form {
  display:none
}</style>