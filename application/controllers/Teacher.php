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

        if ($this->session->userdata('role_id') == 3) {
            $teacher = $this->db->get_where('teacher', ['user_id' => $this->data['user']['id']])->row_array();
            $this->data['teacher']  = $teacher;
        }


    }
    public function task()
    {
        $subjectId =  $this->uri->segment(3);
        if (empty($subjectId)) {
            $this->db->select('*');
            $this->db->from('teacher_subject');
            $this->db->where('teacher_id', $this->data['teacher']['id']);
            $this->db->join('subject', 'teacher_subject.subject_id = subject.id');
            $teacher_subject = $this->db->get()->result_array();
            $this->data['teacher_subject']  = $teacher_subject;

            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/sidebar', $this->data);
            $this->load->view('templates/topbar', $this->data);
            $this->load->view('teacher/task', $this->data);
            $this->load->view('templates/footer');
            
        }
        else {
            // select task by id teacher
            $task = $this->db->get_where('task', ['teacher_id'=> $this->data['teacher']['id']])->result_array();
            $this->data['task']  = $task;
            // ambil subject name
            $subject = $this->db->get_where('subject', ['id' => $subjectId])->row_array();
            $this->data['subject'] = $subject['name'];

            // echo "<pre>";
            // var_dump($subject);
            // echo "</pre>";
            // die;

            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/sidebar', $this->data);
            $this->load->view('templates/topbar', $this->data);
            $this->load->view('teacher/manage-task', $this->data);
            $this->load->view('templates/footer');
            
        }
       
    }

    public function addTask()
    {
        
        // $uploaded_file = $_FILES['attachment_file'];
        $config['allowed_types'] = 'pdf|pptx|ppt|docx|doc|rar';
        $config['max_size']     = '100000'; // in kb
        $config['upload_path'] = './assets/attachment/';
        $this->load->library('upload', $config);
        $this->upload->do_upload('attachment');
        $ci_data = $this->upload->data('file_name');
        
        $_POST['deadline'] = strtotime($this->input->post('deadline'));
        $_POST['attachment'] = $ci_data;
        $_POST['teacher_id'] = $this->data['teacher']['id'];
        $_POST['date'] = time();
        // $this->db->insert('task', $this->input->post());
        // var_dump($this->db->insert('task', $this->input->post()));
        // die;
        if ($this->db->insert('task', $this->input->post())) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                        Task added!
                         </div>');
            redirect('teacher/task/' . $_POST['subject_id']);
        }
        else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Task failed to add!
                         </div>');
            redirect('teacher/task/' . $_POST['subject_id']);
        }
    }

    public function editTask()
    {
        $config['allowed_types'] = 'pdf|pptx|ppt|docx|doc|rar';
        $config['max_size']     = '100000'; // in kb
        $config['upload_path'] = './assets/attachment/';
        $this->load->library('upload', $config);
        $this->upload->do_upload('attachment');
        $ci_data = $this->upload->data('file_name');

        $_POST['deadline'] = strtotime($this->input->post('deadline'));
        $_POST['attachment'] = $ci_data;
        $_POST['teacher_id'] = $this->data['teacher']['id'];
        $_POST['date'] = time();
        
        $previous_task = $this->db->get_where('task', ['id' => $this->input->post('id')])->row_array();
        if ($previous_task['attachment']!=null) {
            if ($_FILES['attachment']==null) {
                // ambil attachment kemarin
                $_POST['attachment'] = $previous_task['attachment'];
            }
            else{
                unlink(FCPATH . 'assets/attachment/' . $previous_task['attachment']);
            }
        }

        $this->db->where('id', $this->input->post('id'));
        $update = $this->db->update('task', $this->input->post());
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                        Task updated!
                         </div>');
            redirect('teacher/task/' . $_POST['subject_id']);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Task failed to update!
                         </div>');
            redirect('teacher/task/' . $_POST['subject_id']);
        }
    }

    public function deleteTask()
    {
        $subjectId =  $_POST['subject_id'];
        $id = $this->input->post('idDelete');
        $this->db->delete('task', ['id' => $id]);
        $this->db->delete('student_task', ['task_id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Task Deleted</div>');
        redirect('teacher/task/' . $subjectId);
    }



    public function mark()
    {
        $this->data['title'] = 'Mark Task';
        $subjectId =  $this->uri->segment(3);
        if (empty($subjectId)) {
            $this->db->select('*');
            $this->db->from('teacher_subject');
            $this->db->where('teacher_id', $this->data['teacher']['id']);
            $this->db->join('subject', 'teacher_subject.subject_id = subject.id');
            $teacher_subject = $this->db->get()->result_array();
            // echo"<pre>";
            // var_dump($teacher_subject);
            // echo"</pre>";
            // die;
            $this->data['teacher_subject']  = $teacher_subject;

            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/sidebar', $this->data);
            $this->load->view('templates/topbar', $this->data);
            $this->load->view('teacher/mark-task', $this->data);
            $this->load->view('templates/footer');
        } else {
            // select task by id teacher
            // $task = $this->db->get_where('task', ['teacher_id' => $this->data['teacher']['id']])->result_array();
            // $this->data['task']  = $task;
            // // ambil subject name
            // $subject = $this->db->get_where('subject', ['id' => $subjectId])->row_array();
            // $this->data['subject'] = $subject['name'];

            // // echo "<pre>";
            // // var_dump($subject);
            // // echo "</pre>";
            // // die;

            // $this->load->view('templates/header', $this->data);
            // $this->load->view('templates/sidebar', $this->data);
            // $this->load->view('templates/topbar', $this->data);
            // $this->load->view('teacher/detail-mark-task', $this->data);
            // $this->load->view('templates/footer');
            // $task = $this->db->get_where('task',['subject_id'=>$subjectId])->result_array();
            $this->db->select('task.id, task.title, user.name');
            $this->db->from('task');
            $this->db->join('teacher', 'task.teacher_id = teacher.id');
            $this->db->join('user', 'teacher.user_id = user.id');
            $this->db->where('task.subject_id', $subjectId);
            $task = $this->db->get()->result_array();
            $this->data['task']  = $task;

            $subject = $this->db->get_where('subject', ['id' => $subjectId])->row_array();
            $this->data['subject'] = $subject['name'];
            // echo '<pre>';
            // var_dump($subject);
            // echo '</pre>';
            // die;

            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/sidebar', $this->data);
            $this->load->view('templates/topbar', $this->data);
            $this->load->view('teacher/detail-mark-task', $this->data);
            $this->load->view('templates/footer');
        }
    }

    public function assignMark($taskId)
    {
        // $taskId = $this->uri->segment(3);
        $this->data['title'] = 'Mark Task';
        $this->db->select('
            student_task.id,
            student_task.attachment,
            student_task.date as submission_date,
            student_task.mark,
            student_task.task_id as task_id,
            task.deadline as task_deadline,
            student.NISN as student_NISN,
            student.class as student_class,
            user.name as name
            ');
        $this->db->from('student_task');
        $this->db->join('task', 'student_task.task_id = task.id');
        $this->db->join('student', 'student_task.student_id = student.id');
        $this->db->join('user', 'student.user_id = user.id');
        // $this->db->where('task.subject_id', $subjectId);
        $studentTask = $this->db->get()->result_array();
        // echo"<pre>";
        // var_dump($studentTask);
        // echo"</pre>";
        // die;
        $this->data['studentTask'] = $studentTask;
        
        $taskTitle = $this->db->get_where('task',['id'=>$taskId])->row_array();
        $this->data['taskTitle'] = $taskTitle['title'];
        
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/sidebar', $this->data);
        $this->load->view('templates/topbar', $this->data);
        $this->load->view('teacher/assign-mark', $this->data);
        $this->load->view('templates/footer');

        if ($this->input->post('mark')!=null) {
            if ($this->input->post('mark') > 0 && $this->input->post('mark') <= 100 ) {
                $this->db->set('mark', $this->input->post('mark'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('student_task');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Task Marked</div>');
                redirect('teacher/assignmark/'.$taskId);
            }
            else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Wrong input, mark must be on range 1 - 100</div>');
                redirect('teacher/assignmark/'.$taskId);
                
            }
        }

    }
}
