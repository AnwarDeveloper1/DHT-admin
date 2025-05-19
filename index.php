
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background: red;
          width:200px;
          height:200px;
          margin-left:300px;
          font-size:20px;
        }
        form{
            font-size:20px;
           
            margin-top:200px;
        }
      
    </style>
</head>
<body>
    <form action="index.php" method="post">
        <input type="radio" name="cridt_card" value="Visa">Visa<br>
        <input type="radio" name="cridt_card" value="MasterCard">MasterCard<br>
        <input type="radio" name="cridt_card" value="Pay_Pale">pay_pal<br>
        <input style="font-size:20px"; type="submit" name="comfim" value='confirm' id="">
    </form>
</body>
</html>
<?php
if(isset($_POST["comfim"])){
    $cridt_card = null;

    if(isset($_POST["cridt_card"])){
        $cridt_card = $_POST["cridt_card"]; 
        
    }
    if($cridt_card == "Visa"){
        echo'You select Visa';
    }

    elseif($cridt_card == 'MasterCard'){
        echo"You selected MasterCard";
    }
    elseif($cridt_card == 'Pay_Pale'){
        echo"You selected Pay_pal";

    }

    else{
        echo"you don't select button";
    }
    
   

}




/*
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if(empty($username)){
        echo"The username is empty";
    }
    elseif(empty($password)){
        echo'The password is missing ';
    }

    else{
        echo"Hello {$username}<br>";
        echo"{$password}";
    }

}
*/


// isset() is a function which is used to declear a variable when it value is true of we don't assign value to a variable it become null so it give falus value
// Empty() is a funtion which give us true value when varibale is not declared and null l
/*
$username = ;
if(empty($username)){
echo"the user name is not set ";
}
else {
    echo"The username is set ";
}*/




// $capitals = array("USA"=> "Washington D.C",
//                    "Pakistan"=> "Karachi",
//                    "Afghanistan"=> "Kabul");
//                    $capitals ["Pakistan"]= "Islamabad";
//                     $capitals["china"] ="Being";
           
// $capatial = $capitals[ $_POST["counter"]];
// echo $capatial;


// session_start();
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: login.php");
//     exit;
// }






?>
