<?php

namespace FilterSubsite;

use MapasCulturais\App,
    MapasCulturais\Entities,
    MapasCulturais\Definitions,
    MapasCulturais\Exceptions;

class Plugin extends \MapasCulturais\Plugin {

    public function _init() {

        $app = App::i();

        $subsite_id = $app->getCurrentSubsiteId();

        $app->hook("API.<<*>>(project).params", function(&$params) use($subsite_id){
            $subsite = \MapasCulturais\App::i()->repo('Subsite')->find($subsite_id);
            if ($subsite->show_instance_only_project == 's')
                $params['_subsiteId'] = "EQ($subsite_id)";
        });

        $app->hook("API.<<*>>(space).params", function(&$params) use($subsite_id){
            $subsite = \MapasCulturais\App::i()->repo('Subsite')->find($subsite_id);
            if ($subsite->show_instance_only_space == 's')
                $params['_subsiteId'] = "EQ($subsite_id)";
        });

        $app->hook("API.<<*>>(agent).params", function(&$params) use($subsite_id){
            $subsite = \MapasCulturais\App::i()->repo('Subsite')->find($subsite_id);
            if ($subsite->show_instance_only_agent == 's')
                $params['_subsiteId'] = "EQ($subsite_id)";
        });

        $app->hook("API.<<*>>(event).params", function(&$params) use($subsite_id){
            $subsite = \MapasCulturais\App::i()->repo('Subsite')->find($subsite_id);
            if ($subsite->show_instance_only_event == 's')
                $params['_subsiteId'] = "EQ($subsite_id)";
        });
    }

    public function register() {

    }
}