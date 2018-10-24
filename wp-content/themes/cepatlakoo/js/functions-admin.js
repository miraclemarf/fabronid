jQuery(document).ready(function($) {
    var navListItems = $('ul.setup-panel li a'),
        allWells = $('.setup-content');

    allWells.hide();

    navListItems.click(function(e)
    {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this).closest('li');
        
        if (!$item.hasClass('disabled')) {
            navListItems.closest('li').removeClass('active');
            $item.addClass('active');
            allWells.hide();
            $target.show();
        }
    });
    
    $('ul.setup-panel li.active a').trigger('click');

    $(document).on('click', ".cl-migration", function(e) {
      $(this).hide();
      $('.migration-loader').show();
        $.ajax({
        url : wpadmin_ajax.ajax_url,
        type : 'post',
        data : {
          action : 'cl_migration',
        },
        success : function( response ) {
            if( response == 1 ){
              $('.cl-notif').text( wpadmin_ajax.texdomain[0] );
              $('.cl-migration').remove();
              window.location.href = wpadmin_ajax.admin_url + 'admin.php?page=cepatlakoo&tab=0';
            }else{
              $('.cl-notif').text( wpadmin_ajax.texdomain[1] );
              var str = window.location.href;
              if (str.toLowerCase().indexOf("tgmpa") < 0){
                window.location.href = wpadmin_ajax.admin_url + 'themes.php?page=tgmpa-install-plugins';
              }
            }
            $('.migration-loader').hide();
            $(this).show();
          }
        });
    });

    $(document).on('click', ".cl-active-redux", function(e) {
      $(this).hide();
      $('.migration-loader').show();
        $.ajax({
        url : wpadmin_ajax.ajax_url,
        type : 'post',
        data : {
          action : 'cl_active_redux',
        },
        success : function( response ) {
            if( response == 1 ){
              $('.cl-notif').text( wpadmin_ajax.texdomain[2] );
              $('.cl-active-redux').remove();
              window.location.href = wpadmin_ajax.admin_url + 'options-general.php?page=cepatlakoo_migration_menu';
              $('.migration-loader').hide();
            }else{
              $('.cl-notif').text( wpadmin_ajax.texdomain[1] );
              var str = window.location.href;
              if (str.toLowerCase().indexOf("tgmpa") < 3){
                window.location.href = wpadmin_ajax.admin_url + 'themes.php?page=tgmpa-install-plugins';
                $('.migration-loader').hide();
              }
            }
          }
        });
    });

});
