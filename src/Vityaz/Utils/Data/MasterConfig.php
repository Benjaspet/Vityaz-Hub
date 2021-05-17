<?php

declare(strict_types=1);

namespace Vityaz\Utils\Data;

use pocketmine\utils\Config;
use Vityaz\Main;

class MasterConfig {

    private $config;

    public function __construct(Main $core) {
        $this->init($core);
    }

    public function init(Main $core) {

        if (!file_exists($core->getDataFolder() . "config.json")) {
            $this->config = new Config($core->getDataFolder() . "config.json", Config::JSON, [
                "NA" => [
                    "host" => "",
                    "port" => (int) "",
                ],
                "EU" => [
                    "host" => "",
                    "port" => (int) "",
                ],
                "AS" => [
                    "host" => "",
                    "port" => (int) "",
                ],
                "UHC" => [
                    "host" => "",
                    "port" => (int) ""
                ]
            ]);
        }
        $this->config = new Config($core->getDataFolder() . "config.json", Config::JSON);
    }

    public function getMasterConfig(): Config {
        return $this->config;
    }

    public function getAllData(): array {
        return $this->getMasterConfig()->getAll();
    }

    public function getNaHost() {
        return $this->getAllData()["NA"]["host"];
    }

    public function getNaPort() {
        return $this->getAllData()["NA"]["port"];
    }

    public function getEuHost() {
        return $this->getAllData()["EU"]["host"];
    }

    public function getEuPort() {
        return $this->getAllData()["EU"]["port"];
    }

    public function getAsHost() {
        return $this->getAllData()["AS"]["host"];
    }

    public function getAsPort() {
        return $this->getAllData()["AS"]["port"];
    }

    public function getUhcHost() {
        return $this->getAllData()["UHC"]["host"];
    }

    public function getUhcPort() {
        return $this->getAllData()["UHC"]["port"];
    }
}
