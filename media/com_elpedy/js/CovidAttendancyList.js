/*------------------------------------------------------------------------
 # com_elergon - e-logism
 # ------------------------------------------------------------------------
 # author    Christoforos J. Korifidis
 # @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
 # Website: http://www.e-logism.gr
 ----------------------------------**/
var CovidAttendancyOptions;
var CovidAttendancyDelContainer;
var covidAttendancyHeadForm = document.getElementById('covidAttendancyHead');
var covidAttendancyFilterForm = document.getElementById('covidAttendnacyFilters');

var covidAttendnacySaveUrl;
var covidDomainBase;

let modalEdit = document.querySelector("#addCovidAttendancy");
let modalEditContainer = document.querySelector("#covidAttendancyDetailsForm") ; //addCovidAttendancy .modal-dialog");
let modalEditLoader = document.querySelector('#addCovidAttendancy .el-busy');

let modalDeleteContainer = document.getElementById("covidAttendancyDeleteForm");
let modalDeleteLoader = document.querySelector('#covidAttendacyDetailDelete .el-busy');

let covidAttendacyMain = document.querySelector(".covid-attendancy");
let covidAttendacyMainLoader =  document.querySelector(".el-busy.main");

export function init(optionsIn) {

    CovidAttendancyOptions = optionsIn;
    CovidAttendancyOptions.table = jQuery(optionsIn.tableSelector);
    CovidAttendancyOptions.btSearch = document.getElementById('btCovidAttendancySearch');
    CovidAttendancyDelContainer = document.querySelector('#covidAttendacyDetailDelete');

    covidDomainBase = location.protocol + "//" + location.host;

    CovidAttendancyOptions.table.bootstrapTable({
        url: covidDomainBase + '/' + CovidAttendancyOptions.dataUrl
        ,id: 'table'
		, pagination: true
        , sidePagination: 'server'
        , idField: 'id'

        , responseHandler: responseHandler

        , columns: [{
                       field: 'table',
                       title: 'α/α',
                       sortable: false,
                       formatter: function(value, row, index){
                            return index + 1;
                       }
                      
            },{
                field: 'gender',
                title: 'Φύλο',

                sortable: false
            }, {
                field: 'age',
                title: 'Ηλικία',
                sortable: false
            }, {
                field: 'nationality',
                title: 'Υπηκοότητα',

                sortable: false
            }, {
                field: 'yesno',
                title: 'Οδηγίες/Κατοίκον περιορισμός',
                
                sortable: false
            }, {
                field: 'id',
                title: '',
                formatter: formatEdit
            }]

        , queryParams: function (params) {
            params.filter_order_Dir = params.order;
            params.filter_order = params.sort;
            params.limit_start = params.offset;
            params.id_health_unit = document.getElementById('id_health_unit').value;
            params.ref_date = getRefDate(document.getElementById('ref_date'));
            params.task ="details";

            delete params.order;
            delete params.sort;
            delete params.offset;
            return params;
        }  
    });

  filtersSubmit();

}
function getRefDate(elm) {
    if (elm.value.replace(/ /g, '') === '') {
        var dt = moment();
        elm.value = dt.format('DD/MM/YYYY');
    } else {
        var dt = moment(elm.value, 'DD/MM/YYYY');
    }
    if (dt.isValid())
        return dt.format('YYYY-MM-DD');
    else
        alert('Ελέγξτε την ημερομηνία στα φίλτρα');
}

function formatDate(val) {
    return moment(val).format('DD/MM/YYYY');
}




function formatEdit(val) {
    return '<button data-id="' + val + '" class="btn btn-primary"  data-toggle="modal" data-target="#addCovidAttendancy" >Επεξεργασία</a> <button type="button"  data-id="' + val + '" class="btn btn-danger del-button"    onclick="delQuestion(this)" value="' + val + '" >Διαγραφή</button>';
}

function responseHandler(res) {
    elgsJS.renderAppMessages(res, 'HTMLBootstrap', {messageArea: CovidAttendancyOptions.messageArea});
    updateSums(res.data.sums);
    return res.data.details;
}

