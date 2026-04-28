<?php
// Prevent any output before our JSON response
ob_start();

// Set proper content type and prevent caching
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

// Enable error logging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Create a log file
$logFile = 'email_debug.log';
file_put_contents($logFile, date('Y-m-d H:i:s') . " - Script started\n", FILE_APPEND);

function logError($message) {
    global $logFile;
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - ERROR: $message\n", FILE_APPEND);
}

function sendJsonResponse($success, $message) {
    ob_clean(); // Clear any previous output
    echo json_encode([
        'success' => $success,
        'message' => $message
    ]);
    exit;
}

try {
    // Check if vendor/autoload.php exists
    if (!file_exists('vendor/autoload.php')) {
        sendJsonResponse(false, 'PHPMailer não está instalado. Por favor, execute composer install');
    }

    require 'vendor/autoload.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendJsonResponse(false, 'Método não permitido');
    }

    $email = $_POST['email'] ?? '';
    $result = $_POST['result'] ?? '';
    
    logError("Received request for email: $email");
    
    if (empty($email) || empty($result)) {
        sendJsonResponse(false, 'Email e resultado são obrigatórios');
    }

    // Parse the result JSON
    $resultData = json_decode($result, true);
    if (!$resultData) {
        sendJsonResponse(false, 'Formato de resultado inválido');
    }

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    // Basic SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.titan.email';
    $mail->SMTPAuth = true;
    $mail->Username = 'contato@radardorh.com.br';
    $mail->Password = '@Talentus2025';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->CharSet = 'UTF-8';

    // Enable verbose debug output
    $mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_CONNECTION;
    $mail->Debugoutput = function($str, $level) use ($logFile) {
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - Debug: $str\n", FILE_APPEND);
    };

    // Basic settings
    $mail->setFrom('contato@radardorh.com.br', 'Radar do RH - Quiz Impacto do Não');
    $mail->addAddress($email);
    $mail->isHTML = true;
    $mail->Subject = 'Seu Resultado do Quiz Impacto do Não';
    
    // Create a nicely formatted HTML email
    $mail->Body = "
        <html>
        <head>
            <style>
                body {
                    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                    line-height: 1.6;
                    color: #f8fafc;
                    background-color: #0a0f1c;
                    margin: 0;
                    padding: 40px 20px;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #141a2b;
                    border: 1px solid rgba(255, 255, 255, 0.08);
                    border-radius: 20px;
                    overflow: hidden;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.5);
                }
                .header {
                    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
                    color: white;
                    padding: 30px;
                    text-align: center;
                }
                .header h1 {
                    margin: 0;
                    font-size: 24px;
                    font-weight: bold;
                    letter-spacing: 1px;
                }
                .content {
                    padding: 40px 30px;
                    text-align: center;
                }
                .title {
                    color: #3b82f6;
                    font-size: 22px;
                    font-weight: bold;
                    margin-bottom: 20px;
                }
                .description {
                    color: #cbd5e1;
                    font-size: 16px;
                    line-height: 1.8;
                    margin-bottom: 30px;
                    text-align: left;
                    background: rgba(30, 41, 59, 0.5);
                    padding: 20px;
                    border-radius: 12px;
                    border: 1px solid rgba(255, 255, 255, 0.05);
                }
                .footer {
                    text-align: center;
                    padding: 20px;
                    color: #64748b;
                    font-size: 14px;
                    background-color: #0f172a;
                    border-top: 1px solid rgba(255, 255, 255, 0.05);
                }
                .btn {
                    display: inline-block;
                    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
                    color: #ffffff;
                    text-decoration: none;
                    padding: 14px 30px;
                    border-radius: 10px;
                    font-weight: bold;
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Resultado: Teste de Impacto do NÃO</h1>
                </div>
                <div class='content'>
                    <div class='title'>{$resultData['title']}</div>
                    <div class='description'>{$resultData['description']}</div>
                    
                    <p style='color: #94a3b8; font-size: 15px;'>
                        Esperamos que esta avaliação tenha trazido bons insights para o seu desenvolvimento pessoal e profissional.
                    </p>
                    <a href='https://www.radardorh.com.br' class='btn'>Acessar Radar do RH</a>
                </div>
                <div class='footer'>
                    Obrigado por participar do nosso quiz!<br><br>
                    Radar do RH &copy; " . date('Y') . "
                </div>
            </div>
        </body>
        </html>
    ";

    // Add plain text version
    $mail->AltBody = "
        Seu Resultado do Quiz Impacto do NÃO
        
        {$resultData['title']}
        
        {$resultData['description']}
        
        Obrigado por participar do nosso quiz!
    ";

    logError("Attempting to send email");
    
    if($mail->send()) {
        logError("Email sent successfully");
        sendJsonResponse(true, 'Email enviado com sucesso! Verifique sua Caixa de Email/Spam');
    } else {
        throw new Exception('Failed to send email');
    }

} catch (Exception $e) {
    logError("Exception: " . $e->getMessage());
    logError("Stack trace: " . $e->getTraceAsString());
    sendJsonResponse(false, 'Erro ao enviar email: ' . $e->getMessage());
} catch (Error $e) {
    logError("PHP Error: " . $e->getMessage());
    logError("Stack trace: " . $e->getTraceAsString());
    sendJsonResponse(false, 'Erro interno do servidor. Por favor, tente novamente mais tarde.');
} catch (Throwable $e) {
    logError("Throwable: " . $e->getMessage());
    logError("Stack trace: " . $e->getTraceAsString());
    sendJsonResponse(false, 'Erro inesperado. Por favor, tente novamente mais tarde.');
}

// Clear any output buffer and send response
ob_end_flush(); 