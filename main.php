
<?php
session_start();
$password =  $_SESSION['password'];
$userloginname =  $_SESSION['username'];
echo  '<h1>Welcome, '.$userloginname.'</h1>';

if (!(isset($_SESSION['username']) && $_SESSION['username'] != '')) {
  header ("Location: login.php");
  }
?>


<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("backend-search.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
</script>


<form  method="post" action="logout.php">
  <label class="logoutLblPos">
  <input name="submit2" type="submit" id="submit2" value="log out">
  </label>
</form>
<form action="main.php">
      <input type=button onClick="location.href='create_note.php'" value="Create notes">
 <br><br></form>  
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
        echo '<table>
        <tr>
          <th></th>
            <th>Title</th>
            <th>Content</th>
        </tr>';

       while( $row = $resultSet ->fetch_assoc()){ //fetch a result row as an associative array
       
        $noteid = $row["noteid"];
        echo'<tr>
            <td> '.$row["noteid"].'</td>
            <td> <a href="view.php?noteid='.$noteid.'"> '.$row["title"].'</a> </td>
            <td>'.$row["content"].'</td>
            </tr>';
       }
        echo '</table>';
      }
      else {
      	echo "No note is created";
      }

	$conn->close();

?>
<body>
  <form>
    <br><br><br>
  <input type="checkbox" name="decryptcheck" id="decryptcheck" value="1" style="width: auto" onclick="myFunction() ">
  <label for="decrypt">Decrypt?</label><br><br>
  <div class="password" id="decrypt" style="display:none">
    Encrypt password:
    <br>
    <input type="text" name="encry">
    
  </div>

    <div class="search-box">
        <input type="text" autocomplete="off" placeholder="Search content..." />
        <div class="result"></div>
    </div>
  </form>

</body>

<style>
  .search-box
  {
    margin:0 auto;
  width:300px
  }
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

form .logoutLblPos{
  margin:0 auto;
  width:30px
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
}
.logoutLblPos{

right:500px;
top:50px;
}

</style>

<script>
  function myFunction() {
    // Get the checkbox
    var checkBox = document.getElementById("decryptcheck");
    // Get the output text
    var text = document.getElementById("text");

    // If the checkbox is checked, display the output text
    if (checkBox.checked == true) {
      decrypt.style.display = "block";
    } else {
      decrypt.style.display = "none";
    }




  }
</script>