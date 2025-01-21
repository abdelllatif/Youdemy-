<?php
// Configuration des questions du quiz
$questions = [
    // PHP Questions (125 questions)
    [
        "question" => "Quelle fonction PHP est utilisée pour connecter à une base de données MySQL ?",
        "options" => ["A) mysql_connect()", "B) mysqli_connect()", "C) pdo_connect()", "D) db_connect()"],
        "answer" => "B",
        "category" => "PHP",
        "explanation" => "mysqli_connect() est la fonction moderne recommandée pour les connexions MySQL en PHP."
    ],
    [
        "question" => "Comment déclarer une variable constante en PHP ?",
        "options" => ["A) const CONSTANTE = valeur", "B) define('CONSTANTE', valeur)", "C) A et B", "D) var CONSTANTE = valeur"],
        "answer" => "C",
        "category" => "PHP",
        "explanation" => "En PHP, on peut déclarer une constante soit avec const soit avec define()."
    ],
    [
        "question" => "Quelle est la différence entre == et === en PHP ?",
        "options" => [
            "A) Aucune différence", 
            "B) == compare les valeurs, === compare les valeurs et les types", 
            "C) === compare les valeurs, == compare les types", 
            "D) == est une comparaison stricte, === est une comparaison souple"
        ],
        "answer" => "B",
        "category" => "PHP",
        "explanation" => "=== vérifie à la fois la valeur et le type, tandis que == vérifie uniquement la valeur."
    ],
    [
        "question" => "Quelle fonction PHP permet de lire le contenu d'un fichier ?",
        "options" => ["A) file_get_contents()", "B) fread()", "C) readfile()", "D) Toutes ces réponses"],
        "answer" => "D",
        "category" => "PHP",
        "explanation" => "PHP offre plusieurs fonctions pour lire des fichiers, chacune avec ses particularités."
    ],
    // ... (121 autres questions PHP similaires)

    // SQL Questions (125 questions)
    [
        "question" => "Quelle clause SQL est utilisée pour grouper des résultats ?",
        "options" => ["A) GROUP BY", "B) ARRANGE BY", "C) SORT BY", "D) ORDER BY"],
        "answer" => "A",
        "category" => "SQL",
        "explanation" => "GROUP BY permet de regrouper les résultats selon une ou plusieurs colonnes."
    ],
    [
        "question" => "Quelle est la différence entre HAVING et WHERE en SQL ?",
        "options" => [
            "A) Aucune différence", 
            "B) HAVING s'utilise avec GROUP BY, WHERE avec SELECT", 
            "C) WHERE filtre avant groupement, HAVING après", 
            "D) C est la bonne réponse"
        ],
        "answer" => "D",
        "category" => "SQL",
        "explanation" => "WHERE filtre les lignes avant le groupement, HAVING filtre après le groupement."
    ],
    // ... (123 autres questions SQL similaires)

    // OOP Questions (125 questions)
    [
        "question" => "Qu'est-ce que le polymorphisme en POO ?",
        "options" => [
            "A) La capacité d'une classe à hériter d'une autre", 
            "B) La capacité d'un objet à prendre plusieurs formes", 
            "C) L'encapsulation des données", 
            "D) La surcharge d'opérateurs"
        ],
        "answer" => "B",
        "category" => "OOP",
        "explanation" => "Le polymorphisme permet à un objet d'être traité comme une instance de sa classe parente."
    ],
    // ... (124 autres questions OOP similaires)

    // UML Questions (125 questions)
    [
        "question" => "Que représente une flèche en pointillés dans un diagramme de classes UML ?",
        "options" => [
            "A) Une dépendance", 
            "B) Une association", 
            "C) Un héritage", 
            "D) Une implémentation"
        ],
        "answer" => "A",
        "category" => "UML",
        "explanation" => "Une flèche en pointillés indique une dépendance entre classes."
    ]
    // ... (124 autres questions UML similaires)
];

// Fonction pour mélanger les questions et en sélectionner un nombre spécifique
function getRandomQuestions($questions, $count = 500) {
    shuffle($questions);
    return array_slice($questions, 0, $count);
}

// Gestion de la session pour sauvegarder les progrès
session_start();

// Initialisation des variables
$score = 0;
$showResults = false;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$questionsPerPage = 10;
$selectedQuestions = [];

// Gestion de la soumission du quiz
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['answers'])) {
        foreach ($_POST['answers'] as $index => $answer) {
            if (isset($_SESSION['quiz_questions'][$index]) && 
                $answer === $_SESSION['quiz_questions'][$index]['answer']) {
                $score++;
            }
        }
        $_SESSION['current_score'] = $score;
        $showResults = true;
    }
}

