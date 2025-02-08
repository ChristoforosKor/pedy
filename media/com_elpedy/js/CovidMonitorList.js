/*------------------------------------------------------------------------
 # com_elergon - e-logism
 # ------------------------------------------------------------------------
 # author    Christoforos J. Korifidis
 # @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
 # Website: http://www.e-logism.gr
 ----------------------------------**/
var CovidMonitorOptions;
var CovidMonitorDelContainer;
var covidMonitorHeadForm = document.getElementById('covidMonitorHead');
var covidMonitorFilterForm = document.getElementById('covidMonitorFilters');

var covidMonitorSaveUrl;
var covidDomainBase;

let modalEdit = jQuery('#addCovidMonitor');
let modalEditContainer = document.getElementById("covidMonitorDetailsForm");
let modalEditLoader = document.querySelector('#addCovidMonitor .el-busy');

let modalDeleteContainer = document.getElementById("covidMonitorDeleteForm");
let modalDeleteLoader = document.querySelector('#covidAttendacyDetailDelete .el-busy');

let covidMonitorMain = document.querySelector(".covid-monitor");
let covidMonitorMainLoader =  document.querySelector(".el-busy.main");
let userUnitsClinics = [];
let personelSpecialities = [];
let healthUnitElm = document.getElementById("id_health_unit");
let clinicsElm = document.getElementById("id_ClinicType");
let contact_nameElm = document.getElementById('contact_name');
let contact_specElm = document.getElementById('contact_spec');
let HomeVisitElm = document.getElementById('HomeVisit');
let id_labcheckElm = document.getElementById('id_labcheck');
let HomeVisitDateElm = document.getElementById('HomeVisitDate');
let HomeVisitNoElm = document.getElementById('HomeVisitNo');
let ResultDateElm = document.getElementById('ResultDate');
let personnelSpecialities = [];
//let selectedHealthUnitID = 0;

