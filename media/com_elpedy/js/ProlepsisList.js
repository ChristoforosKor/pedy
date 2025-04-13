/*------------------------------------------------------------------------
 # com_elergon - e-logism
 # ------------------------------------------------------------------------
 # author    Christoforos J. Korifidis
 # @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
 # Website: http://www.e-logism.gr
 ----------------------------------**/
var options;


export function init(optionsIn) {
    options = optionsIn;
    options.table = jQuery(optionsIn.tableSelector);
    options.btSearch = document.getElementById('btProlepsisListSearch');
    options.table.bootstrapTable({
        url: options.dataUrl
        , pagination: true
        , sidePagination: 'server'
        , idField: 'id'
        , toolbar: '#prolepsisListToolbar'

        , queryParams: function (params) {
            params.filter_order_Dir = params.order;
            params.filter_order = params.sort;
            params.limit_start = params.offset;
            params.healthunit_id = document.getElementById('HealthUnitId').value;
            params.RefDateFrom = getRefDate(document.getElementById('RefDateFrom'));
            params.RefDateTo = getRefDate(document.getElementById('RefDateTo'));
            params.exam_center_id = document.getElementById('exam_center_id').value;
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
                sortable: true,
                halign: 'center'
            }, {
                field: 'exam_center',
                title: Joomla.Text._('COM_EL_PEDY_EXAMS_CENTER_CONDENSED'),
                sortable: true,
                halign: 'center'
            }, {
                field: 'vials_received',
                title: Joomla.Text._('COM_EL_PEDY_RECEIVES'),
                sortable: true,
                align: 'right',
                halign: 'center'
            }, {
                field: 'samples_to_hc',
                title: Joomla.Text._('COM_EL_PEDY_TO_EXAM_CENTER'),
                sortable: true,
                align: 'right',
                halign: 'center'
            }, {
                field: 'result_negative',
                title: Joomla.Text._('COM_EL_PEDY_NEGATIVE'),
                sortable: true,
                align: 'right',
                halign: 'center'
            }, {
                field: 'result_positive_hpv16',
                title: Joomla.Text._('COM_EL_PEDY_HPV_16'),
                sortable: true,
                align: 'right',
                halign: 'center'
            }, {
                field: 'result_positive_hpv18',
                title: Joomla.Text._('COM_EL_PEDY_HPV_18'),
                sortable: true,
                align: 'right',
                halign: 'center'
            }, {
                field: 'result_positive_to_pap_negative',
                title: Joomla.Text._('COM_EL_PEDY_POSITIVE_TO_PAP'),
                sortable: true,
                align: 'right',
                halign: 'center'
            }, {
                field: 'id',
                title: '',
                formatter: formatEdit
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
    document.querySelector('#prolepsisDelete .text-info').textContent = row.cells[0].textContent + ' - ' + row.cells[1].textContent + ' - ' + row.cells[2].textContent + ' -  ' + row.cells[3].textContent + ' -  ' + row.cells[4].textContent;
    jQuery('#prolepsisDelete').modal('show');
}

export function delRec() {

    jQuery.post(options.delUrl, {id: document.getElementById('delId').value}, function (response) {
        elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: document.querySelector('#prolepsisDelete .text-info')});
        if (!elgsJS.hasErrors(response)) {
            setTimeout(function () {
                jQuery('#prolepsisDelete').modal('hide');
            }, 1000);
            options.table.bootstrapTable('refresh');
        }
    });
}



