<?php
// um token composto de tres partes
// 1- header - qual o tipo do token e algoritmo de criptografia para a assinatura
// 2- payload do token - quem é o emissor do token, expiração, email, name
//    (corpo do token)
// 3- assinatura do token - valida o token

//definir as informações
$cabecalho = [
    'alg' => 'HS256', //algoritmo de criptografia HMAC com sha-256
    'typ' => 'JWT'
];

$corpoDaInformacao = [
    'name' => 'Marcela Viana',
    'email' => 'marcelavp@terra.com.br',
    'role' => 'admin',

];

$cabecalho = json_encode($cabecalho); //torna o cabecalho um arquivo json
$corpoDaInformacao = json_encode($corpoDaInformacao); //torna o corpo um arquivo json

echo "Cabeçalho JSON: $cabecalho";
echo "\n";
echo "Corpo JSON: $corpoDaInformacao";
echo "\n";

//transformar em string de criptografia
$cabecalho = base64_encode($cabecalho);
$corpoDaInformacao = base64_encode($corpoDaInformacao);

echo "Cabeçalho BASE64: $cabecalho";
echo "\n";
echo "Corpo BASE64: $corpoDaInformacao";
echo "\n";
echo "$cabecalho.$corpoDaInformacao";
echo "\n";echo "\n";
$chave = "sdufhskdjhakjdqwdhj23235";
$assinatura = hash_hmac('sha256',"$cabecalho.$corpoDaInformacao", $chave, true);

echo "Assinatura RAW: $assinatura";
echo "\n";echo "\n";

$assinatura = base64_encode($assinatura);
echo "Assinatura BASE64: $assinatura";
echo "\n";echo "\n";

echo "Token JWT: $cabecalho.$corpoDaInformacao.$assinatura";
echo "\n";echo "\n";