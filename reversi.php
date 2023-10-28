<?php
namespace Reversi;
require_once __DIR__ . '/vendor/autoload.php';

$game = new Game();

$game->board[4][4] = new Stone(Color::White);
$game->board[4][5] = new Stone(Color::Black);
$game->board[5][4] = new Stone(Color::Black);
$game->board[5][5] = new Stone(Color::White);

while ($game->end_flag !== true) {
    if ($game->canPlay() === false) {
        $game->pass();
        continue;
    }
    $game->draw();
    $turn = $game->turn === Color::Black ? '黒' : '白';
    echo "\n";
    echo "次は {$turn} の番です\n";
    echo "どこに置きますか？\n";
    echo "x座標(1~8): ";
    $x = (int)trim(fgets(STDIN));
    echo "y座標(a~h): ";
    $y = match ((string)trim(fgets(STDIN)))
    {
        'a' => 1,
        'b' => 2,
        'c' => 3,
        'd' => 4,
        'e' => 5,
        'f' => 6,
        'g' => 7,
        'h' => 8,
    };
    try {
        $game->play($x, $y);
    } catch (\Exception $e) {
        echo "\nそこには置けません\n";
    }
}

echo "\n----- ゲーム終了 -----\n";
$game->draw();
echo $game->result() . "\n";
