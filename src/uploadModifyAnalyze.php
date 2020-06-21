<?php
require_once("config.php");
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $currentImageId = $_GET['id'];

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
    $strContent = $_POST['content'];
    if ($_POST['upload-file'] != ""){
        $strPath = $_POST['upload-file'];
        $sql = "update travelimage set Title='$strTitle',Description='$strDes',CityCode='$strCityCode',Country_RegionCodeISO='$strISO',Path='$strPath',Content='$strContent' where ImageID='$currentImageId'";
        $result = $pdo->query($sql);
    } else {
        $sql = "update travelimage set Title='$strTitle',Description='$strDes',CityCode='$strCityCode',Country_RegionCodeISO='$strISO',Content='$strContent' where ImageID='$currentImageId'";
        $result = $pdo->query($sql);
    }


    echo "<script>alert(\"修改成功\"); window.location.href=\"myphotos.php\"</script>";
} catch(PDOException $e) {
    die( $e -> getMessage() );
}

?>
