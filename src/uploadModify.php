<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload</title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/navigation.css" rel="stylesheet" type="text/css">
    <link href="css/upload.css" rel="stylesheet" type="text/css">
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
<form id="form" action='' method='post' role='form'>
    <div class="div-title">
        <h2>Upload</h2>
    </div>
    <?php
        $currentImageID = $_GET['id'];
        require_once("config.php");
        try {
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);

            $sql = "select * from travelimage where ImageID='$currentImageID'";
            $result = $pdo->query($sql);
            //path,title,description & code used for querying for city and country/region
            while($row = $result->fetch()) {
                $strPath = $row['PATH'];
                $strTitle = $row['Title'];
                $strDescription = $row['Description'];
                $strContent = $row['Content'];
                $strCityCode = $row['CityCode'];
                $strCountry_RegionCodeISO = $row['Country_RegionCodeISO'];
            }
            //country/region
            if($strCountry_RegionCodeISO){
                $sqlCR = "select Country_RegionName from geocountries_regions where ISO = '$strCountry_RegionCodeISO'";
                $resultCR = $pdo->query($sqlCR);
                while($row = $resultCR->fetch()){
                    $strCRName = $row['Country_RegionName'];
                }
            } else {
                $strCRName = "Unknown";
            }
            //city
            if($strCityCode){
                $sqlCities = "select AsciiName from geocities where GeoNameID = '$strCityCode'";
                $resultCities = $pdo->query($sqlCities);
                while($row = $resultCities->fetch()){
                    $strCityName = $row['AsciiName'];
                }
            } else {
                $strCityName = "Unknown";
            }
        }catch(PDOException $e){
            die($e -> getMessage());
        }
    echo "<div id=\"preview\">
        <img src='../travel-images/large/".$strPath;
    echo "' width:'320px' height='240px'>
        </div>"; //用来放预览图片的DIV-->
    echo "<input type=\"file\" name=\"upload-file\" id=\"upload-file\" onchange=\"previewImage(this,320,240)\" accept=\"image/*\"";
    echo ">
    <h3>Title:</h3>
    <input type=\"text\" class=\"upload-input\" name='title' id=\"title\" required value='".$strTitle;
    echo "'>
    <div class=\"tri-block\">
        <h4>Content:</h4>
        <select name='content' id=\"content\" required value='".$strContent;
    echo "'>
            <option value=\"0\">Filter by Content</option>
            <option value=\"scenery\" selected>Scenery</option>
            <option value=\"cities\">Cities</option>
            <option value=\"people\">People</option>
            <option value=\"animals\">Animals</option>
            <option value=\"buildings\">Buildings</option>
            <option value=\"wonder\">Wonder</option>
            <option value=\"other\">Other</option>
        </select>
    </div>
    <div class=\"tri-block\">
        <h4>Country/Region:</h4>
        <select name=\"countrySelect\" id=\"countrySelect\" onchange=\"func1(this)\" required value='".$strCRName;
    echo "'><option value=\"0\">Select Country</option>
        </select>
    </div>
    <div class=\"tri-block\">
        <h4>City:</h4>
         <select name=\"citySelect\" id=\"citySelect\" required value='".$strCityName;
    echo "'><option value=\"0\">Select City</option>
        </select>
    </div>
    <h3>Description:</h3>
    <textarea name='description' id=\"description\" required>".$strDescription;
    echo "</textarea><br>";
    ?>
    <input type="submit" class="submit-button" value="Modify" onclick="checkForm()" style="background-image: linear-gradient(#0099e9, #000cb2);">
</form>
</section>

<footer>
    Copyright @ 2020 Web Fundamentals. All Rights Reserved. 备案号：19302010013吴逸昕
</footer>
</body>
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
<script>
    function checkForm() {
        let pic = document.getElementById("upload-file").value;
        let title = document.getElementById("title").value;
        let content = document.getElementById("content").value;
        let country = document.getElementById("countrySelect").value;
        let city = document.getElementById("citySelect").value;
        let description = document.getElementById("description").value;
        // 反馈
        if (title === "" || country === "0" || city === "0" || description === "" || content === "0"){
            alert("请填写完毕所有信息，然后再点击上传！");
        } else {
            let form = document.getElementById("form");
            <?php echo "form.action=\"uploadModifyAnalyze.php?id=".$currentImageID;
            echo "\";";
            ?>
        }
    }
</script>
<script type="text/javascript">
    //图片上传预览，非IE则用了HTML5的代码，IE是用了滤镜
    function previewImage(file, MAXWIDTH, MAXHEIGHT){//MAXWIDTH、MAXHEIGHT与放预览图片的DIV——preview的大小相呼应
        let div = document.getElementById('preview');
        if (file.files && file.files[0]) {//HTML5部分
            div.innerHTML = "<img id='imghead'></img>";
            let img = document.getElementById('imghead');
            img.onload = function(){
                let rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                img.width = rect.width;
                img.height = rect.height;
                img.style.marginTop = rect.top + 'px';
            }
            let reader = new FileReader();
            reader.onload = function(evt){
                img.src = evt.target.result;
            }
            reader.readAsDataURL(file.files[0]);
        }
        else //兼容IE
        {
            let sFilter = 'filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
            file.select();
            let src = document.selection.createRange().text;
            div.innerHTML = "<img id='imghead'></img>";
            let img = document.getElementById('imghead');
            img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
            let rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            div.innerHTML = "<div style='width:" + rect.width + "px;height:" + rect.height + "px;margin-top:" + rect.top + "px;" + sFilter + src + "\"'></div>";
        }
    }
    //用于计算预览图片的大小
    function clacImgZoomParam(maxWidth, maxHeight, width, height){
        let param = {
            top: 0,
            left: 0,
            width: width,
            height: height
        };
        if (width > maxWidth || height > maxHeight) {
            rateWidth = width / maxWidth;
            rateHeight = height / maxHeight;
            if (rateWidth > rateHeight) {
                param.width = maxWidth;
                param.height = Math.round(height / rateWidth);
            }
            else {
                param.width = Math.round(width / rateHeight);
                param.height = maxHeight;
            }
        }
        param.left = Math.round((maxWidth - param.width) / 2);
        param.top = Math.round((maxHeight - param.height) / 2);
        return param;
    }
</script>
<script src="js/clickheart.js"></script>
</html>