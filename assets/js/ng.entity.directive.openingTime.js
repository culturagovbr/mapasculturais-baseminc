(function (angular) {
    "use strict";
    angular.module('entity.directive.openingTime', [])
        .directive('openingTime', ['EditBox', '$log', function (EditBox, $log) {
            return {
                restrict: 'E',
                templateUrl: MapasCulturais.templateUrl.spaceOpeningTime,
                scope: {
                    entityProperty: '@',
                    emptyLabel: '@',
                    boxTitle: '@',
                    helpText: '@'
                },
                link: function ($scope, el, attrs) {
                   
                }
            };
        }]);
})(angular);