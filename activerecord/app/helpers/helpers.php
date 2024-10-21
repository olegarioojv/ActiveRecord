<?php

// Define uma função chamada 'FormatExcetion' que recebe um objeto do tipo Throwable como parâmetro.
// A classe Throwable é a interface de base para todas as exceções e erros em PHP.
function FormatExcetion(Throwable $throw)
{
    // Usa var_dump para exibir uma mensagem de erro detalhada. 
    // A mensagem inclui o nome do arquivo onde o erro ocorreu, a linha do erro, e a mensagem de erro em si.
    // As tags HTML <b> e <i> são usadas para deixar a mensagem mais legível com negrito e itálico.
    var_dump("Erro no arquivo <b>{$throw->getFile()}</b> na linha <b>{$throw->getLine()}</b> 
    com a mensagem <b><i>{$throw->getMessage()}</i></b>");
}
