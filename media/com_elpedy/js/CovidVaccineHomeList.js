/*------------------------------------------------------------------------
 # com_elergon - e-logism
 # ------------------------------------------------------------------------
 # author    Christoforos J. Korifidis
 # @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
 # Website: http://www.e-logism.gr
 ----------------------------------**/
var CovidVaccineOptions;
var CovidVaccineDelContainer;
// var covidVaccineHeadForm = document.getElementById('covidVaccineHead');
var covidVaccineFilterForm = document.getElementById('covidVaccineFilters');

var covidVaccineSaveUrl;
var covidDomainBase;

let modalEdit = jQuery('#addCovidVaccine');
let vaccinesForm = document.getElementById("covidVaccineDetailsForm");
let modalEditLoader = document.querySelector('#addCovidVaccine .el-busy');

let modalDeleteContainer = document.getElementById("covidVaccineDeleteForm");
let modalDeleteLoader = document.querySelector('#covidAttendacyDetailDelete .el-busy');

let covidVaccineMain = document.querySelector(".covid-vaccine");
let covidVaccineMainLoader = document.querySelector(".el-busy.main");


let healthUnitElm = document.getElementById("id_health_unit");
let refDateJElm = jQuery("#ref_date");
let municipalitySectorElm = document.getElementById("MunicipalitySectorId");
let validateModalJElm = jQuery("#modalValidate");
let validateModalTextJElm = validateModalJElm.find(".modal-body p");
let tdsList = document.querySelectorAll('.covidVaccineTable tbody td');
//let sectionList = document.querySelectorAll('tr.vaccine-section');
let vaccinesMadeSumsList = document.querySelectorAll('.vaccine-section.completed');
let vaccinesMadeTotalList = document.querySelector('.vaccine-section.completed-totals');
let vaccinesRejectedSumsList = document.querySelectorAll('.vaccine-section.rejected');
let vaccinesRejectedTotalList = document.querySelector('.vaccine-section.rejected-totals');
let dataSection = document.querySelector('.covidVaccineDetails');
let vaccinesAttributes = {};
let loadedFilters = []; 
let changedFilters = [];

let head1;
let head2_1;
let head2_2;
let head2_3;
let head2_4;
let data1;
let data2;
let data3;
let data5;
let data6;
let data7;
let data8;
let data9;
let data10;
let data11;
let data12;
let data13;
let data14;
let data15;
let data16;
let data17;
let dataCompletedTotals;
let dataRejectedTotals;


export function init(optionsIn) {

    CovidVaccineOptions = optionsIn;
    CovidVaccineOptions.table = jQuery(optionsIn.tableSelector);
    CovidVaccineOptions.btSearch = document.getElementById('btCovidVaccineSearch');
    CovidVaccineDelContainer = document.querySelector('#covidVaccineDeleteForm');
    covidDomainBase = location.protocol + "//" + location.host;
    healthUnitElm.addEventListener("change", filtersChanged);
    municipalitySectorElm.addEventListener("change", filtersChanged);
//    refDateJElm.on("select", function(e) {alert('ok1')});
//    refDateJElm.on("change", function(e) {alert('ok')});
       
    vaccinesAttributes = JSON.parse(optionsIn.vaccinesAttributes);
    municipalitySectorElm.value =  1;
    
    
    head1 = document.querySelector('tr.section1');
    head2_1 = document.querySelector('tr.section2-1');
    head2_2 = document.querySelector('tr.section2-2');
    head2_3 = document.querySelector('tr.section2-3');
    head2_4 = document.querySelector('tr.section2-4');
    data1 = document.getElementById('cv1');
    data2 = document.getElementById('cv2');
    data3 = document.getElementById('cv3');
    data5 = document.getElementById('cv5');
    data6 = document.getElementById('cv6');
    data7 = document.getElementById('cv7');
    data8 = document.getElementById('cv8');
    data9 = document.getElementById('cv9');
    data10 = document.getElementById('cv10');
    data11 = document.getElementById('cv11');
    data12 = document.getElementById('cv12');
	data13 = document.getElementById('cv13');
	data14 = document.getElementById('cv14');
	data15 = document.getElementById('cv15');
	data16 = document.getElementById('cv16');
	data17 = document.getElementById('cv17');
    
    dataCompletedTotals = document.querySelector('.completed-totals');
    dataRejectedTotals = document.querySelector('.rejected-totals');
    
    getSetRefDate();
    filtersSubmit();
    

 
}

function alertInfo(infoText, alertType) {    
    validateModalTextJElm.addClass("text-" + alertType);
    validateModalTextJElm.text(infoText);    
    validateModalJElm.modal('show');
}

