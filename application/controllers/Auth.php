<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        
    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run()==false) {
            $data['title'] = 'WPU Login Page';
            $this->load->view('templates/auth_header',$data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        }
        else {
            $this->_login();
        }
    }

    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('name','Name', 'required|trim');
        $this->form_validation->set_rules('email','Email', 'required|trim|valid_email|is_unique[user.email]',[
            'is_unique' => 'This email has already registered!'
        ]);
        // $this->form_validation->set_rules('email','Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password1','Password', 'required|trim|min_length[6]|matches[password2]',[
            'matches' => 'Password is not match!',
            'min_length' => 'Password is too short!'
        ]);
        $this->form_validation->set_rules('password2','Password', 'required|trim|matches[password1]');
        
        if ($this->form_validation->run()==false) {
            $data['title'] = 'WPU Registration Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        }
        else{
            $data = [
                'name' => htmlspecialchars($this->input->post('name',true)),
                'email' => htmlspecialchars($this->input->post('email',true)),
                'image' => "default.jpg",
                'password' => password_hash($this->input->post('password1',true),
                PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];
            // generate token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $data['email'],
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user',$data);
            $this->db->insert('user_token',$user_token);
            // kirim email
            $this->_sendEmail($token, 'verify');
            // pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Register Success! Please Check your email to activate account
            </div>');
            redirect('auth');

        }
    }
    
    private function _sendEmail($token, $type)
    {

        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'barsavroist@gmail.com',
            'smtp_pass' => '321purnama',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);  //tambahkan baris ini
        $this->email->from('barsavroist@gmail.com', 'Admin');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message(
            'Clik this link to verify your account :<a href="'.
            base_url("auth/verify?email=").
            $this->input->post('email').
            '&token='. urlencode($token).
            '">link</a>');
            
        }
        else {
            $this->email->subject('Reset Password');
            $this->email->message(
                'Clik this link to reset your password :<a href="' .
                    base_url("auth/resetPassword?email=") .
                    $this->input->post('email') .
                    '&token=' . urlencode($token) .
                    '">link</a>'
            );
        }

        if ($this->email->send()) {
            return true;
        }
        else{
            echo $this->email->print_debugger();
            die;
        }
    }

    public function resetPassword()
    {   
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user = $this->db->get_where('user', ['email'=> $email])->row_array();
        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                if (time() - $user_token['date_created'] < 86400) {
                    $this->changePassword($email, $token);
                }
                else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Reset password failed! token expired
                    </div>');
                    redirect('auth');
                }
            }
            else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Reset password failed! Wrong token
                    </div>');
                redirect('auth');
            }
        }
        else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Reset password failed! Wrong email
                    </div>');
            redirect('auth');
        }
    }
    private function changePassword($email, $token)
    {
        $data['title'] = 'Change Password';
        $data['email'] = $email;
        $data['token'] = $token;

        $this->form_validation->set_rules('password1', 'New Password', 'trim|required|min_length[6]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[6]|matches[password1]');

        if ($this->form_validation->run()==false) {
            
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth_footer');
        }
        else {
            $password = $this->input->post('password1');
            $hash = password_hash($password, PASSWORD_DEFAULT);
            //update password
            $this->db->set('password', $hash);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->db->delete('user_token', ['token'=> $token  ]);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                     Password changed successfully!
                     </div>');
            redirect('auth');
        }

    }


    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user',['email' => $email])->row_array();
        if ($user) {
            if ($user['is_active']==1) {
                if (password_verify($password, $user['password'])) {
                    // set session
                    $data = [
                        'email'=> $user['email'],
                        'role_id'=> $user['role_id']
                    ];
                    // check role student
                    if ($user['role_id'] == 2) {
                        // var_dump($user['role_id']);
                        // die;
                        $student = $this->db->get_where('student', ['user_id' => $user['id']])->row_array();
                        $data['class'] = $student['class'];
                    }
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    }
                    else {
                        redirect('user');
                    }
                }
                else{
                    //pesan error
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                     Wrong password!
                     </div>');
                    redirect('auth',$email);
                }
            }
            else {
                //pesan error
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Email has not been activated!
                </div>');
                redirect('auth');
            }
        }
        else {
            //pesan error
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email is not registered!
            </div>');
            redirect('auth');
        }
        // var_dump($user); die;
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user = $this->db->get_where('user', ['email'=> $email])->row_array();
        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token'=> $token])->row_array();
            if ($user_token) {
                if (time() - $user_token['date_created'] < 86400) { // kalau lebih dari 1 hari 
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email );
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email'=> $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Account has been activated
                    </div>');
                    redirect('auth');

                }
                else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Token expired! please register again
                    </div>');
                    redirect('auth');
                }
                
            }
            else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Account activation failed! token invalid
            </div>');
            redirect('auth');
            }
        }
        else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Account activation failed! Wrong email
            </div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('class');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            You have been logged out
            </div>');
        redirect('auth');
    }

    public function blocked()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Dashboard';
        $this->load->view('templates/header', $data);
        $this->load->view('auth/blocked');
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email','required|trim|valid_email');   
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth_footer');
            
        }
        else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email'=> $email, 'is_active'=> 1])->row_array();
            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created'=> time()
                ];
                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Please check your email to reset your password!
            </div>');
                redirect('auth/forgotPassword');

            }
            else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Email is not registered or inactive
            </div>');
            redirect('auth/forgotPassword');
            }
        }
    }


}
