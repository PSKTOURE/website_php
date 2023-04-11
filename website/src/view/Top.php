<!--
  Top of page
  Show the menu, the title and the feedback
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/styles.css">
  <title>Document</title>
</head>

<body>
  <h1 >Random Page talking about motorsport</h1>
  <br>
  <h3>Navigation</h3>
  <nav class="menu">
    <ul>
      <?php
      foreach ($this->menu as $label => $link) : ?>
        <li>
          <a href=<?= $link; ?>><?= $label; ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <br>
  <div>
    <h2><?= $this->getTitle(); ?></h2>
  </div>
  <br>
  <h3 class=<?= ($this->feedback === "") ? "" : "feedback"; ?>><?= ($this->feedback === "") ? "" : $this->feedback; ?></h3>
</body>

</html>