export function init(optionsIn) {

    CovidMonitorOptions = optionsIn;
    CovidMonitorOptions.table = jQuery(optionsIn.tableSelector);
    CovidMonitorOptions.btSearch = document.getElementById('btCovidMonitorSearch');
    CovidMonitorDelContainer = document.querySelector('#covidMonitorDeleteForm');
    covidDomainBase = location.protocol + "//" + location.host;
    healthUnitElm.addEventListener("change", healthUnitChanged);
    
     
    CovidMonitorOptions.table.bootstrapTable({
        url: covidDomainBase + '/' + CovidMonitorOptions.dataUrl
        , id: 'table'
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
                field: 'labCheck',
                title: 'Εργαστηριακός Έλεγχος',
                
                sortable: false
            }, {
                field: 'outcome',
                title: 'Έκβαση',
                
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
   
    contact_nameElm.addEventListener('change', function (e)  {
        if ( e.target.value > 0 ) {
            addSpecialityOptions( e.target.value);
        }
    });
    
   HomeVisitElm.addEventListener('change', function(e){
        if ( e.target.value === '0' || e.target.value === '' ) {
            document.getElementById('HomeVisitNo').value = '';
           
           // jQuery('#HomeVisitDate').val('')
            HomeVisitNoElm.parentNode.style.visibility = 'hidden';
            HomeVisitDateElm.parentNode.style.visibility = 'visible';
        }
        else {
            HomeVisitNoElm.parentNode.style.visibility = 'visible';
            HomeVisitDateElm.parentNode.style.visibility = 'visible';
        }
        
    });
    
    id_labcheckElm.addEventListener('change', function( e ){
        if ( e.target.value === ' 4' ) {
            ResultDateElm.parentNode.style.visibility = 'hidden';
            jQuery(ResultDateElm).val('');
        }
        else {
            ResultDateElm.parentNode.style.visibility = 'visible';
        }
    });
   // filtersSubmit();
 
}

function healthUnitChanged(e) {
    
    makePersonelSpecialities( personnelSpecialities, e.target.value ); 
}
//
//function makeClinicTypesOptions_(idHealthUnit) {
//    clinicsElm.innerHTML =  '<option value ="">Επιλέξτε</option>' 
//            + userUnitsClinics.filter(unitClinic => unitClinic.HealthUnitId === idHealthUnit )
//            .map(unitClinic => '<option value="' + unitClinic.ClinicTypeId + '" >' + unitClinic.DescEL + '</option>')
//            .join(' ');
//}

function makePersonelSpecialities(data, idHealthUnit) {
    
  //  personelSpecialities = data;
  
    contact_nameElm.innerHTML = '<option value="">Επιλογή</option>' 
            + data.filter( personelSpeciality => personelSpeciality.RefHealthUnitId === idHealthUnit  )
         //   .sort(function(el1, el2){ return el1.personelName >= el2.personelName; })
            .map(personel => '<option value="' + personel.personelId + '" >' + personel.personelName + '</option>')
            .join(' ');
    
}

function addSpecialityOptions(personelId) {
    
    contact_specElm.innerHTML = '<option value="">Επιλογή</option>' 
        + personnelSpecialities.filter( function(speciality){ 
            return  speciality.personelId === personelId;  
        })
        .map(data => ' <option value="' + data.PersonelSpecialityId + '">' + data.personelSpeciality + '</option>')
        .join(' ');
//    if ( typeof data === 'undefined' ) {
//        contact_specElm.innerHTML = '<option value="">Επιλογή</option>';
//    }
//    else {
//        contact_specElm.innerHTML = '<option value="' + data.PersonelSpecialityId + '">' + data.personelSpeciality + '</option>';
//    }
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
    return '<button data-id="' + val + '" class="btn btn-primary"  data-toggle="modal" data-target="#addCovidMonitor" >Επεξεργασία</a> <button type="button"  data-id="' + val + '" class="btn btn-danger del-button"    onclick="delQuestion(this)" value="' + val + '" >Διαγραφή</button>';
}

function responseHandler(res) {
    elgsJS.renderAppMessages(res, 'HTMLBootstrap', {messageArea: CovidMonitorOptions.messageArea});
    return res.data.details;
}



export function delQuestion(trg) {
    document.getElementById('delId').value = trg.value;
    var row = trg.parentNode.parentNode;
    CovidMonitorDelContainer.querySelector('.text-info').textContent = row.cells[0].textContent + ' - ' + row.cells[1].textContent + ' - ' + row.cells[2].textContent + ' - ' + row.cells[3].textContent ;
    jQuery(CovidMonitorDelContainer).modal('show')
}
  
export function delDetail(e) {

    jQuery.post(CovidMonitorOptions.saveUrl, {id: document.getElementById('delId').value, task: "delete"}, function (response) {
        elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: CovidMonitorOptions.messageArea });
        CovidMonitorOptions.table.bootstrapTable("refresh");
        if (!elgsJS.hasErrors(response)) {
            jQuery(CovidMonitorDelContainer).modal('hide')
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
    
    covidMonitorFilterForm.elements["id_health_unit"].value = ( typeof data.id_health_unit == 'undefined' ? covidMonitorFilterForm.elements["id_health_unit"].value : data.id_health_unit);
    
    covidMonitorHeadForm.elements["id"].value= (typeof data.id == 'undefined' ?  '': data.id);

    covidMonitorHeadForm.elements["contact_name"].value= ( typeof data.contact_name == 'undefined' ?  '': data.contact_name);
    addSpecialityOptions(data.contact_name);
    covidMonitorHeadForm.elements["contact_spec"].value= ( typeof data.contact_spec == 'undefined' ?  '' : data.contact_spec);
    covidMonitorHeadForm.elements["contact_phone"].value= ( typeof data.contact_phone == 'undefined' ?  '' : data.contact_phone);
    covidMonitorHeadForm.elements["contact_email"].value= ( typeof data.contact_email == 'undefined' ?  '' : data.contact_email);
   
     
   
}



export function filtersSubmit() {
    showBusy( covidMonitorMain, covidMonitorMainLoader);   
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
        url: CovidMonitorOptions.dataUrl + '&task=head&id_health_unit=' + covidMonitorFilterForm.elements['id_health_unit'].value +'&ref_date=' + ref_date ,
        type: 'GET',
        success: function (response) {
            elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: CovidMonitorOptions.messageArea});
            if (!elgsJS.hasErrors(response)) {
                userUnitsClinics = response.data.userUnitsClinics;
                //selectedHealthUnitID = healthUnitElm.options[0].value;
                let seen = {};
                personnelSpecialities = response.data.personelSpecialities.filter( function (persSpec) { 
                    return seen.hasOwnProperty(persSpec.personelId) ? false : 
                            (seen[persSpec.personelId] = true) ; } )
                        . sort(function(el1, el2){ return ( el1.personelName >= el2.personelName ? 1 : -1); });            
                makePersonelSpecialities( personnelSpecialities,  ( healthUnitElm.value > 0 ? healthUnitElm.value : healthUnitElm.options[0].value ) ); 
                fillHeadForm(response.data);
                if ( typeof response.data.id !== 'undefined' ) {
                    CovidMonitorOptions.covidMonitorDetails.style.display = "block";
                }
                else {
                    CovidMonitorOptions.covidMonitorDetails.style.display = "none"; 
                }
                covidMonitorHeadForm.style.display ="block";
                showReady( covidMonitorMain, covidMonitorMainLoader);  
            }
        }
    });
    
     CovidMonitorOptions.table.bootstrapTable("refresh");
}




