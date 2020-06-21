<?php
require_once("config.php");
try {
    //获取图片id
    $currentImageID = $_GET['id'];
    //获取uid
    $strUsername = $_COOKIE["usernameCookieName"];
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $sql = "select UID from traveluser where UserName = '$strUsername'";
    $result = $pdo->query($sql);
    while($row = $result->fetch()){
        $strUID = $row['UID'];
    }
    //删除收藏
    $sql = "delete from travelimagefavor where UID = '$strUID' and ImageID = '$currentImageID'";
    $result = $pdo->query($sql);
    header("Location: favorites.php");
    //echo "<script>alert(\"已取消收藏\")</script>";

} catch(PDOException $e){
    die($e ->getMessage());
}
