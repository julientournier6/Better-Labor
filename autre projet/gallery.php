<!DOCTYPE html>
<?php include ('nav.php');?>
  <head>
    <title>Gallery</title>
    <link href="gallery.css" rel="stylesheet">
    <script src="gallery.js"></script>
  </head>
  <body>
    <div class="gallery"><?php

    $dir = __DIR__ . DIRECTORY_SEPARATOR . "gallery" . DIRECTORY_SEPARATOR;
    $images = glob("$dir*.{jpg,jpeg,gif,png,bmp,webp}", GLOB_BRACE);

    foreach ($images as $i) {
      $img = basename($i);
      $caption = substr($img, 0, strrpos($img, "."));
      printf("<figure><img src='gallery/%s'/><figcaption>%s</figcaption></figure>", $img, $caption);
    }
    ?></div>
  </body>
</html>