function filtersChanged() {
    changedFilters[0] = healthUnitElm.value;
    changedFilters[1] = municipalitySectorElm.value;
    changedFilters[2] = getSetRefDate();
    if ( JSON.stringify(loadedFilters) == JSON.stringify(changedFilters) ) {
        showDataArea();
    }
    else {
        hideDataArea();
    }
}

function showDataArea() {
       dataSection.style.display = 'block';
}


function hideDataArea() {
    dataSection.style.display = 'none';
}

function validateFilter() {
     getSetRefDate(); 
        if (healthUnitElm.value === '') {
           alertInfo("Επιλέξετε Μονάδα", "error");
            return '-';
        }
        
        if ( municipalitySectorElm.value === '') {
           alertInfo("Επιλέξετε Τομέα", "error");
            return '-';
        }
}

function makeEditable() {

        jQuery('table.covidVaccineTable tbody td.editable').editable(
        {
            url: covidDomainBase + '/' + CovidVaccineOptions.saveUrl
            , type: 'text',
            pk: 1,
            name: 'pk',
            mode: 'inline',
            showbuttons: false,
            send: 'always',
            savenochange: true,
            title: 'Click to edit',
            emptytext: '',

            params: function (params) {
                var dataSub = {};
                dataSub.id_health_unit = healthUnitElm.value;
                dataSub.ref_date = getSetRefDate();
                dataSub.MunicipalitySectorId = municipalitySectorElm.value;
                dataSub.Quantity = params.value;
                dataSub.CovidVaccineId = this.parentNode.id.replace('cv', '');
                dataSub.ClinicIncidentGroupId = this.dataset.group;
                dataSub.CovidVaccineTransactionId = this.dataset.id;
                dataSub.CovidVaccineCompanyId = this.dataset.mnf;
                dataSub.task = "savedetails";

                return dataSub;
            },
            validate: function (value) {
                if ( validateFilter === '-' ) {
                    return '-';
                }
                if (isNaN(value.replace(' ', ''))) {
                    alertInfo("Συμπληρώστε μόνο με αριθμητικά", "error");
                    return '-';
                }
            },
            success: function (response, newValue) {
                    
                if( newValue == 0 ) {
                    this.textContent = '';
                    this.dataset.id = 0;
                }
                else {
                    this.textContent = newValue;
                    this.dataset.id =  response.data.CovidVaccineTransactionId;
                }
                elgShowResultMessage(response, newValue, this.id); 
                calculateSums( response.data.CovidVaccineId);
            }
                   
        });
        
        jQuery('table.covidVaccineTable tbody td.editable').on('shown', function(e, editable){ editable.input.clear(); });     
        
        
        
        // rejected 
        jQuery('table.covidVaccineTable tbody td.editable-company-rejected').editable(
        {
            url: covidDomainBase + '/' + CovidVaccineOptions.saveUrl
            , type: 'text',
            pk: 1,
            name: 'pk',
            mode: 'inline',
            showbuttons: false,
            send: 'always',
            savenochange: true,
            title: 'Click to edit',
            emptytext: '',

            params: function (params) {
                var dataSub = {};
                dataSub.id_health_unit = healthUnitElm.value;
                dataSub.ref_date = getSetRefDate();
                dataSub.MunicipalitySectorId = municipalitySectorElm.value;
                dataSub.RejectedQuantity = params.value;              
                dataSub.CovidVaccineCompanyId = this.parentNode.dataset.id;
                dataSub.task = "savevaccines";
                return dataSub;
            },
            validate: function (value) {
                if ( validateFilter === '-' ) {
                    return '-';
                }
                if (isNaN(value.replace(' ', ''))) {
                    alertInfo("Συμπληρώστε μόνο με αριθμητικά", "error");
                    return '-';
                }
            },
            success: function (response, newValue) {
                    
                if( newValue == 0 ) {
                    this.textContent = '';
                   
                }
                else {
                    this.textContent = newValue;
                    
                }
                elgShowResultMessage(response, newValue, this.id); 
              
            }
                   
        });
        
        jQuery('table.covidVaccineTable tbody td.editable-company-rejected').on('shown', function(e, editable){ editable.input.clear(); });
       
       // received
        jQuery('table.covidVaccineTable tbody td.editable-company-received').editable(
        {
            url: covidDomainBase + '/' + CovidVaccineOptions.saveUrl
            , type: 'text',
            pk: 1,
            name: 'pk',
            mode: 'inline',
            showbuttons: false,
            send: 'always',
            savenochange: true,
            title: 'Click to edit',
            emptytext: '',

            params: function (params) {
                var dataSub = {};
                dataSub.id_health_unit = healthUnitElm.value;
                dataSub.ref_date = getSetRefDate();
                dataSub.MunicipalitySectorId = municipalitySectorElm.value;
                dataSub.ReceivedQuantity = params.value;              
                dataSub.CovidVaccineCompanyId = this.parentNode.dataset.id;
                dataSub.task = "savevaccines";
                return dataSub;
            },
            validate: function (value) {
                if ( validateFilter === '-' ) {
                    return '-';
                }
                if (isNaN(value.replace(' ', ''))) {
                    alertInfo("Συμπληρώστε μόνο με αριθμητικά", "error");
                    return '-';
                }
            },
            success: function (response, newValue) {
                    
                if( newValue == 0 ) {
                    this.textContent = '';
                   
                }
                else {
                    this.textContent = newValue;
                    
                }
                elgShowResultMessage(response, newValue, this.id); 
              
            }
                   
        });
        
        jQuery('table.covidVaccineTable tbody td.editable-company-received').on('shown', function(e, editable){ editable.input.clear(); });
	
}
                
