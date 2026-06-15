<?php
use const App\DIRECTORY;
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="A site about frogs, articles, and frog info." />
    <link rel="shortcut icon" href="<?= DIRECTORY ?>/app/static/assets/toxic_frog_favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="<?= DIRECTORY ?>/app/static/stylesheet.css" />
    <title>FrogInfo - <?= $title ?? 'NONE' ?></title>
  </head>
  <body>
    <div class="blur_body">
      <div class="content_body">
        <header class="navbar">
          <div class="header_combo">
            <div class="navbar_sprite_clip">
              <div class="navbar_sprite"></div>
            </div>
            <h1>FrogInfo</h1>
          </div>
          <nav>
            <div>
              <a href="<?= DIRECTORY ?>/" class="link_button">Home</a>
              <a href="<?= DIRECTORY ?>/content/articles" class="link_button">Articles</a>
            </div>
            <div>
              <a href="<?= DIRECTORY ?>/content/gallery" class="link_button">Gallery</a>
              <a href="<?= DIRECTORY ?>/about" class="link_button">About</a>
              <a href="<?= DIRECTORY ?>/contact" class="link_button">Contact</a>
            </div>
          </nav>
        </header>
        <?= "<main class='".($content ?? "")."'>" ?>
