<?php
  error_reporting(E_ALL);
  ini_set('display_errors',1);
 
  include('dbcon_student.php');
 
  $userID=isset($_POST['userID']) ? $_POST['userID'] : '';
  $userPassword=isset($_POST['userPassword']) ? $_POST['userPassword'] : '';
 
  $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
 
  if ($userID != "" ){
 
    $sql="select * from USER where userID='$userID' AND userPassword=SHA1('$userPassword')";
    $stmt = $con->prepare($sql);
    $stmt->execute();
 
    if ($stmt->rowCount() == 0){
 
      echo "'";
      echo $userID;
      echo "' no id OR wrong password.";
    }
    else{
      $data = array();
 
      while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
 
        extract($row);
 
        array_push($data,
          array('userID'=>$row["userID"],
          'userPassword'=>$row["userPassword"],
          'userName'=>$row["userName"],
          'userAge'=>$row["userAge"]
        ));
 
      if (!$android) {
          echo "<pre>";
          print_r($data);
          echo '</pre>';
      }else
      {
          header('Content-Type: application/json; charset=utf8');
          $json = json_encode(array("user"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
          echo $json;
      }
    }
}
  }
  else {
    echo " login. ";
  }
 
 
?>
 
 
 
<?php
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
 
if (!$android){
?>
 
<html>
   <body>
 
      <form action="<?php $_PHP_SELF ?>" method="POST">
         ID: <input type = "text" name = "userID" />
         PASSWORD: <input type = "text" name = "userPassword" />
         <input type = "submit" />
      </form>
 
   </body>
</html>
<?php
}
 
 
?>