function calculateSums(CovideVaccineId) {

    
    let sums = {total:0};
    let dataCells = document.querySelectorAll("#cv" + CovideVaccineId + ' [data-vaccell="1"]' );
    for ( let i = dataCells.length - 1; i >=0; i --) {
        let value = getCellValue(dataCells[i])
        sums.total +=  value;
        let cellMnf = dataCells[i].dataset.mnf;
        let cellGroup = dataCells[i].dataset.group;
        if ( typeof sums['m' + cellMnf] === 'undefined') {
            sums['m' + cellMnf] = {sum: 0, groups: []};
            
        }
        if ( typeof sums['m' + cellMnf]['groups'][cellGroup]  === 'undefined') {
            sums['m' + cellMnf]['groups'][cellGroup]  = 0;
        }
        sums['m' + cellMnf]['sum'] += value; 
        sums['m' + cellMnf]['groups'][cellGroup] += value;
    }
    Object.keys(sums).forEach(function(value){
       document.querySelector("#cv" + CovideVaccineId + " .sum-" + value ).textContent = sums[value]['sum'];  
    });
     document.querySelector("#cv" + CovideVaccineId + " .sum-total" ).textContent = sums.total;

    
 
    if ( CovideVaccineId == 3 || CovideVaccineId == 12 || CovideVaccineId == 13 || CovideVaccineId == 14 || CovideVaccineId == 15 || CovideVaccineId == 16 || CovideVaccineId == 17) {
        getVaccineSums(sums);
    }
    else if ( CovideVaccineId == 5 || CovideVaccineId == 6  || CovideVaccineId == 7 ) {
         getVaccineRejectedSums(sums);
    }
    
}



function getVaccineSums(sums) {
    
    let sum ;
    let mnf ;
    let group;
    
    let tds = vaccinesMadeTotalList.querySelectorAll('td');
       
    for (let k = tds.length -1; k >= 0; k -- ) {
        mnf = tds[k].dataset.mnf;
        group = tds[k].dataset.group;
        sum = parseInt(tds[k].textContent);
        if ( isNaN(sum) || sum === '') {
                sum = 0;
        }
        
        if (  typeof group === 'undefined' && typeof mnf !== 'undefined' && typeof sums['m' + mnf] !== 'undefined') {
            sum += parseInt(sums['m' + mnf]['sum']);
            tds[k].textContent = sum;
        }
        else  if (  typeof group !== 'undefined' && typeof sums['m' + mnf] !== 'undefined') {
            sum += parseInt(sums['m' + mnf]['groups'][group]);
            tds[k].textContent = sum;
        }
        else {
            sum += parseInt(sums.total);
            tds[k].textContent = sum;
        }
        
    }
    
        
}


function getVaccineRejectedSums(sums) {
      
    let sum ;
    let mnf ;
    let group;
    
    let tds = vaccinesRejectedTotalList.querySelectorAll('td');
       
        
    for (let k = tds.length -1; k >= 0; k -- ) {
        mnf = tds[k].dataset.mnf;
        group = tds[k].dataset.group;
        sum = parseInt(tds[k].textContent);
        if ( isNaN(sum) || sum === '') {
                sum = 0;
        }
        
        if (  typeof group === 'undefined' && typeof mnf !== 'undefined') {
            sum += parseInt(sums['m' + mnf]['sum']);
            tds[k].textContent = sum;
        }
        else  if (  typeof group !== 'undefined' ) {
            sum += parseInt(sums['m' + mnf]['groups'][group]);
            tds[k].textContent = sum;
        }
        else {
            sum += parseInt(sums.total);
            tds[k].textContent = sum;
        }
        
    }
    
    
    
//    for (let k = tds.length -1; k >= 0; k -- ) {
//        let sum = 0;
//    for ( let i = vaccinesRejectedSumsList.length -1;  i >=0; i-- ) {
//            sum += getCellValue(vaccinesRejectedSumsList[i].cells[k+1]);
//        }
//        vaccinesRejectedTotalList.cells[k+1].textContent = sum;
//        }
//        
}

