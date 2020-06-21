<?php
require_once("config.php");
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    // 判断用户名是否重复
    $usernameSQL = "select * from traveluser where UserName=:user";
    $statementU = $pdo->prepare($usernameSQL);
    $statementU->bindValue(':user',$_POST["username"]);
    $statementU->execute();
    // 判断邮箱是否重复
    $emailSQL = "select * from traveluser where Email=:email";
    $statementE = $pdo->prepare($emailSQL);
    $statementE->bindValue(':email',$_POST["email"]);
    $statementE->execute();

    if ($statementU->rowCount()>0) {
        echo "<script>alert(\"该用户名已被注册，请更换其他用户名\"); window.location.href=\"register.html\"</script>";
    } else if ($statementE->rowCount()>0){
        echo "<script>alert(\"该邮箱地址已被注册，请更换其他邮箱\"); window.location.href=\"register.html\"</script>";
    } else {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        //加盐，第一个参数为加盐前密码，第二个为哈希算法
        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
        $sql = "insert into traveluser (Email,UserName,Pass,State)values('$email', '$username', '$hashedPassword', '1')";
        $result = $pdo->query($sql);

        $pdo = null;
        echo "<script>alert(\"注册成功\"); window.location.href=\"login.html\"</script>";
    }
} catch(PDOException $e) {
    die( $e -> getMessage() );
}

?>
