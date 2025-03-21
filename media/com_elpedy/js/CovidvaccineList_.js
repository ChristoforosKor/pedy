/*------------------------------------------------------------------------
# com_elergon - e-logism
# ------------------------------------------------------------------------
# author    Christoforos J. Korifidis
# @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
# Website: http://www.e-logism.gr
----------------------------------**/
var CovidMonitorOptions;


export function init(optionsIn) {
    CovidMonitorOptions = optionsIn;
    CovidMonitorOptions.table= jQuery(optionsIn.tableSelector);
    CovidMonitorOptions.btSearch = document.getElementById('btVaccListSearch');
    CovidMonitorDelContainer = document.querySelector('.covid-attendance-delete-model');
    CovidMonitorOptions.table.bootstrapTable({
        url:  CovidMonitorOptions.dataUrl 
        ,pagination: true
        ,sidePagination: 'server' 
        , idField: 'id'
        , toolbar: '#CovidMonitorListToolbar'
        
//        ,queryParams: function (params) {
//            params.filter_order_Dir = params.order;
//            params.filter_order = params.sort;
//            params.limit_start = params.offset;
//            params.HealthUnitId = document.getElementById('HealthUnitId').value;
//            params.RefDateFrom = getRefDate ( document.getElementById('RefDateFrom') );  
//            params.RefDateTo = getRefDate (  document.getElementById('RefDateTo') );
//            delete params.order;
//            delete params.sort;S
//            delete params.offset;
//            return params;
//        }          
    
    ,responseHandler: responseHandler
  
    ,columns: [{
        field: 'nationality',
        title: 'Υπηκοότητα',
        formatter: formatDate,
        sortable: true
    }, {
        field: 'gender',
        title: 'Φύλο',
        formatter: formatDate,
        sortable: true
    },{
        field: 'age',
        title: 'Ηλικία',
        sortable: true
    }, {
        field: 'Περιορισμός',
        title: 'containment',
        sortable: true
    }, {
        field: 'id',
        title: '',
        formatter:  formatEdit
    }]
    
    });    
    
    CovidMonitorOptions.btSearch.addEventListener('click', function() {
        CovidMonitorOptions.table.bootstrapTable('refresh');
    });
    
   
}
function getRefDate(elm) {
    if( elm.value.replace(/ /g, '') === '') {
       var dt = moment();
       elm.value = dt.format('DD/MM/YYYYY');
   }
   else {
       var dt = moment(elm.value, 'DD/MM/YYYY');
   }
    if ( dt.isValid() )
       return dt.format('YYYY-MM-DD');
    else
       alert('Ελέγξτε τις ημερομηνίες στα φίλτρα');
}

function formatDate(val) {
    return moment(val).format('DD/MM/YYYY');
}




function formatEdit(val) {
    return '<a href="' + CovidMonitorOptions.editUrl + '&id=' + val + '" class="btn btn-primary" >Επεξεργασία</a> <button type="button"  class="btn btn-danger del-button"    onclick="delQuestion(this)" value="' + val + '" >Διαγραφή</button>';
}

function responseHandler( res ){
    elgsJS.renderAppMessages(res, 'HTMLBootstrap', { messageArea: CovidMonitorOptions.messageArea } );
    return res.data;
}

export function delQuestion( trg ) {
    document.getElementById('delId').value = trg.value;
    var row  = trg.parentNode.parentNode;
   CovidMonitorDelContainer.querySelector('.text-info').textContent = row.cells[0].textContent + ' - ' + row.cells[1].textContent + ' - ' + row.cells[2].textContent + ' -  ' + row.cells[3].textContent  + ' -  ' + row.cells[4].textContent;
   jQuery(CovidMonitorDelContainer).modal('show')
}

export function delRec() {
  
    jQuery.post(CovidMonitorOptions.delUrl, {id: document.getElementById('delId').value }, function(response){
          elgsJS.renderAppMessages(response, 'HTMLBootstrap', { messageArea: document.querySelector('#vaccinesDelete .text-info') } );
          if ( ! elgsJS.hasErrors(response) ) {
            setTimeout( function() { jQuery(CovidMonitorDelContainer).modal('hide') }, 1500);
            CovidMonitorOptions.table.bootstrapTable('refresh');
        }          
    });
}



