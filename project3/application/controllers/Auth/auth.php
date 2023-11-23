<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends My_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/login_m');

    }
    // method login
    public function login()
    {

        $data = array('title' => 'Đăng nhập hệ thống',
            'keyword' => '',
            'description' => '');
        if ($this->input->post('login')) {
            $data = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
            );
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('username', 'Tên sử dụng', 'trim|required|min_length[3]|max_length[20]|regex_match[/^([a-z0-9_])+$/i]');
            // |callback_check_pass;
            $this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required');
            // |callback_check_pass['.$data['username'].']
            if ($this->form_validation->run()) {
                $username = $this->input->post('username', true);
                $password = $this->input->post('password', true);

                if ($this->check_username($username)) {
                    $user = $this->login_m->getObject("username = '$username'");
                    $password_mh = $this->my_string->encryption_password($username, $password, $user['salt']);
                    if ($password_mh == $user['password']) {
                        $login = array(
                            'username' => $username,
                            'logged_in' => true,
                        );

                        $this->session->set_userdata('login_success', $login);

                        redirect(base_url('backend/dashboard/index'));
                    } else {
                        $this->session->set_flashdata('password_not_exist', 'Mật khẩu không tồn tại.');
                        redirect(base_url('auth/auth/login'));
                    }
                } else {
                    $this->session->set_flashdata('username_not_exist', 'Tên sử dụng không tồn tại.');
                    redirect(base_url('auth/auth/login'));
                } //end if2
            } //end if1
        }

        $data['template'] = 'backend/auth/login';

        $this->load->view('backend/layout/login', isset($data) ? $data : null);
    }
    public function check_username($username)
    {
        $count = $this->login_m->countObject("username='$username'");
        if ($count == 0) {

            return false;

        }return true;
    }

    public function check_pass($password, $username)
    {
        if ($this->check_username($username)) {
            $data = $this->login_m->getObject("username='$username'");
            $password_mh = $this->my_string->encryption_password($data['username'], $password, $data['salt']);
            if ($password_mh != $data['password']) {

                return false;
            }return true;
        }
    }
    // method login end.

    public function forgot()
    {
        if (isset($_SESSION['login_success'])) {
            redirect(base_url('backend/dashboard/index'));
        }
        $data['title'] = 'Quên thông tin tài khoản';
        if ($this->input->post('forgot')) {
            $data = array(
                'email' => $this->input->post('email'),
            );
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            if ($this->form_validation->run()) {
                $_code = $this->my_string->random(69, true);
                $email = $this->input->post('email');

                $data = $this->my_string->allow_post($data, array('email'));

                if ($this->check_email($email)) {
                    $data = array(
                        'forgot_code' => $_code,
                        'forgot_expiry' => time() + 3600,
                    );
                    $count_rows_update = $this->login_m->updateObject("email= '$email'", $data);

                    $name = 'WebTest';
                    $from = 'anhnpz1234@gmail.com';

                    $to = $email;
                    $subject = 'Mã xác nhận quên thông tin tài khoản cho Email ' . $email;
                    $message = 'Click vào link dưới để nhận lại mất khẩu mới : ' . base_url() . 'auth/auth/reset?email=' . urldecode($email) . '&code=' . urldecode($_code);
                    $this->my_common->smtpmailer($to, $from, $name, $subject, $message);

                    //    if($count_rows_update != 0) { $this->my_string->js_redirect('Gửi mã xác nhận thành công.',base_url('auth/auth/login'));  }
                } else {
                    $this->session->set_flashdata('email_not_exist', 'Email không tồn tại.');

                    redirect(base_url('auth/auth/forgot'));
                }

            }
        }
        $data['template'] = 'backend/auth/forgot';
        $this->load->view('backend/layout/login', isset($data) ? $data : null);
    }

    public function check_email($email)
    {
        $count = $this->login_m->countObject("email = '$email'");
        if ($count == 0) {

            return false;

        }return true;
    }

    public function reset()
    {
        if (isset($_SESSION['login_success'])) {
            $this->my_string->js_redirect('Tài khoản hiện đang đăng nhập!', base_url('backend/dashboard/index'));
        }
        // $data['title'] = 'Reset thông tin tài khoản';
        $email = $this->input->get('email');
        $code = $this->input->get('code');

        if (isset($email) && !empty($email) && isset($code) && !empty($code)) {
            $password = '';
            $user = $this->login_m->getUsercode($email, $code);

            if (!isset($user) || empty($user)) {$this->my_string->js_redirect('Người dùng hoặc mã xác nhận không tồn tại!', base_url('auth/auth/login'));}
            if ($user['forgot_expiry'] <= time()) {$this->my_string->js_redirect('Mã xác nhận đã hết hạn!', base_url('auth/auth/login'));}
            $_port['password'] = $this->my_string->random(6, true);

            $password = $_port['password'];
            $_port['salt'] = $this->my_string->random(69, true);
            $_port['password'] = $this->my_string->encryption_password($user['username'], $_port['password'], $_port['salt']);
            $_port['updated'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
            $_port['forgot_code'] = '';
            $_port['forgot_expiry'] = '';
            $this->login_m->updateObject(array('username' => $user['username']), $_port);

            // gửi mật khẩu reset qua mail.
            $name = 'WebTest';
            $from = 'anhnpz1234@gmail.com';

            $to = $email;
            $subject = 'Mật khẩu mới của tài khoản ' . $user['username'];
            $message = 'Username : ' . $user['username'] . '<br>Password : ' . $password . '<br>Nên cập nhật lại mật khẩu.';
            $this->my_common->smtpmailer($to, $from, $name, $subject, $message);
            $this->my_string->js_redirect('Gửi thông tin tài khoản đã reset thành công.', base_url('auth/auth/change_Password'));
        } else {
            $this->my_string->js_redirect('Email hoặc mã không hợp lệ!', base_url('auth/auth/login'));
        }

        // $data['template'] = 'backend/auth/reset';
        // $this->load->view('backend/layout/login', isset($data) ? $data : null);
    }

    public function change_Password()
    {
        $data['title'] = 'Reset thông tin tài khoản';
        if ($this->input->post('change')) {
            $data = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'password_again' => $this->input->post('password_again'),
            );
            if ($this->check_username($data['username'])) {
                $this->form_validation->set_error_delimiters('<li>', '</li>');

                $this->form_validation->set_rules('password', 'Mật khẩu mới', 'trim|required');
                $this->form_validation->set_rules('password_again', 'Mật khẩu xác nhận', 'trim|required|matches[password]');
                if ($this->form_validation->run()) {
                    $username = $this->input->post('username', true);
                    $password = $this->input->post('password', true);
                    $password_again = $this->input->post('password_again', true);

                    $data = $this->my_string->allow_post($data, array('username', 'password'));
                    $data['salt'] = $this->my_string->random(69, true);
                    $data['password'] = $this->my_string->encryption_password($data['username'], $data['password'], $data['salt']);
                    $data['updated'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                    $count_rows_update = $this->login_m->updateObject("username= '$username'", $data);
                    if ($count_rows_update != 0) {
                        redirect(base_url('auth/auth/login'));
                    }
                }
            } else {
                $this->session->set_flashdata('username_not_exist', 'Tên sử dụng không tồn tại.');
                redirect(base_url('auth/auth/change_Password'));
            }
        }
        $data['template'] = 'backend/auth/reset';
        $this->load->view('backend/layout/login', isset($data) ? $data : null);
    }

    //method create_manage
    public function create_manage()
    {

        $count = $this->login_m->countAll_Table();
        if ($count >= 1) {
            redirect(base_url('auth/auth/login'));
        }

        $data = array('title' => 'Tạo tài khoản quản trị');
        if ($this->input->post('create')) {
            $data = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'email' => $this->input->post('email'),
            );

            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('username', 'Tên sử dụng', 'trim|required|min_length[3]|max_length[20]|regex_match[/^([a-z0-9_])+$/i]');
            $this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            if ($this->form_validation->run()) {
                $data = $this->my_string->allow_post($data, array('username', 'password', 'email'));
                $data['salt'] = $this->my_string->random(69, true);
                $data['password'] = $this->my_string->encryption_password($data['username'], $data['password'], $data['salt']);
                $data['created'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                $this->db->insert('user', $data);
                $this->my_string->js_redirect('Tạo tài khoản quản trị thành công!', base_url('auth/auth/login'));
            }
        }
        $data['template'] = 'backend/auth/create_manage';

        $this->load->view('backend/layout/login', isset($data) ? $data : null);
    }

    // method logout
    public function logout()
    {

        $this->session->unset_userdata('login_success');
        session_destroy();
        redirect(base_url('auth/auth/login'));
    }
    // method logout end.
}
