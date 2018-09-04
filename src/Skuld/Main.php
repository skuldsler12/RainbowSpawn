<?php

namespace Skuld;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TE;

class Main extends PluginBase implements Listener {

    public $usrActv = 0;

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getLogger()->info("¡RainbowSpawnProtect Cargado!");
        $this->Data = new Config($this->getDataFolder() . "vips.json", Config::JSON);
    }

    public function onPlayerLogin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $playername = $player->getName();
        $entra = false;
        $maxUSR = 0;
        $online = count($this->getServer()->getOnlinePlayers());
        if($this->checkData($playername)) {
            $rank = $this->getRank($playername);
            $player->setNameTag(TE::GRAY."[".TE::GOLD.$rank.TE::GRAY."]".TE::AQUA.$playername);
            $player->addAttachment($this, "test.command");
        }else{
            if ($online < $maxUSR) {
                $event->getPlayer()->teleport($this->getServer()->getDefaultLevel()->getSafeSpawn());
                self::$usrActv++;
            }else{
                $event->getPlayer()->kick("Servidor completo... Prueba en 10 minutos.",true,"Servidor completo... Prueba en 10 minutos.");
                $event->setCancelled();
            }
        }
    }

    public function checkData($username) {
        return $this->Data->exists($username);
    }

    public function getRank($username) {
        return $this->Data->get($username);
    }

    public function onPlayerQuit(PlayerQuitEvent $event){
        self::$usrActv--;
    }

}
