<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title><?php
        if (isset($page["title"])) {
            echo $page["title"];
        } else {
            echo "Document";
        }
        ?></title>
</head>
<body>
<nav>
    <?php if (isset($navLinks)) {
        foreach ($navLinks as $navLink) {
            echo "<a href='$navLink[link]'>$navLink[name]</a>";
            // for some reason this is required to make a margin between the links (without css because i am lazy)
            echo "\n";
        }
    } else {
        include "navbar.php";
    } ?>
</nav>
<hr>
<?php
if (isset ($page["body"])) {
    $page["body"]();
} else {
    echo '<h1>Error: the $page["body"] function is not defined</h1>';
}
?>
</body>
</html>