function getCellValue(cell) {
    try {
        return getParsedValueAsNumber( parseInt( cell.textContent ) );
    }
    catch(e) {
        return 0;
    }
}

function getParsedValueAsNumber ( parsedValue ) {
    if ( isNaN(parsedValue) ) {
        return 0;
    }
    else {
        return parsedValue;
    }
}

function elgShowResultMessage(data, textStatus, selector)
{
    var same = jQuery('#' + selector);
    var textClass, tdClass;
    if (data.messages)
    {
        for (var key in data.messages)
        {
            if (key == null || key == 'message') {
                textClass = 'text-success';
                tdClass = 'success';
                if (data.data.Quantity > 0) {
                    tdClass = 'success';
                } else {
                    tdClass = 'warning';
                }
            } else {
                if (key === 'error')
                {
                    tdClass = 'danger';
                    textClass = 'text-danger';
                } else
                {
                    textClass = 'text-' + key;
                    tdClass = key;
                    //  sameClass=key;
                }
            }
            var elm = jQuery('<small class="' + textClass + '" ><br />' + data.messages[key] + '</small>');
            elm.hide().appendTo(same.prev('th')).fadeIn().delay(3000).fadeOut();
        }
        elgAddClass(same, tdClass);
        same.css('background-color', '');
    }
}

function elgAddClass(elm, className)
{
	elgClearTDClasses(elm);
	elm.addClass(className);
}

function elgClearTDClasses(elm)
{
    var tdClasses= ['error', 'warning', 'success', 'notice', 'info', 'danger'];
    for(var i = tdClasses.length -1; i >=0; i --)
    {
            elm.removeClass(tdClasses[i]);
    }
}




function getSetRefDate() {
    let refDateV = moment(refDateJElm.val(), 'DD/MM/YYYY');
    if (refDateV.isValid()) {
        return refDateV.format("YYYY-MM-DD");

    } else {
        let d = moment();
        refDateJElm.val(d.format('DD/MM/YYYY'));
        return d.format("YYYY-MM-DD");
    }

}


export function filtersSubmit() {
    if ( validateFilter() === '-' ) {
        return;
    }
  //  showBusy(covidVaccineMain, covidVaccineMainLoader);
    for( let i = tdsList.length -1; i >=0; i -- ) {
        tdsList[i].textContent = '';
        tdsList[i].dataset.id = 0;
    } 
    jQuery.ajax({
        url: CovidVaccineOptions.dataUrl + '&task=data&id_health_unit=' + healthUnitElm.value
                + '&ref_date=' + getSetRefDate()
                + '&MunicipalitySectorId=' + municipalitySectorElm.value
        , type: 'GET'
        , success: function (response) {
            elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: CovidVaccineOptions.messageArea});
            if (typeof response.data.data.transaction === 'undefined') {
                showReady(covidVaccineMain, covidVaccineMainLoader);
                showDataArea();
                return;
            }
            loadedFilters[0] = healthUnitElm.value;
            loadedFilters[1] = municipalitySectorElm.value;
            loadedFilters[2] = refDateJElm.val();
            if ( document.querySelector('.hasManufacturers') !== null ) {
                removeCompaniesCells();
                makeCompaniesCells(response.data.data.manufacturers);
            }
            fillDetailsForm(response.data.data.transaction);
    //        fillBottles(response.data.data.bottles);
            makeEditable();
        }
    });
}

