<?php

declare(strict_types=1);

namespace Vityaz\Task\Async;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use Vityaz\Main;

class QueryUpdateTask extends AsyncTask {

    public function __construct() {
        Server::getInstance()->getAsyncPool()->submitTask($this);
    }

    public function onRun() {
        $result = Main::getInstance()->getVityazManager()->getQueryUtil()->getTotalNetworkCount();
        $this->setResult($result);
    }

    public function onCompletion(Server $server) {
        Main::getInstance()->setCachedPlayers($this->getResult());
        Main::getInstance()->getServer()->getLogger()->info("Query updated.");
    }
}
