<?php
namespace PHPMailer\PHPMailer;

class PHPMailer
{
    public $Host = '';
    public $Port = 25;
    public $SMTPAuth = false;
    public $Username = '';
    public $Password = '';
    public $SMTPSecure = '';
    public $CharSet = 'UTF-8';
    public $SMTPDebug = 0;
    public $Debugoutput = 'error_log';
    public $From = '';
    public $FromName = '';
    public $Subject = '';
    public $Body = '';
    public $isHTML = false;
    private $to = [];
    private $ErrorInfo = '';
    private $smtp = null;
    private $debug = [];

    public function isSMTP()
    {
        return true;
    }

    public function setFrom($address, $name = '')
    {
        $this->From = $address;
        $this->FromName = $name;
        return true;
    }

    public function addAddress($address, $name = '')
    {
        $this->to[] = ['address' => $address, 'name' => $name];
        return true;
    }

    private function debug($message)
    {
        $this->debug[] = $message;
        if (is_callable($this->Debugoutput)) {
            call_user_func($this->Debugoutput, $message, 0);
        }
    }

    private function getResponse()
    {
        $response = '';
        while ($line = fgets($this->smtp, 515)) {
            $response .= $line;
            if (substr($line, 3, 1) == ' ') {
                break;
            }
        }
        $this->debug("SMTP Response: " . trim($response));
        return $response;
    }

    private function sendCommand($command, $expectedCode)
    {
        $this->debug("SMTP Command: " . $command);
        fputs($this->smtp, $command . "\r\n");
        $response = $this->getResponse();
        $code = substr($response, 0, 3);
        if ($code != $expectedCode) {
            throw new Exception("SMTP Error: Expected $expectedCode, got $code. Response: $response");
        }
        return $response;
    }

    private function connect()
    {
        $this->debug("Connecting to {$this->Host}:{$this->Port}");
        $this->smtp = fsockopen($this->Host, $this->Port, $errno, $errstr, 30);
        if (!$this->smtp) {
            throw new Exception("Failed to connect to SMTP server: $errstr ($errno)");
        }

        $this->getResponse(); // Get server greeting

        // Send EHLO
        $this->sendCommand("EHLO " . $_SERVER['SERVER_NAME'], "250");

        // Start TLS if required
        if ($this->SMTPSecure === 'tls') {
            $this->debug("Starting TLS");
            $this->sendCommand("STARTTLS", "220");
            if (!stream_socket_enable_crypto($this->smtp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new Exception("Failed to enable TLS");
            }
            $this->sendCommand("EHLO " . $_SERVER['SERVER_NAME'], "250");
        }

        // Authenticate if required
        if ($this->SMTPAuth) {
            $this->debug("Authenticating");
            $this->sendCommand("AUTH LOGIN", "334");
            $this->sendCommand(base64_encode($this->Username), "334");
            $this->sendCommand(base64_encode($this->Password), "235");
        }
    }

    private function disconnect()
    {
        if ($this->smtp) {
            $this->debug("Disconnecting");
            fputs($this->smtp, "QUIT\r\n");
            fclose($this->smtp);
            $this->smtp = null;
        }
    }

    public function send()
    {
        try {
            if (empty($this->From)) {
                throw new Exception('From address is required');
            }
            if (empty($this->to)) {
                throw new Exception('At least one recipient is required');
            }

            $this->connect();

            // Set sender
            $this->sendCommand("MAIL FROM:<" . $this->From . ">", "250");

            // Set recipients
            foreach ($this->to as $recipient) {
                $this->sendCommand("RCPT TO:<" . $recipient['address'] . ">", "250");
            }

            // Send data
            $this->sendCommand("DATA", "354");

            // Prepare headers
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: " . ($this->isHTML ? "text/html" : "text/plain") . "; charset=" . $this->CharSet . "\r\n";
            $headers .= "From: " . $this->FromName . " <" . $this->From . ">\r\n";
            $headers .= "Subject: " . $this->Subject . "\r\n";
            $headers .= "\r\n";

            // Send headers and body
            fputs($this->smtp, $headers . $this->Body . "\r\n.\r\n");
            $this->sendCommand("", "250");

            $this->disconnect();
            return true;
        } catch (Exception $e) {
            $this->ErrorInfo = $e->getMessage() . "\nDebug log:\n" . implode("\n", $this->debug);
            $this->disconnect();
            return false;
        }
    }
} 