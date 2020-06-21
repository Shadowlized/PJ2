<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Favorites</title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/navigation.css" rel="stylesheet" type="text/css">
    <link href="css/favorites.css" rel="stylesheet" type="text/css">
</head>
<body>
<nav>
    <div class="div-left">
        <img src="../img/avatar.jpg" alt="" id="avatar-nav" width="28px" height="28px">
        <a href="index.php" class="link" id="home-nav">Home</a>
        <a href="browse.php?method=&content=" class="link" id="browse-nav">Browse</a>
        <a href="search.php" class="link" id="search-nav">Search</a>
    </div>
    <div class="dropdown">
        <?php
        if(isset($_COOKIE["usernameCookieName"])){
            echo "<button class=\"dropdown-button\">".$_COOKIE["usernameCookieName"];
            echo "</button><div class=\"dropdown-content\">
                <a href=\"upload.php\"><img src=\"../img/icons/upload.png\" alt=\"\" width=\"20px\" height=\"20px\">&nbsp;&nbsp;Upload</a>
                <a href=\"myphotos.php\"><img src=\"../img/icons/myphotos.png\" alt=\"\" width=\"20px\" height=\"20px\">&nbsp;&nbsp;My Photos</a>
                <a href=\"favorites.php\"><img src=\"../img/icons/favorites.png\" alt=\"\" width=\"20px\" height=\"20px\">&nbsp;&nbsp;Favorites</a>
                <a href=\"logout.php\"><img src=\"../img/icons/login.png\" alt=\"\" width=\"20px\" height=\"20px\">&nbsp;&nbsp;Logout</a>
            </div>";
        } else {
            echo "<a href='login.html'><button class=\"dropdown-button\">Login</button></a>";
        }
        ?>
    </div>
</nav>

<section>
    <div id="div-title">
        <h2>My Favorites</h2>
    </div>
    <div id="div-main">
        <?php
        require_once("config.php");
        try {
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);

            //通过username获取对应UID
            $strUsername = $_COOKIE["usernameCookieName"];
            $sql = "select UID from traveluser where UserName = '$strUsername'";
            $result = $pdo->query($sql);
            while($row = $result->fetch()){
                $strUID = $row['UID'];
            }
            //通过UID获取每个人收藏的图片的ImageID
            $sql = "select ImageID from travelimagefavor where UID = '$strUID'";
            $result = $pdo->query($sql);
            $arrayImageID = []; $i = 0;
            while($row = $result->fetch()){
                $arrayImageID[$i] = $row['ImageID'];
                $i++;
            }
            //页码
            $pageSize = 6; @$currentPage = empty($_GET["currentPage"])?1:$_GET["currentPage"];
            $k = $i;
            if ($k % $pageSize == 0){
                $totalPage = $k / $pageSize;
            } else {
                $totalPage = $k / $pageSize + 1;
            }
            if ($totalPage > 5){
                $totalPage = 5; //保留前五页
            }

        //打印i张
        for ($i = ($currentPage-1)*$pageSize; $i < min($k,(($currentPage-1)*$pageSize)+6); $i++){
            $vari = $arrayImageID[$i];
            $sql = "select * from travelimage where ImageID = '$vari'";
            $result = $pdo->query($sql);
            while($row = $result->fetch()) {
                $strPath = $row['PATH'];
                $strTitle = $row['Title'];
                $strDescription = $row['Description'];
                echo "<div class=\"div-favorites\"><a href=\"details.php?id=".$vari;
                echo "\"><img src=\"../travel-images/medium/".$strPath;
                echo "\" alt=\"\" class=\"img-favorites\"></a><div class=\"description\"><h3>".$strTitle;
                echo "</h3><span>".$strDescription;
                echo "</span><br>
                <button class=\"remove\" onclick=window.location.href=\"favoritesDelete.php?id=".$vari;
                echo "\">Remove</button>
                </div>
            </div>";
            }
        }
        if ($i == 0){
            echo "<h1>您还未添加图片至收藏夹！</h1>";
        }
        if ($i != 0){
            require_once ("pages.php");
        }
        } catch (PDOException $e) {
            die( $e -> getMessage() );
        }
        ?>
    </div>
</section>

<footer>
    Copyright @ 2020 Web Fundamentals. All Rights Reserved. 备案号：19302010013吴逸昕
</footer>
</body>
<script src="js/clickheart.js"></script>
</html>