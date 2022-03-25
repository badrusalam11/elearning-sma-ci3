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

    public function userManagement()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'User Management';
        // $this->db->select('user.id,  user.name, user.email, user.is_active, user.date_created');
        // $this->db->from('user');
        // $this->db->join('student', 'user.i = student.user_id');
        // // $this->db->join('teacher', 'user.id = teacher.user_id');
        // $data['getUser'] = $this->db->get()->result_array();

        $this->load->model('Admin_model', 'admin');
        $data['getUser'] = $this->admin->getUser();

        $data['getRole'] = $this->db->get('user_role')->result_array();

        $data['subject'] = $this->db->get('subject')->result_array();
        
        // echo"<pre>";
        // var_dump($this->admin->getUser());
        // echo"</pre>";
        // die;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/user-management', $data);
        $this->load->view('templates/footer');
    }

    public function addUser()
    {
        // var_dump($this->input->post());
        // die;

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]', [
            'min_length' => 'Password is too short!'
        ]);
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        $this->form_validation->set_rules('NISN', 'NISN', 'is_unique[student.NISN]', [
            'is_unique' => 'This NISN has already registered!'
        ]);
        $this->form_validation->set_rules('NIP', 'NIP', 'is_unique[teacher.NIP]', [
            'is_unique' => 'This NIP has already used by other user!'
        ]);

        if ($this->form_validation->run() == true) {
            
            $this->load->model('Admin_model', 'admin');
            $insert = $this->admin->insertUser($this->input->post());
            // var_dump($insert);
            // die;
            if ($insert) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                         User added successfully
                         </div>');
                redirect('admin/usermanagement/');
            }
            else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                         User failed to add
                         </div>');
            redirect('admin/usermanagement/');
                }
         }
        else {
            $this->userManagement();
        }


    }


    public function editUser()
    {

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('role_id', 'Role', 'required');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_check_user_email');
        // $this->form_validation->set_rules('NISN', 'NISN', 'is_unique[student.NISN]', [
        //     'is_unique' => 'This NISN has already registered!'
        // ]);
        // $this->form_validation->set_rules('NIP', 'NIP', 'is_unique[teacher.NIP]', [
        //     'is_unique' => 'This NIP has already used by other user!'
        // ]);

        if ($this->form_validation->run() == true) {

            $this->load->model('Admin_model', 'admin');
            $insert = $this->admin->updateUser($this->input->post());
            // var_dump($insert);
            // die;
            if ($insert) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                         User updated successfully!
                         </div>');
                redirect('admin/usermanagement/');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                         User failed to update!
                         </div>');
                redirect('admin/usermanagement/');
            }
        } else {
            $this->userManagement();
        }
    }
    public function check_user_email($email)
    {
        if ($this->input->post('id'))
            $id = $this->input->post('id');
        else
            $id = '';
        $this->load->model('Admin_model', 'admin');
        $result = $this->admin->check_unique_user_email($id, $email);
        if ($result == 0)
            $response = true;
        else {
            $this->form_validation->set_message('check_user_email', 'Email must be unique');
            $response = false;
        }
        return $response;
    }

    public function deleteUser()
    {
        $id = $this->input->post('id');
        $this->db->delete('user', ['id' => $id]);
        if ($this->input->post('role_id')==2) {
            $this->db->delete('student', ['user_id', $id]);
        }
        elseif ($this->input->post('role_id')==3) {
            $this->db->delete('teacher', ['user_id'=>$id]);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            User has been Deleted</div>');
        redirect('admin/usermanagement/');
    }

    public function subjectManagement()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Subject Management';


        $data['subject'] = $this->db->get('subject')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('cluster', 'Cluster', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/subject-management', $data);
            $this->load->view('templates/footer');
        }
        else {
            $insert = $this->db->insert('subject', ['name'=> $this->input->post('name'), 'cluster'=> $this->input->post('cluster')]);
            if ($insert) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Subject added!</div>');
                redirect('admin/subjectmanagement/');
            }
            else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Subject failed to add!</div>');
                redirect('admin/subjectmanagement/');
            }
        }

    }

    public function editSubject()
    {
        $this->db->where('id', $this->input->post('id'));
        $update = $this->db->update('subject', ['name' => $this->input->post('name'), 'cluster' => $this->input->post('cluster')]);
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Subject updated!</div>');
            redirect('admin/subjectmanagement/');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Subject failed to update!</div>');
            redirect('admin/subjectmanagement/');
        }
    }

    public function deleteSubject()
    {
        $delete = $this->db->delete('subject', ['id'=> $this->input->post('id')]);
        if ($delete) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Subject deleted!</div>');
            redirect('admin/subjectmanagement/');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Subject failed to delet!</div>');
            redirect('admin/subjectmanagement/');
        }
    }
    

}
