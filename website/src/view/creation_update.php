<!--
  Form for updating or creating an object
  -->
<html>

<head>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <p><?= $this->content; ?></p>
  <form action=<?= $url; ?> method="POST">
    <legend>Complete fields</legend>
    <br>
    <label> Name: <input type="text" name="name" value=<?= $builder->getValue($builder->getNameRef()); ?>>
      <?php if (key_exists($builder->getNameRef(), $error)) :
        $message = $this->htmlesc($error[$builder->getNameRef()]);
        if ($message !== "") : ?>
          <span class="error"><?= $message ?></span>
        <?php endif; ?>
      <?php endif; ?>
    </label><br>
    <br>
    <label> Category: <input type="text" name="category" value=<?= $builder->getValue($builder->getCatRef()); ?>>
      <?php if (key_exists($builder->getCatRef(), $error)) :
        $message = $this->htmlesc($error[$builder->getCatRef()]);
        if ($message !== "") : ?>
          <span class="error"><?= $message ?></span>
        <?php endif; ?>
      <?php endif; ?>
    </label><br>
    <br>
    <label> Teams: <input type="text" name="teams" value=<?= $builder->getValue($builder->getTeamsRef()); ?>>
      <?php if (key_exists($builder->getTeamsRef(), $error)) :
        $message = $this->htmlesc($error[$builder->getTeamsRef()]);
        if ($message !== "") : ?>
          <span class="error"><?= $message ?></span>
        <?php endif; ?>
      <?php endif; ?>
    </label><br>
    <br>
    <label> Duration: <input type="number" name="duration" value=<?= $builder->getValue($builder->getDRef()); ?>>
      <?php if (key_exists($builder->getDRef(), $error)) :
        $message = $this->htmlesc($error[$builder->getDRef()]);
        if ($message !== "") : ?>
          <span class="error"><?= $message ?></span>
        <?php endif; ?>
      <?php endif; ?>
    </label><br>
    <br>
    <label> Champion: <input type="text" name="champion" value=<?= $builder->getValue($builder->getChampRef()); ?>>
      <?php if (key_exists($builder->getChampRef(), $error)) :
        $message = $this->htmlesc($error[$builder->getChampRef()]);
        if ($message !== "") : ?>
          <span class="error"><?= $message ?></span>
        <?php endif; ?>
      <?php endif; ?>
    </label><br>
    <br>
    <label> Junior: <input type="text" name="junior" value=<?= $builder->getValue($builder->getJuniorRef()); ?>>
      <?php if (key_exists($builder->getJuniorRef(), $error)) :
        $message = $this->htmlesc($error[$builder->getJuniorRef()]);
        if ($message !== "") : ?>
          <span class="error"><?= $message ?></span>
        <?php endif; ?>
      <?php endif; ?>
    </label><br>
    <br>
    <div style="text-align: center;">
      <button class="button" type="submit">
        <h3><?= $id === null ? "ADD" : "UPDATE"; ?></h3>
      </button><br>
    </div>
  </form><br>

</body>

</html>