<?php

namespace DidntPot\items\types;

use DidntPot\items\LobbyItem;
use pocketmine\item\ItemIds;
use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class SocialItem extends LobbyItem
{
    public function __construct()
    {
        parent::__construct("§aSocialMenu §8[Use]", 403);
    }

    /**
     * @param Player $player
     * @param Vector3 $directionVector
     * @return ItemUseResult
     */
    public function onClickAir(Player $player, Vector3 $directionVector): ItemUseResult
    {
        return ItemUseResult::SUCCESS();
    }
}
