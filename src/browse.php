<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse</title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/navigation.css" rel="stylesheet" type="text/css">
    <link href="css/browse.css" rel="stylesheet" type="text/css">
</head>
<body>
<nav>
    <div class="div-left">
        <img src="../img/avatar.jpg" alt="" id="avatar-nav" width="28px" height="28px">
        <a href="index.php" class="link" id="home-nav">Home</a>
        <a href="browse.php" class="link" id="browse-nav">Browse</a>
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

<aside>
    <div class="div-small">
        <h3>Search by Title</h3>
        <form id="form" action='' method='post' role='form'>
        <input type="text" name="search-input" id="search-input" placeholder="Search keywords here"></form>
        <div id="search-text" onclick="searchTitle()">
            <img src="../img/icons/search.png" alt="" width="20px" height="20px" id="search-img">
        </div>
    </div>
    <div class="div-small">
        <h3>Hot Content</h3>
        <p onclick="searchScenery()">Scenery</p>
        <p onclick="searchCities()">Cities</p>
        <p onclick="searchPeople()">People</p>
        <p onclick="searchAnimals()">Animals</p>
        <p onclick="searchBuildings()">Buildings</p>
        <p onclick="searchWonder()">Wonder</p>
    </div>
    <div class="div-small">
        <h3>Hot Countries</h3>
        <?php
        require_once("config.php");
        error_reporting(E_ALL & ~E_NOTICE); //关闭错误提示（国家可正常打印但就是有迷之提示）
        $method = $_GET['method'];  //记录点击的按钮
        $content = $_GET['content']; //记录参数
        try {
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            $sql = "select Country_RegionCodeISO from travelimage";
            $result = $pdo->prepare($sql);
            $result->execute();
            $myArray1 = [];
            while ($row = $result->fetch()){
                $myArray1[$row['Country_RegionCodeISO']]++;
            }
            arsort($myArray1);//降序排序，保留键名
            $myArray2 = array_keys($myArray1);//获取键名，储存于新的数组中
            $a = $myArray2[0];//abcde储存出现得最多的五个国家的iso
            $b = $myArray2[1];
            $c = $myArray2[2];
            $d = $myArray2[3];
            $e = $myArray2[4];
            $f = $myArray2[5];

            $sql = "select Country_RegionName from geocountries_regions where ISO = '$a'";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()){
                $aName = $row['Country_RegionName'];
            }
            $sql = "select Country_RegionName from geocountries_regions where ISO = '$b'";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()){
                $bName = $row['Country_RegionName'];
            }
            $sql = "select Country_RegionName from geocountries_regions where ISO = '$c'";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()){
                $cName = $row['Country_RegionName'];
            }
            $sql = "select Country_RegionName from geocountries_regions where ISO = '$e'";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()){
                $eName = $row['Country_RegionName'];
            }
            $sql = "select Country_RegionName from geocountries_regions where ISO = '$f'";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()){
                $fName = $row['Country_RegionName'];
            }
            echo "<p onclick=window.location.href=\"browse.php?method=country&content=".$aName;
            echo "\">".$aName."</p>";
            echo "<p onclick=window.location.href=\"browse.php?method=country&content=".$bName;
            echo "\">".$bName."</p>";
            echo "<p onclick=window.location.href=\"browse.php?method=country&content=".$cName;
            echo "\">".$cName."</p>";
            echo "<p onclick=window.location.href=\"browse.php?method=country&content=".$eName;
            echo "\">".$eName."</p>";
            echo "<p onclick=window.location.href=\"browse.php?method=country&content=".$fName;
            echo "\">".$fName."</p>";
        } catch (PDOException $exception) {
            die( $exception -> getMessage() );
        }
        ?>

    </div>
    <div class="div-small">
        <h3>Hot Cities</h3>
        <?php
        require_once("config.php");
        error_reporting(E_ALL & ~E_NOTICE); //关闭错误提示（国家可正常打印但就是有迷之提示）
        $method = $_GET['method'];  //记录点击的按钮
        $content = $_GET['content']; //记录参数
        try {
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            $sql = "select CityCode from travelimage";
            $result = $pdo->prepare($sql);
            $result->execute();
            $myArray1 = [];
            while ($row = $result->fetch()){
                $myArray1[$row['CityCode']]++;
            }
            arsort($myArray1);//降序排序，保留键名
            $myArray2 = array_keys($myArray1);//获取键名，储存于新的数组中
            $a = $myArray2[0];//abcde储存出现得最多的五个国家的iso
            $b = $myArray2[1];
            $c = $myArray2[2];
            $d = $myArray2[3];
            $e = $myArray2[4];
            $f = $myArray2[5];
            $g = $myArray2[6];
            $h = $myArray2[7];
            $i = $myArray2[8];
            $j = $myArray2[9];

            $sql = "select AsciiName from geocities where GeoNameID = '$a'";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()){
                $aName = $row['AsciiName'];
            }
            $sql = "select AsciiName from geocities where GeoNameID = '$c'";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()){
                $cName = $row['AsciiName'];
            }
            $sql = "select AsciiName from geocities where GeoNameID = '$e'";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()){
                $eName = $row['AsciiName'];
            }
            $sql = "select AsciiName from geocities where GeoNameID = '$h'";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()){
                $hName = $row['AsciiName'];
            }
            $sql = "select AsciiName from geocities where GeoNameID = '$j'";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()){
                $jName = $row['AsciiName'];
            }

            echo "<p onclick=window.location.href=\"browse.php?method=city&content=".$aName;
            echo "\">".$aName."</p>";
            echo "<p onclick=window.location.href=\"browse.php?method=city&content=".$cName;
            echo "\">".$cName."</p>";
            echo "<p onclick=window.location.href=\"browse.php?method=city&content=".$eName;
            echo "\">".$eName."</p>";
            echo "<p onclick=window.location.href=\"browse.php?method=city&content=".$hName;
            echo "\">".$hName."</p>";
            echo "<p onclick=window.location.href=\"browse.php?method=city&content=".$jName;
            echo "\">".$jName."</p>";
        } catch (PDOException $exception) {
            die( $exception -> getMessage() );
        }
        ?>
    </div>
