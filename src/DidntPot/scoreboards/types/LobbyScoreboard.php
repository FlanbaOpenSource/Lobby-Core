<?php

namespace DidntPot\scoreboards\types;

use DidntPot\scoreboards\Scoreboard;
use DidntPot\utils\BasicUtils;
use sergittos\credentialsengine\CredentialsEngine;
use sergittos\credentialsengine\session\SessionFactory;

class LobbyScoreboard extends Scoreboard
{
    /**
     * @return string[]
     */
    public function getLines(): array
    {

        return [
            //" §eOnline: {WHITE}" . BasicUtils::getLobbyPlayers(true),
            " §eOnline: {WHITE}" . BasicUtils::$playerCount,
            " §eRank: {WHITE}" . class_exists(CredentialsEngine::class) ? " §eRank: {WHITE}" . SessionFactory::getSession($this->session->getPlayer())->getRank()->getName() : " §eRank: {WHITE}" . "N/A",
            " §fOpen Beta!"
        ];
    }
}