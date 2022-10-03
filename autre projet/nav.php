<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF8"/>
    <link rel = "stylesheet" href = "style.css"/>
    <title>Saith Seren</title>
</head>
    <body>

    <header class = "header">
        <img src="max_logo.png" alt = "Our logo" title = "The logo of Saith Seren" class = "logo" href = "Home.html">
            <a href = "index.php" class = "home">HOME</a>
            <a href = "Events.php" class = "events">EVENTS</a>
            <a href = "gallery.php" class = "discover">GALLERY</a>
            <a href = "roomrequest.php" class = "rooms">ROOM HIRE</a>
            <a href = "contact.html" class = "help">CONTACT</a>
            <a href = "profile.php" class = "subs">PROFILE</a>
    </header>
    <?php if ($_SERVER['REQUEST_URI'] != "/main/index.php" && $_SERVER['REQUEST_URI'] != "/main/" 
    && $_SERVER['REQUEST_URI'] != "/main/panel.php" ) 
    {?>

    <div class="main"></div>
    <?php } else {?>
    <div style="height:119px"></div>
    <?php }?>