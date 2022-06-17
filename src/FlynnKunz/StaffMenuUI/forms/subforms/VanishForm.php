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

class VanishForm{

    public function VanishForm(Player $player){
        $form = new SimpleForm(function(Player $player, $data){
            if($data !== null){
                switch($data){
                    case 0:
                        $prefix = Main::getInstance()->messages->getNested("Prefix");
                        $message = Main::getInstance()->messages->getNested("Messages.Vanish.vanish");
                        if($player->hasPermission("staffmenuUI.vanish")){
                           foreach (Server::getInstance()->getOnlinePlayers() as $client){
                               $client->hidePlayer($player);
                           }
                           $player->sendMessage($prefix . $message);
                        }else{
                           $noperm = Main::getInstance()->messages->getNested("Messages.no-permission");
                           $player->sendMessage($prefix .  $noperm);
                           PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        }
                    break;
                      
                    case 1:
                        $prefix = Main::getInstance()->messages->getNested("Prefix");
                        $message = Main::getInstance()->messages->getNested("Messages.Vanish.unvanish");
                        if($player->hasPermission("staffmenuUI.unvanish")){
                           foreach (Server::getInstance()->getOnlinePlayers() as $client){
                               $client->showPlayer($player);
                           }
                           $player->sendMessage($prefix . $message);
                        }else{
                           $noperm = Main::getInstance()->messages->getNested("Messages.no-permission");
                           $player->sendMessage($prefix .  $noperm);
                           PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        }
                    break;
                      
                    case 2:
                        Main::getInstance()->menu->StaffUI($player);
                    break;
                   
                }
            }
        });
        $form->setTitle(Main::getInstance()->messages->getNested("Forms.Vanish.title"));
        $form->setContent(Main::getInstance()->messages->getNested("Forms.Vanish.content"));
        $form->addButton(Main::getInstance()->messages->getNested("Forms.Vanish.button-enable"));
        $form->addButton(Main::getInstance()->messages->getNested("Forms.Vanish.button-disable"));
        $form->addButton(Main::getInstance()->messages->getNested("Forms.Vanish.button-exit"));
        $player->sendForm($form);
    }
}
