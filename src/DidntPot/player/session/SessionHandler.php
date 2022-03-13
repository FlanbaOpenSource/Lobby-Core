<?php

namespace DidntPot\player\session;

use DidntPot\player\session\types\PlayerSession;
use JetBrains\PhpStorm\Pure;
use pocketmine\player\Player;

class SessionHandler
{
    /** @var BasicSession[] */
    static private array $sessions = [];

    /**
     * @return BasicSession[]
     */
    static public function getSessions(): array
    {
        return self::$sessions;
    }

    /**
     * @param Player $player
     * @param int $type
     * @return BasicSession|null
     */
    #[Pure] static public function getSession(Player $player, int $type = 0): ?BasicSession
    {
        switch ($type) {
            case SessionIdentifier::PLAYER_SESSION:
                return self::$sessions[$player->getName()] ?? null;

            default:
                break;
        }

        return null;
    }

    /**
     * @param Player $player
     * @param int $type
     * @return void
     */
    static public function createSession(Player $player, int $type = 0): void
    {
        switch ($type) {
            case SessionIdentifier::PLAYER_SESSION:
                $session = new PlayerSession($player);
                self::$sessions[$player->getName()] = $session;
                break;

            default:
                break;
        }
    }

    /**
     * @param Player $player
     * @param int $type
     * @return void
     */
    static public function removeSession(Player $player, int $type): void
    {
        switch ($type) {
            case SessionIdentifier::PLAYER_SESSION:
                $session = self::$sessions[$player->getName()];
                unset($session);
                break;

            default:
                break;
        }
    }
}