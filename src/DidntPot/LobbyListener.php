<?php

namespace DidntPot;

use DidntPot\npc\BridgeNPC;
use DidntPot\utils\BasicUtils;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\world\WorldLoadEvent;
use pocketmine\event\world\WorldUnloadEvent;
use pocketmine\math\Vector2;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\MoveActorAbsolutePacket;
use pocketmine\player\Player;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\utils\TextFormat;

;

class LobbyListener implements Listener
{
    /**
     * @param EntityDamageEvent $ev
     * @return void
     */
    public function onEntityDamage(EntityDamageEvent $ev): void
    {
        $player = $ev->getEntity();

        if (!$player instanceof Player) return;

        switch ($ev->getCause()) {
            case EntityDamageEvent::CAUSE_DROWNING:
            case EntityDamageEvent::CAUSE_FALL:
            case EntityDamageEvent::CAUSE_BLOCK_EXPLOSION:
            case EntityDamageEvent::CAUSE_LAVA:
            case EntityDamageEvent::CAUSE_FIRE:
            case EntityDamageEvent::CAUSE_FIRE_TICK:
            case EntityDamageEvent::CAUSE_STARVATION:
            case EntityDamageEvent::CAUSE_CONTACT:
                $ev->cancel();
                break;

            case EntityDamageEvent::CAUSE_VOID:
                $player->teleport(BasicUtils::getLobbyWorld()->getSafeSpawn());
                break;
        }

        if ($ev instanceof EntityDamageByEntityEvent) {
            $ev->cancel();
        }
    }

    public function onBreak(BlockBreakEvent $event) {

        $event->cancel();

    }

    public function onCraft(CraftItemEvent $event) {
        $event->cancel();
    }

    public function onHit(EntityDamageByEntityEvent $event) {

        if($event->getDamager() instanceof Player && $event->getEntity() instanceof BridgeNPC) {

            $event->cancel();
            $event->getEntity()->onInteract($event->getDamager(), $event->getEntity()->getPosition());

        }

    }
    
    public function onExhaust(PlayerExhaustEvent $event): void
    {
        $event->cancel();
    }

    public function onTransaction(InventoryTransactionEvent $event): void {
        $event->cancel();
    }


    //NPC look to players thanks to https://github.com/brokiem/SimpleNPC/blob/pm4-new/src/brokiem/snpc/EventHandler.php
    public function onMove(PlayerMoveEvent $event): void
    {
        $player = $event->getPlayer();

            /*if ($event->getFrom()->distance($event->getTo()) < 0.1) {
                return;
            }

            foreach ($player->getWorld()->getEntities() as $entity) {
                if ($entity instanceof BridgeNPC) {
                    $angle = atan2($player->getLocation()->z - $entity->getLocation()->z, $player->getLocation()->x - $entity->getLocation()->x);
                    $yaw = (($angle * 180) / M_PI) - 90;
                    $angle = atan2((new Vector2($entity->getLocation()->x, $entity->getLocation()->z))->distance(new Vector2($player->getLocation()->x, $player->getLocation()->z)), $player->getLocation()->y - $entity->getLocation()->y);
                    $pitch = (($angle * 180) / M_PI) - 90;


                        $pk = new MoveActorAbsolutePacket();
                        $pk->actorRuntimeId = $entity->getId();
                        $pk->position = $entity->getPosition();
                        $pk->pitch = $pitch;
                        $pk->yaw = $yaw;
                        $pk->headYaw = $yaw;
                        $player->getNetworkSession()->sendDataPacket($pk);

                }


            }*/

        //$player->sendMessage("Pitch " . $player->getLocation()->getPitch() . "\n\n Yaw " . $player->getLocation()->getYaw());

        }

        public function onDrop(PlayerDropItemEvent $event)
        {
            $event->cancel();
        }
}
