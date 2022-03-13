<?php

namespace DidntPot\player\session\types;

use DidntPot\items\types\GameSelectorItem;
use DidntPot\items\types\UnlocksItem;
use DidntPot\items\types\SocialItem;
use DidntPot\items\types\ShopItem;
use DidntPot\items\types\SettingsItem;
use DidntPot\npc\BridgeNPC;
use DidntPot\player\session\BasicSession;
use DidntPot\scoreboards\Scoreboard;
use DidntPot\scoreboards\types\LobbyScoreboard;
use DidntPot\utils\BasicUtils;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Location;
use pocketmine\player\GameMode;
use pocketmine\utils\TextFormat;

class PlayerSession extends BasicSession
{
    /**
     * @var Scoreboard|null
     */
    private ?Scoreboard $scoreboard = null;

    private ?BridgeNPC $bridg = null;

    /**
     * @return void
     */
    public function onJoin(): void
    {
        $player = $this->getPlayer();
        
        $player->setGamemode(GameMode::ADVENTURE());
        $player->sendMessage(" §f__________________\n     §e§lFLANBA§6MC     \n§l§eSTORE: §r§fflanba.com/store\n§l§eDISCORD: §r§fdiscord.gg/flanba\n§l§eYOUTUBE: §r§fyoutube.com/c/flanba\n§r§f §f__________________");
        $player->sendTitle(TextFormat::YELLOW . TextFormat::BOLD . "Flanba " . TextFormat::GOLD . "Network");
        $player->sendSubTitle(TextFormat::YELLOW . TextFormat::BOLD . "Welcome to Flanba Network,\nPlease join our discord server!\n" . TextFormat::GREEN . "discord.gg/flanba");

        $this->setScoreboard(new LobbyScoreboard($this));
        $this->teleportToLobby();
        $this->sendLobbyItems();

        $this->bridg = $bridg = new BridgeNPC(new Location("235.5", '15', "-202.5", BasicUtils::getLobbyWorld(), 185, 1.5));
        $bridg->setNameTag(TextFormat::BOLD . TextFormat::BLUE . "THE BRIDGE");
        $bridg->setNameTagAlwaysVisible(true);
        $bridg->spawnTo($player);
    }

    public function hasScoreboard(): bool {
        return $this->scoreboard !== null;
    }

    /**
     * @param Scoreboard|null $scoreboard
     * @return void
     */
    public function setScoreboard(?Scoreboard $scoreboard): void
    {
        $this->scoreboard = $scoreboard;
        $scoreboard?->show();
    }

    /**
     * @return void
     */
    public function teleportToLobby(): void
    {
        $player = $this->getPlayer();
        $world = BasicUtils::getLobbyWorld();
        // $coords = BasicUtils::$lobbyCoordinates;

        $player->teleport($world->getSafeSpawn());
    }

    /**
     * @return void
     */
    public function sendLobbyItems(): void
    {
        $player = $this->getPlayer();
        $inv = $player->getInventory();

        $this->clearAll();

        $inv->setItem(4, new GameSelectorItem());
        $inv->setItem(7, new SocialItem());
        $inv->setItem(1, new ShopItem());
        $inv->setItem(8, new SettingsItem());
        $inv->setItem(0, new UnlocksItem());
        $inv->setHeldItemIndex(4);
        $player->getEffects()->add(new EffectInstance(VanillaEffects::NIGHT_VISION(), 10000, 1, false));
    }

    /**
     * @return void
     */
    public function clearAll(): void
    {
        $player = $this->getPlayer();

        $player->extinguish();
        $player->setGamemode(GameMode::SURVIVAL());
        $player->getEffects()->clear();

        $this->clearInventory();
        $this->revivePlayer();
        $this->setImmobile(false);
    }

    /**
     * @return void
     */
    public function clearInventory(): void
    {
        $this->player->getInventory()->clearAll();
        $this->player->getCursorInventory()->clearAll();
        $this->player->getArmorInventory()->clearAll();
        $this->player->getOffHandInventory()->clearAll();
    }

    /**
     * @return void
     */
    public function revivePlayer(): void
    {
        $this->player->setHealth($this->player->getMaxHealth());
        $this->player->getHungerManager()->setFood($this->player->getHungerManager()->getMaxFood());
    }

    /**
     * @param bool $immobile
     * @return void
     */
    public function setImmobile(bool $immobile = true): void
    {
        $this->player->setImmobile($immobile);
    }

    /**
     * @return void
     */
    public function onQuit(): void
    {
        // TODO: ??
        if(!is_null($this->bridg)) $this->bridg->flagForDespawn();
    }

    /**
     * @return void
     */
    public function updateScoreboard(): void {
        if($this->hasScoreboard()) {
            $this->setScoreboard($this->scoreboard);
        }
    }
}
