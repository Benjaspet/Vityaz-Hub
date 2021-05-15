<?php

declare(strict_types=1);

namespace Vityaz\Utils;

use Vityaz\Main;
use Vityaz\Utils\Query\NetQuery;
use Vityaz\Utils\Query\NetQueryException;

class QueryUtil {

    private $core;

    public function __construct(Main $core) {
        $this->core = $core;
    }

    # Use a true boolean parameter to return as an int if offline, false to
    # return as a string "offline".

    public function getNaPracticeCount(bool $bool) {
        try {
            $query = NetQuery::query("45.134.8.234", 19133);
            return (int) $query['Players'];
        } catch (NetQueryException $exception) {
            if ($bool === true) {
                return 0;
            } else {
                return "offline";
            }
        }
    }

    public function getAsPracticeCount(bool $bool) {
        try {
            $query = NetQuery::query("51.161.145.193", 19261);
            return (int) $query['Players'];
        } catch (NetQueryException $exception) {
            if ($bool === true) {
                return 0;
            } else {
                return "offline";
            }
        }
    }

    public function getUhcPlayerCount(bool $bool) {
        try {
            $query = NetQuery::query("45.134.8.234", 19134);
            return (int) $query['Players'];
        } catch (NetQueryException $exception) {
            if ($bool === true) {
                return 0;
            } else {
                return "offline";
            }
        }
    }

    public function getHubPlayerCount(): int {
        return count($this->core->getServer()->getOnlinePlayers());
    }

    public function getTotalNetworkCount(): int {
        return $this->getNaPracticeCount(true) + $this->getUhcPlayerCount(true) + $this->getAsPracticeCount(true) + $this->getHubPlayerCount();
    }
}
