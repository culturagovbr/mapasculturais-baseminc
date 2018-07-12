(function (angular) {
    "use strict";

    var module = angular.module('entity.controller.agentTypes', ['ngSanitize']);

    module.controller('AgentTypesController',['$scope', 'EditBox', '$timeout', '$window', function($scope, EditBox, $timeout, $window) {
        $scope.editBox = EditBox;
        var type = 1;
        var typesIndividuais = MapasCulturais.agentTypesIndividuais;
        var typesColetivos = MapasCulturais.agentTypes;
        var n1 = MapasCulturais.entity.tipologia_nivel1;
        var n2 = MapasCulturais.entity.tipologia_nivel2;
        var n3 = MapasCulturais.entity.tipologia_nivel3;
        var cbo_cod = MapasCulturais.entity.tipologia_individual_cbo_cod;
        var cbo_ocupacao = MapasCulturais.entity.tipologia_individual_cbo_ocupacao;

        if (n1 && n2 && n3 && !cbo_cod && !cbo_ocupacao) {
            type = 2;
        }

        typesColetivos.__values = Object.keys(typesColetivos);
        typesColetivos.__values.forEach(function(val){
            typesColetivos[val].__values = Object.keys(typesColetivos[val]);
        });

        $timeout(function() {
            $('.find-typology .result-container').scroll(function() {
                var innerHeight = this.scrollHeight;
                var scroll = jQuery(this).scrollTop();
                var height = jQuery(this).height();
                var bottomY = innerHeight - height - scroll;
                if (bottomY < height) {
                    $scope.data.currentFind.paginating = true;
                    $scope.find(10);
                    $scope.$apply();
                }
            }).bind('mousewheel DOMMouseScroll', function (e) {
                var e0 = e.originalEvent,
                    delta = e0.wheelDelta || -e0.detail;
                this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                e.preventDefault();
            });

            var classType = ''
            if(MapasCulturais.request.controller == 'space')
                classType = 'Linked';

            $('.js-editable-type' + classType).on('save', function(e, params) {
                /*
                    Ao inicializar os valores das tipologias com o valor "false" faz com que as regras de validação dos metadados sejam desrespeitadas.
                    ao selecionar uma tipologia para um determinado tipo os valores dos campos da tipologia para o outro tipo de agente terão seus valores uma string vazia
                    condição suficiente para ser aceito pela validação dos metadados (validação de obrigatoriedade fraca).
                */
                type = params.newValue;
                $scope.data.tipologia1 = false;
                $scope.data.tipologia2 = false;
                $scope.data.tipologia3 = false;                
                $scope.data.type_individual_selected.codigo = false;
                $scope.data.type_individual_selected.ocupacao = false;
                setEditables();
                $scope.$apply();
            });
        });

        $scope.data = {
            _tipo1: n1,
            _tipo2: n2,
            _tipo3: n3,
                        
            tipologia1: n1,
            tipologia2: n2,
            tipologia3: n3,
            
            _types: typesColetivos,
            _valores_nivel1: typesColetivos.__values,
            _valores_nivel2: n1 ? typesColetivos[n1].__values : [],
            _valores_nivel3: n2 ? typesColetivos[n1][n2] : [],

            searchText : '',
            result : [],
            type_individual_selected : {"codigo":cbo_cod,"ocupacao":cbo_ocupacao,"familia":""},
            currentFind : {"currentRowFamilia":0, "currentRowOcupacao":0, "paginating":false}                
        };
        
        $scope.set = function(n){
            if(n === 1){
                $scope.data._valores_nivel2 = typesColetivos[$scope.data._tipo1].__values;
                $scope.data._valores_nivel3 = [];
                
                $scope.data._tipo2 = '';
                $scope.data._tipo3 = '';
                
            } else if (n === 2) {
                $scope.data._valores_nivel3 = typesColetivos[$scope.data._tipo1][$scope.data._tipo2];
                $scope.data._tipo3 = '';
            }
        };
        
        var setEditables = function(){
            $('#tipologia_nivel1').first().editable('setValue', $scope.data.tipologia1);
            $('#tipologia_nivel2').first().editable('setValue', $scope.data.tipologia2);
            $('#tipologia_nivel3').first().editable('setValue', $scope.data.tipologia3);
            $('#tipologia_individual_cbo_cod').first().editable('setValue', $scope.data.type_individual_selected.codigo);
            $('#tipologia_individual_cbo_ocupacao').first().editable('setValue', $scope.data.type_individual_selected.ocupacao);
        };
        
        setEditables();
        
        $scope.setTypes = function() {            
            if (type == 2) {
                $scope.data.tipologia1 = $scope.data._tipo1;
                $scope.data.tipologia2 = $scope.data._tipo2;
                $scope.data.tipologia3 = $scope.data._tipo3;
                $scope.data.type_individual_selected.codigo = "";
                $scope.data.type_individual_selected.ocupacao = "";
                $scope.data.searchText = "";
                                
                setEditables();
                
                $scope.data.tipologia = $scope.data._tipo3;
                EditBox.close('eb-tipologia-coletiva');
            } else {
                $scope.data.tipologia1 = "";
                $scope.data.tipologia2 = "";
                $scope.data.tipologia3 = "";
                setEditables();
                EditBox.close('eb-tipologia-individual');
            }
        };
        
        
        $scope.resetValues = function(){
            $scope.data._tipo1 = $scope.data.tipologia1;
            $scope.data._tipo2 = $scope.data.tipologia2;
            $scope.data._tipo3 = $scope.data.tipologia3;
        };

        
        $scope.openModalType = function(e) {            
            if (type == 2) {
                $scope.editBox.open('eb-tipologia-coletiva', e);
            } else {                
                $scope.editBox.open('eb-tipologia-individual', e);
            }
        };

        $scope.selected = function(typology) {
            $scope.data.type_individual_selected = typology;
            $scope.data.searchText = $scope.data.type_individual_selected.ocupacao;
            $scope.data.result = [];
            this.setTypes();
        };

        $scope.getCurrentTypology  = function () {
            if (type == 2 && $scope.data.tipologia3 != "") {
                return $scope.data.tipologia3;
            }
            else if (type == 1 && $scope.data.type_individual_selected.codigo != "") {
                return $scope.data.type_individual_selected.codigo + " - " + $scope.data.type_individual_selected.ocupacao;
            }
            return "Escolha uma tipologia";
        };

        $scope.startFind = function (time) {             
            $scope.data.currentFind.paginating = false;
            $scope.find(10);
        }

        $scope.find = function (time) {            
            if ($scope.data.currentFind.paginating == false) {
                $scope.data.currentFind.currentRowFamilia = 0;
                $scope.data.currentFind.currentRowOcupacao = 0;
            }

            var s = $scope.data.searchText.trim();
            if (parseInt(s) != s && s.length < 4) {
                $scope.data.result = [];
                return;
            }            

            var data = [];
            var limit = 10;

            for ( $scope.data.currentFind.currentRowFamilia;
                  $scope.data.currentFind.currentRowFamilia < typesIndividuais.length && limit > 0;
                  $scope.data.currentFind.currentRowFamilia++) {
                var f = $scope.data.currentFind.currentRowFamilia;
                
                for ($scope.data.currentFind.currentRowOcupacao = 0;
                     $scope.data.currentFind.currentRowOcupacao < typesIndividuais[f].ocupacoes.length && limit > 0;
                     $scope.data.currentFind.currentRowOcupacao++) {
                    var t = $scope.data.currentFind.currentRowOcupacao;
                    var type = typesIndividuais[f].ocupacoes[t];
                    if(type.ocupacao.toLowerCase().indexOf(s.toLowerCase())==0) {
                        data.push({
                             "codigo":type.codigo,
                             "ocupacao":type.ocupacao,
                             "familia":typesIndividuais[f].familia});
                        limit--;
                    }
                }
            }
                       
            if (data.length > 0) {
                if ($scope.data.currentFind.paginating == false)
                    $scope.data.result = data;
                else {
                    $scope.data.result = $scope.data.result.concat(data);
                }
            } else if ($scope.data.currentFind.paginating == false) {
                $scope.data.result = [];
            }
        };

    }]);
})(angular);