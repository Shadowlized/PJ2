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

<section>
<form id="form" action='' method='post' role='form'>
    <div class="div-title">
        <h2>Upload</h2>
    </div>
    <div id="preview">
        <p>Not Uploaded</p>
    </div><!--用来放预览图片的DIV-->
    <input type="file" name="upload-file" id="upload-file" onchange="previewImage(this,320,240)" accept="image/*" required>
    <h3>Title:</h3>
    <input type="text" name="title" id="title" class="upload-input" required>
    <div class="tri-block">
        <h4>Content:</h4>
        <select name="content" id="content" required>
            <option value="0">Select Content</option>
            <option value="scenery">Scenery</option>
            <option value="cities">Cities</option>
            <option value="people">People</option>
            <option value="animals">Animals</option>
            <option value="buildings">Buildings</option>
            <option value="wonder">Wonder</option>
            <option value="other">Other</option>
        </select>
    </div>
    <div class="tri-block">
        <h4>Country/Region:</h4>
        <select name="countrySelect" id="countrySelect" onchange="func1(this)" required>
            <option value="0">Select Country</option>
        </select>
    </div>
    <div class="tri-block">
        <h4>City:</h4>
        <select name="citySelect" id="citySelect" required>
            <option value="0">Select City</option>
        </select>
        <?php
        /* 二级联动（不过由于部分名字带引号存在问题，只能打印为字符串）
        require_once ("config.php");
        try{
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            $sql1 = "select ISO, Country_RegionName from geocountries_regions order by ISO";
            $result1 = $pdo->query($sql1);
            $CRNArray = [];
            $ISOArray = [];
            $i = 0;
            while($row1=$result1->fetch()){
                $CRNArray[$i] = $row1['Country_RegionName'];
                $ISOArray[$i] = $row1['ISO'];
                $i++;
            } //此时i对应数组长度！即数组末位编号+1
            $sql2 = "select AsciiName, Country_RegionCodeISO from geocities order by Country_RegionCodeISO, AsciiName";
            $result2 = $pdo->query($sql2);
            $CityStrArray = []; //存储若干个长字符串（城市名）
            $j = 0; $currentCityStr = "";
            while($row2=$result2->fetch()){
                if ($row2['Country_RegionCodeISO'] == $ISOArray[$j]){
                    $currentCityStr = $currentCityStr."'".$row2['AsciiName']."',"; //记下当前城市名并加单引号与逗号 如'Shanghai','Kunming','Beijing','Yantai',
                } else {
                    $CityStrArray[$j] = $currentCityStr; //储存
                    $currentCityStr = ""; //复原
                    $currentCityStr = $currentCityStr."'".$row2['AsciiName']."',";
                    $j++;
                }
                if ($j == ($i - 1))
                    $CityStrArray[$j] = $currentCityStr; //储存被else忽略的最后一项
            }
            $DataStr = "{"; //要的输出结果
            for($k = 0; $k < $i; $k++){
                $DataStr = "'".$DataStr.$CRNArray[$k]."':['.$CityStrArray[$k].'], ";
            }
            $DataStr = $DataStr."}";

        }catch(PDOException $e){
            die($e->getMessage());
        }
        //echo "<h1>".$DataStr; echo "</h1>"
        //echo "<script>data = ".$DataStr;
        //echo "</script>";
*/
        ?>
    </div>
    <h3>Description:</h3>
    <textarea name="description" id="description" required></textarea><br>
    <input type="submit" class="submit-button" value="Upload" onclick="checkForm()">
</form>
</section>

<footer>
    Copyright @ 2020 Web Fundamentals. All Rights Reserved. 备案号：19302010013吴逸昕
</footer>
</body>
<script>
   /* data = {China: ['Shanghai','Kunming','Beijing','Yantai'],
        Japan: ['Tokyo', 'Osaka', 'Kamakura'],
        Italy: ['Rome','Milan','Venice','Florence'],
        America: ['New York','San Francisco', 'Washington']}; */
    /* data = <?php //echo $DataStr; ?>;*/
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
        if (title === "" || country === "0" || city === "0" || description === "" || pic === "" || content === "0"){
            alert("请填写完毕所有信息，然后再点击上传！");
        } else {
            let form = document.getElementById("form");
            form.action="uploadAnalyze.php";
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