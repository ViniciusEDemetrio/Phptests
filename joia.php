<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Zona de Testes</title>
</head>
<body>
    <div class="container text-center">
        <h1>Zona de Testes</h1>
        <p>V- 0.02</p>    
        
        <hr>

        <!-- PHP para tratar criptografia e descriptografia -->
        <?php
        // Lista de algoritmos de criptografia suportados pelo OpenSSL
        $algoritmos = openssl_get_cipher_methods();

        // Função para gerar opções de algoritmos
        function gerarOpcoes($algoritmos) {
            $html = '';
            foreach ($algoritmos as $algoritmo) {
                $html .= "<option value='".htmlspecialchars($algoritmo)."'>".htmlspecialchars($algoritmo)."</option>\n";
            }
            return $html;
        }

        // Variável para armazenar o resultado
        $resultado = '';
        $ivResultado = '';

        // Se o formulário for enviado
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $acao = $_POST['acao']; // Criptografar ou Descriptografar
            $textoOriginal = $_POST['texto'];
            $algoritmoSelecionado = $_POST['algoritmo'];
            $chave = $_POST['chave'];
            $ivBase64 = $_POST['iv'] ?? ''; // IV pode ser enviado para descriptografar

            if (in_array($algoritmoSelecionado, $algoritmos)) {
                if ($acao == 'criptografar') {
                    // Gera um IV do tamanho adequado para o algoritmo selecionado
                    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($algoritmoSelecionado));

                    // Criptografa o texto
                    $textoCriptografado = openssl_encrypt($textoOriginal, $algoritmoSelecionado, $chave, 0, $iv);

                    // Verifica se o texto foi criptografado corretamente
                    if ($textoCriptografado !== false) {
                        $resultado = $textoCriptografado;
                        $ivResultado = base64_encode($iv); // Codifica o IV para exibição
                    } else {
                        $resultado = 'Erro na criptografia.';
                    }
                } elseif ($acao == 'descriptografar') {
                    // Decodifica o IV enviado em base64
                    $iv = base64_decode($ivBase64);

                    // Tenta descriptografar o texto
                    $textoDescriptografado = openssl_decrypt($textoOriginal, $algoritmoSelecionado, $chave, 0, $iv);

                    if ($textoDescriptografado !== false) {
                        $resultado = $textoDescriptografado;
                    } else {
                        $resultado = 'Erro ao descriptografar o texto. Verifique o IV e o texto criptografado.';
                    }
                }
            } else {
                $resultado = 'Algoritmo inválido selecionado.';
            }
        }
        ?>

        <!-- Formulário para criptografia e descriptografia -->
        <form method="POST" action="">
            <div class="form-row">
                <div class="col">
                    <textarea name="texto" id="txt_encript" class="form-control" rows="8" cols="80" placeholder="Insira aqui o texto" required></textarea>
                </div>
            </div>

            <br>
            <div class="form-row">
                <div class="col"> 
                   <select name="algoritmo" id="algoritmo" class="form-control">
                        <?php echo gerarOpcoes($algoritmos); ?>
                    </select>
                </div>
            </div>

            <br>
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" name="chave" id="txt_key_encript" placeholder="Insira aqui sua chave" required>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="iv" id="txt_iv" placeholder="Insira o IV (Base64, para descriptografar)">
                </div>
            </div>

            <br>
            <div class="form-row">
                <div class="col">
                    <button type="submit" name="acao" value="criptografar" class="btn btn-primary">Criptografar</button>
                </div>
                <div class="col">
                    <button type="submit" name="acao" value="descriptografar" class="btn btn-success">Descriptografar</button>
                </div>
            </div>
        </form>

        <hr>

        <h2>Resultado</h2>
        <div class="col">
            <textarea id="txt_result" class="form-control" rows="8" cols="80" placeholder="Resultado" disabled><?php echo $resultado; ?></textarea>
        </div>

        <!-- Exibir IV, se houver -->
        <?php if (!empty($ivResultado)): ?>
            <p><strong>IV (Base64):</strong> <?php echo $ivResultado; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>

