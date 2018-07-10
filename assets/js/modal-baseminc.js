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

        var nivel1 = 'select[name="tipologia_nivel1"]';
        var nivel2 = 'select[name="tipologia_nivel2"]';
        var nivel3 = 'select[name="tipologia_nivel3"]';
        $(nivel1).change(function () {
           var selected = $("option:selected:first",this).val();
           if (selected && selected.length > 0) {
               var selected_class = $("option:selected:first", this).attr('class');
               $(".nivel2").show();
               $(nivel2).val(0);
               hideIfNot(selected_class, (nivel2 + ' > option') );
           } else {
               $(".nivel2").hide();
           }
        });

        $(nivel2).change(function () {
            var selected = $("option:selected:first",this).val();
            if (selected && selected.length > 0) {
                var selected_class = $("option:selected:first", this).attr('class');
                $(".nivel3").show();
                $(nivel3).val(0);

                console.log(selected);
                console.log(selected_class);

                hideIfNot(selected_class, (nivel3 + ' > option') );
            } else {
                $(".nivel3").hide();
            }
        });
    }

    function hideIfNot(className, options) {
        // var options = 'select[name="tipologia_nivel2"] > option';
        $(options).show();
        $(options).each(function (idx, el) {
            var opt_class = $(el).attr('class'); // console.log( $(this).attr('class') );
            if (opt_class !== className) {
                $(this).hide();
            }
        });

        /*
        var options = 'select[name="tipologia_nivel3"] > option';
        $(options).show();
        $(options).each(function (idx, el) {
            var opt_class = $(el).attr('class'); // console.log( $(this).attr('class') );
            if (opt_class !== className) {
                $(this).hide();
            }
        }); */
    }
});