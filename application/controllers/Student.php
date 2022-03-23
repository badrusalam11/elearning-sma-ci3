<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student extends CI_Controller
{
    private $data;

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        
        // $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // $data['title'] = 'Dashboard';
        $this->data = array(
            "user" => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            "title" => 'Task'
        );
        if ($this->session->userdata('role_id')==2) {
            $student = $this->db->get_where('student', ['user_id' => $this->data['user']['id'] ])->row_array();
            $this->data['student']  = $student;
        }
        // var_dump($this->data);
        // die;

    }
    public function task()
    {
        $subjectId =  $this->uri->segment(3);
        if (empty($subjectId)) {
            $class = explode('-', $this->data['student']['class']);
            $cluster = $class[1];

            $this->db->select('*');
            $this->db->from('subject');
            $this->db->where('cluster', $cluster);
            $this->db->or_where('cluster','GENERAL');
            $subject = $this->db->get()->result_array();
            // $subject = $this->db->get_where('subject', ['cluster' => $cluster, 'cluster' =>'GENERAL'])->result_array();
            $this->data['subject']  = $subject;
            // var_dump($subject);
            // die;

            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/sidebar', $this->data);
            $this->load->view('templates/topbar', $this->data);
            $this->load->view('student/task', $this->data);
            $this->load->view('templates/footer');
        }
        else {

            // $task = $this->db->get_where('task',['subject_id'=>$subjectId])->result_array();
            $this->db->select('task.id, task.title, user.name');
            $this->db->from('task');
            $this->db->join('teacher', 'task.teacher_id = teacher.id');
            $this->db->join('user', 'teacher.user_id = user.id');
            $task = $this->db->get()->result_array();
            $this->data['task']  = $task;

            $subject = $this->db->get_where('subject',['id'=>$subjectId])->row_array();
            $this->data['subject'] = $subject['name'];
            // echo '<pre>';
            // var_dump($subject);
            // echo '</pre>';
            // die;

            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/sidebar', $this->data);
            $this->load->view('templates/topbar', $this->data);
            $this->load->view('student/detail-task', $this->data);
            $this->load->view('templates/footer');

        }
    }

    public function assign($taskId)
    {
        $this->db->select('task.id, task.title, task.content, task.attachment, task.date, task.deadline, subject.name as subject, user.name as user');
        $this->db->from('task');
        $this->db->where('task.id',$taskId);
        $this->db->join('teacher', 'task.teacher_id = teacher.id');
        $this->db->join('user', 'teacher.user_id = user.id');
        $this->db->join('subject', 'task.subject_id = subject.id');
        $task = $this->db->get()->row_array();
        $this->data['task']  = $task;

        // echo '<pre>';
        //     var_dump($task);
        //     echo '</pre>';
        //     die;
        // check if student has been uploaded task or not
        $check_task = $this->db->get_where('student_task', ['student_id' => $this->data['student']['id'], 'task_id' => $taskId])->row_array();
        $this->data['check_task']  = $check_task;

        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/sidebar', $this->data);
        $this->load->view('templates/topbar', $this->data);
        $this->load->view('student/assign-task', $this->data);
        $this->load->view('templates/footer');
    }

    public function addSubmission($taskId)
    {
        $this->db->select('task.id, task.title, task.content, task.attachment, task.date, task.deadline, subject.name as subject, user.name as user');
        $this->db->from('task');
        $this->db->where('task.id', $taskId);
        $this->db->join('teacher', 'task.teacher_id = teacher.id');
        $this->db->join('user', 'teacher.user_id = user.id');
        $this->db->join('subject', 'task.subject_id = subject.id');
        $task = $this->db->get()->row_array();
        $this->data['task']  = $task;

        // check if student has been uploaded task or not
        $check_task = $this->db->get_where('student_task', ['student_id'=> $this->data['student']['id'], 'task_id'=>$taskId])->row_array();
        $this->data['check_task']  = $check_task;
        // upload file
        if (!empty($_FILES['attachment_file'])) {
            $uploaded_file = $_FILES['attachment_file'];
            $config['allowed_types'] = 'pdf|pptx|ppt|docx|doc|rar';
            $config['max_size']     = '100000'; // in kb
            $config['upload_path'] = './assets/attachment/';
            $this->load->library('upload', $config);
            $upload = $this->upload->do_upload('attachment_file');
            $ci_data = $this->upload->data('file_name');

            //upload
            if ($upload) {
                // if data is not exist
                if (!$check_task) {
                    $this->db->insert(
                        'student_task',
                        [
                            'attachment' => $ci_data,
                            'date' => time(),
                            'task_id'=> $taskId,
                            'student_id'=> $this->data['student']['id']
    
                        ]
                    );
                    
                    
                }
                else {
                    // delete file in directory
                    // var_dump($ci_data);
                    // die;
                    $old_file = $check_task['attachment'];
                    unlink(FCPATH . 'assets/attachment/' . $old_file);
                    // update database
                    $this->db->set('attachment', $ci_data);
                    $this->db->set('date', time());
                    $this->db->set('task_id', $taskId);
                    $this->db->set('student_id', $this->data['student']['id']);
                    $this->db->where('id', $check_task['id']);
                    $this->db->update('student_task');
                    
                }
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                         Your file submitted successfully
                         </div>');
                redirect('student/assign/'.$taskId);
            }
            else {
                $message =  $this->upload->display_errors();
                $set_msg = '<div class="alert alert-danger" role="alert">' . $message . '
                    </div>';
                // // $this->session->set_flashdata('message', $set_msg);
                $this->session->set_flashdata('message', $set_msg);
                redirect('student/assign/' . $taskId);
            }
        }

        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/sidebar', $this->data);
        $this->load->view('templates/topbar', $this->data);
        $this->load->view('student/submission-task', $this->data);
        $this->load->view('templates/footer');
    }
    

}