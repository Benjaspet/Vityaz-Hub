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

    public function transferForm(Player $player): SimpleForm {
        $form = new SimpleForm (function (Player $event, $data) {
            $player = $event->getPlayer();

            if ($data === null) {
                return;
            }
            switch ($data) {
                case 0:
                    $player->transfer("45.134.8.234", 19133);
                    break;
                case 1;
                    $player->transfer("51.161.145.193", 19261);
                    break;
                case 2;
                    $player->transfer("45.134.8.234", 19134);
                    break;
            }
        });

        $form->setTitle("§l§8TRANSFER FORM");
        $form->setContent("Transfer to a region below:");
        $form->addButton("§8NA Practice\n§r§8" . $this->core->getVityazManager()->getQueryUtil()->getNaPracticeCount(false) . "/25");
        $form->addButton("§8AS Practice\n§r§8" . $this->core->getVityazManager()->getQueryUtil()->getAsPracticeCount(false) . "/25");
        $form->addButton("§8UHC Meetup\n" . $this->core->getVityazManager()->getQueryUtil()->getUhcPlayerCount(false) . "/25");
        $player->sendForm($form);
        return $form;
    }


}