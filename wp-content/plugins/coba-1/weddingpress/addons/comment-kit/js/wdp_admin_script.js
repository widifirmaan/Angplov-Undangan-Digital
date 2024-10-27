jQuery(document).ready(function ($) {
    //Tabs Navigation Admin
    $(".wdp-tab-content").hide(); //Hide all content
    $("#wdp-tabs a:first").addClass("nav-tab-active").show(); //Activate first tab
    $(".wdp-tab-content:first").show(); //Show first tab content

    //On Click Event
    $("#wdp-tabs a").click(function () {
        $("#wdp-tabs a").removeClass("nav-tab-active"); //Remove any "active" class
        $(this).addClass("nav-tab-active"); //Add "active" class to selected tab
        $(".wdp-tab-content").removeClass("active").hide(); //Remove any "active" class and Hide all tab content
        var activeTab = $(this).attr("href"); //Find the rel attribute value to identify the active tab + content
        $(activeTab).fadeIn().addClass("active"); //Fade in the active content
        return false;
    });


    // Activa ColorPicker en la Página de Opciones
    if (typeof jQuery.fn.wpColorPicker == 'function') {
        $('.wdp-colorpicker').wpColorPicker();
    }

    $('input[name="wdp_options[auto_show]"]').click(function () {

    });

    function showHideFieldBox_CUI(radioItem, box) {
        if ($(radioItem).is(':checked'))
            $(box).fadeIn();
        else
            $(box).fadeOut();
    }


    $('select[name="export_post_type"]').on('change', function (e) {
        var parrent = $(this).closest('#wdp-tab-data-export'),export_post_type = $(this).val();
        if (export_post_type.length === 1 && export_post_type[0] === 'custom') {
            parrent.find('#custom-export-ids').show()
            parrent.find('#custom-export-exclude-ids').hide()
        } else {
            parrent.find('#custom-export-ids').hide();
            parrent.find('#custom-export-exclude-ids').show();
        }
    });



    function exportCSVFile(headers, items, fileTitle) {
        if (headers) {
           // items.unshift(headers);
        }

        // Convert Object to JSON
       // var jsonObject = JSON.stringify(items);

        var csv = generate_csv_from_json(items);

        var exportedFilename = fileTitle + '.csv' || 'export.csv';

        var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        if (navigator.msSaveBlob) { // IE 10+
            navigator.msSaveBlob(blob, exportedFilename);
        } else {
            var link = document.createElement("a");
            if (link.download !== undefined) { // feature detection
                // Browsers that support HTML5 download attribute
                var url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", exportedFilename);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    }

    $('button[data-content="button-export"]').click(function (e) {
        e.preventDefault();
        var parrent = $(this).closest('#wdp-tab-data-export'),
            export_post_type = parrent.find('select[name="export_post_type"]').val(),
            ids = parrent.find('input[name="export_ids"]').val(),
            exclude_to_export = parrent.find('input[name="exclude_to_export"]').val(),
            _token = parrent.find('input[name="_token"]').val()
        ;
        $.ajax({
            type: "post",
            dataType: 'json',
            url: window.ajaxurl,
            data: {
                ids: ids,
                post_type: export_post_type,
                exclude_pages: exclude_to_export,
                _token: _token,
                action: 'wp_comment_export_data_to_csv'
            },
            success:function (response) {
                if (response.success){
                    var data = response.data;
                   exportCSVFile(data.header,data.comments,data.file_name)
                    // console.log(generate_csv_from_json(data.comments))
                }
            }
        })

    })


    function generate_csv_from_json(items) {
        var replacer = (key, value) => value === null ? '' : value.replace(/,/g, '') // specify how you want to handle null values here
        var header = Object.keys(items[0])
        var csv = [
            header.join(','), // header row first
            ...items.map(row => header.map(fieldName => JSON.stringify(row[fieldName], replacer)).join(','))
        ].join('\r\n')

        return csv;
    }
});
