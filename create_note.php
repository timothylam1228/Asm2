<?php
session_start();
$password =  $_SESSION['password'];
$userloginname =  $_SESSION['username'];
if (!(isset($_SESSION['username']) && $_SESSION['username'] != '')) {
  header("Location: login.php");
}
?>


<?php
$titleErr = $contentErr = $encrypassErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["title"])) {
    $titleErr = "Title is required";
  }
  if (empty($_POST["content"])) {
    $contentErr = "Content is required";
  }
  if (empty($_POST["encry"])) {
    $encrypassErr = "Encrypt password is required";
  }
}
?>
<form action="create_note.php" method="POST">
  <h1>Create note</h1>
  Title:<br>
  <input type="text" name="title" id="input">
  <span class="error">* <?php echo $titleErr; ?></span><br><br>
  Content:<br>
  <input type="text" name="content" id="input">
  <span class="error">* <?php echo $contentErr; ?></span><br><br>
  <input type="checkbox" name="encryptcheck" id="encryptcheck" value="1" style="width: auto" onclick="myFunction() ">
  <label for="encrypt">Encrypt?</label><br><br>
  <div class="password" id="encry" style="display:none">
    Encrypt password:
    <br>
    <input type="password" name="encry">
    <span class="error">* <?php echo $encrypassErr; ?></span><br><br>
  </div>
  <br>
  <input type="submit" value="Create">
</form>



<?php
if (isset($_POST["title"]) && isset($_POST["content"])) {
  if (!empty($_POST["title"]) && !empty($_POST["content"])) {
    $servername = "localhost:3306";
    $username = "root";
    $serverpassword = "password";

    $conn  = new mysqli($servername, $username, $serverpassword);
    if ($conn->connect_error) {
      echo "Error connecting to database";
    }
    $title = $_POST["title"];
    $content = $_POST["content"];
    $salt = random_bytes(16);
    if (isset($_POST['encryptcheck'])) {
      $temp = 1;
    } else {
      $temp = 0;
    }
    $combinded = $salt . $password;

    if ($temp == 1 && $_POST["encry"] != $password) {
      #$sql = "INSERT INTO 18022038d.notes (`title`, `content`, `encrypted`,`username`,`salt`)
      #VALUES ('$title', AES_ENCRYPT('$content',SHA2('$combinded',256),'$salt'), '" . $_POST["encryptcheck"] . "', '$userloginname', '$salt')";
      #print_r($sql);
      $stmt = $conn->prepare("INSERT INTO 18022038d.notes (`title`, `content`, `encrypted`,`username`,`salt`)
      VALUES (?, AES_ENCRYPT('$content',SHA2('$combinded',256),'$salt'), ?, ?, ?)");
      $stmt->bind_param("ssss", $title, $temp, $userloginname, $salt);

    } else if ($temp == 1 && $_POST["encry"] == $password) {
      echo '<h3>encrypt password cannot same as login password</h3>';
    } else if ($temp == 0) {
      #$sql = "INSERT INTO 18022038d.notes (`title`, `content`, `encrypted`,`username`)
      #VALUES ('$title', '$content', '$temp', '$userloginname' )";
      $stmt = $conn->prepare("INSERT INTO 18022038d.notes (`title`, `content`, `encrypted`,`username`)
        VALUES (?, ?, ?, ? )");
      $stmt->bind_param("ssss", $title, $content, $temp, $userloginname);
    }
    if (isset($stmt)) {
      if ($stmt->execute() === TRUE) {
        echo "New record created successfully";
        echo "<script type='text/javascript'>alert('Add success');</script>";
        header("refresh:0.3;url=main.php");
      } else {
        echo "Error:  <br>" . $conn->error;
      }
      $conn->close();
    }
  }
}



?>
<style>
  h3 {
    margin: 0 auto;
    color: #FF0000;
    width: 480px;
  }

  form {
    margin: 0 auto;
    width: 480px
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

<script>
  function myFunction() {
    // Get the checkbox
    var checkBox = document.getElementById("encryptcheck");
    // Get the output text
    var text = document.getElementById("text");

    // If the checkbox is checked, display the output text
    if (checkBox.checked == true) {
      encry.style.display = "block";
    } else {
      encry.style.display = "none";
    }




  }
</script>