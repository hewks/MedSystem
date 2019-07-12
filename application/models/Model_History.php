<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_History extends Model_Genetic
{

    protected $tab = 'clinic_histories_register';
    protected $cells = ['id', 'codigo_diagnostico', 'localidad'];
    protected $select = '';

    function __construct()
    {
        parent::__construct();
        $this->select = $this->create_select();
    }

    function all()
    {
        $return_data = array();
        $this->db->select($this->select);
        $this->db->from($this->tab);
        $query = $this->db->get()->result();
        foreach ($query as $data) {
            $return_data[] = array(
                'id' => $data->id,
                'diagnosticCode' => $data->codigo_diagnostico,
                'locality' => $data->localidad
            );
        }
        return ($return_data) ? $return_data : false;
    }
}
