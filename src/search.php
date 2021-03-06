<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/navigation.css" rel="stylesheet" type="text/css">
    <link href="css/search.css" rel="stylesheet" type="text/css">
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

<section class="search">
    <div class="div-title">
        <h2>Search</h2>
    </div>
    <div class="div-favorites-bottom" id="search-div">
        <form action='searched.php' method='post' role='form'>
        <div class="search-div-2">
            <input type="radio" value="filter-title" class="radio" id="filter" name="filter" checked required>&nbsp;Filter by Title<br>
            <textarea id="textarea1" name="textarea1" placeholder="Type here"></textarea><br>
        </div>
        <div class="search-div-2">
            <input type="radio" value="filter-description" class="radio" id="filter" name="filter" required>&nbsp;Filter by Description<br>
            <textarea id="textarea2" name="textarea2" placeholder="Type here"></textarea><br>
        </div>
        <div><input type="submit" value="Filter" class="filter-button" onclick=window.location.href="searched.php"></div>
        </form>
    </div>
</section>

<section class="results">
    <div class="div-title">
        <h2>Results</h2>
    </div>
    <div id="div-main">
        <h1>Image Loading Area</h1>
    </div>
</section>

<footer>
    Copyright @ 2020 Web Fundamentals. All Rights Reserved. 备案号：19302010013吴逸昕
</footer>
</body>
<script src="js/clickheart.js"></script>
</html>