<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teacher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->data = array(
            "user" => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            "title" => 'Task'
        );
    }
    public function task()
    {
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/sidebar', $this->data);
        $this->load->view('templates/topbar', $this->data);
        $this->load->view('teacher/task', $this->data);
        $this->load->view('templates/footer');
    }
}
