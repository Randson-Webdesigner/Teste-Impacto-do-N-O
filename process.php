<?php
session_start();

// Configuração do banco de dados (opcional)
$host = 'localhost';
$dbname = 'nao';
$username = 'root';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'save_result':
            saveQuizResult();
            break;
        case 'get_stats':
            getQuizStats();
            break;
        default:
            http_response_code(400);
            echo json_encode(['error' => 'Ação inválida']);
    }
}

function saveQuizResult() {
    $score = intval($_POST['score'] ?? 0);
    $answers = json_decode($_POST['answers'] ?? '[]', true);
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $timestamp = date('Y-m-d H:i:s');
    
    // Validação básica
    if ($score < 0 || $score > 15) {
        http_response_code(400);
        echo json_encode(['error' => 'Score inválido']);
        return;
    }
    
    // Salvar em sessão (ou banco de dados)
    $_SESSION['quiz_results'][] = [
        'score' => $score,
        'answers' => $answers,
        'ip' => $user_ip,
        'timestamp' => $timestamp
    ];
    
    // Opcional: Salvar no banco de dados
    /*
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("INSERT INTO quiz_results (score, answers, user_ip, created_at) VALUES (?, ?, ?, ?)");
        $stmt->execute([$score, json_encode($answers), $user_ip, $timestamp]);
        
        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao salvar resultado']);
    }
    */
    
    echo json_encode(['success' => true, 'message' => 'Resultado salvo com sucesso']);
}

function getQuizStats() {
    $results = $_SESSION['quiz_results'] ?? [];
    
    if (empty($results)) {
        echo json_encode(['total' => 0, 'average' => 0, 'distribution' => []]);
        return;
    }
    
    $total = count($results);
    $scores = array_column($results, 'score');
    $average = array_sum($scores) / $total;
    
    // Distribuição por nível
    $distribution = [
        'critico' => 0,    // 10-15
        'moderado' => 0,   // 6-9
        'baixo' => 0,      // 3-5
        'saudavel' => 0    // 0-2
    ];
    
    foreach ($scores as $score) {
        if ($score >= 10) {
            $distribution['critico']++;
        } elseif ($score >= 6) {
            $distribution['moderado']++;
        } elseif ($score >= 3) {
            $distribution['baixo']++;
        } else {
            $distribution['saudavel']++;
        }
    }
    
    echo json_encode([
        'total' => $total,
        'average' => round($average, 2),
        'distribution' => $distribution
    ]);
}

// Função para limpar resultados antigos (opcional)
function cleanOldResults() {
    if (!isset($_SESSION['quiz_results'])) {
        return;
    }
    
    $cutoff = strtotime('-30 days');
    $_SESSION['quiz_results'] = array_filter($_SESSION['quiz_results'], function($result) use ($cutoff) {
        return strtotime($result['timestamp']) > $cutoff;
    });
}

// Executar limpeza automática
cleanOldResults();
?>