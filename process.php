<?php
session_start();

require_once 'config.php';

header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodificar payload JSON se fornecido via fetch, caso contrário, fallback para POST
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);
    
    $action = $input['action'] ?? $_POST['action'] ?? '';
    
    switch ($action) {
        case 'save_result':
            saveQuizResult($input);
            break;
        case 'get_stats':
            getQuizStats();
            break;
        default:
            http_response_code(400);
            echo json_encode(['error' => 'Ação inválida', 'success' => false]);
    }
}

function saveQuizResult($input) {
    $score = isset($input['score']) ? intval($input['score']) : intval($_POST['score'] ?? 0);
    
    // Tratamento das respostas (answers)
    if (isset($input['answers'])) {
        $answers = is_array($input['answers']) ? json_encode($input['answers']) : $input['answers'];
    } else {
        $answers = $_POST['answers'] ?? '[]';
    }

    $user_ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    // Validação básica
    if ($score < 0 || $score > 45) { // Adjusted max score to handle 15 questions
        http_response_code(400);
        echo json_encode(['error' => 'Score inválido', 'success' => false]);
        return;
    }
    
    // Salvar em sessão também como cache/histórico local
    $_SESSION['quiz_results'][] = [
        'score' => $score,
        'answers' => json_decode($answers, true),
        'ip' => $user_ip,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    // Salvar no banco de dados
    $pdo = getDBConnection();
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO quiz_results (score, answers, user_ip, user_agent) VALUES (?, ?, ?, ?)");
            $stmt->execute([$score, $answers, $user_ip, $user_agent]);
            
            echo json_encode(['success' => true, 'message' => 'Resultado salvo com sucesso no DB', 'id' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            http_response_code(500);
            error_log("DB Error on save_result: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Erro ao salvar resultado no banco de dados']);
        }
    } else {
        // Fallback apenas para sessão se o DB falhar
        echo json_encode(['success' => true, 'message' => 'Resultado salvo apenas na sessão (DB offline)']);
    }
}

function getQuizStats() {
    $pdo = getDBConnection();
    
    if (!$pdo) {
        // Fallback para sessão
        getQuizStatsFromSession();
        return;
    }

    try {
        $stmt = $pdo->query("SELECT score FROM quiz_results");
        $results = $stmt->fetchAll();
        
        $total = count($results);
        if ($total === 0) {
            echo json_encode(['total' => 0, 'average' => 0, 'distribution' => []]);
            return;
        }

        $scores = array_column($results, 'score');
        $average = array_sum($scores) / $total;
        
        // Distribuição por nível - ajustado para 15 perguntas (máx 45 pts)
        $distribution = [
            'critico' => 0,    // >= 30
            'moderado' => 0,   // 18-29
            'baixo' => 0,      // 9-17
            'saudavel' => 0    // 0-8
        ];
        
        foreach ($scores as $score) {
            if ($score >= 30) {
                $distribution['critico']++;
            } elseif ($score >= 18) {
                $distribution['moderado']++;
            } elseif ($score >= 9) {
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
    } catch (PDOException $e) {
        getQuizStatsFromSession();
    }
}

function getQuizStatsFromSession() {
    $results = $_SESSION['quiz_results'] ?? [];
    
    if (empty($results)) {
        echo json_encode(['total' => 0, 'average' => 0, 'distribution' => []]);
        return;
    }
    
    $total = count($results);
    $scores = array_column($results, 'score');
    $average = array_sum($scores) / $total;
    
    $distribution = ['critico' => 0, 'moderado' => 0, 'baixo' => 0, 'saudavel' => 0];
    
    foreach ($scores as $score) {
        if ($score >= 30) { $distribution['critico']++; }
        elseif ($score >= 18) { $distribution['moderado']++; }
        elseif ($score >= 9) { $distribution['baixo']++; }
        else { $distribution['saudavel']++; }
    }
    
    echo json_encode([
        'total' => $total,
        'average' => round($average, 2),
        'distribution' => $distribution
    ]);
}
?>