function updateSums(data)
{
    let totalMen =0;
    let totalWomen = 0;
    let totalSuspectMen = 0;
    let totalSuspectWomen = 0;
    let cnt = 0;
    data.forEach(function(item){
        cnt = parseInt(item.cnt);
        if ( item.id_gender === "1" ) {
            totalMen += cnt;
            if ( item.id_action === "1") {
                totalSuspectMen += cnt;
            }
        }
        else {
            totalWomen += cnt;
            if ( item.id_action === "1") {
                totalSuspectWomen += cnt;
            }
        }
    });
    document.getElementById("total_men").textContent = totalMen;
    document.getElementById("total_women").textContent = totalWomen;
    document.getElementById("total_suspectmen").textContent = totalSuspectMen;
    document.getElementById("total_suspectwomen").textContent = totalSuspectWomen;
	
	document.getElementById("total_all").textContent = totalMen + totalWomen;
	document.getElementById("total_suspectall").textContent = totalSuspectMen + totalSuspectWomen;
	
    document.getElementById("attendnacy_sums").style.visibility ="visible";
}

export function delQuestion(trg) {
    document.getElementById('delId').value = trg.value;
    var row = trg.parentNode.parentNode;
    CovidAttendancyDelContainer.querySelector('.text-info').textContent = row.cells[0].textContent + ' - ' + row.cells[1].textContent + ' - ' + row.cells[2].textContent ;
    jQuery(CovidAttendancyDelContainer).modal('show')
}

export function delDetail(e) {

    jQuery.post(CovidAttendancyOptions.saveUrl, {id: document.getElementById('delId').value, task: "delete"}, function (response) {
        elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: CovidAttendancyOptions.messageArea });
        CovidAttendancyOptions.table.bootstrapTable("refresh");
        if (!elgsJS.hasErrors(response)) {
            jQuery(CovidAttendancyDelContainer).modal('hide')
        }
    });
}



function fillHeadForm(data) {
    let ref_date;
    let mDate = moment(data.ref_date);
    if( mDate.isValid()) 
    {
        ref_date = mDate.format("DD/MM/YYYY");
        jQuery("#ref_date").val(ref_date);
    }
    
    covidAttendancyFilterForm.elements["id_health_unit"].value = ( typeof data.id_health_unit == 'undefined' ? covidAttendancyFilterForm.elements["id_health_unit"].value : data.id_health_unit);
    
    covidAttendancyHeadForm.elements["id"].value= (typeof data.id == 'undefined' ?  '': data.id);
    covidAttendancyHeadForm.elements["personnel_doctors"].value= ( typeof data.personnel_doctors == 'undefined' ?  '': data.personnel_doctors);
    covidAttendancyHeadForm.elements["personnel_nurses"].value= ( typeof data.personnel_nurses == 'undefined' ?  '' : data.personnel_nurses);
    covidAttendancyHeadForm.elements["personnel_office"].value= ( typeof data.personnel_office == 'undefined' ?  '' : data.personnel_office);
    covidAttendancyHeadForm.elements["personnel_labs"].value= ( typeof data.personnel_labs == 'undefined' ?  '' : data.personnel_labs);
    covidAttendancyHeadForm.elements["personnel_cleaning"].value= ( typeof data.personnel_cleaning == 'undefined' ? '' : data.personnel_cleaning);
    covidAttendancyHeadForm.elements["personnel_guard"].value= ( typeof data.personnel_guard == 'undefined' ? '' : data.personnel_guard);
     
   
}



export function filtersSubmit() {
    //  covidAttendancyHeadForm
    showBusy( covidAttendacyMain, covidAttendacyMainLoader);   
    let mdate = moment(jQuery("#ref_date").val(), "DD/MM/YYYY");
    let ref_date = '';
    if ( mdate.isValid() )
    {
        ref_date = mdate.format('YYYY-MM-DD'); 
    }
    else {
        ref_date = moment().format('YYYY-MM-DD');
    }
    
    jQuery.ajax({
        url: CovidAttendancyOptions.dataUrl + '&task=head&id_health_unit=' + covidAttendancyFilterForm.elements['id_health_unit'].value +'&ref_date=' + ref_date ,
        type: 'GET',
        success: function (response) {
            elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: CovidAttendancyOptions.messageArea});
            if (!elgsJS.hasErrors(response)) {
                fillHeadForm(response.data);
                if ( typeof response.data.id !== 'undefined' ) {
                    CovidAttendancyOptions.covidAttendancyDetails.style.display = "block";
                }
                else {
                    CovidAttendancyOptions.covidAttendancyDetails.style.display = "none";
                }
                showReady( covidAttendacyMain, covidAttendacyMainLoader);  
            }
        }
    });
    
     CovidAttendancyOptions.table.bootstrapTable("refresh");
}




