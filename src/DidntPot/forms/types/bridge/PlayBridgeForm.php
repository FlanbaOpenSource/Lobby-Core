<?php

namespace DidntPot\forms\types\bridge;

use alemiz\sga\StarGateAtlantis;
use EasyUI\element\Button;
use EasyUI\variant\SimpleForm;
use pocketmine\player\Player;

class PlayBridgeForm extends SimpleForm
{
    public function __construct()
    {
        parent::__construct("Play Bridge");
    }

    /**
     * @return void
     */
    protected function onCreation(): void
    {

        $this->addButton(new Button("§l§bSOLOS", null, function (Player $player) {
            StarGateAtlantis::getInstance()->transferPlayer($player, "bridge-solo-1");
        }));

        $this->addButton(new Button("§e§lDUOS", null, function (Player $player) {
            StarGateAtlantis::getInstance()->transferPlayer($player, "bridge-duos-1");
        }));

        $this->addButton(new Button("§a§lTRIOS", null, function (Player $player) {
            StarGateAtlantis::getInstance()->transferPlayer($player, "bridge-trios-1");
        }));

        $this->addButton(new Button("§c§lSQUADS", null, function (Player $player) {
            StarGateAtlantis::getInstance()->transferPlayer($player, "bridge-squads-1");
        }));
    }
}
