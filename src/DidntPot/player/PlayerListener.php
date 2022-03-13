<?php

namespace DidntPot\player;

use DidntPot\player\session\SessionHandler;
use DidntPot\player\session\SessionIdentifier;
use DidntPot\utils\BasicUtils;
use pocketmine\data\bedrock\EffectIdMap;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;

class PlayerListener implements Listener
{
    /**
     * @param PlayerLoginEvent $ev
     * @return void
     */
    public function onLogin(PlayerLoginEvent $ev)
    {
        SessionHandler::createSession($ev->getPlayer(), SessionIdentifier::PLAYER_SESSION);
    }

    /**
     * @param PlayerJoinEvent $ev
     * @return void
     */
    public function onJoin(PlayerJoinEvent $ev)
    {
        $player = $ev->getPlayer();
        $session = SessionHandler::getSession($player, SessionIdentifier::PLAYER_SESSION);
        $ev->setJoinMessage(" §gWelcome, §a" . $player->getDisplayName() . "!");
        $session->onJoin();

        foreach(SessionHandler::getSessions() as $session) {
            $session->updateScoreboard();
        }
    }

    /**
     * @param PlayerRespawnEvent $ev
     * @return void
     */
    public function onRespawn(PlayerRespawnEvent $ev)
    {
        $ev->setRespawnPosition(BasicUtils::getLobbyWorld()->getSafeSpawn());
    }

    /**
     * @param PlayerQuitEvent $ev
     * @return void
     */
    public function onQuit(PlayerQuitEvent $ev) {
        $ev->setQuitMessage("");

        $player = $ev->getPlayer();
        SessionHandler::getSession($player, SessionIdentifier::PLAYER_SESSION)->onQuit();
        SessionHandler::removeSession($player, SessionIdentifier::PLAYER_SESSION);
    }
}