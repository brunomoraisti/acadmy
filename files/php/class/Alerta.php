<?php
/**
 * User: Bruno Morais
 * Email: brunosm08@gmail.com
 * Date: 13/06/2017
 * Time: 15:17
 *
 * DANGER - ERRO
 * WARNING - ATENÇÃO
 * SUCCESS - EXECUTADO COM SUCESSO
 * INFO - INFORMAR
 *
 */
class Alerta
{
    var $nomeSessao = "alerta";

    public function __construct()
    {
    }

    /*FUNÇÃO ALERT -DANGER -SUCCESS -INFO -WARGING*/
    public function danger($menssage,$redirect){

        //$alert = "<script>toastr.error('$menssage', 'Ops!');</script>";
        $alert = "<script>iziToast.error({title: 'Ops!', message: '$menssage', position: 'bottomRight'});</script>";

        $this->setaSessao($alert);
        header('location:'.$redirect);
    }

    public function warning($menssage,$redirect){

        //$alert = "<script>toastr.warning('$menssage', 'Atenção!');</script>";
        $alert = "<script>iziToast.warning({title: 'Atenção!', message: '$menssage', position: 'bottomRight'});</script>";

        $this->setaSessao($alert);
        header('location:'.$redirect);
    }

    public function success($menssage,$redirect){

        //$alert = "<script>toastr.success('$menssage', 'Legal!');</script>";
        $alert = "<script>iziToast.success({title: 'Legal!', message: '$menssage', position: 'bottomRight'});</script>";

        $this->setaSessao($alert);
        header('location:'.$redirect);
    }

    public function info($menssage,$redirect){

        //$alert = "<script>toastr.info('$menssage', 'Informação!');</script>";
        $alert = "<script>iziToast.info({title: 'Legal!', message: '$menssage', position: 'bottomRight'});</script>";

        $this->setaSessao($alert);
        header('location:'.$redirect);

    }

    public function apagaMensagem()
    {
        session_name($this->nomeSessao);
        session_start();
        if (isset($_SESSION['msg'])) {
            unset($_SESSION['msg']);
            unset($_SESSION['alertamsg']);
        }
        session_write_close();
    }

    public function setaSessao($alert)
    {
        session_name($this->nomeSessao);
        session_start();
        $_SESSION['alertamsg']= $alert;
        $_SESSION['msg']=1;
        session_write_close();

    }


    public function verificaMsg()
    {
        session_name($this->nomeSessao);
        session_start();
        if ($_SESSION['msg']==1) {
            $msg = $_SESSION['alertamsg'];
        }
        session_write_close();

        $this->apagaMensagem();

        return $msg;
    }
}
