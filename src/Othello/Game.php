<?php

namespace Reversi;

class Game
{
    public array $board;
    public Color $turn = Color::Black;
    public bool $pass_flag = false;
    public bool $end_flag = false;

    public function __construct()
    {
        $this->board = array_fill(1, 8, array_fill(1, 8, null));
        // $this->board[4][4] = new Stone(Color::White);
        // $this->board[4][5] = new Stone(Color::Black);
        // $this->board[5][4] = new Stone(Color::Black);
        // $this->board[5][5] = new Stone(Color::White);
    }

    public function draw()
    {
        echo "  a b c d e f g h\n";
        foreach ($this->board as $y => $row) {
            echo $y . ' ';
            foreach ($row as $cell) {
                if ($cell === null) {
                    echo '-';
                } elseif ($cell->color === Color::Black) {
                    echo 'x';
                } elseif ($cell->color === Color::White) {
                    echo 'o';
                }
                echo ' ';
            }
            echo "\n";
        }
    }

    // public function finish()
    // {
    //     echo "\n----- ゲーム終了 -----\n";
    //     $this->draw();
    // }

    private function canPlay(): bool
    {
        foreach (range(1, 8) as $x) {
            foreach (range(1, 8) as $y) {
                if ($this->canPut($x, $y, $this->turn)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function play($x, $y): void
    {
        $this->put($x, $y);
        $this->pass_flag = false;
        // 石を置いた場合はターンを変更
        $this->turn = $this->turn === Color::Black ? Color::White : Color::Black;
        
        // 全てのセルを確認して置ける場所がない場合はパスさせる
        if ($this->canPlay()) {
            return;
        } else {
            $this->turn = $this->turn === Color::Black ? Color::White : Color::Black;
            if ($this->pass_flag) {
                $this->end_flag = true;
            }
            $this->pass_flag = true;
        }

        // 2回連続でパスされた場合はゲーム終了
        if ($this->canPlay()) {
            return;
        } else {
            $this->turn = $this->turn === Color::Black ? Color::White : Color::Black;
            if ($this->pass_flag) {
                $this->end_flag = true;
            }
            $this->pass_flag = true;
        }
    }

    public function put($x, $y)
    {
        if (!$this->canPut($x, $y, $this->turn)) {
            throw new \Exception('Cannot put');
        }
        $this->board[$x][$y] = new Stone($this->turn);

        // 挟める場合は挟んだ石をひっくり返す
        foreach ([-1, 0, 1] as $dx) {
            foreach ([-1, 0, 1] as $dy) {
                if ($dx === 0 && $dy === 0) {
                    continue;
                }
                $temp_x = $x;
                $temp_y = $y;
                $other_color_flag = false;
                while (true) {
                    $temp_x += $dx;
                    $temp_y += $dy;
                    if ($temp_x < 1 || $temp_x > 8 || $temp_y < 1 || $temp_y > 8) {
                        break;
                    }
                    if ($this->board[$temp_x][$temp_y] === null) {
                        break;
                    }
                    if ($this->board[$temp_x][$temp_y]->color === $this->turn) {
                        // 同じ色になったらフラグを確認して挟める石をひっくり返す
                        if ($other_color_flag) {
                            $temp_x = $x;
                            $temp_y = $y;
                            while (true) {
                                $temp_x += $dx;
                                $temp_y += $dy;
                                if ($temp_x < 1 || $temp_x > 8 || $temp_y < 1 || $temp_y > 8) {
                                    break;
                                }
                                if ($this->board[$temp_x][$temp_y]->color === $this->turn) {
                                    break;
                                }
                                $this->flip($temp_x, $temp_y);
                            }
                        } else {
                            break;
                        }
                    } else {
                        // 違う色の場合はフラグを立てる
                        $other_color_flag = true;
                    }
                }
            }
        }
    }

    public function flip($x, $y)
    {
        $this->board[$x][$y]->flip();
    }

    public function canPut(int $x, int $y, Color $color)
    {
        // すでに石がある場合は置けない
        if ($this->board[$x][$y] !== null) {
            return false;
        }
        // 挟めなければ置けない
        foreach ([-1, 0, 1] as $dx) {
            foreach ([-1, 0, 1] as $dy) {
                if ($dx === 0 && $dy === 0) {
                    continue;
                }
                $temp_x = $x;
                $temp_y = $y;
                $other_color_flag = false;
                while (true) {
                    $temp_x += $dx;
                    $temp_y += $dy;
                    if ($temp_x < 1 || $temp_x > 8 || $temp_y < 1 || $temp_y > 8) {
                        break;
                    }
                    if ($this->board[$temp_x][$temp_y] === null) {
                        break;
                    }
                    if ($this->board[$temp_x][$temp_y]->color === $color) {
                        // 同じ色になったらフラグを確認して挟めるかどうかを返す
                        if ($other_color_flag) {
                            return true;
                        } else {
                            break;
                        }
                    } else {
                        // 違う色の場合はフラグを立てる
                        $other_color_flag = true;
                    }
                }
            }
        }

        return false;
    }
}
