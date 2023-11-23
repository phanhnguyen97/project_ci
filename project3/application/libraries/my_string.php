<?php defined('BASEPATH') or exit('No direct script access allowed');

class My_string
{
    private $CI;
    public function __construct()
    {
        $this->CI = &get_instance();
    }
    // tạo chuỗi mã hóa
    public function random($length = 10, $char = false)
    {
        if ($char == false) {
            $s = 'ABCDEFGHIKLMNOPQRSTVXYZabcdefghiklmnopqrstvxyz0123456789!@#$%^^&*()';
        } else {
            $s = 'ABCDEFGHIKLMNOPQRSTVXYZabcdefghiklmnopqrstvxyz0123456789';
        }

        mt_srand((double) microtime() * 1000000);
        $salt = '';
        for ($i = 0; $i < $length; $i++) {
            $salt = $salt . substr($s, (mt_rand() % (strlen($s))), 1);
        }
        return $salt;
    }
    public function encryption_password($username ='',$password = '', $salt = '')
    {
        return md5($salt .$username. md5($salt .$username. md5($password) .$username. $salt) . $salt);
    }

    public function allow_post($param, $allow)
    {
        $_temp = null;
        if (isset($param) && count($param) && isset($allow) && count($allow)) {
            foreach ($param as $key => $val) {
                if (in_array($key, $allow)) {
                    $_temp[$key] = $val;
                }
            }return $_temp;
        }
        return $param;
    }

    public function js_redirect($alert, $url ){
        die('<meta charset="utf-8"><script type="text/javascript">alert(\''.$alert.'\');location.href = \''.$url.'\';</script>');
    }
}
