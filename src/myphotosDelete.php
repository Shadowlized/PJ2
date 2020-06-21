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
    //删除照片  同时删除所有关于这张图片的收藏信息
    $sql = "delete from travelimage where UID = '$strUID' and ImageID = '$currentImageID'";
    $result = $pdo->query($sql);
    $sql = "delete from travelimagefavor where ImageID = '$currentImageID'";
    $result = $pdo->query($sql);
    header("Location: myphotos.php");
    //echo "<script>alert(\"已从网站删除该图片\")</script>";

} catch(PDOException $e){
    die($e ->getMessage());
}
