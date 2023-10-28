<?php

namespace Reversi;

enum Color: int {
    case Black = 1;
    case White = 2;

    public function toggle(): Color {
        return match ($this) {
            Color::Black => Color::White,
            Color::White => Color::Black,
        };
    }
}