
<?php
session_start();
$password =  $_SESSION['password'];
$userloginname =  $_SESSION['username'];
echo $_GET['noteid'];
?>

<?php
   $servername = "localhost:3306";
   $username = "root";
   $serverpassword = "password";
   // Create connection
   $conn = new mysqli($servername, $username, $serverpassword);
   // Check connection
   if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
    }
    $username =  $_SESSION['username'];
    $sql = "SELECT noteid, title, content FROM 18022038d.notes WHERE username='$userloginname';";
    
    $resultSet = $conn->query($sql);
      if (!$resultSet) {
      trigger_error('Invalid query: ' . $conn->error);
      }

      if ($resultSet->num_rows > 0) {

       $row = $resultSet ->fetch_assoc(); //fetch a result row as an associative array
        
      echo '<h2> '.$row["title"].'</h2>';
       
      
      }
      else {
      	echo "No note is created";
      }

	$conn->close();

?>


<style>
  h1{
    margin:0 auto;
  width:300px
  }
    table{
    border: 1px solid black;
    margin:0 auto;
    width:auto;
    padding: 5px;
  }
  table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 10px;
}
form {
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