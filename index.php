<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Estabelecer Limites</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #7dd3fc 0%, #0891b2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .quiz-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
        }

        .icon {
            width: 60px;
            height: 60px;
            background: #0891b2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .subtitle {
            color: #374151;
            font-size: 14px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .title {
            color: #1f2937;
            font-size: 24px;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 30px;
        }

        .description {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
            text-align: left;
        }

        .start-btn {
            background: #0891b2;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .start-btn:hover {
            background: #0e7490;
        }

        .question-container {
            display: none;
        }

        .question {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 30px;
            text-align: left;
        }

        .options {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }

        .option {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
        }

        .option:hover {
            border-color: #0891b2;
            background: #f0f9ff;
        }

        .option.selected {
            border-color: #0891b2;
            background: #f0f9ff;
        }

        .next-btn {
            background: #0891b2;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
            opacity: 0.5;
            pointer-events: none;
        }

        .next-btn.active {
            opacity: 1;
            pointer-events: auto;
        }

        .next-btn:hover.active {
            background: #0e7490;
        }

        .result-container {
            display: none;
        }

        .result-title {
            font-size: 22px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
        }

        .result-description {
            color: #6b7280;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .restart-btn {
            background: #10b981;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .restart-btn:hover {
            background: #059669;
        }
    </style>
</head>
<body>
    <div class="quiz-container">
        <!-- Tela Inicial -->
        <div id="intro" class="intro-container">
            <div class="icon">!</div>
            <div class="subtitle">Responda ao QUIZ e descubra...</div>
            <h1 class="title">Como a dificuldade de dizer "NÃO" e estabelecer limites claro pode estar afetando sua vida?</h1>
            <p class="description">
                Você já se sentiu sobrecarregado por não conseguir estabelecer limites claros? A incapacidade de dizer "NÃO" pode impactar diversos aspectos da sua vida, desde sua saúde mental até seus relacionamentos pessoais e profissionais.
            </p>
            <p class="description">
                Ao responder ao nosso quiz, você entenderá melhor como essa dificuldade está influenciando seu dia a dia e descobrirá uma solução poderosa que pode mudar essa situação, permitindo que você viva com mais equilíbrio e satisfação.
            </p>
            <button class="start-btn" onclick="startQuiz()">Começar</button>
        </div>

        <!-- Container das Perguntas -->
        <div id="quiz" class="question-container">
            <div class="question" id="question-text"></div>
            <div class="options" id="options"></div>
            <button class="next-btn" id="next-btn" onclick="nextQuestion()">Próxima</button>
        </div>

        <!-- Resultado -->
        <div id="result" class="result-container">
            <div class="icon">✓</div>
            <h2 class="result-title" id="result-title"></h2>
            <p class="result-description" id="result-description"></p>
            <button class="restart-btn" onclick="restartQuiz()">Refazer Quiz</button>
        </div>
    </div>

    <script>
        const questions = [
            {
                question: "Qual o seu Gênero?",
                options: [
                    { text: "Homem", score: 3 },
                    { text: "Mulher", score: 3 },
                    { text: "Prefiro não dizer", score: 3 },
                    
                ]
            },
            {
                question: "Qual o sua Idade?",
                options: [
                    { text: "Menos de 25 anos", score: 3 },
                    { text: "25 a 35 anos", score: 3 },
                    { text: "36 a 45 anos", score: 3 },
                    { text: "46 anos ou mais", score: 3 },
                    
                ]
            },

            {
                question: "Você se considera uma pessoa:",
                options: [
                    { text: "Extrovertido(a)", score: 3 },
                    { text: "Introvertido(a)", score: 2 },
                    { text: "Ambivertido(a)", score: 1 },
                    { text: "Não tenho certeza", score: 0 },
                    
                ]
            },
            {
                question: "Qual é o seu principal objetivo ao responder este quiz?",
                options: [
                    { text: "Aprender mais sobre como estabelecer limites", score: 3 },
                    { text: "Encontrar uma solução para minha dificuldade em dizer não", score: 2 },
                    { text: "Verificar se minha dificuldade é comum", score: 1 },
                    { text: "Não tenho certeza", score: 0 },
                ]
            },
            {
                question: "Com que frequência você se sente sobrecarregado(a) com tarefas que não queria aceitar?",
                options: [
                    { text: "Sempre - isso acontece constantemente", score: 3 },
                    { text: "Frequentemente - várias vezes por semana", score: 2 },
                    { text: "Às vezes - algumas vezes por mês", score: 1 },
                    { text: "Raramente - quase nunca acontece", score: 0 }
                ]
            },
            {
                question: "Quando alguém pede um favor, qual é sua reação mais comum?",
                options: [
                    { text: "Aceito imediatamente, mesmo estando ocupado(a)", score: 3 },
                    { text: "Hesito, mas geralmente acabo aceitando", score: 2 },
                    { text: "Avalio minha disponibilidade antes de responder", score: 1 },
                    { text: "Digo não quando necessário, sem culpa", score: 0 }
                ]
            },
            {
                question: "Como você se sente após dizer 'não' para alguém?",
                options: [
                    { text: "Muito culpado(a) e ansioso(a)", score: 3 },
                    { text: "Desconfortável e preocupado(a)", score: 2 },
                    { text: "Um pouco desconfortável, mas aliviado(a)", score: 1 },
                    { text: "Tranquilo(a) e no controle", score: 0 }
                ]
            },
            {
                question: "Seus relacionamentos pessoais são afetados pela sua dificuldade em estabelecer limites?",
                options: [
                    { text: "Sim, constantemente gero conflitos por isso", score: 3 },
                    { text: "Sim, às vezes causa problemas", score: 2 },
                    { text: "Ocasionalmente, mas nada grave", score: 1 },
                    { text: "Não, mantenho limites saudáveis", score: 0 }
                ]
            },
            {
                question: "No trabalho, como você lida com demandas extras?",
                options: [
                    { text: "Aceito tudo, mesmo prejudicando minha vida pessoal", score: 3 },
                    { text: "Geralmente aceito, mas fico estressado(a)", score: 2 },
                    { text: "Aceito quando possível, nego quando necessário", score: 1 },
                    { text: "Estabeleço limites claros e os mantenho", score: 0 }
                ]
            }
        ];

        let currentQuestion = 0;
        let totalScore = 0;
        let selectedOption = null;

        function startQuiz() {
            document.getElementById('intro').style.display = 'none';
            document.getElementById('quiz').style.display = 'block';
            showQuestion();
        }

        function showQuestion() {
            const question = questions[currentQuestion];
            document.getElementById('question-text').textContent = question.question;
            
            const optionsContainer = document.getElementById('options');
            optionsContainer.innerHTML = '';
            
            question.options.forEach((option, index) => {
                const optionDiv = document.createElement('div');
                optionDiv.className = 'option';
                optionDiv.textContent = option.text;
                optionDiv.onclick = () => selectOption(index, option.score);
                optionsContainer.appendChild(optionDiv);
            });
            
            document.getElementById('next-btn').classList.remove('active');
            selectedOption = null;
        }

        function selectOption(index, score) {
            // Remove seleção anterior
            document.querySelectorAll('.option').forEach(opt => opt.classList.remove('selected'));
            
            // Adiciona seleção atual
            document.querySelectorAll('.option')[index].classList.add('selected');
            
            selectedOption = score;
            document.getElementById('next-btn').classList.add('active');
        }

        function nextQuestion() {
            if (selectedOption === null) return;
            
            totalScore += selectedOption;
            currentQuestion++;
            
            if (currentQuestion < questions.length) {
                showQuestion();
            } else {
                showResult();
            }
        }

        function showResult() {
            document.getElementById('quiz').style.display = 'none';
            document.getElementById('result').style.display = 'block';
            
            let title, description;
            
            if (totalScore >= 10) {
                title = "Nível Crítico - Precisa de Atenção Urgente";
                description = "Sua dificuldade em estabelecer limites está impactando significativamente sua vida. É importante buscar estratégias para desenvolver essa habilidade e recuperar o controle sobre seu tempo e energia.";
            } else if (totalScore >= 6) {
                title = "Nível Moderado - Há Espaço para Melhoria";
                description = "Você tem algumas dificuldades em dizer não e estabelecer limites, mas ainda consegue manter certo controle. Desenvolver essas habilidades pode trazer mais equilíbrio para sua vida.";
            } else if (totalScore >= 3) {
                title = "Nível Baixo - Você Está no Caminho Certo";
                description = "Você já tem uma boa noção de como estabelecer limites, mas ainda pode aprimorar essas habilidades para ter ainda mais controle sobre sua vida pessoal e profissional.";
            } else {
                title = "Parabéns! Você Tem Limites Saudáveis";
                description = "Você demonstra uma excelente capacidade de estabelecer e manter limites saudáveis. Continue assim e sirva de exemplo para outras pessoas ao seu redor.";
            }
            
            document.getElementById('result-title').textContent = title;
            document.getElementById('result-description').textContent = description;
        }

        function restartQuiz() {
            currentQuestion = 0;
            totalScore = 0;
            selectedOption = null;
            
            document.getElementById('result').style.display = 'none';
            document.getElementById('intro').style.display = 'block';
        }
    </script>
</body>
</html>