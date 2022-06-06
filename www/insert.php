<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon_student.php');

    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        // 안드로이드 코드의 postParameters 변수에 적어준 이름을 가지고 값을 전달 받는다.

        $userId=$_POST['userId_s'];
        $userPassword=$_POST['userPassword_s']; // 단말 TimeStamp는 POST로 전달받음    
        $userName=$_POST['userName_s'];
        $userAge=$_POST['userAge_s'];


        if(empty($userId)){
            $errMSG = "Input userId";
        }
        else if(empty($userPassword)){
            $errMSG = "Input userPassword";
        }
        else if(empty($userName)){
            $errMSG = "Input userName";
        }
        else if(empty($userAge)){
            $errMSG = "Input userAge";
        }


        if(!isset($errMSG))
        {
            try{
                $stmt = $con->prepare('INSERT INTO USER(userId, userPassword, userName, userAge) VALUES(:userId, :userPassword, :userName, :userAge)');
                $stmt->bindParam(':userId', $userId);
                $stmt->bindParam(':userPassword', $userPassword);
                $stmt->bindParam(':userName', $userName);
                $stmt->bindParam(':userAge', $userAge);

                if($stmt->execute())
                {
                    $successMSG = "New record addition";
                }
                else
                {
                    $errMSG = "record addition error";
                }

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage()); 
            }
        }

    }
?>

<html>
   <body>
        <?php 
        if (isset($errMSG)) echo $errMSG;
        if (isset($successMSG)) echo $successMSG;
        ?>
        
        <!-- <form action="<?php $_PHP_SELF ?>" method="POST">
            id: <input type = "text" userId = "id" /><br>
            Terminal_time: <input type = "text" userId = "Terminal_time" /><br>
            Server_time: <input type = "text" userId = "Server_time" /><br>
            x: <input type = "text" userId = "x" /><br>
            y: <input type = "text" userId = "y" /><br>
            bat_level: <input type = "text" userId = "bat_level" /><br>
            <input type = "submit" userId = "submit" />
        </form> -->
   
   </body>
</html>