<?php
require_once("config.php");
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);

    $sqlImageID = "select ImageID from travelimage order by ImageID";
    $resultImageID = $pdo->query($sqlImageID);
    $strImageID = 0;
    while($row = $resultImageID->fetch()){
        $strImageID = $row['ImageID'];
    }
    $strImageID++;

    $strTitle = $_POST['title'];
    $strDes = $_POST['description'];
    $strCityName = $_POST['citySelect'];
        $sqlCity = "select GeoNameID from geocities where AsciiName = '$strCityName'";
        $resultCity = $pdo->query($sqlCity);
        while($row = $resultCity->fetch()){
            $strCityCode = $row['GeoNameID'];
        }
    $strCountryName = $_POST['countrySelect'];
        $sqlCountry = "select ISO from geocountries_regions where Country_RegionName = '$strCountryName'";
        $resultCountry = $pdo->query($sqlCountry);
        while($row = $resultCountry->fetch()){
            $strISO = $row['ISO'];
        }
    $strUserName = $_COOKIE["usernameCookieName"];
        $sqlUID = "select UID from traveluser where UserName = '$strUserName'";
        $resultUID = $pdo->query($sqlUID);
        while($row = $resultUID->fetch()){
            $strUID = $row['UID'];
        }
    $strPath = $_POST['upload-file'];
    $strContent = $_POST['content'];

    //echo $strTitle.$strDes.$strCityCode.$strISO.$strUID.$strPath.$strContent;
    $sql = "insert into travelimage(ImageID,Title,Description,CityCode,Country_RegionCodeISO,UID,Path,Content) values ('$strImageID','$strTitle', '$strDes', '$strCityCode', '$strISO', '$strUID', '$strPath', '$strContent')";
    $result = $pdo->query($sql);

    echo "<script>alert(\"上传成功\"); window.location.href=\"myphotos.php\"</script>";

} catch(PDOException $e) {
    die( $e -> getMessage() );
}

?>