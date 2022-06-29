<?php

namespace App\Services;

use Exception;

class VerifierService
{
    /**
     * @throws Exception
     */
    public function verificaCamposObrigatorios(array $dados, array $camposObrigatorios):void
    {
        if (count($dados) != count($camposObrigatorios)){
            throw new Exception('Numero de campos do json é diferente do esperado, informe '.count($camposObrigatorios).' campos');
        }

        for($i = 0; $i < count($camposObrigatorios); $i++){
            if (!array_key_exists($camposObrigatorios[$i],$dados)){
                throw new Exception("Campo $camposObrigatorios[$i] é obrigatório");
            }
        }
    }

    /**
     * @throws Exception
     */
    public function verificaCamposVaziosOuNulos(array $dados): void
    {
        foreach ($dados as $dado){
            if(is_null($dado) or empty($dado)){
                throw new Exception('Há um campo vazio ou nulo');
            }
        }
    }
}