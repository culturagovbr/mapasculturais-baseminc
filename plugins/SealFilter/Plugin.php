<?php

namespace SealFilter;

use MapasCulturais\App,
    MapasCulturais\i;

class Plugin extends \MapasCulturais\Plugin {

    public function _init() {

        $app = App::i();
        $subsite_id = $app->getCurrentSubsiteId();

        if ($subsite_id)
            $app->hook('search.filters', function(&$filters) use($subsite_id, $app) {

                $subsite = \MapasCulturais\App::i()->repo('Subsite')->find($subsite_id);
                $seal_filter = [
                    'label' => i::__('Selos'),
                    'placeholder' => i::__('Selecione os Selos'),
                    'fieldType' => 'checklist',
                    'type' => 'custom',
                    'isArray' => true,
                    'filter' => [
                        'param' => '@seals',
                        'value' => '{val}'
                    ],
                    'options' => []
                ];

                $seals = \MapasCulturais\App::i()->repo('Seal')->findBy(['id' => $subsite->verifiedSeals]);

                foreach ($seals as $seal)
                    $seal_filter['options'][] = ['value' => $seal->id, 'label' => $seal->name];

                foreach($filters as $entity => $filter){
                    if(isset($filters[$entity]['verificados'])) unset($filters[$entity]['verificados']);
                    $filters[$entity]['seal'] = $seal_filter;
                }
            });
    }

    public function register() {
    }
}
