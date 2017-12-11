<?php if($this->isEditable()): ?>
<div class="entity-type agent-type" ng-controller="AgentTypesController">
    <div class="icon icon-agent"></div>
    <a class="required editable" ng-click="editBox.open('eb-tipologia', $event)"> {{data.tipologia3 ? data.tipologia3 : 'Escolha uma tipologia'}}</a>

    <edit-box id="eb-tipologia" position="bottom" cancel-label="Cancelar" submit-label="Enviar" on-submit="setTypes" on-cancel="resetValues" close-on-cancel="1">
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
</div>
<!--.entity-type-->
<?php else: ?>
    <div class="entity-type agent-type">
        <div class="icon icon-agent"></div>
        <a href="#"><?php echo $entity->tipologia_nivel3 ?></a>
    </div>
<?php endif; ?>