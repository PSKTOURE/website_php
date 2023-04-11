<html>

<head>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>

  <div>
    <p><?= $this->getContent(); ?></p>
  </div>
  <div>
    <li>
      <a href=<?= $this->getRouter()->getDisciplineDeletionURL($id); ?>>
        DELETE</a>
    </li>
  </div>
  <br>
  <div>
    <li>
      <a href=<?= $this->getRouter()->getDisciplineUpdateURL($id); ?>>
        UPDATE</a>
    </li>
  </div>
</body>

</html>