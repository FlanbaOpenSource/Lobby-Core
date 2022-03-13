<?php

namespace DidntPot\items\types;

use DidntPot\forms\types\GameSelectorForm;
use DidntPot\items\LobbyItem;
use pocketmine\item\ItemIds;
use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class GameSelectorItem extends LobbyItem
{
    public function __construct()
    {
        parent::__construct("{GOLD}Game Selector", ItemIds::COMPASS);
    }

    /**
     * @param Player $player
     * @param Vector3 $directionVector
     * @return ItemUseResult
     */
    public function onClickAir(Player $player, Vector3 $directionVector): ItemUseResult
    {
        $player->sendForm(new GameSelectorForm());
        return ItemUseResult::SUCCESS();
    }
}