</aside>

<section>
    <div>
        <h3>Filter</h3>
        <div id="div-filter">
            <select name="content" id="content">
                <option value="0">Filter by Content</option>
                <option value="scenery" selected>Scenery</option>
                <option value="cities">Cities</option>
                <option value="people">People</option>
                <option value="animals">Animals</option>
                <option value="buildings">Buildings</option>
                <option value="wonder">Wonder</option>
                <option value="other">Other</option>
            </select>
            <!-- 此处使用到js -->
            <select name="countrySelect" id="countrySelect" onchange="func1(this)">
                <option value="0">Filter by Country</option>
            </select>
            <select name="citySelect" id="citySelect">
                <option value="0">Filter by City</option>
            </select>
            <button class="filter-button" onclick="countryCitySelect()">Filter</button>
        </div>
        <div>
            <table id="table">
                <?php
                require_once("config.php");

                @$method = $_GET['method'];  //记录点击的按钮
                @$content = $_GET['content']; //记录参数
                @$currentPage = empty($_GET["currentPage"])?1:$_GET["currentPage"]; //记录当前页数，@防止报错

                function printImage($sqlVari){
                    try {
                        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
                        $result = $pdo->prepare($sqlVari);
                        $result->execute();
                        //计算总页数
                        $method = $_GET['method'];  //记录点击的按钮
                        $content = $_GET['content']; //记录参数
                        $k = 0; $pageSize = 16; @$currentPage = empty($_GET["currentPage"])?1:$_GET["currentPage"];
                        while($row = $result->fetch()){
                            $k++;
                        } //k表示共几张图片
                        if ($k % $pageSize == 0){
                            $totalPage = $k / $pageSize;
                        } else {
                            $totalPage = $k / $pageSize + 1;
                        }
                        if ($totalPage > 5)
                            $totalPage = 5; //保留前五页
                        // limit为约束显示多少条信息，后面有两个参数，第一个为从第几个开始，第二个为长度
                        $sqlVari .= " limit " . (($currentPage - 1) * $pageSize) . "," . $pageSize;
                        $result = $pdo->prepare($sqlVari);
                        $result->execute();
                        $k = 1; //k表示当前是第几张图片
                        while($row = $result->fetch()) {
                            $currentID = $row['ImageID'];
                            $currentPath = $row['PATH'];
                            if ($k % 4 == 1){
                                $currentTR = $k / 4 + 1;
                                echo "<tr id='table-row".$currentTR;
                                echo "'>";
                            }
                            echo "<td><a href='details.php?id=".$currentID;
                            echo "'><img src='../travel-images/medium/".$currentPath;
                            echo "' alt='' class='table-img'></a></td>";
                            if ($k % 4 == 0){
                                echo "</tr>";
                            }
                            $k++;
                        }
                        if ($k % 4 != 1){
                            echo "</tr>"; //最后一个/tr
                        }
                        echo "</table>";
                        if ($k != 1){
                            require_once("pagesForBrowse.php"); // 显示页码翻转
                        }
                        if ($k == 1){
                            echo "<h1>No results found. Please search for other images of interest. </h1>";
                        }
                    } catch (PDOException $e) {
                        die( $e -> getMessage() );
                    }
                }
                //具体判断
                if ($method == ""){
                    echo "<h1>Image Loading Area </h1>";
                } else if ($method == "searchTitle"){
                    $strSearch = $content;
                    $sql = "select * from travelimage where Title like '%$strSearch%'";
                    printImage($sql);
                } else if ($method == "searchScenery"){
                    $sql = "select * from travelimage where Content = 'scenery'";
                    printImage($sql);
                } else if ($method == "searchCities"){
                    $sql = "select * from travelimage where Content = 'cities'";
                    printImage($sql);
                } else if ($method == "searchPeople"){
                    $sql = "select * from travelimage where Content = 'people'";
                    printImage($sql);
                } else if ($method == "searchAnimals"){
                    $sql = "select * from travelimage where Content = 'animals'";
                    printImage($sql);
                } else if ($method == "searchBuildings"){
                    $sql = "select * from travelimage where Content = 'buildings'";
                    printImage($sql);
                } else if ($method == "searchWonder"){
                    $sql = "select * from travelimage where Content = 'wonder'";
                    printImage($sql);
                } else if ($method == "country"){
                    $sql = "select * from geocountries_regions where Country_RegionName = '$content'";
                    $result = $pdo->query($sql);
                    while ($row = $result->fetch()){
                        $iso = $row['ISO'];
                    }
                    $sql = "select * from travelimage where Country_RegionCodeISO = '$iso'";
                    printImage($sql);
                } else if ($method == "city"){
                    $sql = "select * from geocities where AsciiName = '$content'";
                    $result = $pdo->query($sql);
                    while ($row = $result->fetch()){
                        $cityCode = $row['GeoNameID'];
                    }
                    $sql = "select * from travelimage where CityCode = '$cityCode'";
                    printImage($sql);
                } else {
                    //二级联动
                    $sql = "select * from geocities where AsciiName = '$content'";
                    $result = $pdo->query($sql);
                    while ($row = $result->fetch()){
                        $cityCode = $row['GeoNameID'];
                    }
                    $sql = "select * from travelimage where CityCode = '$cityCode' and Content = '$method'";
                    printImage($sql);
                }



                ?>
            </table>
        </div>
    </div>
