<?php

class PHP_Email_Form
{
    public $to;
    public $from_name;
    public $from_email;
    public $subject;
    public $message;
    public $headers;
    public $smtp = array();

    public $errors = array();

    public $success_message = "Thank you for contacting us. We will get back to you soon.";

    function __construct()
    {
        $this->headers = "MIME-Version: 1.0" . "\r\n";
        $this->headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $this->headers .= 'From: ' . $this->from_name . '<' . $this->from_email . '>' . "\r\n";
    }

    public function add_message($content, $label = '')
    {
        if ($label != '') {
            $this->message .= "<strong>$label:</strong><br>$content<br><br>";
        } else {
            $this->message .= "$content<br><br>";
        }
    }

    public function send()
    {
        $this->errors = array();

        if (empty($this->to)) {
            $this->errors[] = 'Recipient Email is required.';
        } else {
            $mail = mail($this->to, $this->subject, $this->message, $this->headers);

            if ($mail) {
                return $this->success_message;
            } else {
                $this->errors[] = 'Email could not be sent.';
            }
        }

        return json_encode($this->errors);
    }
}

?>
