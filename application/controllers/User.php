<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
     
        $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')] )->row_array();
        $data['title'] = 'My Profile';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Edit Profile';

        $this->form_validation->set_rules('name','Name','required|trim');

        if ($this->form_validation->run() ==  false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        }
        else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            // cek jika ada gambar yang diupload
            $upload_image = $_FILES['image'];
            // var_dump($upload_image);
            // die;
            if (!empty($upload_image['name'])) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048'; // in kb
                $config['upload_path'] = './assets/img/profile/';
                $this->load->library('upload', $config);   
                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/'. $old_image);
                    }
                    $new_image = $upload_image['name'];
                    $this->db->set('image', $new_image);
                    $this->db->set('name', $name);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                         Your profile has been updated
                         </div>');
                    redirect('user/edit');
                }
                else {
                    $message =  $this->upload->display_errors();
                    $set_msg = '<div class="alert alert-danger" role="alert">'.$message.'
                    </div>';
                    // // $this->session->set_flashdata('message', $set_msg);
                    $this->session->set_flashdata('message', $set_msg);
                    redirect('user/edit');
                    die;
                }
            }
            else{

                $this->db->set('name' , $name);
                $this->db->where('email', $email);
                $this->db->update('user');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                         Your profile has been updated
                         </div>');
                redirect('user/edit');
            }

        }

    }

    public function changePassword()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Change Password';

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[6]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm Password', 'required|trim|min_length[6]|matches[new_password1]');

        if ($this->form_validation->run()==false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        }
        else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                         Wrong password! Please retry
                         </div>');
                redirect('user/changepassword');
            }
            else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                         New Password cannot be the same as current password!
                         </div>');
                    redirect('user/changepassword');
                }
                else {
                    // password sudah ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $this->db->set('password', $password_hash);
                    $this->db->where('id', $data['user']['id']);
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                         Password Changed!
                         </div>');
                    redirect('user/changepassword');
                }
            }
        }
    }


}
