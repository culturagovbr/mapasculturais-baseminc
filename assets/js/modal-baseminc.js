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
            width: '100%',
            placeholder: "Selecione a tipologia individual para o novo agente",
            allowClear: true
        });

        var t_individual = '.create-entity select[name="tipologia_individual_cbo_cod"]';
        $(t_individual).change(function () {
            var current_modal =  $(this).data('modal');
            var latest_value = $("option:selected:first",this).val();
            var t = $('#' + current_modal + " .create-entity option[value='" + latest_value + "']").text();

            $('#' + current_modal + ' input[name="tipologia_individual_cbo_ocupacao"]').val(t);
        });
    }
});