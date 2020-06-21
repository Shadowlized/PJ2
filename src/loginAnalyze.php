<?php
require_once("config.php");
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "select * from traveluser where UserName='$username' or Email='$username'";
    $result = $pdo->query($sql);
    //判断加盐后密码
    while($row=$result->fetch()){
        $hash = $row['Pass'];
    }
    $valid = password_verify($password,$hash);
    if($valid || ($password == $hash)){ //后者用于应对先前未加盐的账户的登录
        //将可能出现的输入email登录的情况先转为username，同一判断，若输入的是username本语句不影响
        $sqlEToU = "select UserName from traveluser where Email='$username'";
        $result = $pdo->prepare($sqlEToU);
        $result->execute();
        while($row = $result->fetch()){
            $username = $row['UserName'];
        }
        setcookie("usernameCookieName",$username, time()+3600*24);
        header("Location: index.php");
    /*
    //username login
    $sql = "select * from traveluser where UserName='$username' and Pass='$password'";
    $statement = $pdo->query($sql);
    //email login
    $sqlE = "select * from traveluser where Email='$username' and Pass='$password'";
    $statementE = $pdo->query($sqlE);
    //
    if($statement->rowCount()>0){
        setcookie("usernameCookieName",$_POST["username"], time()+3600*24);
        header("Location: index.php");
    } else if($statementE->rowCount()>0){
        //获取email相应username记录于cookie中
        $sqlEToU = "select UserName from traveluser where Email='$username'";
        $result = $pdo->prepare($sqlEToU);
        $result->execute();
        while($row = $result->fetch()){
            $strUserName = $row['UserName'];
        }
        setcookie("usernameCookieName",$strUserName, time()+3600*24);
        header("Location: index.php");*/
    } else {
        echo "<script>alert(\"用户名不存在或密码错误\"); window.location.href=\"login.html\"</script>";
    }
} catch (PDOException $e) {
    die( $e -> getMessage() );
}
?>


