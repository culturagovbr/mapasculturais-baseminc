<?php
namespace BaseMinc;
use Subsite;
use MapasCulturais\App;

class Theme extends Subsite\Theme{

    function getMetadataPrefix(){
        return '';
    }
    protected function _getAgentMetadata(){
        return [];
    }
    protected function _getSpaceMetadata(){
        return [];
    }
    protected function _getEventMetadata(){
        return [];
    }
    protected function _getProjectMetadata(){
        return [];
    }

    static function getThemeFolder() {
        return __DIR__;
    }

    public function addEntityToJs(\MapasCulturais\Entity $entity) {
        parent::addEntityToJs($entity);
        $this->jsObject['entity']['tipologia_nivel1'] = $entity->tipologia_nivel1?$entity->tipologia_nivel1:'';
        $this->jsObject['entity']['tipologia_nivel2'] = $entity->tipologia_nivel2?$entity->tipologia_nivel2:'';
        $this->jsObject['entity']['tipologia_nivel3'] = $entity->tipologia_nivel3?$entity->tipologia_nivel3:'';
        $this->jsObject['entity']['tipologia_individual_cbo_cod'] = $entity->tipologia_individual_cbo_cod?$entity->tipologia_individual_cbo_cod:'';
        $this->jsObject['entity']['tipologia_individual_cbo_ocupacao'] = $entity->tipologia_individual_cbo_ocupacao?$entity->tipologia_individual_cbo_ocupacao:'';        
    }

