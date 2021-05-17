<?php

declare(strict_types=1);

namespace Vityaz\Task\Async\Selector;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use Vityaz\Main;
use Vityaz\Utils\Query\NetQuery;
use Vityaz\Utils\Query\NetQueryException;

class AsyncSelectorTask extends AsyncTask {

    private $core;

    public function __construct(Main $core) {
        $this->core = $core;
        $this->core->getServer()->getAsyncPool()->submitTask($this);
    }

    public function onRun() {

        try {
            $query = NetQuery::query(
                $this->core->getVityazManager()->getMasterConfig()->getNaPort(),
                $this->core->getVityazManager()->getMasterConfig()->getNaPort()
            );
            $na = (int) $query['Players'];
        } catch (NetQueryException $exception) {
            $na = "Offline";
        }

        try {
            $query = NetQuery::query(
                $this->core->getVityazManager()->getMasterConfig()->getEuHost(),
                $this->core->getVityazManager()->getMasterConfig()->getEuPort()
            );
            $eu = (int) $query['Players'];
        } catch (NetQueryException $exception) {
            $eu = "Offline";
        }

        try {
            $query = NetQuery::query(
                $this->core->getVityazManager()->getMasterConfig()->getAsHost(),
                $this->core->getVityazManager()->getMasterConfig()->getAsPort()
            );
            $as = (int) $query['Players'];
        } catch (NetQueryException $exception) {
            $as = "Offline";
        }

        try {
            $query = NetQuery::query(
                $this->core->getVityazManager()->getMasterConfig()->getUhcHost(),
                $this->core->getVityazManager()->getMasterConfig()->getUhcPort()
            );
            $uhc = (int) $query['Players'];
        } catch (NetQueryException $exception) {
            $uhc = "Offline";
        }
        $this->setResult(["NA" => $na, "EU" => $eu, "AS" => $as, "UHC" => $uhc]);
    }

    public function onCompletion(Server $server) {
        $this->core->getVityazManager()->getPlayerCountManager()->count = $this->getResult();
    }
}