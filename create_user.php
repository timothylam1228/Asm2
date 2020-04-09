

<form action="create_user.php" method="POST">
<h1>Create User</h1>
Username:
<input type="text" name="user_name"><br>
First Name:
<input type="text" name="first_name"><br>
Last Name
<input type="text" name="last_name"><br>
Password:
<input type="text" name="loginpassword"><br>
Re-enter Password
<input type="text" name="re_password"><br>
<input type="submit">
</form>


<?php
if(isset($_POST["user_name"])){
    $servername = "localhost:3306";
    $username = "root";
    $password = "password";
    
    $conn  = new mysqli($servername,$username,$password);
    if($conn->connect_error){
        echo "2";
    }
    echo "nivc";
    $loginusername =  $_POST["user_name"];
    $firstname =  $_POST["first_name"];
    $lastname =  $_POST["last_name"];
    $loginpassword =  $_POST["loginpassword"];
    $reloginpassword =  $_POST["re_password"];
    $salt = bin2hex(random_bytes(16));
    $combinded = $loginpassword.$salt;
  
    $sql = "INSERT INTO 18022038d.user (`username`, `firstname`, `lastname`,`password`,`salt`)
    VALUES ('$loginusername', '$firstname', '$lastname',AES_ENCRYPT('$loginpassword',SHA2('$combinded',256),'$salt'),'$salt' )";

    print_r($sql);
    if($loginpassword!=$reloginpassword){
        echo 'two password are not the same';
    }
    else if(strlen($loginpassword)<=6){
        echo 'password are too short, password must >=7 digits';
    }
    
    else if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        echo "<script type='text/javascript'>alert('Add success');</script>";
        header( "refresh:0.3;url=login.php" );
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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