export function headSubmit() {
   showBusy( covidMonitorMain, covidMonitorMainLoader);  
    var isValid = covidMonitorFilterForm.reportValidity();
    let contact_phone = document.getElementById("contact_phone" ).value.replace(/ /g, '');
    if( contact_phone !== '' && contact_phone.length !== 10 ) {
        alert ("Το Τηλέφωνο Υπευθύνου δεν έχει 10 ψηφία")
        return;
    }
    if (isValid) {
        var fd = new FormData(covidMonitorHeadForm);
        fd.append("ref_date", moment(document.getElementById("ref_date").value, 'DD/MM/YYYY').format('YYYY-MM-DD'));
        fd.append("id_health_unit", document.getElementById("id_health_unit").value);
        jQuery.ajax({
            url: CovidMonitorOptions.saveUrl,
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (response) {
                elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: CovidMonitorOptions.messageArea});
                if (!elgsJS.hasErrors(response)) {
                    fillHeadForm(response.data);
                    userUnitsClinics = response.data['userClinic'];
                    CovidMonitorOptions.covidMonitorDetails.style.display = "block";
                    showReady( covidMonitorMain, covidMonitorMainLoader); 
                    CovidMonitorOptions.table.bootstrapTable("refresh");
                }
            }
        });
    }

}





export function showDetails (e) 
{
  
   let formElements = document.getElementById("covidMonitorDetailsForm").elements;
   for ( let i = formElements.length -1; i >= 0;  i --) {
      if (  formElements[i].type === 'hidden' || formElements[i].type === 'text'  || formElements[i].type === 'select-one' || formElements[i].type === 'tel' ) {
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
        url: CovidMonitorOptions.dataUrl + '&task=item&id=' + id ,
        type: 'GET',
        success: function (response) {
            elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: CovidMonitorOptions.messageArea});
            if (!elgsJS.hasErrors(response)) {
                fillDetailsForm(response.data);                
            }
            showReady( modalEditContainer, modalEditLoader );
        }
        
    });
}

