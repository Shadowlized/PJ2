<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Details</title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/navigation.css" rel="stylesheet" type="text/css">
    <link href="css/details.css" rel="stylesheet" type="text/css">
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
        <h2>Details</h2>
    </div>
    <div id="div-main">
        <?php
        require_once("config.php");
        try {
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            $currentImageID = $_GET['id'];

            //travelimage数据库
            $sql = "select * from travelimage where ImageID = '$currentImageID'";
            $result = $pdo->query($sql);
            while($row = $result->fetch()) {
                $strPath = $row['PATH'];
                $strTitle = $row['Title'];
                $strDescription = $row['Description'];
                $strUID = $row['UID'];
                $strContent = $row['Content'];
                $strCityCode = $row['CityCode'];
                $strCountry_RegionCodeISO = $row['Country_RegionCodeISO'];
            }

            //traveluser数据库
            $sqlUserName = "select UserName from traveluser where UID = '$strUID'";
            $resultUserName = $pdo->query($sqlUserName);
            while($row = $resultUserName->fetch()){
                $strUserName = $row['UserName'];
            }

            //geocities数据库
            if($strCityCode){
                $sqlCities = "select AsciiName from geocities where GeoNameID = '$strCityCode'";
                $resultCities = $pdo->query($sqlCities);
                while($row = $resultCities->fetch()){
                    $strCityName = $row['AsciiName'];
                }
            } else {
                $strCityName = "Unknown";
            }

            //geocountries_regions数据库
            if($strCountry_RegionCodeISO){
                $sqlCR = "select Country_RegionName from geocountries_regions where ISO = '$strCountry_RegionCodeISO'";
                $resultCR = $pdo->query($sqlCR);
                while($row = $resultCR->fetch()){
                    $strCRName = $row['Country_RegionName'];
                }
            } else {
                $strCRName = "Unknown";
            }

            //☆☆☆获取每张图片收藏数☆☆☆  重置至排序前顺序（注释见index）
            $sql = "select ImageID from travelimagefavor";
            $result = $pdo->query($sql);
            $GLOBALS = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
            while ($row = $result->fetch()){
                $GLOBALS[$row['ImageID']]++;
            }

            echo "<h1>".$strTitle;
            echo "<span id=\"author\">&nbsp;&nbsp; by ".$strUserName;
            echo "</span></h1><img src=\"../travel-images/large/".$strPath;
            echo "\" alt=\"\" id=\"img-main\"><div class=\"div-right\">
                <div class=\"div-small\"><h3>Like Number</h3><h4>".$GLOBALS[$currentImageID];
            echo "</h4></div><div class=\"div-small\">
                <h3>Image Details</h3><p>Content: ".$strContent;
            echo "</p><p>Country: ".$strCRName;
            echo "</p><p>City: ".$strCityName;
            echo "</p></div><button id=\"favorite\" onclick=window.location.href=\"favoritesAdd.php?id=".$currentImageID;
            echo "\">";
            //检测是否已收藏
            if (!isset($_COOKIE["$currentImageID"])){
                echo "❤ Favorite";
            } else {
                echo "× Remove from Favorites";
            }
            echo "</button></div>
                <div class=\"description\">".$strDescription;
            echo "</div>";

            $pdo = null;
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

<script>/*
    let buttonWord = document.getElementById("favorite").value;
    document.getElementById("favorite").onclick = function(){
        if (buttonWord === "❤ Favorite"){
            buttonWord = "Remove Favorite";
            alert("图片已收藏");
        } else {
            buttonWord = "❤ Favorite";
            alert("图片已取消收藏");

        }
    };
    */
</script>

</html>