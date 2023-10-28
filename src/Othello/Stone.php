<?php

namespace Reversi;

class Stone
{
    public Color $color;

    public function __construct(Color $color)
    {
        $this->color = $color;
    }

    public function flip()
    {
        $this->color = $this->color === Color::Black ? Color::White : Color::Black;
    }
}
