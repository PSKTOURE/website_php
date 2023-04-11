<html>

<head>
  <link rel="stylesheet" href="css/styles.css">
</head>
<ul>
<?php
foreach ($data as $key => $val) {
  echo "<li>";
  echo $val->getName();
  echo "</li>";
}
?>
</ul>
<br>
<form action="F1.php" method="GET">
  <select name="action">
    <optgroup label="Sort Choice">
      <option value="alphabeticASC">alphabeticASC</option>
      <option value="alphabeticDSC">alphabeticDSC</option>
      <option value="durationASC">durationASC</option>
      <option value="durationDSC">durationDSC</option>
    </optgroup>
  </select>
  <button type="submit">Go</button>

</form>

</html>