</section>

<footer>
    Copyright @ 2020 Web Fundamentals. All Rights Reserved. 备案号：19302010013吴逸昕
</footer>
</body>
<script>
    let url = "browse.php?method=&content=";
    function searchTitle(){
        let searchInput = document.getElementById("search-input").value;
        url = "browse.php?method=searchTitle&content=" + searchInput;
        window.location.href= url;
    }
    function searchScenery(){
        window.location.href="browse.php?method=searchScenery&content=";
    }
    function searchCities(){
        window.location.href="browse.php?method=searchCities&content=";
    }
    function searchPeople(){
        window.location.href="browse.php?method=searchPeople&content=";
    }
    function searchAnimals(){
        window.location.href="browse.php?method=searchAnimals&content=";
    }
    function searchBuildings(){
        window.location.href="browse.php?method=searchBuildings&content=";
    }
    function searchWonder(){
        window.location.href="browse.php?method=searchWonder&content=";
    }
    function countryCitySelect(){
        let methodVari = document.getElementById("content").value;
        let contentVari = document.getElementById("citySelect").value;
        let hrefVari = "?method=" + methodVari + "&content=" + contentVari;
        window.location.href = hrefVari;
    }

</script>
<script>
    let pro  = document.getElementById("countrySelect");
    let city = document.getElementById("citySelect");

    for (let i in data){
        let option_pro = document.createElement("option");
        option_pro.innerHTML=i;
        option_pro.value=i;
        pro.appendChild(option_pro);
    }

    function func1(self){
        let choice = (self.options[self.selectedIndex]).innerHTML;
        let options = city.children;
        for (let k=0; k<options.length; k++){
            city.removeChild(options[k--]);
        }
        for (let i in data[choice]){
            let option_city = document.createElement("option");
            option_city.innerHTML = data[choice][i];
            option_city.value = data[choice][i];
            city.appendChild(option_city);
        }
    }
</script>
<script src="js/clickheart.js"></script>
</html>