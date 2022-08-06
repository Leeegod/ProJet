<?php 
  $db = "store"; //database name
  $dbuser = "root"; //database username
  $dbpassword = ""; //database password
  $dbhost = "localhost"; //database host
  $return["error"] = false;
  $return["message"] = "";
  $return["success"] = false;
  $link = mysqli_connect($dbhost, $dbuser, $dbpassword, $db);
  session_start();
  if(isset($_POST["username"]) && isset($_POST["password"])){
       //checking if there is POST data

       $username = $_POST["username"];
       $password = $_POST["password"];
     
       $username = mysqli_real_escape_string($link, $username);
       //escape inverted comma query conflict from string
        
       $sql = "SELECT * FROM user_info WHERE email = '$username'";
       //building SQL query
       $res = mysqli_query($link, $sql);
       $numrows = mysqli_num_rows($res);
       //check if there is any row
       if($numrows > 0){
           //if there is any data with that username
           $obj = mysqli_fetch_object($res);
           //get row as object
           if($password == $obj->password){
               $return["success"] = true;
               $return["Name"] = $obj->Name;
             
              }else{
               $return["error"] = true;
               $return["message"] = "Your Password is Incorrect.";
           }
       }else{
           $return["error"] = true;
           $return["message"] = 'Email Not Registered.';
       }}else{
      $return["error"] = true;
      $return["message"] = 'Error Ouccerd';
  }

  mysqli_close($link);

  header('Content-Type: application/json');
  // tell browser that its a json data
  echo json_encode($return);
  //converting array to JSON string
?>