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
    //添加收藏
    $sqlTest = "select UID,ImageID from travelimagefavor";
    $result = $pdo->query($sqlTest);
        //检测是否已收藏
    //$GLOBALS['redundantFavorite'] = false;
    while($row = $result->fetch()){
        if ($row['UID'] == $strUID && $row['ImageID'] == $currentImageID)
            setcookie("$currentImageID", true, time()+3600000*24);
            //$GLOBALS['redundantFavorite'] = true;
    }
    if (!isset($_COOKIE["$currentImageID"])){
        setcookie("$currentImageID", true, time()+3600000*24);
        $sql = "insert into travelimagefavor (UID, ImageID) values('$strUID', '$currentImageID')";
        $result = $pdo->query($sql);
        //echo "× Remove from Favorites";
    } else {
        setcookie("$currentImageID","",-1);
        $sql = "delete from travelimagefavor where UID = '$strUID' and ImageID = '$currentImageID'";
        $result = $pdo->query($sql);
        //echo "❤ Favorite";
    }

    header("Location: details.php?id=".$currentImageID);
} catch(PDOException $e){
    die($e ->getMessage());
}