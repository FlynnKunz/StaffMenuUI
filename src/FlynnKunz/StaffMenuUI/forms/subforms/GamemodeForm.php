<?php 

/* Copyright 2022-2022 FlynnKunz and fernanACM
   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at
       http://www.apache.org/licenses/LICENSE-2.0
   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/

namespace FlynnKunz\StaffMenuUI\forms\subforms;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\player\GameMode;

use Vecnavium\FormsUI\SimpleForm;

use FlynnKunz\StaffMenuUI\Main;
use FlynnKunz\StaffMenuUI\utils\PluginUtils;

class GamemodeForm{
  
    public function GamemodeForm(Player $player){
        $form = new SimpleForm(function(Player $player, $data){
            if($data !== null){
                switch($data){
                    case 0: //SURVIVAL
                        $prefix = Main::getInstance()->messages->getNested("Prefix");
                        $message = Main::getInstance()->messages->getNested("Messages.Gamemode.survival");
                        if($player->hasPermission("staffmenuUI.gm.survival")){
                           $player->setGamemode(GameMode::SURVIVAL());
                           $player->sendMessage($prefix . $message);
                           PluginUtils::PlaySound($player, "random.pop", 11, 1);
                        }
                        $noperm = Main::getInstance()->messages->getNested("Messages.no-permission");
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    break;
                    
                    case 1: //CREATIVE
                        $prefix = Main::getInstance()->messages->getNested("Prefix");
                        $message = Main::getInstance()->messages->getNested("Messages.Gamemode.creative");
                        if($player->hasPermission("staffmenuUI.gm.creative")){
                           $player->setGamemode(GameMode::CREATIVE());
                           $player->sendMessage($prefix . $message);
                           PluginUtils::PlaySound($player, "random.pop", 11, 1);
                        }
                        $noperm = Main::getInstance()->messages->getNested("Messages.no-permission");
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    break;
                    
                    case 2: //ADVENTURE
                        $prefix = Main::getInstance()->messages->getNested("Prefix");
                        $message = Main::getInstance()->messages->getNested("Messages.Gamemode.adventure");
                        if($player->hasPermission("staffmenuUI.gm.adventure")){
                           $player->setGamemode(GameMode::ADVENTURE());
                           $player->sendMessage($prefix . $message);
                           PluginUtils::PlaySound($player, "random.pop", 11, 1);
                        }
                        $noperm = Main::getInstance()->messages->getNested("Messages.no-permission");
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    break;
                    
                    case 3: //SPECTATOR
                        $prefix = Main::getInstance()->messages->getNested("Prefix");
                        $message = Main::getInstance()->messages->getNested("Messages.Gamemode.spectator");
                        if($player->hasPermission("staffmenuUI.gm.spectator")){
                           $player->setGamemode(GameMode::SPECTATOR());
                           $player->sendMessage($prefix . $message);
                           PluginUtils::PlaySound($player, "random.pop", 11, 1);
                        }
                        $noperm = Main::getInstance()->messages->getNested("Messages.no-permission");
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    break;
                    
                    case 4: //BACK
                        Main::getInstance()->menu->StaffUI($player);
                        PluginUtils::PlaySound($player, "random.pop2", 11, 1);
                    break;
                }
            }
        });
        $form->setTitle(Main::getInstance()->getNested("Forms.Gamemode.title"));
        $form->setContent(Main::getInstance()->getNested("Forms.Gamemode.content"));
        $form->addButton(Main::getInstance()->getNested("Forms.Gamemode.button-survival"));
        $form->addButton(Main::getInstance()->getNested("Forms.Gamemode.button-creative"));
        $form->addButton(Main::getInstance()->getNested("Forms.Gamemode.button-adventure"));
        $form->addButton(Main::getInstance()->getNested("Forms.Gamemode.button-spectator"));
        $form->addButton(Main::getInstance()->getNested("Forms.Gamemode.button-exit"));
        $player->sendForm($form);
    }
}
