<?php

namespace DidntPot\scoreboards;

use DidntPot\player\session\BasicSession;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;

// Credits: https://github.com/Flanba/Flanba-Core/blob/a27ae7deae1616c318f0fa693d1253f21e115bea/src/sergittos/flanbacore/utils/scoreboard/Scoreboard.php#L22
abstract class Scoreboard
{
    /**
     * @var BasicSession|null
     */
    protected BasicSession|null $session = null;

    /**
     * @param BasicSession|null $session
     */
    public function __construct(?BasicSession $session)
    {
        $this->session = $session;
    }

    /**
     * @return BasicSession
     */
    public function getSession(): BasicSession
    {
        return $this->session;
    }

    /**
     * @return void
     */
    public function show(): void
    {
        if (!$this->session->getPlayer()->isOnline()) {
            return;
        }

        $this->hide();

        $packet = new SetDisplayObjectivePacket();
        $packet->displaySlot = "sidebar";
        $packet->objectiveName = $this->session->getPlayer()->getDisplayName();
        $packet->displayName = "flanba.sb.logo";
        $packet->criteriaName = "dummy";
        $packet->sortOrder = 0;
        $this->session->getPlayer()->getNetworkSession()->sendDataPacket($packet);

        $current_number = 0;

        foreach ($this->getLines() as $line) {
            $current_number++;
            $this->addLine(new Line($current_number, $line));
        }
    }

    /**
     * @return void
     */
    private function hide(): void
    {
        $packet = new RemoveObjectivePacket();
        $packet->objectiveName = $this->session->getPlayer()->getDisplayName();
        $this->session->getPlayer()->getNetworkSession()->sendDataPacket($packet);
    }

    /**
     * @return string[]
     */
    abstract public function getLines(): array;

    /**
     * @param Line $line
     * @return void
     */
    private function addLine(Line $line): void
    {
        $score = $line->getScore();
        if (!($score > 15 or $score < 1)) {
            $entry = new ScorePacketEntry();
            $entry->objectiveName = $this->session->getPlayer()->getDisplayName();
            $entry->type = $entry::TYPE_FAKE_PLAYER;
            $entry->customName = $line->getText();
            $entry->score = $score;
            $entry->scoreboardId = $score;
            $packet = new SetScorePacket();
            $packet->type = $packet::TYPE_CHANGE;
            $packet->entries[] = $entry;
            $this->session->getPlayer()->getNetworkSession()->sendDataPacket($packet);
        }
    }
}