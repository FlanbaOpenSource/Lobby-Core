<?php

namespace DidntPot\items;

use DidntPot\utils\ColorUtils;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;

// Credits: https://github.com/Flanba/Flanba-Core/blob/a27ae7deae1616c318f0fa693d1253f21e115bea/src/sergittos/flanbacore/item/FlanbaItem.php#L18
class LobbyItem extends Item
{
    /**
     * @param string $name
     * @param int $id
     * @param int $meta
     */
    public function __construct(string $name, int $id, int $meta = 0)
    {
        $this->setCustomName($name = ColorUtils::translate($name));
        parent::__construct(new ItemIdentifier($id, $meta), $name);
        $this->getNamedTag()->setString("flanba", "flanba");
    }
}