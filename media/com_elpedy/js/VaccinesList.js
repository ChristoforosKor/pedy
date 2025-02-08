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
    options.table= jQuery(optionsIn.tableSelector);
    options.btSearch = document.getElementById('btVaccListSearch');
    options.table.bootstrapTable({
        url:  options.dataUrl 
        ,pagination: true
        ,sidePagination: 'server' 
        , idField: 'id'
        , toolbar: '#vaccinesListToolbar'
        
        ,queryParams: function (params) {
            params.filter_order_Dir = params.order;
            params.filter_order = params.sort;
            params.limit_start = params.offset;
            params.HealthUnitId = document.getElementById('HealthUnitId').value;
            params.RefDateFrom = getRefDate ( document.getElementById('RefDateFrom') );  
            params.RefDateTo = getRefDate (  document.getElementById('RefDateTo') );
            delete params.order;
            delete params.sort;
            delete params.offset;
            return params;
        }          
    
    ,responseHandler: responseHandler
  
    ,columns: [{
        field: 'RefDate',
        title: 'Ημερομηνία Εξέτασης',
        formatter: formatDate,
        sortable: true
    }, {
        field: 'birthday',
        title: 'Ημερομηνία Γέννησης',
        formatter: formatDate,
        sortable: true
    },{
        field: 'school',
        title: 'Σχολείο',
        sortable: true
    }, {
        field: 'schoolClass',
        title: 'Τάξη',
        sortable: true
    }, {
        field: 'isMale',
        title: 'Φύλο',
        sortable: true,
        formatter:  formatGender
    }, {
        field: 'id',
        title: '',
        formatter:  formatEdit
    }]
    
    });    
    
    options.btSearch.addEventListener('click', function() {
        options.table.bootstrapTable('refresh');
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

function formatGender(val) {
    return (val === '1' ? 'ΑΓΟΡΙ' : 'ΚΟΡΙΤΣΙ');
}


function formatEdit(val) {
    return '<a href="' + options.editUrl + '&id=' + val + '" class="btn btn-primary" >Επεξεργασία</a> <button type="button"  class="btn btn-danger del-button"    onclick="delQuestion(this)" value="' + val + '" >Διαγραφή</button>';
}

function responseHandler( res ){
    elgsJS.renderAppMessages(res, 'HTMLBootstrap', { messageArea: options.messageArea } );
    return res.data;
}

export function delQuestion( trg ) {
    document.getElementById('delId').value = trg.value;
    var row  = trg.parentNode.parentNode;
    document.querySelector('#vaccinesDelete .text-info').textContent = row.cells[0].textContent + ' - ' + row.cells[1].textContent + ' - ' + row.cells[2].textContent + ' -  ' + row.cells[3].textContent  + ' -  ' + row.cells[4].textContent;
   jQuery('#vaccinesDelete').modal('show')
}

export function delRec() {
  
    jQuery.post(options.delUrl, {id: document.getElementById('delId').value }, function(response){
          elgsJS.renderAppMessages(response, 'HTMLBootstrap', { messageArea: document.querySelector('#vaccinesDelete .text-info') } );
          if ( ! elgsJS.hasErrors(response) ) {
            setTimeout( function() { jQuery('#vaccinesDelete').modal('hide') }, 1500);
            options.table.bootstrapTable('refresh');
        }          
    });
}



