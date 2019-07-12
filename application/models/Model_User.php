<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_User extends Model_Genetic {
    
    protected $tab = 'users_register';
    protected $cells = ['id','username','email','name','lastname','created_at'];
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
                        'username' => $row->username,
                        'email' => $row->email,
                        'name' => $row->name,
                        'lastname' => $row->lastname,
                        'actions' => '<div class="hw-btn-group-section">
                            <button class="hw-btn-action hw-btn-edit" onClick="requestEditData(\'Administradores\',' . $row->id . ')"><i class="fas fa-edit"></i></button>
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

}