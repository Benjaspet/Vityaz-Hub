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

    public function getTotalNetworkCount(): int {
        $na = $this->getNaPracticeCountAsInteger();
        $eu = $this->getEuPracticeCountAsInteger();
        $as = $this->getAsPracticeCountAsInteger();
        $hub = $this->getHubCountAsInteger();
        $uhc = $this->getUhcCountAsInteger();
        return $na + $eu + $as + $hub + $uhc;
    }

    public function getNaPracticeCountAsInteger(): int {
        $na = $this->core->getVityazManager()->getPlayerCountManager()->count["NA"];
        if ($na === "Offline") return 0;
        return $na;
    }

    public function getEuPracticeCountAsInteger(): int {
        $eu = $this->core->getVityazManager()->getPlayerCountManager()->count["EU"];
        if ($eu === "Offline") return 0;
        return $eu;
    }

    public function getAsPracticeCountAsInteger(): int {
        $as = $this->core->getVityazManager()->getPlayerCountManager()->count["AS"];
        if ($as === "Offline") return 0;
        return $as;
    }

    public function getUhcCountAsInteger(): int {
        $uhc = $this->core->getVityazManager()->getPlayerCountManager()->count["UHC"];
        if ($uhc === "Offline") return 0;
        return $uhc;
    }

    public function getHubCountAsInteger(): int {
        return count($this->core->getServer()->getOnlinePlayers());
    }
}