function removeCompaniesCells() {
    for( let i = head1.cells.length -1; i >0; i -- ) {
        head1.deleteCell(i);
    }
    for( let i = head2_1.cells.length -1; i >0; i -- ) {
        head2_1.deleteCell(i);
    }
    for( let i = head2_2.cells.length -1; i >0; i -- ) {
        head2_2.deleteCell(i);
    }
    for( let i = head2_3.cells.length -1; i >0; i -- ) {
        head2_3.deleteCell(i);
    }
    for( let i = head2_4.cells.length -1; i >0; i -- ) {
        head2_4.deleteCell(i);
    }
    
    for( let i = data1.cells.length -1; i >0; i -- ) {
        data1.deleteCell(i);
    }
      
    for( let i = data2.cells.length -1; i >0; i -- ) {
        data2.deleteCell(i);
    }
    
    for( let i = data3.cells.length -1; i >0; i -- ) {
        data3.deleteCell(i);
    }
    
    for( let i = data5.cells.length -1; i >0; i -- ) {
        data5.deleteCell(i);
    }
    
    for( let i = data6.cells.length -1; i >0; i -- ) {
        data6.deleteCell(i);
    }
    
    for( let i = data7.cells.length -1; i >0; i -- ) {
        data7.deleteCell(i);
    }
    
    for( let i = data8.cells.length -1; i >0; i -- ) {
        data8.deleteCell(i);
    }
    
    for( let i = data9.cells.length -1; i >0; i -- ) {
        data9.deleteCell(i);
    }
    
    for( let i = data10.cells.length -1; i >0; i -- ) {
        data10.deleteCell(i);
    }
    
    for( let i = data11.cells.length -1; i >0; i -- ) {
        data11.deleteCell(i);
    }
    
    for( let i = data12.cells.length -1; i >0; i -- ) {
        data12.deleteCell(i);
    }
    
	for( let i = data13.cells.length -1; i >0; i -- ) {
        data13.deleteCell(i);
    }
	
	for( let i = data14.cells.length -1; i >0; i -- ) {
        data14.deleteCell(i);
    }
	
	for( let i = data15.cells.length -1; i >0; i -- ) {
        data15.deleteCell(i);
    }
	
	for( let i = data16.cells.length -1; i >0; i -- ) {
        data16.deleteCell(i);
    }
	
	for( let i = data17.cells.length -1; i >0; i -- ) {
        data17.deleteCell(i);
    }
	
    for( let i = dataCompletedTotals.cells.length -1; i >0; i -- ) {
        dataCompletedTotals.deleteCell(i);
    }
    
    for( let i = dataRejectedTotals.cells.length -1; i >0; i -- ) {
        dataRejectedTotals.deleteCell(i);
    }
    
    
}
function makeCompaniesCells(data) {
    let groups = [3, 7];
    let companiesNo = data.length;
    document.getElementById('group-3').colSpan = companiesNo;
    document.getElementById('group-7').colSpan = companiesNo;
    document.querySelector('.group-sum').colSpan = companiesNo + 1;
//    document.querySelector('.section3-1 > th').colSpan = (companiesNo *3) + 2;
//    let cells = document.querySelectorAll('.bottles-received  th'); 
//    for( let i = cells.length - 1; i >= 0; i --) {
//        cells[i].colSpan = (companiesNo *3) + 1;
//    }
    
//    document.querySelector('.section3-2 > th').colSpan = (companiesNo *3) + 2;
//    cells = document.querySelectorAll('.bottles-rejected  th');
//    for( let i = cells.length - 1; i >= 0; i --) {
//        cells[i].colSpan = (companiesNo *3) + 1;
//    }        
      
    groups.forEach( function(item)  {
        for (let i = data.length - 1; i >=0 ; i --) {
            let newCell1 =  head1.insertCell(-1);
            let newCel2_1 = head2_1.insertCell(-1);
            let newCel2_2 = head2_2.insertCell(-1);
            let newCel2_3 = head2_3.insertCell(-1);
            let newCel2_4 = head2_4.insertCell(-1);

            newCell1.innerHTML = '<span class="label label-info">' + data[i].CovidVaccineCompanyDesc + '</span>';
            newCel2_1.innerHTML = '<span class="label label-info">' + data[i].CovidVaccineCompanyDesc + '</span>';
            newCel2_2.innerHTML = '<span class="label label-info">' + data[i].CovidVaccineCompanyDesc + '</span>';
            newCel2_3.innerHTML = '<span class="label label-info">' + data[i].CovidVaccineCompanyDesc + '</span>';
            newCel2_4.innerHTML = '<span class="label label-info">' + data[i].CovidVaccineCompanyDesc + '</span>';
            
            let newDataCell1 = data1.insertCell(-1);
            newDataCell1.setAttribute('data-id', 0);
			newDataCell1.setAttribute('data-vaccell',1)
            newDataCell1.setAttribute('data-group', item);
            newDataCell1.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            newDataCell1.classList.add('editable');
            
            let newDataCell2 = data2.insertCell(-1);
            newDataCell2.setAttribute('data-id', 0);
			newDataCell2.setAttribute('data-vaccell',1)
            newDataCell2.setAttribute('data-group', item);
            newDataCell2.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            newDataCell2.classList.add('editable');
            
            let newDataCell3 = data3.insertCell(-1);
            newDataCell3.setAttribute('data-id', 0);
			newDataCell3.setAttribute('data-vaccell',1)
            newDataCell3.setAttribute('data-group', item);
            newDataCell3.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            if (data[i].CovidVaccineCompanyId !=9 && data[i].CovidVaccineCompanyId !=10 && data[i].CovidVaccineCompanyId !=12) { // pfizer 
            newDataCell3.classList.add('editable');
			}else{
			newDataCell3.style.backgroundColor = 'silver';
            //alert('here');    
            }                        
                                    
            let newDataCell5 = data5.insertCell(-1);
            newDataCell5.setAttribute('data-id', 0);
			newDataCell5.setAttribute('data-vaccell',1)
            newDataCell5.setAttribute('data-group', item);
            newDataCell5.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            newDataCell5.classList.add('editable');
            
            let newDataCell6 = data6.insertCell(-1);
            newDataCell6.setAttribute('data-id', 0);
			newDataCell6.setAttribute('data-vaccell',1)
            newDataCell6.setAttribute('data-group', item);
            newDataCell6.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            newDataCell6.classList.add('editable');
            
            let newDataCell7 = data7.insertCell(-1);
            newDataCell7.setAttribute('data-id', 0);
			newDataCell7.setAttribute('data-vaccell',1)
            newDataCell7.setAttribute('data-group', item);
            newDataCell7.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            newDataCell7.classList.add('editable');
            
            let newDataCell8 = data8.insertCell(-1);
            newDataCell8.setAttribute('data-id', 0);
			newDataCell8.setAttribute('data-vaccell',1)
            newDataCell8.setAttribute('data-group', item);
            newDataCell8.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            newDataCell8.classList.add('editable');
            
            let newDataCell9 = data9.insertCell(-1);
            newDataCell9.setAttribute('data-id', 0);
			newDataCell9.setAttribute('data-vaccell',1)
            newDataCell9.setAttribute('data-group', item);
            newDataCell9.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            newDataCell9.classList.add('editable');
            
            let newDataCell10 = data10.insertCell(-1);
            newDataCell10.setAttribute('data-id', 0);
			newDataCell10.setAttribute('data-vaccell',1)
            newDataCell10.setAttribute('data-group', item);
            newDataCell10.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            newDataCell10.classList.add('editable');
            
            let newDataCell11 = data11.insertCell(-1);
            newDataCell11.setAttribute('data-id', 0);
			newDataCell11.setAttribute('data-vaccell',1)
            newDataCell11.setAttribute('data-group', item);
            newDataCell11.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            newDataCell11.classList.add('editable');
            
            let newDataCell12 = data12.insertCell(-1);
            newDataCell12.setAttribute('data-id', 0);
			newDataCell12.setAttribute('data-vaccell',1)
            newDataCell12.setAttribute('data-group', item);
            newDataCell12.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            if (data[i].CovidVaccineCompanyId !=9 && data[i].CovidVaccineCompanyId !=10 && data[i].CovidVaccineCompanyId !=12) { // pfizer 
            newDataCell12.classList.add('editable');
			}else{
			newDataCell12.style.backgroundColor = 'silver';
            //alert('here');
            }
			
			let newDataCell13 = data13.insertCell(-1);
            newDataCell13.setAttribute('data-id', 0);
			newDataCell13.setAttribute('data-vaccell',1)
            newDataCell13.setAttribute('data-group', item);
            newDataCell13.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            if (data[i].CovidVaccineCompanyId !=9 && data[i].CovidVaccineCompanyId !=10 && data[i].CovidVaccineCompanyId !=12) { // pfizer 
            newDataCell13.classList.add('editable');
			}else{
			newDataCell13.style.backgroundColor = 'silver';
            //alert('here');
			}
			
			let newDataCell14 = data14.insertCell(-1);
            newDataCell14.setAttribute('data-id', 0);
			newDataCell14.setAttribute('data-vaccell',1)
            newDataCell14.setAttribute('data-group', item);
            newDataCell14.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            if (data[i].CovidVaccineCompanyId !=9 && data[i].CovidVaccineCompanyId !=10 && data[i].CovidVaccineCompanyId !=12) { // pfizer 
            newDataCell14.classList.add('editable');
			}else{
			newDataCell14.style.backgroundColor = 'silver';
            //alert('here');
			}                    
			
			let newDataCell15 = data15.insertCell(-1);
            newDataCell15.setAttribute('data-id', 0);
			newDataCell15.setAttribute('data-vaccell',1)
            newDataCell15.setAttribute('data-group', item);
            newDataCell15.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            if (data[i].CovidVaccineCompanyId ==9) { // pfizer 
            newDataCell15.classList.add('editable');
			}else{
			newDataCell15.style.backgroundColor = 'silver';
            //alert('here');
			}           
            
			let newDataCell16 = data16.insertCell(-1);
            newDataCell16.setAttribute('data-id', 0);
            newDataCell16.setAttribute('data-vaccell',1)
            newDataCell16.setAttribute('data-group', item);
            newDataCell16.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            if (data[i].CovidVaccineCompanyId ==10) { // pfizer 
            newDataCell16.classList.add('editable');
			}else{
			newDataCell16.style.backgroundColor = 'silver';
            //alert('here');
			}
			
			let newDataCell17 = data17.insertCell(-1);
            newDataCell17.setAttribute('data-id', 0);
            newDataCell17.setAttribute('data-vaccell',1)
            newDataCell17.setAttribute('data-group', item);
            newDataCell17.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            if (data[i].CovidVaccineCompanyId ==12) { // pfizer 
            newDataCell17.classList.add('editable');
			}else{
			newDataCell17.style.backgroundColor = 'silver';
            //alert('here');
			}
			
            let newDataCompletedTotals = dataCompletedTotals.insertCell(-1);
            newDataCompletedTotals.setAttribute('data-id', 0);
            newDataCompletedTotals.setAttribute('data-group', item);
            newDataCompletedTotals.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
            
            let newDataRejectedTotals = dataRejectedTotals.insertCell(-1);
            newDataRejectedTotals.setAttribute('data-id', 0);
            newDataRejectedTotals.setAttribute('data-group', item);
            newDataRejectedTotals.setAttribute('data-mnf', data[i].CovidVaccineCompanyId);
        }
        
        
    });
    let newCell;
    data.forEach( function(item)  {
        newCell = head1.insertCell(-1);
        newCell.classList.add('group-sum');
//        newCell.classList.add('c' + item.CovidVaccineCompanyId);
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
        newCell.innerHTML='<span class="label label-info">' + item.CovidVaccineCompanyDesc + '</span>';
         
        newCell = head2_1.insertCell(-1);
        newCell.classList.add('group-sum');
//        newCell.classList.add('c' + item.CovidVaccineCompanyId);
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
        newCell.innerHTML='<span class="label label-info">' + item.CovidVaccineCompanyDesc + '</span>';
        
        newCell = head2_2.insertCell(-1);
        newCell.classList.add('group-sum');
//        newCell.classList.add('c' + item.CovidVaccineCompanyId);
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
        newCell.innerHTML='<span class="label label-info">' + item.CovidVaccineCompanyDesc + '</span>';
        
        newCell = head2_3.insertCell(-1);
        newCell.classList.add('group-sum');
//        newCell.classList.add('c' + item.CovidVaccineCompanyId);
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
        newCell.innerHTML='<span class="label label-info">' + item.CovidVaccineCompanyDesc + '</span>';
        
        newCell = head2_4.insertCell(-1);
        newCell.classList.add('group-sum');
//        newCell.classList.add('c' + item.CovidVaccineCompanyId);
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
        newCell.innerHTML='<span class="label label-info">' + item.CovidVaccineCompanyDesc + '</span>';
    });
    
    newCell = head1.insertCell(-1);
    newCell.innerHTML='<span class="label label-success">Σύνολο</span>';
    newCell = head2_1.insertCell(-1);
    newCell.innerHTML='<span class="label label-success">Σύνολο</span>';
    
    newCell = head2_2.insertCell(-1);
    newCell.innerHTML='<span class="label label-success">Σύνολο</span>';
    newCell = head2_3.insertCell(-1);
    newCell.innerHTML='<span class="label label-success">Σύνολο</span>';
    newCell = head2_4.insertCell(-1);
    newCell.innerHTML='<span class="label label-success">Σύνολο</span>';
    
    let addClass= "sum-data-1st";
    data.forEach( function(item)  {
        newCell = data1.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId );
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
         
        newCell = data2.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
        
        newCell = data3.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
        
        newCell = data5.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
        
        newCell = data6.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
    
        newCell = data7.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
    
        newCell = data8.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
    
        newCell = data9.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
    
        newCell = data10.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
    
        newCell = data11.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
    
        newCell = data12.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
		
		newCell = data13.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
        
		newCell = data14.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
		
		newCell = data15.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
		
		newCell = data16.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
		
		newCell = data17.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
		
        newCell = dataCompletedTotals.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
        
        newCell = dataRejectedTotals.insertCell(-1);
        newCell.classList.add('sum-m' + item.CovidVaccineCompanyId);
        if ( addClass != "") {
            newCell.classList.add( addClass );
        }
        newCell.dataset.mnf = item.CovidVaccineCompanyId;
        
        addClass = "";
    });
    
    
    
    
    let nD1 = data1.insertCell(-1);
    nD1.classList.add('sum-total');
    let nD2 = data2.insertCell(-1);
    nD2.classList.add('sum-total');
    let nD3 = data3.insertCell(-1);
    nD3.classList.add('sum-total');
    let nD5 = data5.insertCell(-1);
    nD5.classList.add('sum-total');
    let nD6 = data6.insertCell(-1);
    nD6.classList.add('sum-total');
    let nD7 = data7.insertCell(-1);
    nD7.classList.add('sum-total');
    let nD8 = data8.insertCell(-1);
    nD8.classList.add('sum-total');
    let nD9 = data9.insertCell(-1);
    nD9.classList.add('sum-total');
    let nD10 = data10.insertCell(-1);
    nD10.classList.add('sum-total');
    let nD11 = data11.insertCell(-1);
    nD11.classList.add('sum-total');
    let nD12 = data12.insertCell(-1);
    nD12.classList.add('sum-total');
    let nD13 = data13.insertCell(-1);
    nD13.classList.add('sum-total');
	let nD14 = data14.insertCell(-1);
    nD14.classList.add('sum-total');
	let nD15 = data15.insertCell(-1);
    nD15.classList.add('sum-total');
	let nD16 = data16.insertCell(-1);
    nD16.classList.add('sum-total');
	let nD17 = data17.insertCell(-1);
    nD17.classList.add('sum-total');
	
    let nDCT = dataCompletedTotals.insertCell(-1);
    nDCT.classList.add('sum-total');
    let nDRT = dataRejectedTotals.insertCell(-1);
    nDRT.classList.add('sum-total');
}

