<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>分页</title>
    <?php
    require_once ("config.php");
    //分页的函数
    function pics($pageNum = 1, $pageSize = 16){
        try {
            $array = array();
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            // limit为约束显示多少条信息，后面有两个参数，第一个为从第几个开始，第二个为长度
            $sql = "select * from travelimage limit " . (($pageNum - 1) * $pageSize) . "," . $pageSize;
            $result = $pdo->query($sql);
            $i = 0;
            while ($row = $result->fetch()) {
                $array[$i] = $row[''];
                $i++;
            }
            return $array;
        } catch (PDOException $exception) {
            die( $exception -> getMessage() );
        }

    }
    //显示总页数的函数
    function allPics(){
        $coon = mysqli_connect("localhost", "root");
        mysqli_select_db($coon, "jereh");
        mysqli_set_charset($coon, "utf8");
        $rs = "select count(*) num from n_content"; //可以显示出总页数
        $r = mysqli_query($coon, $rs);
        $obj = mysqli_fetch_object($r);
        mysqli_close($coon,"jereh");
        return $obj->num;
    }

    @$allNum = allPics();
    @$pageSize = 3; //约定没页显示几条信息
    @$pageNum = empty($_GET["pageNum"])?1:$_GET["pageNum"];
    @$endPage = ceil($allNum/$pageSize); //总页数
    @$array = pics($pageNum,$pageSize);
    ?>
</head>
<body>
<table border="1" style="text-align: center" cellpadding="0">
    <tr>
        <td>编号</td><td>新闻标题</td><td>来源</td><td>点击率</td><td>发布日期</td>
    </tr>
    <?php
    foreach($array as $key=>$values){
        echo "<tr>";
        echo "<td>{$values->id}</td>";
        echo "<td>{$values->title}</td>";
        echo "<td>{$values->src}</td>";
        echo "<td>{$values->indexs}</td>";
        echo "<td>{$values->times}</td>";
        echo "</tr>";
    }
    ?>
</table>
<div>
    <a href="?pageNum=<?php echo $pageNum==1?1:($pageNum-1)?>" rel="external nofollow" rel="external nofollow" >上一页</a>
    <a href="?pageNum=<?php echo $pageNum==$endPage?$endPage:($pageNum+1)?>" rel="external nofollow" rel="external nofollow" >下一页</a>
</div>
</body>
</html>
