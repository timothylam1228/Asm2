<?php
$nameErr = $passErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["user_name"])) {
    $nameErr = "Name is required";
  }
  if (empty($_POST["loginpassword"])) {
    $passErr = "Password is required";
  }
}
?>

<form action="create_user.php" method="POST">
  <h1>Create User</h1>
  Username:<br>
  <input type="text" name="user_name">
  <span class="error">* <?php echo $nameErr; ?></span><br><br>
  First Name:<br>
  <input type="text" name="first_name"><br><br>
  Last Name<br>
  <input type="text" name="last_name"><br><br>
  Password:<br>
  <input type="password" name="loginpassword" autocomplete="off">
  <span class="error">* <?php echo $passErr; ?></span><br><br>
  Re-enter Password:<br>
  <input type="password" name="re_password" autocomplete="off"><br><br>
  <input type="submit" value="Create">
</form>


<?php
if (isset($_POST["user_name"])) {
  if (!empty($_POST["user_name"])) {
    $servername = "localhost:3306";
    $username = "root";
    $serverpassword = "password";

    $conn  = new mysqli($servername, $username, $serverpassword);
    if ($conn->connect_error) {
      echo "Error connecting to database";
    }
    $loginusername =  $_POST["user_name"];
    $firstname =  $_POST["first_name"];
    $lastname =  $_POST["last_name"];
    $loginpassword =  $_POST["loginpassword"];
    $reloginpassword =  $_POST["re_password"];
    $salt = bin2hex(random_bytes(16));
    $combinded = $loginpassword . $salt;

    #$sql = "INSERT INTO 18022038d.user (`username`, `firstname`, `lastname`,`password`,`salt`)
    #VALUES ('$loginusername', '$firstname', '$lastname',AES_ENCRYPT('$loginpassword',SHA2('$combinded',256),'$salt'),'$salt' )";

    $stmt = $conn->prepare("INSERT INTO 18022038d.user (`username`, `firstname`, `lastname`,`password`,`salt`)
    VALUES (?, ?, ? ,AES_ENCRYPT('$loginpassword',SHA2('$combinded',256),'$salt'), ? )");

    $stmt->bind_param("ssss", $loginusername, $firstname, $lastname, $salt);
    echo '<br><br>';
    if ($loginpassword != $reloginpassword) {
      echo '<h3>two password are not the same</h3>';
    } else if (strlen($loginpassword) <= 6) {
      echo '<h3>password are too short, password must >=7 digits</h3>';
    } else if ($stmt->execute() === TRUE) {
      #echo "New record created successfully";
      echo "<script type='text/javascript'>alert('Add success');</script>";
      header("refresh:0.3;url=login.php");
    } else {
      echo "Error: " . $stmt . "<br>" . $conn->error;
    }
    $conn->close();
  }
}

?>

<style>
  h3 {
    margin: 0 auto;
    width: 500px;
    color: #FF0000;
  }

  form {
    margin: 0 auto;
    width: 500px
  }

  input {
    margin-bottom: 3px;
    padding: 10px;
    width: 70%;
    border: 1px solid #CCC
  }

  button {
    padding: 10px
  }

  label {
    cursor: pointer
  }

  #form-switch {
    display: none
  }

  #register-form {
    display: none
  }

  #form-switch:checked~#register-form {
    display: block
  }

  #form-switch:checked~#login-form {
    display: none
  }

  .error {
    color: #FF0000;
  }
</style>