function fillDetailsForm(data) {

    let dataValues = Object.values(data);
    let tbody = document.querySelector('.covidVaccineTable tbody');
    for ( let i = tbody.rows.length -1; i >=0; i --) {
        let vaccineId = tbody.rows[i].id.replace("cv", "");
         if ( vaccineId !== '' ) {
            let vaccineData = dataValues.filter(item => item.CovidVaccineId === vaccineId); // data of whole row
            setDetailsCells(vaccineData, tbody.rows[i]);
            calculateSums( vaccineId );
        }
    }
    showDataArea();
    showReady(covidVaccineMain, covidVaccineMainLoader);
    
}
 
 function fillBottles(data) {
    let receivedElms = document.querySelectorAll('tr.bottles-received td');
    let rejectedElms = document.querySelectorAll('tr.bottles-rejected td');
    data.forEach(function(item){
        setRejectedBottle(item, rejectedElms);
        setReceivedBottle(item, receivedElms);
    });
}  

function setRejectedBottle(dbRow, rejectedElms) {
    for (let i = rejectedElms.length -1; i >= 0; i --) {
        if ( rejectedElms[i].parentNode.dataset.id == dbRow.CovidVaccineCompanyId ) {
            rejectedElms[i].textContent = dbRow.RejectedQuantity;
            return;
        }
    }
}

