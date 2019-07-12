<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Genetic extends CI_Model
{

    function create_select()
    {
        $select = '';
        foreach ($this->cells as $index => $cell) {
            $select .= ($index < count($this->cells) - 1) ? $cell . ',' : $cell;
        }
        return $select;
    }

    function create($new_data)
    {
        return ($this->db->insert($this->tab, $new_data)) ? true : false;
    }

    function create_custom($new_data, $table)
    {
        return ($this->db->insert($table, $new_data)) ? true : false;
    }

    function search_by_in($search, $in)
    {
        $this->db->select($search['select']);
        $this->db->from($in);
        $this->db->where($search['where'], $search['value']);
        return ($this->db->get()->row()) ? true : false;
    }

    function search_by($by, $search)
    {
        $this->db->select($by);
        $this->db->from($this->tab);
        $this->db->where($by, $search);
        return ($this->db->get()->row()) ? true : false;
    }

    function search_data_where($data, $where)
    {
        $this->db->select($data);
        $this->db->from($this->tab);
        $this->db->where($where);
        $query = $this->db->get()->row();
        return ($query) ? $query : false;
    }

    function validate($login_data, $by = 'id')
    {
        $this->db->select($by);
        $this->db->from($this->tab);
        $this->db->where($login_data);
        return ($this->db->get()->row()) ? true : false;
    }

    function delete($id)
    {
        $update_data = array(
            'status' => 0,
            'updated_at' => date('Y-m-d H-i-s')
        );
        $this->db->where('id', $id);
        return ($this->db->update($this->tab, $update_data)) ? true : false;
    }

    function active($id)
    {
        $update_data = array(
            'status' => 1,
            'updated_at' => date('Y-m-d H-i-s')
        );
        $this->db->where('user_di', $id);
        return ($this->db->update($this->tab, $update_data)) ? true : false;
    }

    function one($id)
    {
        $this->db->select($this->select);
        $this->db->from($this->tab);
        $this->db->where('id', $id);
        $query = $this->db->get()->row();
        return ($query) ? $query : false;
    }

    function edit($edit_data)
    {
        $this->db->where('id', $edit_data['id']);
        return ($this->db->update($this->tab, $edit_data)) ? true : false;
    }

}
