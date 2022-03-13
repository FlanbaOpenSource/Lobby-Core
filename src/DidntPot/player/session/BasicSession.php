<?php

namespace DidntPot\player\session;

use pocketmine\player\Player;

abstract class BasicSession
{
    /** @var Player */
    public Player $player;

    /**
     * @param Player $player
     */
    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }
}