export function headSubmit() {
   showBusy( covidAttendacyMain, covidAttendacyMainLoader);  
    var isValid = covidAttendancyFilterForm.reportValidity();
    if (isValid) {
        var fd = new FormData(covidAttendancyHeadForm);
        fd.append("ref_date", moment(document.getElementById("ref_date").value, 'DD/MM/YYYY').format('YYYY-MM-DD'));
        fd.append("id_health_unit", document.getElementById("id_health_unit").value);
        jQuery.ajax({
            url: CovidAttendancyOptions.saveUrl,
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (response) {
                elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: CovidAttendancyOptions.messageArea});
                if (!elgsJS.hasErrors(response)) {
                    fillHeadForm(response.data);
                    CovidAttendancyOptions.covidAttendancyDetails.style.display = "block";
                    showReady( covidAttendacyMain, covidAttendacyMainLoader); 
                    CovidAttendancyOptions.table.bootstrapTable("refresh");
                }
            }
        });
    }

}





export function showDetails (e) 
{
   
   let formElements = document.getElementById("covidAttendancyDetailsForm").elements;
   for ( let i = formElements.length -1; i >= 0;  i --) {
      if (  formElements[i].type === 'hidden' || formElements[i].type === 'text'  || formElements[i].type === 'select-one' ) {
           formElements[i].value = '';
      }
   }
   let id = e.relatedTarget.dataset.id;
   if ( typeof id !== 'undefined') {
        getDetailItem( e.relatedTarget.dataset.id );
    }
}

function getDetailItem(id) {
    showBusy( modalEditContainer, modalEditLoader );
     jQuery.ajax({
        url: CovidAttendancyOptions.dataUrl + '&task=item&id=' + id ,
        type: 'GET',
        success: function (response) {
            elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: CovidAttendancyOptions.messageArea});
            if (!elgsJS.hasErrors(response)) {
                fillDetailsForm(response.data);                
            }
            showReady( modalEditContainer, modalEditLoader );
        }
        
    });
}

function fillDetailsForm(data) {
    let formElements = document.getElementById("covidAttendancyDetailsForm").elements;
    formElements["id_covidattendancy_details"].value = data.id;
    formElements["id_gender"].value = data.id_gender;
    formElements["age"].value = data.age;
    formElements["residence"].value = data.residence;
    formElements["id_attendancy_medium"].value = data.id_attendancy_medium;
    formElements["id_nationality"].value = data.id_nationality;
    formElements["id_treatment"].value = data.id_treatment;
    formElements["id_action"].value = data.id_action;
    formElements["hospital_prompt"].value = data.hospital_prompt;
}
    
    
    
export function detailsSubmit(e) {
    if (!covidAttendancyFilterForm.reportValidity())
        return;
    if (!covidAttendancyHeadForm.reportValidity())
        return;
    showBusy( modalEditContainer, modalEditLoader );
    var fd = new FormData(e.target);
    fd.append("task", "savedetails");
    fd.append("id_covidattendancy", covidAttendancyHeadForm.elements["id"].value);
    jQuery.ajax({
        url: CovidAttendancyOptions.saveUrl,
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',

        success: function (response) {
            elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: CovidAttendancyOptions.messageArea});
            CovidAttendancyOptions.table.bootstrapTable("refresh");
             showReady( modalEditContainer, modalEditLoader );
            if (!elgsJS.hasErrors(response)) {
               jQuery(modalEdit).modal('hide');
               
            }
          
           
        },
        error: function (response) {
            CovidAttendancyOptions.table.bootstrapTable("refresh");
            elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: CovidAttendancyOptions.messageArea});
            showReady( modalEditContainer, modalEditLoader );
        }
    });
  
    

}


function showReady(container, loader) {
    loader.style.display = 'none';
    container.style.display = 'block';
}   

function showBusy(container, loader) {
    container.style.display = 'none';
    loader.style.display = 'block';  
}