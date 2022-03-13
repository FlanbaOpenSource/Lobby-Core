<?php

namespace DidntPot\forms\types;

use DidntPot\forms\types\bridge\PlayBridgeForm;
use EasyUI\element\Button;
use EasyUI\icon\ButtonIcon;
use EasyUI\variant\SimpleForm;
use pocketmine\player\Player;

class GameSelectorForm extends SimpleForm
{
    public function __construct()
    {
        parent::__construct("Game Selector");
    }

    /**
     * @return void
     */
    protected function onCreation(): void
    {
        $this->addButton(new Button("§l§9THE §cBRIDGE", new ButtonIcon("textures/form/bridge.png", ButtonIcon::TYPE_PATH), function (Player $player) {
            $player->sendForm(new PlayBridgeForm());
        }));
    }
}
