<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Estabelecer Limites</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                        { text: "Apenas Curiosidade", score: 0 },
                    ]
                },
                {
                    question: "Como você geralmente se sente ao final de um dia cheio de compromissos?",
                    options: [
                        { text: "Exausto(a), como se tivesse sido puxado(a) em várias direções.", score: 3 },
                        { text: "Cansado(a), mas satisfeito(a) por ter ajudado os outros.", score: 2 },
                        { text: "Moderadamente cansado(a), mas consegui fazer o que precisava.", score: 1 },
                        { text: "Energizado(a) e pronto(a) para mais.", score: 0 },
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
            let selectedOption = null;

            function showQuestion() {
                const question = questions[currentQuestion];
                document.getElementById('question-text').textContent = question.question;
                
                // Update progress bar
                const progress = ((currentQuestion + 1) / questions.length) * 100;
                document.getElementById('progress').style.width = `${progress}%`;
                
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
                document.querySelectorAll('.option').forEach(opt => opt.classList.remove('selected'));
                document.querySelectorAll('.option')[index].classList.add('selected');
                selectedOption = score;
                document.getElementById('next-btn').classList.add('active');
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

            function startQuiz() {
                document.getElementById('intro').style.display = 'none';
                document.getElementById('quiz').style.display = 'block';
                document.getElementById('result').style.display = 'none';
                currentQuestion = 0;
                totalScore = 0;
                selectedOption = null;
                showQuestion();
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

            function restartQuiz() {
                currentQuestion = 0;
                totalScore = 0;
                selectedOption = null;
                document.getElementById('result').style.display = 'none';
                document.getElementById('intro').style.display = 'block';
            }

            document.getElementById('start-btn').addEventListener('click', startQuiz);
            document.getElementById('next-btn').addEventListener('click', nextQuestion);
            document.getElementById('restart-btn').addEventListener('click', restartQuiz);

            // Add email sharing functionality
            document.getElementById('share-btn').addEventListener('click', function() {
                const email = document.getElementById('share-email').value;
                const result = {
                    title: document.getElementById('result-title').textContent,
                    description: document.getElementById('result-description').textContent
                };

                if (!email) {
                    alert('Por favor, digite um email válido');
                    return;
                }

                fetch('send_email.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `email=${encodeURIComponent(email)}&result=${encodeURIComponent(JSON.stringify(result))}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Email enviado com sucesso!');
                        document.getElementById('share-email').value = '';
                    } else {
                        alert('Erro ao enviar email: ' + (data.debug || data.message));
                        console.error('Email Error:', data);
                    }
                })
                .catch(error => {
                    alert('Erro ao enviar email. Por favor, tente novamente.');
                    console.error('Error:', error);
                });
            });
        });
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #1e293b;
        }

        .quiz-container {
            background: white;
            border-radius: 24px;
            padding: 48px;
            max-width: 680px;
            width: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
            transition: all 0.3s ease;
        }

        .icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 32px;
            color: white;
            font-size: 28px;
            font-weight: bold;
            box-shadow: 0 10px 20px -5px rgba(2, 132, 199, 0.3);
        }

        .subtitle {
            color: #0284c7;
            font-size: 15px;
            margin-bottom: 24px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .title {
            color: #0f172a;
            font-size: 28px;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 32px;
        }

        .description {
            color: #475569;
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 24px;
            text-align: left;
        }

        .start-btn, .next-btn, .restart-btn {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: white;
            border: none;
            padding: 14px 36px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 24px;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.2);
        }

        .start-btn:hover, .next-btn:hover.active, .restart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(2, 132, 199, 0.3);
        }

        .question-container {
            display: none;
        }

        .question {
            font-size: 20px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 32px;
            text-align: left;
            line-height: 1.5;
        }

        .options {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 32px;
        }

        .option {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px 24px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
            font-size: 16px;
            color: #334155;
        }

        .option:hover {
            border-color: #0284c7;
            background: #f0f9ff;
            transform: translateY(-1px);
        }

        .option.selected {
            border-color: #0284c7;
            background: #f0f9ff;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.1);
        }

        .next-btn {
            opacity: 0.5;
            pointer-events: none;
        }

        .next-btn.active {
            opacity: 1;
            pointer-events: auto;
        }

        .result-container {
            display: none;
        }

        .result-title {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 24px;
            line-height: 1.4;
        }

        .result-description {
            color: #475569;
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 32px;
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            margin-bottom: 32px;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            background: linear-gradient(90deg, #0284c7 0%, #0369a1 100%);
            transition: width 0.3s ease;
        }

        @media (max-width: 640px) {
            .quiz-container {
                padding: 32px 24px;
            }

            .title {
                font-size: 24px;
            }

            .question {
                font-size: 18px;
            }

            .option {
                padding: 16px 20px;
            }
        }
        .logo {
            position: absolute;
            top: 60px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
        }

        .email-share {
            margin: 20px 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }

        .email-input {
            width: 100%;
            max-width: 400px;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .email-input:focus {
            outline: none;
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
        }

        .share-btn {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.2);
        }

        .share-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(2, 132, 199, 0.3);
        }
    </style>
</head>
<body>
    <img src="assets/img/lg.webp" alt="Logo" width="300px" class="logo">
    <div class="quiz-container">
        <!-- Tela Inicial -->
        <div id="intro" class="intro-container">
            <div class="icon">!</div>
            <div class="subtitle">Avaliação Profissional</div>
            <h1 class="title">Como a dificuldade de dizer "NÃO" e estabelecer limites pode estar afetando sua vida?</h1>
            <p class="description">
                Você já se sentiu sobrecarregado por não conseguir estabelecer limites claros? A incapacidade de dizer "NÃO" pode impactar diversos aspectos da sua vida, desde sua saúde mental até seus relacionamentos pessoais e profissionais.
            </p>
            <p class="description">
                Ao responder ao nosso quiz, você entenderá melhor como essa dificuldade está influenciando seu dia a dia e descobrirá uma solução poderosa que pode mudar essa situação, permitindo que você viva com mais equilíbrio e satisfação.
            </p>
            <button class="start-btn" id="start-btn">Iniciar Avaliação</button>
        </div>

        <!-- Container das Perguntas -->
        <div id="quiz" class="question-container">
            <div class="progress-bar">
                <div class="progress" id="progress"></div>
            </div>
            <div class="question" id="question-text"></div>
            <div class="options" id="options"></div>
            <button class="next-btn" id="next-btn">Próxima Pergunta</button>
        </div>

        <!-- Resultado -->
        <div id="result" class="result-container">
            <div class="icon">✓</div>
            <h2 class="result-title" id="result-title"></h2>
            <p class="result-description" id="result-description"></p>
            <div class="email-share">
                <input type="email" id="share-email" placeholder="Digite seu email para receber o resultado" class="email-input">
                <button class="share-btn" id="share-btn">Compartilhar por Email</button>
            </div>
            <button class="restart-btn" id="restart-btn">Refazer Avaliação</button>
        </div>
    </div>
</body>
</html>