<?php

namespace DidntPot\scoreboards;

use DidntPot\utils\ColorUtils;

// Credits: https://github.com/Flanba/Flanba-Core/blob/a27ae7deae1616c318f0fa693d1253f21e115bea/src/sergittos/flanbacore/utils/scoreboard/Line.php#L16
class Line
{
    /**
     * @var int
     */
    private int $score;
    /**
     * @var string
     */
    private string $text;

    /**
     * @param int $score
     * @param string $text
     */
    public function __construct(int $score, string $text)
    {
        $this->score = $score;
        $this->text = ColorUtils::translate($text);
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getText(): string
    {
        return $this->text;
    }
}