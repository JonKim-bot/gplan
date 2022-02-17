$.fn.customTable = function () {
    var table = $(this);
    var id = $(this).attr("id");
    var tclass = $("#" + id).attr("class");
    var method = $("#" + id).data("method");
    var url = $("#" + id).data("url");
    var thead = $("#" + id).find("thead")[0];
    var thead_row = $(thead).find("th");
    var tbody = $("#" + id).find("tbody")[0];
    var tbody_row = $(tbody).find("tr");
    var form_id = 1;

    $("#" + id).attr("class", tclass + " customTable");
    $("#" + id).html('');

    // create thead
    var html = "<thead id='" + id + "_head'>";
    html += "<tr>";
    $(thead_row).each(function (index, ele) {
        var text = $(ele).text();
        var custom_class = $(ele).attr('class');
        var filter = $(ele).data('filter');
        var value = "";
        if (custom_class === "" || custom_class === undefined) {
            custom_class = "";
        }
        if (filter === "" || filter === undefined) {
            filter = "";
        } else {
            value = getUrlParameter(filter);
            
            if(value === "" || value === undefined){
                value = "";
            }
        }

        html += '<th class="sorting_asc ' + custom_class + '">';
        html += '<div class="c-formgroup">';
        html += '<input type="text" class="form-filter custom_table_filter" data-form="' + form_id + '" placeholder="' + text + '" name="' + filter + '" form="custom_table_form_' + form_id + '" value="' + value + '">';
        html += '<a href="" class="c-sorticon">';
        html += '<i class="fas fa-sort"></i>';
        html += '</a>';
        html += ' </div>';
        html += '</th>';
    });
    html += "</tr>";
    html += "</thead>";
    $("#" + id).append(html);

    //create tbody
    html = "<tbody id='" + id + "_body'>";
    $(tbody_row).each(function (index, ele) {
        html += $(ele).prop('outerHTML');
    });
    html += "</tbody>";
    $("#" + id).append(html);

    var html = "<form class='custom_table_form' id='custom_table_form_" + form_id + "' data-id='" + form_id + "' data-method='" + method + "' data-url='" + url + "'></form>";
    $(html).insertAfter($("#" + id));
    form_id++;

    pagingInit(id);
    pagingFuncInit();
    formInit();
    formSubmit();
};

function pagingFuncInit(){
    var list = document.querySelectorAll(".page-link");
    for (var i = 0; i < list.length; i++) {
        list[i].addEventListener("click", function (e) {

            var param = $(this).data('param');
            var parent = $(this).closest($(".custom_pagination"));
            var method = $(parent).data("method");
            var table_id = $(parent).data("table");
            var parent_id = $(parent).attr("id");
            var table_wrapper = $("#" + table_id).data("wrap");
            var url = $(parent).data("url");
            var previousGet = getUrlParameter("", "page");
            previousGet = $.param(previousGet);
            if(previousGet != "" && previousGet != undefined){
                param += "&" + previousGet;
            }

            if (method === "get") {
                history.pushState('', '', param);
                $.get(param, function (result) {
                    var table = $(result).find('#' + table_id);
                    var tbody = $(table).find("tbody")[0];
                    var tbody_row = $(tbody).find("tr");

                    var pagination = $(result).find('.custom_pagination[data-table="' + table_id + '"]');

                    var html = "";
                    $(tbody_row).each(function (index, ele) {
                        html += $(ele).prop('outerHTML');
                    });
                    $('#' + table_id + "_body").html(html);

                    var html = $(pagination).find('nav').prop('outerHTML');
                    if(html === undefined){
                        html = "";
                    }

                    $('.custom_pagination[data-table="' + table_id + '"]').html(html);
                });
            }
            setTimeout(function () {
                pagingInit(table_id);
            }, 300);
            setTimeout(function () {
                pagingFuncInit();
            }, 300);
        });
    }
}

function pagingInit(id) {
    var method = $(".custom_pagination[data-table='" + id + "']").data('method');
    var url = $(".custom_pagination[data-table='" + id + "']").data('url');
    var links = $(".custom_pagination[data-table='" + id + "']").find($(".page-link"));
    $(links).each(function () {
        var page = $(this).data('page');
        if (page != undefined && page != "#") {
            var getParam = {
                page: page
            }
            getParam = $.param(getParam);
            $(this).attr("data-param", url + "?" + getParam);
            
        }
    });
}

function formInit(){
    var list = document.querySelectorAll(".custom_table_filter");
    for (var i = 0; i < list.length; i++) {
        list[i].addEventListener("keypress", function (e) {
            if (e.which == 13) {
                var form_id = $(this).data('form');
                $("#custom_table_form_" + form_id).submit();
            }
        });
    }
}

function formSubmit(){
    $('.custom_table_form').submit(function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var method = $(this).data("method");
        var url = $(this).data("url");
        var table = $(".customTable[data-url='" +  url+ "'][data-method='" + method + "']");
        var table_id = $(table).attr("id");

        if(method === "get"){
            var getParam = $(this).serializeArray();
            getParam = $.param(getParam);
            var param = url + "?" + getParam;
            history.pushState('', '', param);

            $.get(param, function (result) {
                var table = $(result).find('#' + table_id);
                var tbody = $(table).find("tbody")[0];
                var tbody_row = $(tbody).find("tr");

                var pagination = $(result).find('.custom_pagination[data-table="' + table_id + '"]');

                var html = "";
                $(tbody_row).each(function (index, ele) {
                    html += $(ele).prop('outerHTML');
                });
                $('#' + table_id + "_body").html(html);

                var html = $(pagination).find('nav').prop('outerHTML');
                if(html === undefined){
                    html = "";
                }

                $('.custom_pagination[data-table="' + table_id + '"]').html(html);
            });
        }
        setTimeout(function () {
            pagingInit(table_id);
        }, 300);
        setTimeout(function () {
            pagingFuncInit();
        }, 300);
    });
}

function getUrlParameter(single, exclude = '') {
    var sPageURL = window.location.search.substring(1),
    sURLVariables = sPageURL.split('&'),
    sParameterName,
    i;

    if(sURLVariables[0] === ""){
        data = "";
    } else {
        var data = {};
        for (i = 0; i < sURLVariables.length; i++) {
            var param = sURLVariables[i].split("=");
            if(exclude != '' && exclude != param[0]){
                data[param[0]] = param[1];
            }
            if(param[0] === single){
                return param[1];
            }
        }
    }
    
    if(single === "" || single === undefined){
        return data;
    }

};
