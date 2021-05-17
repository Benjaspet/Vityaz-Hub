<?php

declare(strict_types=1);

namespace Vityaz\Task\Async;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class ProxyTask extends AsyncTask {

    private $name;
    private $address;

    public function __construct(string $name, string $address) {
        $this->name = $name;
        $this->address = $address;
    }

    public function onRun() {

        $url = "http://check.getipintel.net/check.php?ip=" . $this->getAddress() . "&format=json&contact=test@outlook.de";
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        ]);

        $result = curl_exec($curl);
        $data = json_decode($result, true);

        $this->setResult(array(
            "name" => (string) $this->getPlayerName(),
            "result" => $data["result"]
        ));
    }

    public function onCompletion(Server $server) {

        $result = (float)$this->getResult()["result"];
        $name = $this->getResult()["name"];

        if ($result !== null) {
            if ($result > 0.98) {
                $player = $server->getPlayerExact($name);
                $player->kick("§cPlease disable your VPN or proxy to play on Vityaz.", false);
            }
        }
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getPlayerName(): string {
        return $this->name;
    }

    public function setAddress(string $address) {
        $this->address = $address;
    }

    public function setPlayerName(string $name) {
        $this->name = $name;
    }
}