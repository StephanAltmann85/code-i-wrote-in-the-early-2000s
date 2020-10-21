<form action="test2.php" method="POST">
<input type="hidden" name="action" value="ok">
<input type="hidden" name="id" value="ok">
<input type="Submit" name="" value="Absenden">
</form><br><br>

<b>Ausgabe:</b>
<?php
echo "<br>Action: " . $action;
echo "<br>POST-Action: " . $_POST["action"];
echo "<br>REQUEST-Action: " . $_REQUEST["action"];

echo "<br><br>Id: " . $id;
echo "<br>POST-Id: " . $_POST["id"];
echo "<br>REQUEST-Id: " . $_REQUEST["id"];
?>
