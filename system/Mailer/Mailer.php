<?php

/**
 *   ___       _
 *  / _ \  ___| |_ ___  _ __  _   _
 * | | | |/ __| __/ _ \| '_ \| | | |
 * | |_| | (__| || (_) | |_) | |_| |
 *  \___/ \___|\__\___/| .__/ \__, |
 *                     |_|    |___/
 * @author  : Supian M <supianidz@gmail.com>
 * @version : v1.0
 * @license : MIT
 */

namespace Octopy;

use Octopy\Mailer\Exception\AttachmentNotExistException;
use Octopy\Mailer\Exception\AuthorizationErrorException;
use Octopy\Mailer\Exception\ErrorSendingCommandException;
use Octopy\Mailer\Exception\SMTPConnectionErrorException;

class Mailer
{
    /**
     * @var array
     */
    private $auth = [];

    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $boundary;

    /**
     * @var array
     */
    private $from;

    /**
     * @var array
     */
    private $to;

    /**
     * @var string
     */
    private $subject = 'No Subject';

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $multipart = '';

    /**
     * @var boolean
     */
    private $attachment = false;

    /**
     *
     */
    public function __construct()
    {
        $mail = config('mail');
        $this->auth(
            $mail->auth,
            $mail->host,
            $mail->port
        );
        
        $this->boundary = '--' . md5(uniqid(time()));
    }

    /**
     * @param  array  $auth
     * @param  string $host
     * @param  int    $port
     * @return Mailer
     */
    public function auth($auth, string $host, int $port)
    {
        $this->auth = $auth;
        $this->host = $host;
        $this->port = $port;

        return $this;
    }

    /**
     * @param  string $name
     * @param  string $email
     * @return Mailer
     */
    public function from(string $name, string $email)
    {
        $this->from = [
            $name, $this->validate($email)
        ];

        return $this;
    }

    /**
     * @param  array|string $email
     * @return Mailer
     */
    public function to($email)
    {
        if (is_array($email)) {
            foreach ($email as $address) {
                $this->to($address);
            }

            return $this;
        }

        $this->to[] = $this->validate($email);

        return $this;
    }

    /**
     * @param  string $subject
     * @return Mailer
     */
    public function subject(string $subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @param  string $message
     * @return Mailer
     */
    public function message(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param  string $view
     * @param  array  $data
     * @return Mailer
     */
    public function view(string $view, array $data)
    {
        $this->message = view($view, $data);
        return $this;
    }

    /**
     * @param  string $path
     * @return Mailer
     */
    public function attach(string $path)
    {
        if (!is_file($path)) {
            throw new AttachmentNotExistException;
        }
        
        $file = @fopen($path, 'rb');
        
        $data = fread($file, filesize($path));
        
        fclose($file);
        
        $filename = basename($path);
        $multipart  = "\r\n--{$this->boundary}\r\n";
        $multipart .= "Content-Type: application/octet-stream; name=\"{$filename}\"\r\n";
        $multipart .= "Content-Transfer-Encoding: base64\r\n";
        $multipart .= "Content-Disposition: attachment; filename=\"{$filename}\"\r\n";
        $multipart .= "\r\n";
        $multipart .= chunk_split(base64_encode($data));
        
        $this->multipart .= $multipart;
        $this->attachment = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function send()
    {
        return $this->socket($this->get());
    }

    /**
     * @param  string $content
     * @return bool
     */
    private function socket(string $content)
    {
        $socket = @fsockopen($this->host, $this->port, $errno, $errdesc, 30);

        if (!$this->parse($socket, 220)) {
            throw new SMTPConnectionErrorException;
        }
            
        $server = $_SERVER['SERVER_NAME'];

        fputs($socket, "EHLO $server\r\n");
        if (!$this->parse($socket, 250)) {
            fputs($socket, "HELO $server\r\n");
            if (!$this->parse($socket, 250)) {
                fclose($socket);
                throw new ErrorSendingCommandException;
            }
        }
            
        fputs($socket, "AUTH LOGIN\r\n");
        if (!$this->parse($socket, 334)) {
            fclose($socket);
            throw new AuthorizationErrorException;
        }
            
        fputs($socket, base64_encode($this->auth->username) . "\r\n");
        if (!$this->parse($socket, 334)) {
            fclose($socket);
            throw new AuthorizationErrorException;
        }
            
        fputs($socket, base64_encode($this->auth->password) . "\r\n");
        if (!$this->parse($socket, 235)) {
            fclose($socket);
            throw new AuthorizationErrorException;
        }
            
        fputs($socket, "MAIL FROM: <" . $this->auth->username . ">\r\n");
        if (!$this->parse($socket, 250)) {
            fclose($socket);
            throw new ErrorSendingCommandException;
        }
            
        foreach ($this->to as $email) {
            fputs($socket, "RCPT TO: <{$email}>\r\n");
            if (!$this->parse($socket, 250)) {
                fclose($socket);
                throw new ErrorSendingCommandException;
            }
        }
            
        fputs($socket, "DATA\r\n");
        if (!$this->parse($socket, 354)) {
            fclose($socket);
            throw new ErrorSendingCommandException;
        }
            
        fputs($socket, $content."\r\n.\r\n");
        if (!$this->parse($socket, 250)) {
            fclose($socket);
            throw new FailedSendingEmailException;
        }
            
        fputs($socket, "QUIT\r\n");
        return fclose($socket);
    }

    /**
     * @param  string $email
     * @return Mailer
     */
    private function validate(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception;
        }

        return $email;
    }

    /**
     * @return string
     */
    private function get()
    {
        $content  = "Date: " . date("D, d M Y H:i:s") . " UT\r\n";
        $content .= 'Subject: =?utf-8?B?'  . base64_encode($this->subject) . "=?=\r\n";
        
        $headers = "MIME-Version: 1.0\r\n";
        
        if ($this->attachment === true) {
            $headers .= "Content-Type: multipart/mixed; boundary=\"{$this->boundary}\"\r\n";
        } else {
            $headers .= "Content-type: text/html; charset=utf-8\r\n";
        }

        $headers .= "From: {$this->from[0]} <{$this->from[1]}>\r\n";
        $headers .= "To: " . implode(',', $this->to) . "\r\n";
        $content .= $headers . "\r\n";
        
        if ($this->attachment === true) {
            $content .= "--{$this->boundary}\r\n";
            $content .= "Content-Type: text/html; charset=utf-8\r\n";
            $content .= "Content-Transfer-Encoding: base64\r\n";
            $content .= "\r\n";
            $content .= chunk_split(base64_encode($this->message));
            $content .= $this->multipart;
            $content .= "\r\n--{$this->boundary}--\r\n";
        } else {
            $content .= $this->message . "\r\n";
        }
        
        return $content;
    }

    /**
     * @param  Resource $socket
     * @param  int      $response
     * @return bool
     */
    private function parse($socket, int $response)
    {
        $responseServer = '';

        while (substr($responseServer, 3, 1) != ' ') {
            if (!($responseServer = fgets($socket, 256))) {
                return false;
            }
        }

        if (!(substr($responseServer, 0, 3) == $response)) {
            return false;
        }
        
        return true;
    }
}
