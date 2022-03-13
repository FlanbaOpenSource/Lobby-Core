<?php

namespace DidntPot\utils;

use DidntPot\LobbyCore;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\world\World;
use DidntPot\query\PMQuery;
use DidntPot\query\PmQueryException;

class BasicUtils
{
    /**
     * @var string
     */
    public const IP = "flanba.net";

    /**
     * @var string[]
     */
    public const BRIDGE_IPS = ['104.128.58.163:19133'];

    /**
     * @var ?string[]
     */
    public const BRIDGE_IPS_INFO = null;

    /**
     * @var string
     */
    public const LOBBY_NAME = "lobby";

    public static int $playerCount = 0;

    /**
     * @return bool
     */
    public static function loadLobbyWorld(): bool
    {
        return Server::getInstance()->getWorldManager()->loadWorld(self::LOBBY_NAME);
    }

    /**
     * @param bool $count
     * @return array|int
     */
    public static function getLobbyPlayers(bool $count = false): array|int
    {
        return match ($count) {
            false => self::getLobbyWorld()->getPlayers(),
            true => count(self::getLobbyWorld()->getPlayers())
        };
    }

    /**
     * @return World
     */
    public static function getLobbyWorld(): World
    {
        return LobbyCore::getInstance()->getServer()->getWorldManager()->getWorldByName(self::LOBBY_NAME);
    }
}