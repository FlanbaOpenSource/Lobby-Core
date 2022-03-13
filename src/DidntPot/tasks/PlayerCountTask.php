<?php

namespace DidntPot\tasks;

use DidntPot\query\PMQuery;
use DidntPot\query\PmQueryException;
use DidntPot\utils\BasicUtils;
use pocketmine\scheduler\AsyncTask;

class PlayerCountTask extends AsyncTask
{
    private int $lobbyPlayers;
    private array $serverss;

    public function __construct(int $lobbyCount, array $serversFromConfig){
        $this->lobbyPlayers = $lobbyCount;
        $this->serverss = $serversFromConfig;
    }

    public function onRun(): void
    {
        $count = 0;
        $count += $this->lobbyPlayers;
        foreach($this->serverss as $server){
            $serverData = explode(":", $server);
            try{
                $query = PMQuery::query($serverData[0], $serverData[1]);
                $count += (int) $query['Players'];
            }catch(PmQueryException $e){
                $count += 0;
            }
        }
        $this->setResult($count);
    }

    public function onCompletion(): void
    {
        BasicUtils::$playerCount = $this->getResult();
    }
}
