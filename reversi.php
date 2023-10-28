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
    echo "\n";
    $game->draw();
    $turn = $game->turn === Color::Black ? '黒' : '白';
    echo "\n";
    echo "次は {$turn} の番です\n";
    echo "どこに置きますか？: ";
    $input = trim(fgets(STDIN));
    try {
        $x = (int)substr($input, 0, 1);
        $y = match (substr($input, 1, 1))
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
    } catch (\Error $e) {
        echo sprintf("\033[%dm %s \033[m", 31, "\n座標の指定が誤っています\n");
        continue;
    }
    try {
        $game->play($x, $y);
    } catch (\Exception $e) {
        echo sprintf("\033[%dm %s \033[m", 31, "\nそこには置けません\n");
    }
}

echo "\n----- ゲーム終了 -----\n";
$game->draw();
echo $game->result() . "\n";
