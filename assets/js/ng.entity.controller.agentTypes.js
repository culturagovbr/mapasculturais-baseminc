(function (angular) {
    "use strict";

    var module = angular.module('entity.controller.agentTypes', ['ngSanitize']);
    
    module.controller('AgentTypesController',['$scope', 'EditBox', function($scope, EditBox){
        $scope.editBox = EditBox;

        var type = 0;
        var typesIndividuais = MapasCulturais.agentTypesIndividuais;
        var typesColetivos = MapasCulturais.agentTypes;

        var n1 = MapasCulturais.entity.tipologia_nivel1;
        var n2 = MapasCulturais.entity.tipologia_nivel2;
        var n3 = MapasCulturais.entity.tipologia_nivel3;
        var cbo_cod = MapasCulturais.entity.tipologia_individual_cbo_cod;
        var cbo_ocupacao = MapasCulturais.entity.tipologia_individual_cbo_ocupacao;
        console.log(cbo_ocupacao);
        
        typesColetivos.__values = Object.keys(typesColetivos);
        typesColetivos.__values.forEach(function(val){
            typesColetivos[val].__values = Object.keys(typesColetivos[val]);
        });

        $('.js-editable-type').on('save', function(e, params) {
            type = params.newValue;
            $scope.data.tipologia3 = "";
            $scope.data.type_individual_selected.codigo = "";
            $scope.$apply();
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
            type_individual_selected : {"codigo":cbo_cod,"ocupacao":cbo_ocupacao,"familia":""}
            
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
            //var type = parseInt($('.js-editable-type').editable('getValue').type);            
            if (type == 2) {
                $scope.data.tipologia1 = $scope.data._tipo1;
                $scope.data.tipologia2 = $scope.data._tipo2;
                $scope.data.tipologia3 = $scope.data._tipo3;
                $scope.data.type_individual_selected.codigo = "";
                $scope.data.searchText = "";
                                
                setEditables();
                
                $scope.data.tipologia = $scope.data._tipo3;
                EditBox.close('eb-tipologia-coletiva');
            } else {
                $scope.data.tipologia1 = "";
                $scope.data.tipologia2 = "";
                $scope.data.tipologia3 = "";
                console.log($scope.data.type_individual_selected);
                console.log($scope.data.type_individual_selected.codigo);
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
            //var type = parseInt($('.js-editable-type').editable('getValue').type);
            if (type == 2) {
                $scope.editBox.open('eb-tipologia-coletiva', e);
            } else {                
                $scope.editBox.open('eb-tipologia-individual', e);
            }
        };

        $scope.selected = function(typology){
            $scope.data.type_individual_selected = typology;
            $scope.data.searchText = $scope.data.type_individual_selected.ocupacao;            
            $scope.data.result = [];            
        };

        $scope.getCurrentTypology  = function () {
            if ($scope.data.tipologia3 != "") {
                return $scope.data.tipologia3;
            }
            else if ($scope.data.type_individual_selected.codigo != "") {
                return $scope.data.type_individual_selected.codigo + " - " + $scope.data.type_individual_selected.ocupacao;
            }
            return "Escolha uma tipologia";
        };

        $scope.find = function (time) {
            
            var s = $scope.data.searchText.trim();
            if (parseInt(s) != s && s.length < 2) {
                 return;
            }            

            var data = [];
            var limint = 0;
            for (var f in typesIndividuais) {
                for (var t in typesIndividuais[f].ocupacoes) {
                    var type = typesIndividuais[f].ocupacoes[t];
                    if(type.ocupacao.toLowerCase().indexOf(s.toLowerCase())==0) {
                        data.push({
                             "codigo":type.codigo,
                             "ocupacao":type.ocupacao,
                             "familia":typesIndividuais[f].familia});
                        limint++;
                    }
                    if (limint > 6)
                        break;
                 }
                 if (limint > 6)
                        break;
            }
            $scope.data.result = data;            
        };       
        

    }]);
})(angular);