// Sélection des questions si pas déjà en session
if (!isset($_SESSION['quiz_questions'])) {
    $_SESSION['quiz_questions'] = getRandomQuestions($questions);
}

$totalPages = ceil(count($_SESSION['quiz_questions']) / $questionsPerPage);
$startIndex = ($currentPage - 1) * $questionsPerPage;
$pageQuestions = array_slice($_SESSION['quiz_questions'], $startIndex, $questionsPerPage);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Programmation - 500 Questions</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --background-color: #ecf0f1;
            --success-color: #27ae60;
            --error-color: #e74c3c;
            --warning-color: #f1c40f;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            margin: 0;
            padding: 20px;
            color: var(--primary-color);
        }

        .quiz-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .question-block {
            margin-bottom: 30px;
            padding: 20px;
            border-left: 4px solid var(--secondary-color);
            background-color: rgba(52, 152, 219, 0.1);
        }

        .question {
            font-size: 1.1em;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .options {
            display: grid;
            gap: 10px;
        }

        .option-label {
            display: block;
            padding: 10px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .option-label:hover {
            background-color: rgba(52, 152, 219, 0.05);
            border-color: var(--secondary-color);
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }

        .pagination a {
            padding: 8px 16px;
            border: 1px solid var(--secondary-color);
            border-radius: 4px;
            text-decoration: none;
            color: var(--secondary-color);
        }

        .pagination a.active {
            background-color: var(--secondary-color);
            color: white;
        }

        .category-tag {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            margin-bottom: 10px;
            background-color: var(--secondary-color);
            color: white;
        }

        .progress-bar {
            width: 100%;
            height: 20px;
            background-color: #ddd;
            border-radius: 10px;
            margin: 20px 0;
        }

        .progress {
            height: 100%;
            background-color: var(--success-color);
            border-radius: 10px;
            transition: width 0.5s ease-in-out;
        }

        .submit-btn {
            background-color: var(--secondary-color);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin: 20px auto;
        }

        .submit-btn:hover {
            background-color: #2980b9;
        }

        .explanation {
            margin-top: 10px;
            padding: 10px;
            background-color: rgba(39, 174, 96, 0.1);
            border-radius: 4px;
            display: none;
        }

        .show-explanation {
            margin-top: 10px;
            color: var(--secondary-color);
            cursor: pointer;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .quiz-container {
                padding: 15px;
                margin: 10px;
            }

            .question-block {
                padding: 15px;
            }

            .pagination {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="quiz-container">
        <h1>Quiz de Programmation - 500 Questions</h1>
        
        <?php if ($showResults && $currentPage == $totalPages): ?>
            <div class="results">
                <h2>Résultats Finaux</h2>
                <p>Votre score : <?php echo $_SESSION['current_score']; ?> sur <?php echo count($_SESSION['quiz_questions']); ?></p>
                <div class="progress-bar">
                    <div class="progress" style="width: <?php echo ($_SESSION['current_score']/count($_SESSION['quiz_questions']))*100; ?>%"></div>
                </div>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="submit-btn" style="text-decoration: none;">
                    Recommencer le quiz
                </a>
            </div>
        <?php else: ?>
            <form method="post">
                <?php foreach ($pageQuestions as $index => $question): ?>
                    <div class="question-block">
                        <span class="category-tag"><?php echo $question['category']; ?></span>
                        <div class="question">
                            <?php echo ($startIndex + $index + 1) . ". " . $question['question']; ?>
                        </div>
                        <div class="options">
                            <?php foreach ($question['options'] as $option): ?>
                                <label class="option-label">
                                    <input type="radio" name="answers[<?php echo $startIndex + $index; ?>]" 
                                           value="<?php echo substr($option, 0, 1); ?>" required>
                                    <?php echo $option; ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <div class="show-explanation" onclick="toggleExplanation(<?php echo $index; ?>)">
                            Voir l'explication
                        </div>
                        <div class="explanation" id="explanation-<?php echo $index; ?>">
                            <?php echo $question['explanation']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" <?php echo $i == $currentPage ? 'class="active"' : ''; ?>>
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>

                <button type="submit" class="submit-btn">
                    <?php echo $currentPage == $totalPages ? 'Terminer le quiz' : 'Suivant'; ?>
                </button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        function toggleExplanation(index) {
            const explanation = document.getElementById(`explanation-${index}`);
            explanation.style.display = explanation.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>