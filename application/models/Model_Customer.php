<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Customer extends Model_Genetic
{

    protected $tab = 'customers_register';
    protected $cells = ['id', 'nombres', 'apellidos','identificacion','tipo_identificacion',];
    protected $select = '';

    function __construct()
    {
        parent::__construct();
        $this->select = $this->create_select();
    }

    function all($mode = null)
    {
        $this->db->select($this->select);
        $this->db->from($this->tab);
        switch ($mode) {
            case 'table':
                $data = $this->db->get()->result();
                $query = array();
                foreach ($data as $row) {
                    $query[] = array(
                        'id' => $row->id,
                        'name' => $row->nombres . ' ' . $row->apellidos,
                        'document' => $row->identificacion,
                        'documentType' => $row->tipo_identificacion,
                        'actions' => '
                        <div class="hw-btn-group-section">
                            <button onclick="showCustomerHistories(' . $row->id . ');" class="hw-btn-action hw-btn-active"><i class="fas fa-book-medical"></i></button>
                        </div>'
                    );
                }
                break;
            case null:
                $query = $this->db->get()->result();
                break;
        }
        return ($query) ? $query : false;
    }

    function customer_data($customer_id)
    {
        $this->db->select('nombres,apellidos,tipo_identificacion,identificacion,estado_civil,fecha_nacimiento,pais,departamento,sexo,hijos,escolaridad,pais_residencia,ciudad_residencia');
        $this->db->from($this->tab);
        $this->db->where('id', $customer_id);
        $query = $this->db->get()->row();
        return ($query) ? $query : false;
    }

    function history_request($history_id)
    {
        $this->db->select('*');
        $this->db->from('clinic_histories_register');
        $this->db->where('id', $history_id);
        $query = $this->db->get()->row();
        return ($query) ? $query : false;
    }

    function search_history_by_customer($id)
    {
        $this->db->select('id,user_id');
        $this->db->from('clinic_histories_register');
        $this->db->where('user_id', $id);
        $query = $this->db->get()->result();
        return ($query) ? $query : false;
    }
}
