<?php
session_start();

// Initialize the game state if not exists
if (!isset($_SESSION['board'])) {
    $_SESSION['board'] = [
        7 => ['♜', '♞', '♝', '♛', '♚', '♝', '♞', '♜'],
        6 => ['♟', '♟', '♟', '♟', '♟', '♟', '♟', '♟'],
        5 => [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
        4 => [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
        3 => [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
        2 => [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
        1 => ['♙', '♙', '♙', '♙', '♙', '♙', '♙', '♙'],
        0 => ['♖', '♘', '♗', '♕', '♔', '♗', '♘', '♖']
    ];
    $_SESSION['currentTurn'] = 'white';
    $_SESSION['moveHistory'] = [];
}

// Handle AJAX requests for moves
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = ['success' => false, 'message' => ''];
    
    if ($_POST['action'] === 'move') {
        $from = json_decode($_POST['from']);
        $to = json_decode($_POST['to']);
        
        // Validate and make move
        if (isValidMove($from, $to)) {
            makeMove($from, $to);
            $response['success'] = true;
            $response['board'] = $_SESSION['board'];
            $response['currentTurn'] = $_SESSION['currentTurn'];
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

function isValidMove($from, $to) {
    // Basic move validation - can be expanded for proper chess rules
    return true;
}

function makeMove($from, $to) {
    $piece = $_SESSION['board'][$from[0]][$from[1]];
    $_SESSION['board'][$from[0]][$from[1]] = ' ';
    $_SESSION['board'][$to[0]][$to[1]] = $piece;
    $_SESSION['currentTurn'] = $_SESSION['currentTurn'] === 'white' ? 'black' : 'white';
    $_SESSION['moveHistory'][] = [
        'from' => $from,
        'to' => $to,
        'piece' => $piece
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chess Game</title>
    <style>
        .chess-board {
            width: 640px;
            height: 640px;
            border: 2px solid #333;
            display: grid;
            grid-template-columns: repeat(8, 1fr);
        }
        .cell {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            cursor: pointer;
            user-select: none;
        }
        .cell.white { background-color: #fff; }
        .cell.black { background-color: #ccc; }
        .cell.selected { background-color: #ffeb3b; }
        .cell.valid-move { background-color: #81c784; }
        .move-history {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            max-height: 200px;
            overflow-y: auto;
        }
        .game-info {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="game-info">
        Current Turn: <span id="currentTurn"><?php echo $_SESSION['currentTurn']; ?></span>
    </div>
    
    <div class="chess-board" id="chessBoard">
        <?php
        for ($row = 7; $row >= 0; $row--) {
            for ($col = 0; $col < 8; $col++) {
                $isWhite = ($row + $col) % 2 === 0;
                $cellClass = $isWhite ? 'white' : 'black';
                echo sprintf(
                    '<div class="cell %s" data-row="%d" data-col="%d">%s</div>',
                    $cellClass,
                    $row,
                    $col,
                    $_SESSION['board'][$row][$col]
                );
            }
        }
        ?>
    </div>

    <div class="move-history">
        <h3>Move History</h3>
        <div id="moveList"></div>
    </div>

    <script>
        let selectedCell = null;
        const board = document.getElementById('chessBoard');
        const moveList = document.getElementById('moveList');
        const currentTurnDisplay = document.getElementById('currentTurn');

        board.addEventListener('click', (e) => {
            const cell = e.target.closest('.cell');
            if (!cell) return;

            const row = parseInt(cell.dataset.row);
            const col = parseInt(cell.dataset.col);

            if (selectedCell === null) {
                if (cell.textContent.trim() === '') return;
                selectedCell = [row, col];
                cell.classList.add('selected');
                highlightValidMoves(row, col);
            } else {
                const [fromRow, fromCol] = selectedCell;
                makeMove(fromRow, fromCol, row, col);
                clearHighlights();
                selectedCell = null;
            }
        });

        function clearHighlights() {
            document.querySelectorAll('.cell').forEach(cell => {
                cell.classList.remove('selected', 'valid-move');
            });
        }

        function highlightValidMoves(row, col) {
            // Simplified valid moves - can be expanded for proper chess rules
            document.querySelectorAll('.cell').forEach(cell => {
                if (cell.textContent.trim() === '') {
                    cell.classList.add('valid-move');
                }
            });
        }

        function makeMove(fromRow, fromCol, toRow, toCol) {
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=move&from=${JSON.stringify([fromRow, fromCol])}&to=${JSON.stringify([toRow, toCol])}`,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateBoard(data.board);
                    currentTurnDisplay.textContent = data.currentTurn;
                    addMoveToHistory(fromRow, fromCol, toRow, toCol);
                }
            });
        }

        function updateBoard(boardData) {
            const cells = document.querySelectorAll('.cell');
            cells.forEach(cell => {
                const row = parseInt(cell.dataset.row);
                const col = parseInt(cell.dataset.col);
                cell.textContent = boardData[row][col];
            });
        }

        function addMoveToHistory(fromRow, fromCol, toRow, toCol) {
            const files = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
            const ranks = ['1', '2', '3', '4', '5', '6', '7', '8'];
            const moveText = `${files[fromCol]}${ranks[fromRow]} → ${files[toCol]}${ranks[toRow]}`;
            
            const moveEntry = document.createElement('div');
            moveEntry.textContent = moveText;
            moveList.appendChild(moveEntry);
            moveList.scrollTop = moveList.scrollHeight;
        }
    </script>
</body>
</html>