function fillDetailsForm(data) {
    let formElements = document.getElementById("covidMonitorDetailsForm").elements;
    formElements["idCovidMonitorDetails"].value = data.id;
    formElements["id_gender"].value = data.id_gender;
    formElements["age"].value = data.age;
    formElements["isMedicalPers"].value = data.isMedicalPers;
    formElements["id_ClinicType"].value = data.id_ClinicType;
    formElements["id_treatment"].value = data.id_treatment;
    formElements["id_labcheck"].value = data.id_labcheck;
    if( formElements["id_labcheck"].value === '4' ) {        
        jQuery(ResultDateElm).val('');
        ResultDateElm.parentNode.style.visibility = "hidden";
    }
    else {
        let dtR = moment(data.ResultDate, 'YYYY-MM-DD' );
        if ( dtR.isValid() ) {
          jQuery(ResultDateElm).val(dtR.format("DD/MM/YYYY"));
        }
        else {
             jQuery(ResultDateElm).val('');
        }
        ResultDateElm.parentNode.style.visibility = "visible";
    }
    
    
    
    
    formElements["id_PersonelSpeciality"].value = data.id_PersonelSpeciality;    
    formElements["HomeVisit"].value = data.HomeVisit;
    formElements["HomeVisitNo"].value =  data.HomeVisitNo;
    let dt =  moment(data.HomeVisitDate, "YYYY-MM-DD");
    if ( dt.isValid() ) {
        jQuery(HomeVisitDateElm).val(dt.format("DD/MM/YYYY")); // , "DD/MM/YYYY" ;
    }
    if( data.HomeVisit === '0') {
       // jQuery(HomeVisitDateElm).val('');
        HomeVisitDateElm.parentNode.style.visibility = 'visible';
        HomeVisitNo.parentNode.style.visibility = "hidden";
    }
    else {
    /*  
        else {
            
       }
     * */
     
        
        HomeVisitDateElm.parentNode.style.visibility = 'visible';
        HomeVisitNo.parentNode.style.visibility = "visible";
    }
    
    formElements["clinic_phone"].value = data.clinic_phone;
    formElements["dep_phone"].value = data.dep_phone;
    formElements["id_outcome"].value = data.id_outcome;

  
}
     
    
    
export function detailsSubmit(e) {
    if (!covidMonitorFilterForm.reportValidity())
        return;
    if (!covidMonitorHeadForm.reportValidity())
        return;
    if ( HomeVisitElm.value == 1 && ( jQuery('#HomeVisitDate').val() == '' || document.getElementById('HomeVisitNo') == '' ) ) {
        alert("Πρέπει να βάλετε Ημερομηνία και Α/Α επίσκεψης εφόσον επιλέξετε ΝΑΙ στο Επίσκεψη κατ' οίκον");
        return;
    }
    
    if ( id_labcheckElm.value != 4 && jQuery("#ResultDate").val() == '' ) {
         alert("Πρέπει να βάλετε ημερομηνία αποτελέσματος εφόσον έχετε επιλέξει Εργαστηριακό Έλεγχο διαφορετικό του ΟΧΙ");
        return;
    }
    
    let clinicPhone = document.getElementById("clinic_phone" ).value.replace(/ /g, '');
    if( clinicPhone != '' && clinicPhone.length != 10 ) {
        alert ("Το Τηλ. Ιατρείου δεν έχει 10 ψηφία")
        return;
    }
    
    
     let dep_phone = document.getElementById("dep_phone" ).value.replace(/ /g, '');
    if( dep_phone != '' && dep_phone.length != 10 ) {
        alert ("Το Τηλ. Τμήματος δεν έχει 10 ψηφία")
        return;
    }
   
    
    showBusy( modalEditContainer, modalEditLoader );
    var fd = new FormData(e.target);
    
    fd.append("task", "savedetails");
    fd.append("id_covidmonitor", covidMonitorHeadForm.elements["id"].value);
    let HomeVisitDate = moment(jQuery("#HomeVisitDate").val(), "DD/MM/YYYY");
    let homeVisitDate;
    if ( HomeVisitDate.isValid() )
    {
        homeVisitDate = HomeVisitDate.format('YYYY-MM-DD'); 
    }
    else {
        homeVisitDate = '';
    }
    
    fd.append("HomeVisitDate", homeVisitDate);
	
    let ResultDate = moment(jQuery("#ResultDate").val(), "DD/MM/YYYY");
    let resultDate;
    if ( ResultDate.isValid() )
    {
        resultDate = ResultDate.format('YYYY-MM-DD'); 
    }
    else {
        resultDate = '';
    }
    
    fd.append("ResultDate", resultDate);
    
    jQuery.ajax({
        url: CovidMonitorOptions.saveUrl,
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',

        success: function (response) {
            elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: CovidMonitorOptions.messageArea});
            CovidMonitorOptions.table.bootstrapTable("refresh");
             showReady( modalEditContainer, modalEditLoader );
            if (!elgsJS.hasErrors(response)) {
              modalEdit.modal('hide');               
            }          
        },
        error: function (response) {
            CovidMonitorOptions.table.bootstrapTable("refresh");
            elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: CovidMonitorOptions.messageArea});
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