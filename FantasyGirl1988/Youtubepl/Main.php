<?php

namespace FantasyGirl1988\Youtube;

#Uses

use pocketmine\player\Player;

use pocketmine\Server;

use jojoe77777\FormAPI\CustomForm;

use pocketmine\command\CommandSender;

use pocketmine\command\Command;

use pocketmine\world\World;

use pocketmine\utils\Config;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

  public static self $instance;

  public static Config $config;

  

  public function onEnable(): void{

    self::$instance = $this;

    self::saveResource("config.yml");

    self::$config = new Config(self::getDataFolder() . "config.yml", Config::YAML);

    $this->getLogger()->info("§aGeladen!");

  }

  

  public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{

    

    switch($cmd->getName()){

      

      case "youtube":

        if(!$sender instanceof Player){

          $sender->sendMessage("Benutze das Ingame!");

          return false;

        }

        if(!isset($args[0])){

          $sender->sendMessage("§cBenutze /youtube <live,aufnehmen,livemenu>");

          return false;

        }

        if(isset($args[0])){

          switch($args[0]){

            case "livemenu":

              $this->liveform($sender);

              break;

              

            case "live":

              if(!isset($args[1])){

                $sender->sendMessage("§cBenutze /youtube <live> <link>");

              }

              if(isset($args[1])){

                $name = $sender->getName();

                $msg = implode(" ", $args);

                foreach($this->getServer()->getOnlinePlayers() as $player){

                  $player->sendMessage("§8»\n§8»\n§aDer Spieler §e" . $sender->getName() . " §aist gerade Live.\n§8» §6Link: §7" . $args[1] . "\n§8»\n§8»");

                }

              }

              break;

              

            case "aufnehmen":

              $name = $sender->getName();

              Server::getInstance()->broadcastMessage("§8»\n§8»\n§aDer Spieler §e" . $name . " §animmt gerade auf!\n§8»\n§8»");

              break;

          }

        }

        break;

    }

    return true;

  }

  

  public function liveform($player){

    $live = new CustomForm(function(Player $player, array $data){

      if($data === null){

        return true;

      }

        foreach($this->getServer()->getOnlinePlayers() as $players){

          $players->sendMessage("§8»\n§8»\n§aDer Spieler §e" . $player->getName() . " §aist gerade Live. \n§8» §aLink: §e" . $data[1] . "\n§8»\n§8»");

        }

    });

    $live->setTitle("§aLive");

    $live->addLabel("§aPlease Put you link in the Box, §e" . $player->getName());

    $live->addInput("§aPlease the Link", "Please the Link!", "i'm Live!");

    $live->sendToPlayer($player);

    return $live;

  }

}
