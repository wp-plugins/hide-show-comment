jQuery(document).ready(function($){
    /**
     * Ace editor
     */
    var editor = ace.edit("ace-editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/css");
    editor.getSession().on('change', function(e) {
        var code = editor.getSession().getValue();

        jQuery("#ace_editor_value").val(code);        
        preview_button();
    });

    /**
     * Select2
     */
    function format(state) {
        if (!state.id) return state.text; // optgroup

        var name_select = state.id.toLowerCase();
        var name_select_array = name_select.split('-premium');

        if(name_select_array[1] == 'true')
        {
            var button = hsc_button_premium_dir_name + name_select_array[0];
        }
        else
        {
            var button = hsc_button_dir_name + name_select_array[0];
        }

        return "<div><img class='images' src='" + button + ".png'/></div>" + "<p>" + state.text + "</p>";
    }
    $("select[name='tonjoo_hsc_options[button_skin]']").select2({
        formatResult: format,
        formatSelection: format,
        escapeMarkup: function(m) { return m; }
    }).on("change", function(e) {
            preview_button(); 
    });
    $("select[name='tonjoo_hsc_options[loadmore_skin]']").select2({
        formatResult: format,
        formatSelection: format,
        escapeMarkup: function(m) { return m; }
    }).on("change", function(e) {
            preview_button_loadmore(); 
    });


    /**
     * Hide Show Button Preview
     *
     * @since   1.0.5
     */
    $("input[name='tonjoo_hsc_options[show_button_text]']").on('keyup',function(){
        preview_button(); 
    })
    $("select[name='tonjoo_hsc_options[align]']").on('change',function(){
        preview_button(); 
    })
    $("select[name='tonjoo_hsc_options[hideshow_animation]']").on('change',function(){
        if(hsc_premium_enable == false)
        {
            alert('Please purchase the premium edition to enable this feature');
            $("select[name='tonjoo_hsc_options[hideshow_animation]']").val('none');
        }
    })
    $("select[name='tonjoo_hsc_options[button_font]']").on('change',function(){
        if(hsc_premium_enable == false)
        {
            alert('Please purchase the premium edition to enable this feature');
            $("select[name='tonjoo_hsc_options[button_font]']").val('Open Sans');
        }
        else
        {
            preview_button(); 
        }
    })
    $("input[name='tonjoo_hsc_options[button_font_size]']").on('keyup mouseup',function(){        
        preview_button(); 
    })
    $("select[name='tonjoo_hsc_options[template]']").on('change',function(){
        if(hsc_premium_enable == false)
        {
            alert('Please purchase the premium edition to enable this feature');
            $("select[name='tonjoo_hsc_options[template]']").val('button_only');
        }
        else
        {
            if($(this).val() == 'button_only')
            {
                document.getElementById('custom_template').value = '{button}';
            }
            else if($(this).val() == 'count_and_button')
            {
                document.getElementById('custom_template').value = '{count} Comments &nbsp; {button}';
            }
            else if($(this).val() == 'count')
            {
                document.getElementById('custom_template').value = '{count} Comments';
            }

            preview_button(); 
        }
        
    })
    $("textarea[name='tonjoo_hsc_options[custom_template]']").on('keyup',function(){
        if(hsc_premium_enable == false)
        {
            alert('Please purchase the premium edition to enable this feature');
            $("select[name='tonjoo_hsc_options[button_font]']").val('Open Sans');
        }
        else
        {
            preview_button(); 
        }
    })

    function preview_button()
    {
        var button_skin = $("select[name='tonjoo_hsc_options[button_skin]']").val();
        var lasSubstring = button_skin.substr(button_skin.length - 12);

        if(hsc_premium_enable == false && lasSubstring == "-PREMIUMtrue")
        {
            alert('Please purchase the premium edition to enable this feature');
            $("select[name='tonjoo_hsc_options[button_skin]']").select2("val", "hsc-buttonskin-none");

            button_skin = "hsc-buttonskin-none";
        }
        
        data = {
            action: 'hsc_preview_button',
            show_button_text: $("input[name='tonjoo_hsc_options[show_button_text]']").val(),
            align: $("select[name='tonjoo_hsc_options[align]']").val(),
            button_font: $("select[name='tonjoo_hsc_options[button_font]']").val(),            
            button_font_size: $("input[name='tonjoo_hsc_options[button_font_size]']").val(),
            template: $("select[name='tonjoo_hsc_options[template]']").val(),
            custom_template: document.getElementById('custom_template').value,
            button_skin: button_skin,
            custom_css: editor.getSession().getValue()
        }

        // $('#hsc_ajax_preview_button').html("<img src='" + hsc_dir_name + "/assets/loading.gif'>");

        $.post(ajaxurl, data,function(response){
            $('#hsc_ajax_preview_button').html(response);
        });
    }


    /**
     * Load More Button Preview
     *
     * @since   1.0.5
     */
    $("input[name='tonjoo_hsc_options[loadmore_button_text]']").on('keyup',function(){
        preview_button_loadmore(); 
    })
    $("select[name='tonjoo_hsc_options[loadmore_align]']").on('change',function(){
        preview_button_loadmore(); 
    })
    $("select[name='tonjoo_hsc_options[loadmore_animation]']").on('change',function(){
        if(hsc_premium_enable == false)
        {
            alert('Please purchase the premium edition to enable this feature');
            $("select[name='tonjoo_hsc_options[loadmore_animation]']").val('none');
        }
    })
    $("select[name='tonjoo_hsc_options[loadmore_font]']").on('change',function(){
        if(hsc_premium_enable == false)
        {
            alert('Please purchase the premium edition to enable this feature');
            $("select[name='tonjoo_hsc_options[loadmore_font]']").val('Open Sans');
        }
        else
        {
            preview_button_loadmore(); 
        }
    })
    $("select[name='tonjoo_hsc_options[loadmore_load_number]']").on('change',function(){
        if(hsc_premium_enable == false)
        {
            alert('Please purchase the premium edition to enable this feature');
            $("select[name='tonjoo_hsc_options[loadmore_load_number]']").val('3');
        }
    })    
    $("input[name='tonjoo_hsc_options[loadmore_font_size]']").on('keyup mouseup',function(){        
        preview_button_loadmore(); 
    })

    function preview_button_loadmore()
    {
        var button_skin = $("select[name='tonjoo_hsc_options[loadmore_skin]']").val();
        var lasSubstring = button_skin.substr(button_skin.length - 12);

        if(hsc_premium_enable == false && lasSubstring == "-PREMIUMtrue")
        {
            alert('Please purchase the premium edition to enable this feature');
            $("select[name='tonjoo_hsc_options[loadmore_skin]']").select2("val", "hsc-buttonskin-none");

            button_skin = "hsc-buttonskin-none";
        }
        
        data = {
            action: 'hsc_preview_button_loadmore',
            loadmore_button_text: $("input[name='tonjoo_hsc_options[loadmore_button_text]']").val(),
            loadmore_align: $("select[name='tonjoo_hsc_options[loadmore_align]']").val(),
            loadmore_font: $("select[name='tonjoo_hsc_options[loadmore_font]']").val(),            
            loadmore_font_size: $("input[name='tonjoo_hsc_options[loadmore_font_size]']").val(),
            loadmore_skin: button_skin,
            custom_css: editor.getSession().getValue()
        }

        // $('#hsc_ajax_preview_button').html("<img src='" + hsc_dir_name + "/assets/loading.gif'>");

        $.post(ajaxurl, data,function(response){
            $('#hsc_ajax_preview_button_loadmore').html(response);
        });
    }


    /**
     * Advanced settings
     *
     * @since   1.0.5
     */
    var identifierChanger = $("select[name='tonjoo_hsc_options[identifier_type]']");

    if(identifierChanger.val() == 'auto')
    {
        $('.advanced-form').css('display','none');
    }    

    identifierChanger.on('change',function(){
        if($(this).val() == 'auto')
        {
            $('.advanced-form').hide();
        }
        else
        {
            $('.advanced-form').show();
        }
    })


    /**
     * Run on start
     */
    preview_button();
    preview_button_loadmore();
});