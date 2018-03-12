<?php if($this->isEditable()): ?>
<div class="entity-type agent-type" ng-controller="AgentTypesController">
    <div class="icon icon-agent"></div>
    
    <a id="edit-tipologia" class="required editable" ng-click="openModalType($event)"> {{getCurrentTypology()}}</a>    

    <edit-box id="eb-tipologia-coletiva" position="bottom" cancel-label="Cancelar" submit-label="Enviar" on-submit="setTypes" on-cancel="resetValues" close-on-cancel="1">
        <input type="hidden" id="tipologia_nivel1" class="js-editable" data-edit="tipologia_nivel1" data-emptytext="">
        <input type="hidden" id="tipologia_nivel2" class="js-editable" data-edit="tipologia_nivel2" data-emptytext="">
        <input type="hidden" id="tipologia_nivel3" class="js-editable" data-edit="tipologia_nivel3" data-emptytext="">
        <label>
            nível 1:
            <select ng-model="data._tipo1" ng-change="set(1)">
                <option ng-repeat="val in data._valores_nivel1" ng-value="val">{{val}}</option>
            </select>
        </label>
        <label ng-show="data._tipo1">
            nível 2:
            <select ng-model="data._tipo2"  ng-change="set(2)">
                <option ng-repeat="val in data._valores_nivel2" ng-value="val">{{val}}</option>
            </select>
        </label>
        <label ng-show="data._tipo2">
            nível 3:
            <select ng-model="data._tipo3">
                <option ng-repeat="val in data._valores_nivel3" ng-value="val">{{val}}</option>
            </select>
        </label>
    </edit-box>

    <edit-box id="eb-tipologia-individual" position="bottom" cancel-label="Cancelar" on-cancel="resetValues" close-on-cancel="1">
        <label>Tipologia:</label>
        <input type="hidden" id="tipologia_individual_cbo_cod" class="js-editable" data-edit="tipologia_individual" data-emptytext="">
        <input type="hidden" id="tipologia_individual_cbo_ocupacao" class="js-editable" data-edit="tipologia_individual" data-emptytext="">
        
        <div class="find-typology">
            <input id="seachTexTypologyIndividual" ng-model="data.searchText" ng-change="startFind()" placeholder="buscar tipologia"/>
            
            <div class="result-container">
                
                <ul class="search-typology-list">
                    <li class="search-typology clearfix" ng-repeat="typology in data.result" ng-click="selected(typology)" >
                        <span><b>{{typology.codigo}} - {{typology.ocupacao}}</b></span><br />
                        <span class="typology_familia">{{typology.familia}}</span>
                    </li>
                </ul>
            </div>
        </div>
    </edit-box>


</div>
<!--.entity-type-->
<?php else: ?>
<div class="entity-type agent-type" ng-controller="AgentTypesController">
    <div class="entity-type agent-type">
        <div class="icon icon-agent"></div>        
        <a href="#">
            <?php
                if ($entity->tipologia_nivel3 != "")
                    echo $entity->tipologia_nivel3;
                else
                    echo "$entity->tipologia_individual_cbo_cod - $entity->tipologia_individual_cbo_ocupacao"
            ?>
        </a>        
    </div>
</div>
<?php endif; ?>