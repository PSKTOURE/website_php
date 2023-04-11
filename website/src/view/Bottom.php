<!--
  Bottom of page
  Show the links to the disciplines
-->

<html lang="eng">

<head>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <br>
  <br>
  <nav>
    <h3>Links:</h3>
    <ul>
      <?php
      foreach ($this->getRouter()->getDisciplinesStorage()->readAll() as $id => $val) {
        echo "<li>";
        echo "<a href=" . $this->getRouter()->getDisciplineURL($id) . ">Link to " . $val->getName() . "</a>";
        echo "</li>\n";
      }
      ?>
    </ul>
  </nav>
  <br>
</body>

</html>