(function($) {
    'use strict';
    $(document).ready(function () {
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        };

        if(getUrlParameter('page') == 'cepatlakoo_input_resi'){
            $('.form-table').repeater({
                defaultValues: {
                    'text-input': '',
                },
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });

            var dataExp = $('input[name="cepatlakoo_ekspedisi"]').val().split(",");
            $('.data-item:first').remove();
            $.each(dataExp,function(i){
               $( '[data-repeater-list="data-ekspedisi"]' ).append( '<div data-repeater-item class="data-item"><input type="text" name="data-ekspedisi['+ i +'][text-input]" value="'+ dataExp[i] +'"> <input data-repeater-delete="" type="button" class="hapus" value="'+ _cl_inputresi.translation +'"></div>');
            });

            $("form").submit(function(e){
                console.log($("form").serialize());
                var dataItem = [];
                for (var i = 0; i < $('.data-item').length; i++) {
                    if(!$('input[name="data-ekspedisi['+ i +'][text-input]"]').val()){
                        $('input[name="data-ekspedisi['+ i +'][text-input]"]').siblings("[data-repeater-delete]").trigger('click');
                    }else{
                        dataItem.push($('input[name="data-ekspedisi['+ i +'][text-input]"]').val());
                    }
                }
                $('input[name="cepatlakoo_ekspedisi"]').val(dataItem.toString());
            });
        }

    });

})(jQuery);
