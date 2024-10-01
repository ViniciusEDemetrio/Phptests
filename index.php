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
    
    <!-- Seleção de Algorítimo -->
    <form>
        <label for="select_cipher">Algorítimo</label>
        <select id="select_cipher" name="select_cipher" >
            <?php getCiphers(); ?>
        </select>

        <input type="text" name="txtinput" id="txtinput" placeholder="Texto a ser criptografado">
        <input type="text" name="key" id="txtoutput" placeholder="Chave personalizada (senha)">

        <button type="submit">Iniciar</button>

        <input type="text" name="txtoutput" id="txtoutput" placeholder="Saída" readonly>
    </form>

    
    <!-- texto de entrada -->




    <!-- texto de saída -->
    
    
</body>
</html>
