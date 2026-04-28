<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Estabelecer Limites | Radar do RH</title>
    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0a0f1c;
            --card-bg: rgba(20, 26, 43, 0.6);
            --card-border: rgba(255, 255, 255, 0.08);
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --accent: #8b5cf6;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --success: #10b981;
            --option-bg: rgba(30, 41, 59, 0.5);
            --option-border: rgba(255, 255, 255, 0.1);
            --option-hover-border: #3b82f6;
            --option-hover-bg: rgba(59, 130, 246, 0.1);
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Background Glows */
        .ambient-glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            z-index: -1;
            opacity: 0.5;
            animation: float 10s infinite alternate ease-in-out;
        }

        .glow-1 {
            width: 400px;
            height: 400px;
            background: rgba(59, 130, 246, 0.3);
            top: -100px;
            left: -100px;
        }

        .glow-2 {
            width: 500px;
            height: 500px;
            background: rgba(139, 92, 246, 0.2);
            bottom: -200px;
            right: -100px;
            animation-delay: -5s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(50px, 50px) scale(1.1); }
        }

        .logo-container {
            margin-bottom: 40px;
            text-align: center;
            z-index: 10;
        }

        .logo-container img {
            width: 250px;
            max-width: 100%;
            filter: drop-shadow(0 0 20px rgba(255,255,255,0.1));
            transition: var(--transition);
        }

        .quiz-container {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: 30px;
            padding: 50px;
            max-width: 700px;
            width: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255,255,255,0.05) inset;
            position: relative;
            z-index: 10;
            overflow: hidden;
        }

        /* Fade/Slide Transitions */
        .view-section {
            display: none;
            opacity: 0;
            transform: translateY(20px);
            transition: var(--transition);
        }

        .view-section.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .icon-badge {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            color: white;
            font-size: 32px;
            font-weight: 700;
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.5);
            transform: rotate(-10deg);
            transition: var(--transition);
        }
        
        .quiz-container:hover .icon-badge {
            transform: rotate(0deg) scale(1.05);
        }

        .subtitle {
            color: var(--primary);
            font-size: 14px;
            margin-bottom: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-align: center;
        }

        .title {
            color: var(--text-main);
            font-size: 32px;
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 24px;
            text-align: center;
            background: linear-gradient(to right, #fff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .description {
            color: var(--text-muted);
            font-size: 17px;
            line-height: 1.7;
            margin-bottom: 24px;
            text-align: center;
            font-weight: 400;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            padding: 16px 40px;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.4);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, var(--accent), var(--primary));
            opacity: 0;
            z-index: -1;
            transition: var(--transition);
        }

        .btn-primary:hover::before {
            opacity: 1;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px -5px rgba(59, 130, 246, 0.5);
        }

        .btn-primary:disabled, .btn-primary.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Quiz Layout */
        .progress-container {
            margin-bottom: 40px;
        }

        .progress-text {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 12px;
            font-weight: 600;
        }

        .progress-bar-bg {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            width: 0%;
            border-radius: 10px;
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }

        .question-text {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 32px;
            line-height: 1.4;
            text-align: left;
        }

        .options-grid {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 40px;
        }

        .option-card {
            background: var(--option-bg);
            border: 1px solid var(--option-border);
            border-radius: 16px;
            padding: 20px 24px;
            cursor: pointer;
            transition: var(--transition);
            text-align: left;
            font-size: 16px;
            color: var(--text-main);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            overflow: hidden;
        }

        .option-card:hover {
            border-color: var(--option-hover-border);
            background: var(--option-hover-bg);
            transform: translateX(5px);
        }

        .option-card.selected {
            border-color: var(--primary);
            background: rgba(59, 130, 246, 0.15);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.2) inset;
        }
        
        .option-indicator {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 2px solid var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .option-card:hover .option-indicator {
            border-color: var(--primary);
        }

        .option-card.selected .option-indicator {
            border-color: var(--primary);
            background: var(--primary);
            box-shadow: 0 0 10px var(--primary);
        }

        .option-card.selected .option-indicator::after {
            content: '';
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
        }

        /* Result Section */
        .result-score {
            font-size: 64px;
            font-weight: 800;
            color: var(--text-main);
            margin: 20px 0;
            text-shadow: 0 0 30px rgba(59, 130, 246, 0.4);
        }

        .email-form {
            background: rgba(0,0,0,0.2);
            padding: 30px;
            border-radius: 20px;
            margin-top: 30px;
            border: 1px solid var(--card-border);
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--option-border);
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-family: 'Outfit', sans-serif;
            transition: var(--transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .loader {
            display: none;
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .quiz-container {
                padding: 30px 20px;
                border-radius: 20px;
            }
            .title { font-size: 26px; }
            .question-text { font-size: 20px; }
            .option-card { padding: 16px 20px; }
            .logo-container img { width: 200px; }
        }
    </style>
</head>
<body>
    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>

    <div class="logo-container">
        <img src="assets/img/lg.webp" alt="Radar do RH Logo" onerror="this.src='https://via.placeholder.com/250x80?text=Radar+do+RH'">
    </div>

    <div class="quiz-container">
        
        <!-- Tela de Introdução -->
        <div id="view-intro" class="view-section active">
            <div class="icon-badge">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            </div>
            <div class="subtitle">Avaliação Profissional</div>
            <h1 class="title">Como a dificuldade de dizer "NÃO" está afetando sua vida?</h1>
            <p class="description">
                Você já se sentiu sobrecarregado por não conseguir estabelecer limites claros? A incapacidade de dizer "NÃO" pode impactar sua saúde mental, bem como seus relacionamentos pessoais e profissionais.
            </p>
            <p class="description">
                Descubra em poucos minutos seu perfil e receba insights sobre como recuperar o controle sobre seu tempo e energia.
            </p>
            <button class="btn-primary" onclick="startQuiz()" style="margin-top: 30px;">
                Iniciar Avaliação 
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
        </div>

        <!-- Tela do Quiz -->
        <div id="view-quiz" class="view-section">
            <div class="progress-container">
                <div class="progress-text">
                    <span id="progress-count">Pergunta 1 de 15</span>
                    <span id="progress-percentage">0%</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-fill" id="progress-bar"></div>
                </div>
            </div>
            
            <h2 class="question-text" id="question-text">Carregando pergunta...</h2>
            
            <div class="options-grid" id="options-container">
                <!-- Opções serão inseridas via JS -->
            </div>
            
            <button class="btn-primary disabled" id="next-btn" onclick="nextQuestion()" disabled>
                Continuar
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
        </div>

        <!-- Tela de Carregamento para Processamento -->
        <div id="view-loading" class="view-section" style="text-align: center; padding: 40px 0;">
            <div class="icon-badge" style="animation: spin 2s linear infinite; margin: 0 auto 30px;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-6.219-8.56"></path></svg>
            </div>
            <h2 class="title" style="font-size: 24px;">Analisando seu perfil...</h2>
            <p class="description">Gerando resultados baseados em suas respostas.</p>
        </div>

        <!-- Tela de Resultado -->
        <div id="view-result" class="view-section">
            <div class="icon-badge" style="background: linear-gradient(135deg, #10b981, #059669);">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <div class="subtitle">Análise Concluída</div>
            <h2 class="title" id="result-title">Seu Resultado</h2>
            
            <div style="background: rgba(0,0,0,0.2); padding: 20px; border-radius: 16px; margin-bottom: 24px; border: 1px solid var(--card-border);">
                <p class="description" id="result-description" style="margin-bottom: 0; color: #fff; text-align: left;"></p>
            </div>

            <div class="email-form">
                <h3 style="color: white; margin-bottom: 15px; font-size: 18px;">Receba um relatório detalhado</h3>
                <div class="form-group">
                    <label class="form-label">Seu melhor E-mail</label>
                    <input type="email" id="user-email" class="form-input" placeholder="exemplo@email.com" required>
                </div>
                <button class="btn-primary" id="send-email-btn" onclick="sendEmailResult()">
                    <span id="btn-text">Enviar para meu E-mail</span>
                    <div class="loader" id="btn-loader"></div>
                </button>
                <div id="email-feedback" style="margin-top: 15px; font-size: 14px; text-align: center; display: none;"></div>
            </div>

            <button class="btn-primary" onclick="location.reload()" style="background: transparent; border: 1px solid var(--card-border); margin-top: 20px; box-shadow: none;">
                Refazer Avaliação
            </button>
        </div>

    </div>

    <script>
        // Array de Perguntas
        const questions = [
            {
                question: "Qual o seu Gênero?",
                options: [
                    { text: "Homem", score: 3 },
                    { text: "Mulher", score: 3 },
                    { text: "Prefiro não dizer", score: 3 }
                ]
            },
            {
                question: "Qual o sua Idade?",
                options: [
                    { text: "Menos de 25 anos", score: 3 },
                    { text: "25 a 35 anos", score: 3 },
                    { text: "36 a 45 anos", score: 3 },
                    { text: "46 anos ou mais", score: 3 }
                ]
            },
            {
                question: "Você se considera uma pessoa:",
                options: [
                    { text: "Extrovertido(a)", score: 3 },
                    { text: "Introvertido(a)", score: 2 },
                    { text: "Ambivertido(a)", score: 1 },
                    { text: "Não tenho certeza", score: 0 }
                ]
            },
            {
                question: "Qual é o seu principal objetivo ao responder este quiz?",
                options: [
                    { text: "Aprender mais sobre como estabelecer limites", score: 3 },
                    { text: "Encontrar uma solução para minha dificuldade em dizer não", score: 2 },
                    { text: "Verificar se minha dificuldade é comum", score: 1 },
                    { text: "Apenas Curiosidade", score: 0 }
                ]
            },
            {
                question: "Como você geralmente se sente ao final de um dia cheio de compromissos?",
                options: [
                    { text: "Exausto(a), como se tivesse sido puxado(a) em várias direções.", score: 3 },
                    { text: "Cansado(a), mas satisfeito(a) por ter ajudado os outros.", score: 2 },
                    { text: "Moderadamente cansado(a), mas consegui fazer o que precisava.", score: 1 },
                    { text: "Energizado(a) e pronto(a) para mais.", score: 0 }
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
                question: "Você já se sentiu pressionado(a) a participar de eventos sociais que não queria?",
                options: [
                    { text: "Às vezes consigo escapar, mas se for um evento importante, vou.", score: 3 },
                    { text: "Vou a todos, pois não quero que pensem que sou antissocial.", score: 2 },
                    { text: "Tento evitar, mas se insistirem, acabo indo.", score: 1 },
                    { text: "Geralmente não vou, mas fico preocupado(a) com a impressão que estou passando ao não ir.", score: 0 }
                ]
            },
            {
                question: "Você já aceitou um convite para sair mesmo estando extremamente cansado(a)?",
                options: [
                    { text: "Algumas vezes consigo recusar, mas se insistirem muito, acabo indo.", score: 3 },
                    { text: "Geralmente aceito para evitar conflitos.", score: 2 },
                    { text: "Aceito sempre, pois não gosto de desapontar as pessoas.", score: 1 },
                    { text: "Normalmente recuso, mas depois fico pensando se deveria ter ido.", score: 0 }
                ]
            },
            {
                question: "Você tem dificuldade em pedir tempo ou espaço para si mesmo(a)?",
                options: [
                    { text: "Peço algumas vezes, mas me preocupo que os outros pensem que estou fugindo das responsabilidades.", score: 3 },
                    { text: "Peço quando preciso, mas fico refletindo se fiz a coisa certa ou se poderia ter aguentado mais.", score: 2 },
                    { text: "Nunca peço, pois acho que serei visto como fraco ou egoísta.", score: 1 },
                    { text: "Peço, mas só quando estou no meu limite, o que me deixa ansioso(a).", score: 0 }
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
                question: "O que você acha que conseguiria fazer se fosse mais capaz de dizer \"NÃO\"?",
                options: [
                    { text: "Aceito imediatamente, mesmo estando ocupado(a)", score: 3 },
                    { text: "Finalmente teria tempo para mim.", score: 2 },
                    { text: "Melhoraria meus relacionamentos.", score: 1 },
                    { text: "Teria mais paz e menos estresse.", score: 0 }
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
                question: "O que você gostaria de alcançar se fosse capaz de se posicionar e se fazer respeitar mais?",
                options: [
                    { text: "Um estilo de vida mais equilibrado.", score: 3 },
                    { text: "Sentir-se mais empoderado e confiante.", score: 2 },
                    { text: "Relacionamentos mais saudáveis, equilibrados e respeitosos.", score: 1 },
                    { text: "Maior realização pessoal e profissional.", score: 0 }
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
        let selectedOptionScore = null;
        let userAnswers = [];
        let finalResultData = {};

        function switchView(viewId) {
            document.querySelectorAll('.view-section').forEach(el => {
                el.classList.remove('active');
                setTimeout(() => el.style.display = 'none', 400);
            });
            
            setTimeout(() => {
                const target = document.getElementById(viewId);
                target.style.display = 'block';
                // Trigger reflow
                void target.offsetWidth;
                target.classList.add('active');
            }, 400);
        }

        function startQuiz() {
            switchView('view-quiz');
            loadQuestion();
        }

        function loadQuestion() {
            const questionData = questions[currentQuestion];
            document.getElementById('question-text').textContent = questionData.question;
            
            // Atualizar Progresso
            const currentNum = currentQuestion + 1;
            const totalNum = questions.length;
            const progressPercent = ((currentNum) / totalNum) * 100;
            
            document.getElementById('progress-count').textContent = `Pergunta ${currentNum} de ${totalNum}`;
            document.getElementById('progress-percentage').textContent = `${Math.round(progressPercent)}%`;
            document.getElementById('progress-bar').style.width = `${progressPercent}%`;

            // Gerar Opções
            const optionsContainer = document.getElementById('options-container');
            optionsContainer.innerHTML = '';
            selectedOptionScore = null;
            document.getElementById('next-btn').disabled = true;
            document.getElementById('next-btn').classList.add('disabled');

            questionData.options.forEach((opt, index) => {
                const optEl = document.createElement('div');
                optEl.className = 'option-card';
                optEl.innerHTML = `
                    <div class="option-indicator"></div>
                    <div class="option-text">${opt.text}</div>
                `;
                optEl.onclick = () => selectOption(index, opt);
                optionsContainer.appendChild(optEl);
            });
        }

        function selectOption(index, optData) {
            document.querySelectorAll('.option-card').forEach(el => el.classList.remove('selected'));
            document.querySelectorAll('.option-card')[index].classList.add('selected');
            selectedOptionScore = optData.score;
            
            // Guardar a resposta literal para enviar ao backend
            userAnswers[currentQuestion] = {
                question: questions[currentQuestion].question,
                answer: optData.text,
                score: optData.score
            };

            const nextBtn = document.getElementById('next-btn');
            nextBtn.disabled = false;
            nextBtn.classList.remove('disabled');
        }

        function nextQuestion() {
            if (selectedOptionScore === null) return;
            
            totalScore += selectedOptionScore;
            currentQuestion++;

            if (currentQuestion < questions.length) {
                // Efeito de transição de pergunta
                const quizSection = document.getElementById('view-quiz');
                quizSection.style.opacity = '0';
                quizSection.style.transform = 'translateY(10px)';
                
                setTimeout(() => {
                    loadQuestion();
                    quizSection.style.opacity = '1';
                    quizSection.style.transform = 'translateY(0)';
                }, 300);
            } else {
                finishQuiz();
            }
        }

        function finishQuiz() {
            switchView('view-loading');
            
            // Definir o resultado baseado no score (0 a 45)
            let title, description;
            
            if (totalScore >= 30) {
                title = "Nível Crítico - Precisa de Atenção Urgente";
                description = "Sua dificuldade em estabelecer limites está impactando significativamente sua vida. É importante buscar estratégias para desenvolver essa habilidade e recuperar o controle sobre seu tempo e energia.";
            } else if (totalScore >= 18) {
                title = "Nível Moderado - Há Espaço para Melhoria";
                description = "Você tem algumas dificuldades em dizer não e estabelecer limites, mas ainda consegue manter certo controle. Desenvolver essas habilidades pode trazer mais equilíbrio para sua vida.";
            } else if (totalScore >= 9) {
                title = "Nível Baixo - Você Está no Caminho Certo";
                description = "Você já tem uma boa noção de como estabelecer limites, mas ainda pode aprimorar essas habilidades para ter ainda mais controle sobre sua vida pessoal e profissional.";
            } else {
                title = "Parabéns! Você Tem Limites Saudáveis";
                description = "Você demonstra uma excelente capacidade de estabelecer e manter limites saudáveis. Continue assim e sirva de exemplo para outras pessoas ao seu redor.";
            }

            finalResultData = { title, description, score: totalScore };
            
            document.getElementById('result-title').textContent = title;
            document.getElementById('result-description').textContent = description;

            // Salvar no Backend via Fetch API
            saveResultToDB();
        }

        function saveResultToDB() {
            fetch('process.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'save_result',
                    score: totalScore,
                    answers: userAnswers
                })
            })
            .then(res => res.json())
            .then(data => {
                console.log("Salvo no banco:", data);
            })
            .catch(err => console.error("Erro ao salvar:", err))
            .finally(() => {
                // Mostrar resultado após pequeno delay visual
                setTimeout(() => {
                    switchView('view-result');
                }, 1500);
            });
        }

        function sendEmailResult() {
            const email = document.getElementById('user-email').value;
            const feedback = document.getElementById('email-feedback');
            const btn = document.getElementById('send-email-btn');
            const btnText = document.getElementById('btn-text');
            const loader = document.getElementById('btn-loader');

            if (!email || !email.includes('@')) {
                feedback.textContent = 'Por favor, insira um e-mail válido.';
                feedback.style.color = '#ef4444';
                feedback.style.display = 'block';
                return;
            }

            // UI State Loading
            btn.disabled = true;
            btnText.style.display = 'none';
            loader.style.display = 'block';
            feedback.style.display = 'none';

            fetch('send_email.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `email=${encodeURIComponent(email)}&result=${encodeURIComponent(JSON.stringify(finalResultData))}`
            })
            .then(response => response.json())
            .then(data => {
                feedback.style.display = 'block';
                if (data.success) {
                    feedback.textContent = 'E-mail enviado com sucesso! Verifique sua caixa de entrada.';
                    feedback.style.color = '#10b981';
                    document.getElementById('user-email').value = '';
                } else {
                    feedback.textContent = 'Erro ao enviar e-mail: ' + (data.message || 'Tente novamente.');
                    feedback.style.color = '#ef4444';
                }
            })
            .catch(error => {
                feedback.style.display = 'block';
                feedback.textContent = 'Erro de conexão. Tente novamente mais tarde.';
                feedback.style.color = '#ef4444';
                console.error(error);
            })
            .finally(() => {
                btn.disabled = false;
                btnText.style.display = 'block';
                loader.style.display = 'none';
            });
        }
    </script>
</body>
</html>