<?php
$entityClass = $entity->getClassName();
$entityName = strtolower(array_slice(explode('\\', $entityClass),-1)[0]);
$viewModeString = $entityName !== 'project' ? '' : ',viewMode:list';

$this->addSealsToJs(true,array(),$entity);

$editEntity = $this->controller->action === 'create' || $this->controller->action === 'edit';

function printSubsiteFilter($property){
    if($property){
        echo implode('; ', $property);
    }
}

?>
<div id="filtros" class="aba-content">
    <p class="alert info">Configure aqui os filtros que serão aplicados sobre os dados cadastrados na instalação principal. Deixe em branco os campos onde você não quer aplicar filtro algum, deixando aparecer todos os dados da instalação principal.</p>

    <section class="filter-section">
        <header>Agentes</header>
        <p>
          <span class="label <?php echo ($entity->isPropertyRequired($entity,"filtro_agent_term_area") && $editEntity? 'required': '');?>">Área de Atuação do Agente: </span>
          <span class="js-editable" data-edit="filtro_agent_term_area" data-original-title="Área de Atuação" data-emptytext="Selecione a(s) área(s) de atuação"><?php printSubsiteFilter($entity->filtro_agent_term_area) ?></span>
        </p>
        <p>
          <span class="label <?php echo ($entity->isPropertyRequired($entity,"filtro_agent_meta_En_Estado") && $editEntity? 'required': '');?>">Estado(s): </span>
          <span class="js-editable" data-edit="filtro_agent_meta_En_Estado" data-original-title="Estado(s)" data-emptytext="Selecione o(s) estado(s) para o(s) Agente(s)"><?php printSubsiteFilter($entity->filtro_agent_meta_En_Estado) ?></span>
        </p>
        <p>
          <span class="label <?php echo ($entity->isPropertyRequired($entity,"filtro_agent_meta_En_Municipio") && $editEntity? 'required': '');?>">Municipio(s): </span>
          <span class="js-editable" data-edit="filtro_agent_meta_En_Municipio" data-original-title="Município" data-emptytext="Selecione o(s) município(s) para o(s) Agente(s)"><?php printSubsiteFilter($entity->filtro_agent_meta_En_Municipio) ?></span>
        </p>
        <p>
          <span class="label <?php echo ($entity->isPropertyRequired($entity,"filtro_agent_meta_En_Bairro") && $editEntity? 'required': '');?>">Bairro(s): </span>
          <span class="js-editable" data-edit="filtro_agent_meta_En_Bairro" data-original-title="Bairro" data-emptytext="Selecione o(s) bairro(s) para o(s) Agente(s)"><?php printSubsiteFilter($entity->filtro_agent_meta_En_Bairro) ?></span>
        </p>
        <p>
          <span class="label">Exibir somente Agentes cadastrados por este site</span>
          <span class="js-editable" data-edit="show_instance_only_agent" data-original-title="Exibir somente Agentes cadastrados por este site"><?php echo $entity->show_instance_only_agent ?></span>
        </p>
    </section>

    <section class="filter-section">
        <header>Espaços</header>
        <p>
          <span class="label <?php echo ($entity->isPropertyRequired($entity,"filtro_space_term_area") && $editEntity? 'required': '');?>">Área de Atuação do Espaço: </span>
          <span class="js-editable" data-edit="filtro_space_term_area" data-original-title="Área de Atuação" data-emptytext="Selecione a(s) área(s) de atuação"><?php printSubsiteFilter($entity->filtro_space_term_area) ?></span>
        </p>
        <p>
          <span class="label <?php echo ($entity->isPropertyRequired($entity,"filtro_space_meta_type") && $editEntity? 'required': '');?>">Tipo de Espaço: </span>
          <span class="js-editable" data-edit="filtro_space_meta_type" data-original-title="Tipo de Espaço" data-emptytext="Selecione o(s) tipo(s) de espaço(s)"><?php printSubsiteFilter($entity->filtro_space_meta_type) ?></span>
        </p>

        <p>
          <span class="label <?php echo ($entity->isPropertyRequired($entity,"filtro_space_meta_En_Estado") && $editEntity? 'required': '');?>">Estado: </span>
          <span class="js-editable" data-edit="filtro_space_meta_En_Estado" data-original-title="Estado" data-emptytext="Selecione o(s) estado(s) para o(s) Espaço(s)"><?php printSubsiteFilter($entity->filtro_space_meta_En_Estado) ?></span>
        </p>
        <p>
          <span class="label <?php echo ($entity->isPropertyRequired($entity,"filtro_space_meta_En_Municipio") && $editEntity? 'required': '');?>">Municipio(s): </span>
          <span class="js-editable" data-edit="filtro_space_meta_En_Municipio" data-original-title="Município" data-emptytext="Selecione o(s) município(s) para o(s) Agente(s)"><?php printSubsiteFilter($entity->filtro_space_meta_En_Municipio) ?></span>
        </p>
        <p>
          <span class="label <?php echo ($entity->isPropertyRequired($entity,"filtro_space_meta_En_Bairro") && $editEntity? 'required': '');?>">Bairro(s): </span>
          <span class="js-editable" data-edit="filtro_space_meta_En_Bairro" data-original-title="Bairro" data-emptytext="Selecione o(s) bairro(s) para o(s) Agente(s)"><?php printSubsiteFilter($entity->filtro_space_meta_En_Bairro) ?></span>
        </p>
        <p>
          <span class="label">Exibir somente Espaços cadastrados por este site</span>
          <span class="js-editable" data-edit="show_instance_only_space" data-original-title="Exibir somente Espaços cadastrados por este site"><?php echo $entity->show_instance_only_space ?></span>
        </p>
    </section>

    <section class="filter-section">
        <header>Eventos</header>
        <p>
            <span class="label <?php echo ($entity->isPropertyRequired($entity,"filtro_event_term_linguagem") && $editEntity? 'required': '');?>">Linguagem: </span>
            <span class="js-editable" data-edit="filtro_event_term_linguagem" data-original-title="Linguagem" data-emptytext="Selecione o(s) tipos(s) de linguagem"><?php printSubsiteFilter($entity->filtro_event_term_linguagem) ?></span>
        </p>
        <p>
          <span class="label">Exibir somente Eventos cadastrados por este site</span>
          <span class="js-editable" data-edit="show_instance_only_event" data-original-title="Exibir somente Eventos cadastrados por este site"><?php echo $entity->show_instance_only_event ?></span>
        </p>
    </section>

    <section class="filter-section">
        <header>Projetos</header>
        <p>
          <span class="label">Exibir somente Projetos cadastrados por este site</span>
          <span class="js-editable" data-edit="show_instance_only_project" data-original-title="Exibir somente Projetos cadastrados por este site"><?php echo $entity->show_instance_only_project ?></span>
        </p>
    </section>

    <section class="filter-section">
        <header>Selos Verificadores</header>
            <span class="label <?php echo ($entity->isPropertyRequired($entity, "verifiedSeals") && $editEntity ? 'required' : ''); ?>">Selos: </span>
        <div class="subsite-related-seal-configuration" ng-controller="SealsSubSiteController">
            <div class="selos-relacionados">
                <input type="hidden" id="verifiedSeals" name="verifiedSeals" class="js-editable" data-edit="verifiedSeals" data-name="verifiedSeals" data-value="<?php printSubsiteFilter($entity->verifiedSeals) ?>">
                <edit-box id='set-seal-subsite' cancel-label="Cancelar" close-on-cancel='true'>
                    <div ng-if="seals.length > 0" class="widget">
                        <div class="selos clearfix">
                            <div class="avatar-seal modal" ng-repeat="seal in seals" ng-class="{pending: seal.status < 0}"  ng-click="setSeal(seal)">
                                <img ng-src="{{avatarUrl(seal['@files:avatar.avatarSmall'].url)}}" width="48">
                                <h3>{{seal.name}}</h3>
                            </div>
                        </div>
                    </div>
                </edit-box>
                <div class="widget">
                    <div class="selos clearfix">
                        <div ng-if="entity.verifiedSeals.length > 0" class="avatar-seal" ng-repeat="item in entity.verifiedSeals">
                            <img ng-if="item" class="img-seal" ng-src="{{avatarUrl(allowedSeals[getArrIndexBySealId(item)]['@files:avatar.avatarSmall'].url)}}">
                            <div class="botoes"><a class="delete hltip js-remove-item"  data-href="" data-target="" data-confirm-message="" title="Excluir selo" ng-click="removeSeal(item)"></a></div>
                            <div ng-if="item" class="descricao-do-selo">
                                <h1><a href="{{allowedSeals[getArrIndexBySealId(item)].singleUrl}}" class="ng-binding">{{allowedSeals[getArrIndexBySealId(item)].name}}</a></h1>
                            </div>
                        </div>
                        <div ng-if="seals.length > 0" ng-click="editbox.open('set-seal-subsite', $event)" class="hltip editable editable-empty" title="Adicionar selo"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>