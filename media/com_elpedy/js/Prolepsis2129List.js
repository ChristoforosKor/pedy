
var options;


export function init(optionsIn) {
    options = optionsIn;
    options.table = jQuery(optionsIn.tableSelector);
    options.btSearch = document.getElementById('btProlepsis2129ListSearch');
    options.table.bootstrapTable({
        url: options.dataUrl
        , pagination: true
        , sidePagination: 'server'
        , idField: 'id'
        , toolbar: '#prolepsis2129ListToolbar'

        , queryParams: function (params) {
            params.filter_order_Dir = params.order;
            params.filter_order = params.sort;
            params.limit_start = params.offset;
            params.healthunit_id = document.getElementById('HealthUnitId').value;
            params.RefDateFrom = getRefDate(document.getElementById('RefDateFrom'));
            params.RefDateTo = getRefDate(document.getElementById('RefDateTo'));
//            params.exam_center_id = document.getElementById('exam_center_id').value;
            delete params.order;
            delete params.sort;
            delete params.offset;
            return params;
        }

        , responseHandler: responseHandler

        , columns: [{
                field: 'RefDate',
                title: Joomla.Text._('JDATE'),
                formatter: formatDate,
                align: 'right',
                halign: 'center',
                sortable: true
            },{
                field: 'samples_to_check',
                title: Joomla.Text._('COM_EL_PEDY_SAMPLES_TO_CHECK_TO_NEXT'),
                sortable: true,
                width: '200px',
                align: 'right',
                halign: 'center'
                                
                
            }, {
                field: 'result_ok',
                title: Joomla.Text._('COM_EL_PEDY_RESULT_NORMAL'),
                sortable: true,
                width: '200px',
                align: 'right',
                halign: 'center'
                
            }, {
                field: 'result_notok',
                title: Joomla.Text._('COM_EL_RESULT_NOT_OK'),
                sortable: true,
                width: '200px',
                align: 'right',
                halign: 'center'
            }, {
                field: 'vials_in_stock',
                title: Joomla.Text._('COM_EL_PEDY_VIALS_STOCK'),
                sortable: true,
                width: '200px',
                align: 'right',
                halign: 'center'
            }, {
                field: 'id',
                title: '',
                formatter: formatEdit,
                width:'270px',
                align: 'center'
            }]

    });

    options.btSearch.addEventListener('click', function () {
        options.table.bootstrapTable('refresh');
    });


}
function getRefDate(elm) {
    if (elm.value.replace(/ /g, '') === '') {
        var dt = moment();
        elm.value = dt.format('DD/MM/YYYYY');
    } else {
        var dt = moment(elm.value, 'DD/MM/YYYY');
    }
    if (dt.isValid())
        return dt.format('YYYY-MM-DD');
    else
        alert(Joomla.Text._('COM_EL_PEDY_CHECK_FILTERS_DATE'));
}

function formatDate(val) {
    return moment(val).format('DD/MM/YYYY');
}

 

function formatEdit(val) {
    return '<a href="' + options.editUrl + '&id=' + val + '" class="btn btn-primary" >' + Joomla.Text._('JACTION_EDIT')
            + '</a> <button type="button"  class="btn btn-danger del-button"    onclick="delQuestion(this)" value="' + val + '" >' + Joomla.Text._('JACTION_DELETE') + '</button>';
}

function responseHandler(res) {
    elgsJS.renderAppMessages(res, 'HTMLBootstrap', {messageArea: options.messageArea});
    return res.data;
}

export function delQuestion(trg) {
    document.getElementById('delId').value = trg.value;
    var row = trg.parentNode.parentNode;
    document.querySelector('#prolepsis2129Delete .text-info').textContent = row.cells[0].textContent + ' - ' + row.cells[1].textContent + ' - ' + row.cells[2].textContent + ' -  ' + row.cells[3].textContent + ' -  ' + row.cells[4].textContent;
    jQuery('#prolepsis2129Delete').modal('show');
}

export function delRec() {

    jQuery.post(options.delUrl, {id: document.getElementById('delId').value}, function (response) {
        elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: document.querySelector('#prolepsis2129Delete .text-info')});
        if (!elgsJS.hasErrors(response)) {
            setTimeout(function () {
                jQuery('#prolepsis2129Delete').modal('hide');
            }, 1000);
            options.table.bootstrapTable('refresh');
        }
    });
}



