<!--
  Part of the page asking for confirming the deletion
-->
<html lang="en">

<head>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <p style="color:red"><strong><?= $this->content; ?></strong></p>
  <form action=<?= $this->router->getDisciplineConfirmDeletionURL($id); ?> method="POST">
    <div style="text-align: center;">
      <button class="button" type="submit">
        <h3>DELETE</h3>
      </button>
    </div>
  </form>
  <br>
  <div>
    <p>You may want instead updating it? Link under</p>
    <li>
      <a href=<?= $this->getRouter()->getDisciplineUpdateURL($id); ?>>Update</a>
    </li>
  </div>
</body>

</html>