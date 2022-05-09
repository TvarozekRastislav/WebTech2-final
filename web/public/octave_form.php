<!DOCTYPE html>
<html lang="SK">
<head>
    <meta charset="UTF-8">
    <title>Formulár</title>
</head>
<body>

<form method="get" action="api.php">
    <input type="number" step="0.01" id="r" name="r">
    <label for="r">Zadaj výšku prekážky</label>
    <input type="hidden" id="acces_token" name="acces_token" value="kiRkR15MBEypq7Che">
    <button type="submit"> Submit</button>
</form>

<form method="get" action="api.php">
    <textarea type="textarea"  id="prikaz" name="prikaz"></textarea>
    <label for="prikaz">Zadaj príkaz</label>
    <input type="hidden" id="acces_token" name="acces_token" value="kiRkR15MBEypq7Che">
    <button type="submit"> Vykonaj</button>
</form>
</body>
</html>