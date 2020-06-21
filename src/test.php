<html>
<head></head>
<body>
<div class="tri-block">
    <h4>Country/Region:</h4>
    <select name="countrySelect" id="countrySelect" onchange="func1(this)">
        <option value="0">Select Country</option>
    </select>
</div>
<div class="tri-block">
    <h4>City:</h4>
    <select name="citySelect" id="citySelect">
        <option value="0">Select City</option>
    </select>
    <!-- <input type="text" id="city" class="upload-input-short" required> -->
</div>
<?php
/*  直接打印国家列表
        require_once("config.php");
        try {
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            $sql = "select Country_RegionName from geocountries_regions";
            $result = $pdo->query($sql);
            while($row = $result->fetch()){
                $strCRN = $row['Country_RegionName'];
                echo "<option value=\"".$strCRN;
                echo "\">".$strCRN;
                echo "</option>";
            }

        } catch(PDOException $e) {
            die($e -> getMessage());
        }*/
?>
<?php
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
        $DataStr = $DataStr.$CRNArray[$k].":[".$CityStrArray[$k]."],";
    }
    $DataStr = $DataStr."}";

}catch(PDOException $e){
    die($e->getMessage());
}

echo "<script>data = ".$DataStr;
echo "</script>";
?>

</body>
<script>
    let pro  = document.getElementById("countrySelect");
    let city = document.getElementById("citySelect");

    for (let i in data){
        let option_pro = document.createElement("option");
        option_pro.innerHTML=i;
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
            city.appendChild(option_city);
        }
    }
</script>
</html>