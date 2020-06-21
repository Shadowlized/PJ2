<?php
@$currentPage = empty($_GET["currentPage"])?1:$_GET["currentPage"]; //记录当前页数，@防止报错
echo "<div id=\"div-favorites-bottom\"><h5>";
echo "<a href='?currentPage=".($currentPage==1?1:($currentPage-1))."' style='text-decoration:none'>&lt;&lt;</a><span>&nbsp;&nbsp;</span>";
echo "<a id='page1' href='?currentPage=1' style='text-decoration:none'> 1 </a><span>&nbsp;&nbsp;</span>";
if ($totalPage >= 2)
    echo "<a id='page2' href='?currentPage=2' style='text-decoration:none'> 2 </a><span>&nbsp;&nbsp;</span>";
if ($totalPage >= 3)
    echo "<a id='page3' href='?currentPage=3' style='text-decoration:none'> 3 </a><span>&nbsp;&nbsp;</span>";
if ($totalPage >= 4)
    echo "<a id='page4' href='?currentPage=4' style='text-decoration:none'> 4 </a><span>&nbsp;&nbsp;</span>";
if ($totalPage >= 5)
    echo "<a id='page5' href='?currentPage=5' style='text-decoration:none'> 5 </a><span>&nbsp;&nbsp;</span>";
echo "<a href='?currentPage=".(($currentPage==$totalPage)?$totalPage:($currentPage+1))."' style='text-decoration:none'>&gt;&gt;</a>";
echo "</h5></div>";
?>
<script>
    <?php
    @$currentPage = empty($_GET["currentPage"])?1:$_GET["currentPage"]; //记录当前页数，@防止报错
    ?>
    let pageToHighlight =  document.getElementById('<?php echo "page".$currentPage ?>');
    pageToHighlight.style = "color: #f00; font-size: 16px;";
</script>