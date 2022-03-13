<?php

namespace DidntPot;

use DidntPot\npc\BridgeNPC;
use DidntPot\player\PlayerListener;
use DidntPot\tasks\PlayerCountTask;
use DidntPot\utils\BasicUtils;
use pocketmine\entity\Entity;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Location;
use pocketmine\entity\Skin;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;
use pocketmine\world\World;
use sergittos\flanbacore\FlanbaCore;
use xenialdan\skinapi\API;
use pocketmine\scheduler\ClosureTask;

class LobbyCore extends PluginBase
{
    // Free getInstance() method!
    use SingletonTrait;

    public array $serverData;

    /**
     * @return void
     */
    public function onLoad(): void
    {
        self::setInstance($this);
    }

    /**
     * @return void
     */
    public function onEnable(): void
    {

        $this->saveResource("config.yml");
        $this->serverData = $this->getConfig()->getNested("bridge-servers");

        $this->regEntity([BridgeNPC::class]);

        // Shouldn't really happen but just in case.
        if (is_null(self::$instance)) {
            $this->getLogger()->critical("LobbyCore instance is NULL, disabling the plugin.");
            $this->getServer()->shutdown();
        }

        $doesLoad = BasicUtils::loadLobbyWorld();
        if ($doesLoad === false) {
            $this->getLogger()->critical("The lobby world couldn't be loaded, disabling the plugin.");
            $this->getServer()->shutdown();
        }
        $this->registerListeners(
            [
                new LobbyListener(),
                new PlayerListener()
            ]
        );

        $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function(){
            $this->getServer()->getAsyncPool()->submitTask(new PlayerCountTask(BasicUtils::getLobbyPlayers(true), $this->serverData));
        }), 400);
    }

    /**
     * @param array $listeners
     * @return void
     */
    private function registerListeners(array $listeners): void
    {
        foreach ($listeners as $listener) {
            $this->getServer()->getPluginManager()->registerEvents($listener, self::getInstance());
        }
    }

    /**
     * @return void
     */
    public function onDisable(): void
    {
        foreach ($this->getServer()->getOnlinePlayers() as $player) {
            $player->transfer(BasicUtils::IP);
        }
    }

    public function regEntity($entitys) : void{

        foreach ($entitys as $entity) {
            EntityFactory::getInstance()->register($entity, function (World $world, CompoundTag $nbt) use ($entity): Entity {
                return new $entity(EntityDataHelper::parseLocation($nbt, $world), $nbt);
            }, ['vobs', 'more vobs']);
        }
    }
}