    public function _init() {
        parent::_init();
        $app = App::i();

        $that = $this;

        $app->hook('subsite.applyConfigurations:after', function(&$config) use($that){
            $theme_path = $that::getThemeFolder() . '/';
            if (file_exists($theme_path . 'conf-base.php')) {
                $theme_config = require $theme_path . 'conf-base.php';
                $config = array_merge($config, $theme_config);
            }
            if (file_exists($theme_path . 'config.php')) {
                $theme_config = require $theme_path . 'config.php';
                $config = array_merge($config, $theme_config);
            }
        });

        $app->hook('view.render(agent/<<create|edit|single>>):before', function(){
            $this->jsObject['agentTypes'] = require __DIR__ . '/tipologia-agentes.php';
            $this->jsObject['agentTypesIndividuais'] = require __DIR__ . '/tipologia-agentes-individuais.php';
        });

        $app->hook('entity(<<Agent|Space|Event|Project>>).save:after', function() use ($app){
            if(!$this->getValidationErrors()){
                $num = strtoupper(substr($this->entityType, 0, 2)) . '-' . $this->id;
                $this->num_sniic = $num;
            }
        });

        // $app->hook('entity(AgentMeta).new', function() use ($app){
        //     \dump($app->getController());
        //     die();
        // });

        $app->hook('view.render(<<*>>):before', function() use($app) {
            $this->jsObject['angularAppDependencies'][] = 'entity.controller.agentTypes';
            $this->assetManager->publishAsset('img/minc_logo.png');
        });

        $app->hook('template(<<space|agent|project|event>>.<<create|edit|single>>.name):after', function(){
            $this->enqueueScript('app', 'num-sniic', 'js/num-sniic.js');
            $this->part('num-sniic', ['entity' => $this->data->entity]);
        });

        $app->hook('template(agent.<<create|edit|single>>.type):after', function(){
            $this->part('tipologia-agente', ['entity' => $this->data->entity]);
        });

        $app->hook('template(space.<<create|edit|single>>.tab-about-service):before', function(){
            $this->part('mais-campos', ['entity' => $this->data->entity]);
        });

        // BUSCA POR NÚMERO SNIIC
        // adiciona o join do metadado
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.join', function(&$joins, $keyword) {
            $joins .= "
                LEFT JOIN
                        e.__metadata num_sniic
                WITH
                        num_sniic.key = 'num_sniic'";
        });

        // filtra pelo valor do keyword
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.where', function(&$where, $keyword) {
            $where .= "OR lower(num_sniic.value) LIKE lower(:keyword)";
        });

        // BUSCA POR NÚMERO MUNICIPIO
        // adiciona o join do metadado
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.join', function(&$joins, $keyword) {
            $joins .= "
                LEFT JOIN
                        e.__metadata En_Municipio
                WITH
                        En_Municipio.key = 'En_Municipio'";
        });

        // filtra pelo valor do keyword
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.where', function(&$where, $keyword) {
            $where .= "OR lower(En_Municipio.value) LIKE lower(:keyword)";
        });

        $app->hook('entity(<<Subsite>>).new', function(){
            $this->show_instance_only_project = 'n';
            $this->show_instance_only_space = 'n';
            $this->show_instance_only_agent = 'n';
            $this->show_instance_only_event = 'n';
        });

        $app->hook('mapasculturais.head', function() use($app,$trackingID)) {
            echo "<!-- Piwik -->
                <script type='text/javascript'>
                  var _paq = _paq || [];
                  _paq.push(['trackPageView']);
                  _paq.push(['enableLinkTracking']);
                  (function() {
                    var u='//analise.cultura.gov.br/';
                    _paq.push(['setTrackerUrl', u+'piwik.php']);
                    _paq.push(['setSiteId', '42']);
                    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
                  })();
                </script>";
        }, 1000);
    }

    public function includeAngularEntityAssets($entity) {
        parent::includeAngularEntityAssets($entity);

        $this->enqueueScript('app', 'entity.controller.agentType', 'js/ng.entity.controller.agentTypes.js', ['entity.app']);
    }

    public function includeOpeningTimeAssets(){
        $this->jsObject['templateUrl']['spaceOpeningTime'] = $this->asset('js/directives/openingTime.html', false);
        $this->jsObject['angularAppDependencies'][] = 'entity.directive.openingTime';
        $this->enqueueScript('app', 'entity.directive.openingTime', 'js/ng.entity.directive.openingTime.js', array('ng-mapasculturais'));
    }

    public function register() {
        parent::register();

        $app = App::i();

        $metadata = [
            // 'MapasCulturais\Entities\Subsite' => [
            //     'show_instance_only_agent' => [
            //         'label' => 'Exibir somente Agentes cadastrados por este site',
            //         'type'  => 'select',
            //         'options' => [
            //             's' => 'Sim',
            //             'n' => 'Não'
            //         ]
            //     ],
            //     'show_instance_only_space' => [
            //         'label' => 'Exibir somente Espaços cadastrados por este site',
            //         'type'  => 'select',
            //         'options' => [
            //             's' => 'Sim',
            //             'n' => 'Não'
            //         ]
            //     ],
            //     'show_instance_only_event' => [
            //         'label' => 'Exibir somente Eventos cadastrados por este site',
            //         'type'  => 'select',
            //         'options' => [
            //             's' => 'Sim',
            //             'n' => 'Não'
            //         ]
            //     ],
            //     'show_instance_only_project' => [
            //         'label' => 'Exibir somente Projetos cadastrados por este site',
            //         'type'  => 'select',
            //         'options' => [
            //             's' => 'Sim',
            //             'n' => 'Não'
            //         ]
            //     ]
            // ],

            'MapasCulturais\Entities\Event' => [
                'num_sniic' => [
                    'label' => 'Nº SNIIC:',
                    'private' => false
                ],
            ],

            'MapasCulturais\Entities\Project' => [
                'num_sniic' => [
                    'label' => 'Nº SNIIC:',
                    'private' => false
                ],
            ],

            'MapasCulturais\Entities\Space' => [
                'num_sniic' => [
                    'label' => 'Nº SNIIC:',
                    'private' => false
                ],

                'cnpj' => [
                    'label' => 'CNPJ',
                    'private' => false,
                    'validations' => [
                        'v::cnpj()' => 'O CNPJ informado é inválido'
                    ]
                ],

                'esfera' => [
                    'label' => 'Esfera',
                    'type' => 'select',
                    'options' => [
                        'Pública',
                        'Privada'
                    ]
                ],

                'esfera_tipo' => [
                    'label' => 'Tipo de esfera',
                    'type' => 'select',
                    'options' => [
                        'Federal',
                        'Estadual',
                        'Distrital',
                        'Municipal',
                        'Associação',
                        'Empresa',
                        'Fundação',
                        'Particular',
                        'Religiosa',
                        'Mista',
                        'Entidade Sindical',
                        'Outra',
                    ],
                ],

                'certificado' => [
                    'label' => 'Títulos e Certificados',
                    'type' => 'select',
                    'options' => [
                        'ONG'   => 'Organização não Governamental (ONG)',
                        'OSCIP' => 'Organização da Sociedade Civil de Interesse Público (OSCIP)',
                        'OS'    => 'Organização Social (OS)',
                        'CEBAS' => 'Certificado de Entidade Beneficente de Assistência Social (CEBAS)',
                        'UPF'   => 'Certificado de Utilidade Pública Federal (UPF)',
                        'UPE'   => 'Certificado de Utilidade Pública Estadual (UPE)',
                        'UPM'   => 'Certificado de Utilidade Pública Municipal (UPM)'
                    ]
                ],
            ],

            'MapasCulturais\Entities\Agent' => [
                'num_sniic' => [
                    'label' => 'Nº SNIIC:',
                    'private' => false
                ],

                'tipologia_nivel1' => [
                    'label' => 'Tipologia Nível 1',
                    'private' => false
                ],
                'tipologia_nivel2' => [
                    'label' => 'Tipologia Nível 2',
                    'private' => false
                ],
                'tipologia_nivel3' => [
                    'label' => 'Tipologia Nível 3',
                    'private' => false,
                    'validations' => [
                        'v::not(v::falseVal())' => 'A tipologia deve ser informada.'
                    ]
                ],
                'tipologia_individual_cbo_cod' => [
                    'label' => 'Código Tipologia Individual (CBO)',
                    'private' => false,
                    'validations' => [
                        'v::not(v::falseVal())' => 'A tipologia deve ser informada.'
                    ]
                ],
                'tipologia_individual_cbo_ocupacao' => [
                    'label' => 'Ocupação Tipologia Individual (CBO)',
                    'private' => false
                ]
            ]
        ];

        $prefix = $this->getMetadataPrefix();

        foreach($this->_getAgentMetadata() as $key => $cfg){
            $key = $prefix . $key;

            $metadata['MapasCulturais\Entities\Agent'][$key] = $cfg;
        }

        foreach($this->_getSpaceMetadata() as $key => $cfg){
            $key = $prefix . $key;

            $metadata['MapasCulturais\Entities\Space'][$key] = $cfg;
        }

        foreach($this->_getEventMetadata() as $key => $cfg){
            $key = $prefix . $key;

            $metadata['MapasCulturais\Entities\Event'][$key] = $cfg;
        }

        foreach($this->_getProjectMetadata() as $key => $cfg){
            $key = $prefix . $key;

            $metadata['MapasCulturais\Entities\Project'][$key] = $cfg;
        }

        foreach($metadata as $entity_class => $metas){
            foreach($metas as $key => $cfg){
                $def = new \MapasCulturais\Definitions\Metadata($key, $cfg);
                $app->registerMetadata($def, $entity_class);
            }
        }
    }
}
