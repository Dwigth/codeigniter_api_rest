<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Pedidos extends REST_Controller
{

    public function __construct()
    {
        header("Access-Control-Allow-Methods:  GET");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");
        parent::__construct();
        $this->load->database();

    }

    public function realizar_orden_post($token = "0" ,$id_usuario = "0")
    {
        $data = $this->post();

        if($token == "0" || $id_usuario == "0")
        {
            $respuesta = array(
                'error' => TRUE,
                'mensaje' => 'Token invalido y/o usuario invalido'
            );
            $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
        // evaluar si vienen items
        if(!isset($data['items']) || strlen($data['items']) == 0 )
        {
            $respuesta = array(
                'error' => TRUE,
                'mensaje' => 'Faltan items en el post'
            );
            $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        // todo va bien, hay que validar el token y el id del usuario
        $condiciones = array(
            'id' => $id_usuario,
            'token' => $token
        );
        $this->db->where($condiciones);
        $query = $this->db->get('login');

        $existe = $query->row();

        if(!$existe)
        {
            $respuesta = array(
                'error' => TRUE,
                'mensaje' => 'Token invalido y/o usuario incorrectos'
            );
            $this->response($respuesta, REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }

        // usuario y token correcto
        $this->db->reset_query();
        $insertar = array(
            'usuario_id' => $id_usuario,
        );
        

    }
}