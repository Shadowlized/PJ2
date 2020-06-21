<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet">
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <link href="css/navigation.css" rel="stylesheet" type="text/css">
    <link href="css/index.css" rel="stylesheet" type="text/css">
</head>
<body>
    <a name="return-here"><nav>
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
    </nav></a>
    <header>
        <div id="div-header">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="4"></li>
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="../travel-images/large/6114907897.jpg" alt="..." class="carousel-img">
                        <div class="carousel-caption">
                            At top of Sulpher Mountain
                        </div>
                    </div>
                    <div class="item">
                        <img src="../travel-images/large/8710289254.jpg" alt="..." class="carousel-img">
                        <div class="carousel-caption">
                            Looking towards Fira
                        </div>
                    </div>
                    <div class="item">
                        <img src="../travel-images/large/8730408907.jpg" alt="..." class="carousel-img">
                        <div class="carousel-caption">
                            Matthias Church
                        </div>
                    </div>
                    <div class="item">
                        <img src="../travel-images/large/9496787858.jpg" alt="..." class="carousel-img">
                        <div class="carousel-caption">
                            Verona Ponte Scaligero
                        </div>
                    </div>
                    <div class="item">
                        <img src="../travel-images/large/9504448540.jpg" alt="..." class="carousel-img">
                        <div class="carousel-caption">
                            Garden of Boboli, Pitti Palace, Florence
                        </div>
                    </div>
                </div>
                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </header>

    <section>
        <table>
            <tr>
                <?php
                require_once("config.php");
                try {
                    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
                    $sql = "select ImageID from travelimagefavor";
                    $result = $pdo->query($sql);
                    //$GLOBALS储存每个ImageID出现的次数   初始81张图，需大于等于82个0，此处给了256个0的存储容量(即可255张图)，myArray[0]未存储图片，后面数组序号与图片序号一一对应
                    $GLOBALS = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
                    while ($row = $result->fetch()){
                        $GLOBALS[$row['ImageID']]++;
                    }
                    arsort($GLOBALS);//降序排序，保留键名
                    $myArray = array_keys($GLOBALS);//获取键名，储存于新的数组中
                    $a = $myArray[0];//abcdef储存出现得最多的六张图片的ID
                    $b = $myArray[1];
                    $c = $myArray[2];
                    $d = $myArray[3];
                    $e = $myArray[4];
                    $f = $myArray[5];

                    //打印六张
                    for ($j = 1; $j <= 6; $j++){
                        switch ($j){
                            case 1:
                                $vari = $a;
                                break;
                            case 2:
                                $vari = $b;
                                break;
                            case 3:
                                $vari = $c;
                                break;
                            case 4:
                                $vari = $d;
                                break;
                            case 5:
                                $vari = $e;
                                break;
                            case 6:
                                $vari = $f;
                                break;
                        }
                        $sql = "select * from travelimage where ImageID = '$vari'";
                        $result = $pdo->query($sql);
                        while($row = $result->fetch()) {
                            $strPath = $row['PATH'];
                            $strTitle = $row['Title'];
                            $strDescription = $row['Description'];
                        }

                        // *******将当前imageID记录在url里，在跳转后的界面用$_GET['id']获取传递的值
                        echo "<td><div><a href=\"details.php?id=".$vari;
                        echo "\"><img src=\"../travel-images/medium/".$strPath;// . 根据$a获取图片路径
                        echo "\" alt=\"\" class=\"display\"></a></div><h3>".$strTitle;// . 根据$a获取图片标题Title
                        echo "</h3><p>".$strDescription;// . 根据$a获取图片描述This is a brief photo description.
                        echo "</p></td>";
                        if ($j == 3)
                            echo "</tr><tr>";
                        if ($j == 6)
                            echo "</tr>";
                    }

                    $pdo = null;
                } catch (PDOException $e) {
                    die( $e -> getMessage() );
                }
                ?>

        </table>
    </section>

    <aside>
        <img src="../img/icons/refresh-fixed.png" alt= "" id="refresh-icon" onclick=window.location.href="indexRefresh.php">
        <a href="#return-here"><img src="../img/icons/return-up-fixed.png" alt="" id="return-top-icon"></a>
    </aside>

    <footer>
        <div id="div-footer-1">
            <span>使用条款</span>
            <span>隐私保护</span>
            <span>Cookies</span>
            <span>关于</span>
            <span>联系我们</span>
        </div>
        <div id="div-footer-2">
            Copyright @ 2020 Web Fundamentals. All Rights Reserved. 备案号：19302010013 吴逸昕
        </div>
    </footer>
</body>
<script src="js/clickheart.js"></script>
</html>