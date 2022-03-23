<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Dashboard';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Role';
        $data['role'] = $this->db->get('user_role')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function roleInsert()
    {

        $this->form_validation->set_rules('role', 'Role', 'required');
        if ($this->form_validation->run() == true) {
            $this->db->insert('user_role', ['name' => $this->input->post('role')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Role Added</div>');
            redirect('admin/role');
        } else {
            redirect('admin/role');
        }
    }

    public function roleEdit()
    {

        $this->form_validation->set_rules('role', 'Role', 'required');
        if ($this->form_validation->run() == true) {
            $this->db->set('name', $this->input->post('role'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('user_role');
            // $this->db->insert('user_role', ['name' => $this->input->post('role')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Role Edited</div>');
            redirect('admin/role');
        } else {
            redirect('admin/role');
        }
    }

    public function roleDelete()
    {
        $id = $this->input->post('idDelete');
        $this->db->delete('user_role', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Role Deleted</div>');
        redirect('admin/role');
    }

    public function roleAccess($role_id)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Role Access';
        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
        $this->db->where('id !=',1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        $select = $this->db->get_where('user_access_menu', [
            'role_id' => $this->input->post('roleId'),
            'menu_id' => $this->input->post('menuId')
        ]);
        if($select->num_rows() > 0)
        {
            // delete access
            $data = $select->row_array();
            $this->db->where('id', $data['id']);
            $this->db->delete('user_access_menu');
            
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Access deleted successfully!
            </div>');
        }
        else {
            // set access
            $this->db->insert('user_access_menu',
            [
                'role_id'=> $this->input->post('roleId'),
                'menu_id'=> $this->input->post('menuId')
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Access added successfully!
            </div>');
            
        }


    }

}
