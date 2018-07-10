$(document).ready(function() {
    var typology_select = '.create-entity select[name="type"]';
    if ($(typology_select).length > 0) {

        /*
        * Conforme enviado para a API:
        * 1 = Individual
        * 2 = Coletivo
        * */
        var typology = { individual: 1, coletivo: 2 };
        $(typology_select).change(function() {
            var _toggable = '.tipologias';
            $(_toggable).toggle();

        });

        $('.tipologias-individuais-agente').select2({
            width: '100%'
        });
    }
});