<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="scripts.js"></script>
</head>
<body>
    <!-- chama o php -->
    <?php require "openssl.php"; ?>
    <form>
        <label for="select_cipher">Algorítimo</label>
        <select id="select_cipher" name="select_cipher" >
            <?php getCiphers(); ?>
        </select>
        
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
