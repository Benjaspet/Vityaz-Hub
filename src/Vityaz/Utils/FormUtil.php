<?php

declare(strict_types=1);

namespace Vityaz\Utils;

use pocketmine\Player;
use Vityaz\Main;
use Vityaz\Utils\Forms\SimpleForm;

class FormUtil {

    private $core;

    public function __construct(Main $core) {
        $this->core = $core;
    }

    public function homeForm(Player $player): SimpleForm {
        $form = new SimpleForm(function (Player $event, $data) {

            $player = $event->getPlayer();

            if ($data === null) {
                return;
            }

            switch ($data) {

                case 0:
                    $this->transferForm($player);
                    break;
                case 1:
                    break;
            }
        });

        $form->setTitle("§l§8TRANSFER FORM");
        $form->setContent("Select a gamemode below:");
        $form->addButton("Practice\nOnline: " . $this->core->getVityazManager()->getQueryUtil()->getTotalNetworkCount());

        return $form;
    }

    public function transferForm(Player $player): SimpleForm {
        $form = new SimpleForm(function (Player $event, $data) {

            $player = $event->getPlayer();

            if ($data === null) {
                return;
            }

            switch ($data) {

                case 0:
                    $player->transfer(
                        $this->core->getVityazManager()->getMasterConfig()->getNaHost(),
                        $this->core->getVityazManager()->getMasterConfig()->getNaPort()
                    );
                    break;
                case 1:
                    $player->transfer(
                        $this->core->getVityazManager()->getMasterConfig()->getEuHost(),
                        $this->core->getVityazManager()->getMasterConfig()->getEuPort()
                    );
                    break;
                case 2:
                    $player->transfer(
                        $this->core->getVityazManager()->getMasterConfig()->getAsHost(),
                        $this->core->getVityazManager()->getMasterConfig()->getAsPort()
                    );
                    break;
            }
        });

        $form->setTitle("§l§8TRANSFER FORM");
        $form->setContent("Transfer to a region below:");

        if ($this->core->getVityazManager()->getPlayerCountManager()->count["NA"] !== "Offline") {
            $form->addButton("NA Practice\nOnline: " . $this->core->getVityazManager()->getPlayerCountManager()->count["NA"] . "/50");
        } else {
            $form->addButton("NA Practice\n" . $this->core->getVityazManager()->getPlayerCountManager()->count["NA"]);
        }

        if ($this->core->getVityazManager()->getPlayerCountManager()->count["EU"] !== "Offline") {
            $form->addButton("EU Practice\nOnline: " . $this->core->getVityazManager()->getPlayerCountManager()->count["EU"] . "/50");
        } else {
            $form->addButton("EU Practice\n" . $this->core->getVityazManager()->getPlayerCountManager()->count["EU"]);
        }

        if ($this->core->getVityazManager()->getPlayerCountManager()->count["AS"] !== "Offline") {
            $form->addButton("AS Practice\nOnline: " . $this->core->getVityazManager()->getPlayerCountManager()->count["AS"] . "/50");
        } else {
            $form->addButton("AS Practice\n" . $this->core->getVityazManager()->getPlayerCountManager()->count["AS"]);
        }
        $player->sendForm($form);
        return $form;
    }
}