function setReceivedBottle(dbRow, receivedElms) {
    for (let i = receivedElms.length -1; i >= 0; i --) {
        if ( receivedElms[i].parentNode.dataset.id == dbRow.CovidVaccineCompanyId ) {
            receivedElms[i].textContent = dbRow.ReceivedQuantity;
             return;
        }
    }
}


function setDetailsCells(vaccineData, row) {
    
    for( let i = vaccineData.length -1; i >=0 ; i --) {
//        let cellIndex = null;
        let dataCell = row.querySelector("[data-group='" + vaccineData[i].ClinicIncidentGroupId + "'][data-mnf='" + vaccineData[i].CovidVaccineCompanyId + "']");
        if ( dataCell != null ) {
            dataCell.dataset.id = vaccineData[i].CovidVaccineTransactionId
            dataCell.textContent = vaccineData[i].Quantity;
        }
        else {
            return;
           
        }
//        switch ( vaccineData[i].ClinicIncidentGroupId ) {
//            case '3' :
//                cellIndex = 1;               
//                break;
//            case '7': 
//                cellIndex = 2;
//                break;
//        }
//        if ( cellIndex === null ) {
//            return;
//        }
//        else {
//            row.cells[cellIndex].dataset.id = vaccineData[i].CovidVaccineTransactionId;
//            row.cells[cellIndex].textContent = vaccineData[i].Quantity;
//           
//        }
    }
}


function showReady(container, loader) {
    loader.style.display = 'none';
    container.style.display = 'block';
}

function showBusy(container, loader) {
    container.style.display = 'none';
    loader.style.display = 'block';
}
