<?php defined('BASEPATH') or exit('No direct script access allowed');

class My_common
{
    private $CI;
    public function __construct()
    {
        $this->CI = &get_instance();
    }

    // sent email
    public function smtpmailer($to, $from, $from_name, $subject, $body)
    {
        global $error;
        require_once(FCPATH."/phpmailer/Exception.php");
        require_once(FCPATH."/phpmailer/PHPMailer.php");
        require_once(FCPATH."/phpmailer/SMTP.php");

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP(); // enable SMTP

    $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only ,0 = khỏi hiện lỗi
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com"; // Thiết lập thông tin của SMPT
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "anhnpz1234@gmail.com";
    $mail->Password = "ocalfvkjvusbdbno";
    //Thiet lap thong tin nguoi gui va email nguoi gui
    $mail->SetFrom($from,$from_name);
    //Thiết lập tiêu đề
    $mail->Subject = $subject;
    //Thiết lập định dạng font chữ
    $mail->CharSet = 'utf-8';
    $mail->Body = $body;
    //Thiết lập thông tin người nhận
    $mail->AddAddress($to);
    //Thiết lập email nhận email hồi đáp
    //nếu người nhận nhấn nút Reply
    // $mail->AddReplyTo(“emailnguoinhan@gmail.com”,”Nguyen Van A”);

     if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
     } else {
        echo 'Message has been sent';
     }

    }

}
