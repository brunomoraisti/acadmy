<?php
$raiz = str_repeat("../", $level = 0);

include($raiz."files/php/includes.php");
$aRedireciona = $sessao->pegarCampo("REDIRECIONA");

/*$_POST['email'] = str_replace('/[^[:alpha:]_]/', '', $_POST['email']);*/
$email = $_POST['email'];
$senha = $_POST['senha'];

$arquivo = $raiz."files/json/usuarios.json";

$info = file_get_contents($arquivo);
$obj = json_decode($info);
    if (count($obj)>0) {
        $discentes = $obj->usuarios;
        foreach ($discentes as $cadaAluno) {
            if ($cadaAluno->email == $email) {
                if ($cadaAluno->tipo=="Aluno"){
                    $retorno['redireciona'] = "./";

                    $sessao->gravarCampo("NOME", $cadaAluno->nome);
                    $sessao->gravarCampo("EMAIL", $cadaAluno->email);
                    $sessao->gravarCampo("CPF", $cadaAluno->cpf);
                    $sessao->gravarCampo("NOMEESCOLA", $cadaAluno->nomeescola);
                    $sessao->gravarCampo("TIPO", $cadaAluno->tipo);
                    $sessao->gravarCampo("CIDADE", $cadaAluno->cidade);
                    $sessao->gravarCampo("OPCAOCURSO", $cadaAluno->opcaocurso);
                    $sessao->gravarCampo("FOTO", $cadaAluno->foto);

                } else{
                    $retorno['redireciona'] = "./instituicao.php";

                    $sessao->gravarCampo("NOME", $cadaAluno->nome);
                    $sessao->gravarCampo("SIGLA", $cadaAluno->sigla);
                    $sessao->gravarCampo("EMAIL", $cadaAluno->email);
                    $sessao->gravarCampo("CNPJ", $cadaAluno->cnpj);
                    $sessao->gravarCampo("TIPO", $cadaAluno->tipo);
                    $sessao->gravarCampo("CIDADE", $cadaAluno->cidade);

                }

                $retorno['error'] = "0";
                $retorno['msg'] = "";

                echo json_encode($retorno);

            }
        }
    } else {
        $retorno['error'] = "1";
        $retorno['msg'] = "Usuário não cadastrado!";
        echo json_encode($retorno);
    }



?>
