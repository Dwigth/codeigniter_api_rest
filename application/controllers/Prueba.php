<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Prueba extends REST_Controller
{

    public function __construct()
    {
        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");
        parent::__construct();
        $this->load->database();

    }

    public function index()
    {
        echo 'Hola mundo';
    }

    public function obtener_arreglo_get($id)
    {
        $arreglo = array("Manzana", "Pera", "Piña");

        if ($id < count($arreglo) && $id > -1) {

            $respuesta = array('error' => false, 'fruta' => $arreglo[$id]);
            $this->response($respuesta);

        } else {
            $respuesta = array('error' => true, 'mensaje' => 'No existe el elemento en la posición: ' . $id);
            //echo "Error: index fuera de lugar";
            $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);

        }

    }

    public function obtener_producto_get($codigo)
    {
        //  $this->load->database();

        $query = $this->db->query('SELECT * FROM productos WHERE codigo = "' . $codigo . '" ');

        $resultado = $query->result();

        echo json_encode($resultado);
    }
}
