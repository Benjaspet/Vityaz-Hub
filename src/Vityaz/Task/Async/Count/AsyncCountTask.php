<?php

declare(strict_types=1);

namespace Vityaz\Task\Async\Count;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use Vityaz\Main;
use Vityaz\Utils\Query\NetQuery;
use Vityaz\Utils\Query\NetQueryException;

class AsyncCountTask extends AsyncTask {

    private $core;

    public function __construct(Main $core) {
        $this->core = $core;
        $this->core->getServer()->getAsyncPool()->submitTask($this);
    }

    public function onRun() {

        try {
            $response1 = ['count' => 0, 'errors' => []];
            $data1 = NetQuery::query(
                $this->core->getVityazManager()->getMasterConfig()->getNaHost(),
                $this->core->getVityazManager()->getMasterConfig()->getNaPort());
        } catch (NetQueryException $exception) {
            $data1['Players'] = 0;
        }
        $response1['count'] += $data1['Players'];

        try {
            $response2 = ['count' => 0, 'errors' => []];
            $data2 = NetQuery::query(
                $this->core->getVityazManager()->getMasterConfig()->getEuHost(),
                $this->core->getVityazManager()->getMasterConfig()->getEuPort());
        } catch (NetQueryException $exception) {
            $data2['Players'] = 0;
        }
        $response2['count'] += $data2['Players'];

        try {
            $response3 = ['count' => 0, 'errors' => []];
            $data3 = NetQuery::query(
                $this->core->getVityazManager()->getMasterConfig()->getAsHost(),
                $this->core->getVityazManager()->getMasterConfig()->getAsPort());
        } catch (NetQueryException $exception) {
            $data3['Players'] = 0;
        }
        $response3['count'] += $data3['Players'];

        try {
            $response4 = ['count' => 0, 'errors' => []];
            $data4 = NetQuery::query(
                $this->core->getVityazManager()->getMasterConfig()->getUhcHost(),
                $this->core->getVityazManager()->getMasterConfig()->getUhcPort());
        } catch (NetQueryException $exception) {
            $data4['Players'] = 0;
        }
        $response4['count'] += $data4['Players'];

        $this->setResult($response1["count"] + $response2["count"] + $response3["count"] + $response4["count"]);
    }

    public function onCompletion(Server $server) {
        $this->core->getVityazManager()->getPlayerCountManager()->setCachedPlayers($this->getResult());
    }
}
