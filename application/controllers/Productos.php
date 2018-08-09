<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Productos extends REST_Controller
{

    public function __construct()
    {
        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");
        parent::__construct();
        $this->load->database();

    }

    public function todos_get($pagina = 0)
    {
        $pagina *= 10;
        $query = $this->db->query("SELECT * FROM `productos` limit " . $pagina . ",10 ");
        $respuesta = array(
            'error' => false,
            'productos' => $query->result_array(),
        );

        $this->response($respuesta);
    }

    public function por_tipo_get($tipo = 0, $pagina = 0)
    {



        if ($tipo > 0) {
            $pagina *= 10;
            $query = $this->db->query("SELECT * FROM `productos` WHERE `linea_id`  = ".$tipo." limit " . $pagina . ",10 ");
            $respuesta = array(
                'error' => false,
                'productos' => $query->result_array(),
            );

            $this->response($respuesta);
        } else {
            $respuesta = array('error' => 'El tipo no existe');
            $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function buscar_get($termino)
    {
        if(!empty($termino))
        {
            $query = $this->db->query("SELECT * FROM `productos` WHERE producto LIKE '%".$termino."%'  ");
            $respuesta = array(
                'error' => FALSE,
                'termino' => $termino,
                'producto' => $query->result()
            );
            $this->response($respuesta);
        }
        else
        {
            $respuesta = array('error' => 'No se encontró producto');
            $this->response($respuesta, REST_Controller::HTTP_BAD_RESQUEST);
        }
    }
}
