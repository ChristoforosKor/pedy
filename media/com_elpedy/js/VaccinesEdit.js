/*------------------------------------------------------------------------
# com_elergon - e-logism
# ------------------------------------------------------------------------
# author    Christoforos J. Korifidis
# @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
# Website: http://www.e-logism.gr
----------------------------------**/
var options;
var VaccinesElms = {
    patient_id:  document.getElementById('vaccine_patient_id')
    , HealthUnitId : document.getElementById('HealthUnitId')
    , RefDate : document.getElementById('RefDate')
    
    , isMale0 : document.getElementById('isMale0')
    , isMale1 : document.getElementById('isMale1')
    , school_level_id : jQuery('#school_level_id')
    , area_id : jQuery('#area_id')
    , school_id : jQuery('#school_id')
    , school_class_id : jQuery('#school_class_id')
    , nationality_id : jQuery('#nationality_id')
    , birthday : document.getElementById('birthday')
    , father_profession : document.getElementById('father_profession')
    , mother_profession : document.getElementById('mother_profession')
    , vaccines_checkboxes:  document.getElementById('vaccines_edit_table').querySelectorAll('input[type="checkbox"]')
};
var areaTypeElms;
function init(optionsIn) {
    options = optionsIn;
    document.getElementById('vaccinesEdit').addEventListener('submit', function(e){
        elgsJS.showAsBusy('.el.vaccines-edit', '.vaccines-edit.el-busy');
        e.preventDefault();
        reformDate( document.getElementById('birthday') );
        reformDate( document.getElementById('RefDate') );
        var frm = jQuery( e.target ).serializeArray();
       
        jQuery.post( options.saveUrl, frm, response);
    });
    document.addEventListener('DOMContentLoaded', function(){
        areaTypeElms = document.querySelectorAll('input.area_type');
        var areasData = areas.map(function(area){return {id: area[0], text: area[2]};});
        VaccinesElms.school_level_id.select2({data: schoolLevels.map(function(item){ return { id: item[0], text:item[1] } ; }), width: '80%' })
            .on("change", function(e){
                changeArea(
                      VaccinesElms.school_id.val()
                );
            });
         VaccinesElms.area_id.select2({data: areasData}).on("change", function(e){changeArea(e.target.value)});    
         VaccinesElms.school_id.select2({}).on('change', function(e){ 
         changeSchool(e.target.value) });
         VaccinesElms.school_class_id.select2({});
         VaccinesElms.nationality_id.select2({});
        
    
    
        var school_id = document.getElementById('school_id').value;
        if(school_id > 0) {
            var school = schools.filter(function(elm){return elm[0]===school_id;});
            ar.select2('val', school[0][2]);
            changeArea(school[0][2]);
            changeSchool(school_id);
        }
        if(document.getElementById('area_id').value > 0) {
            changeArea(document.getElementById('area_id').value);
        }
        if ( options.id > 0)
            getData( options.id );
        
    });
    
    function getData( id )
    {
        jQuery.get(options.dataUrl, 'id=' + id, function( res ) { 
            showData( res.data.data ); } );
    }

    
    
}
function setSelect2Val( elmId, val)
{
    jQuery('#' + elmId ).val( val ).trigger('change');
}
function reformDate(elm) {
    elm.value = moment(elm.value, 'DD/MM/YYYY').format('YYYY-MM-DD');
}

function reformDate2(val){
    return moment(val).format('DD/MM/YYYY');
}
function showData( data ) {
        if ( Object.keys(data.patientData).length > 0 ) {
           
            let school_level =  null;
            let school_level_id = null;
            let school_id  = null;
            let school_class_id = null;
            //setSelect2Val( 'school_level_id', data.patientData[ 'info_level_id' ]);
         //   let school_level_id = schools.find( function( item){
          //      return item[0] === data.patientData[ 'area_id'] ;
          //  });
            //setSelect2Val( 'school_level_id', school_level_id);
            Object.keys( data.patientData).forEach(function(key){
                switch(key){
                    case 'id':
                        document.getElementById('vaccine_patient_id').value = data.patientData[key];
                        break;
                    case 'birthday':
                    case 'RefDate':
                        document.getElementById( key ) .value = reformDate2( data.patientData[key] );
                        break;
                    case 'isMale':
                        if ( data.patientData[key] === '1' ) {
                             document.getElementById('isMale0').checked = true;
                        }
                        else {
                            document.getElementById('isMale1').checked = true;
                        }
                        
                        break;
                  
                    case 'school_id':
                        school_id = data.patientData[key];                       
                            break;
                    case 'school_class_id':
                        school_class_id = data.patientData[key];
                        break;
                    case 'nationality_id':  
                            setSelect2Val( key, data.patientData[key])
                        break;
                    case 'info_level_id': 
                    case 'area_id':
                        ;
                    break;
                    default:
                        document.getElementById(key).value = data.patientData[key];
                };
                elgsJS.showAsReady('.el.vaccines-edit', '.vaccines-edit.el-busy');
            });
            school_level = schools.find( function( item){
                return item[0] === school_id ;
            });
            if ( typeof school_level === 'undefined') {
                school_level_id = '';
            }
            else {
                school_level_id = school_level[1];
            }
            setSelect2Val( 'school_level_id', school_level_id);
            setSelect2Val( 'area_id', data.patientData[ 'area_id' ] );
            setSelect2Val( 'school_id', school_id);
            setSelect2Val( 'school_class_id', school_class_id);
        }
        data.vaccinesTransactions.forEach( function( item ){
            document.getElementById('v' + item [1]).checked = true;
        });
    }

function response(response)
{
     document.getElementById('vaccine_patient_id').value = response.data.id;
     elgsJS.renderAppMessages(response, 'HTMLBootstrap', { messageArea: document.querySelector('.yjsg-system-msg.inside-container') } );
     if ( !  elgsJS.hasErrors(response) ) {
         clearForm();
     }
     elgsJS.showAsReady('.el.vaccines-edit', '.vaccines-edit.el-busy');
}

function changeSchool(selIdSchool){
    var curSchool = schools.filter(function(val){ return val[0] == selIdSchool});
   var classesData ;
    try {
        classesData = levelClasses.filter(function(val){ 
            return  val[0] == curSchool[0][1];            
        }).map(function(item){return {id: item[2], text:item[3]};});
    }
    catch(e) {
        classesData = [];
    }
    finally {        
        VaccinesElms.school_class_id.select2({data: classesData, width: '80%'});
        document.getElementById('class-container').style.display = 'block';
    } 
}

function changeArea(selIdArea) {
    var curArea = areas.filter(function(item){ return item[0] == selIdArea });
    var selSchoolLevelId =VaccinesElms.school_level_id.val();
    try {
       var curAreaType = curArea[0][1];
    }
    catch(ex) {
        var curAreaType = 0;
    }
    for( var i =0; i < 3; i ++ ) {
        if(areaTypeElms[i].value == curAreaType){
            areaTypeElms[i].checked = true;
        }
        else {
            areaTypeElms[i].checked = false;
        }
    }
    var schoolFiltered = schools.filter(function(element){
        return element[2] == selIdArea;
    });

   
     if ( selSchoolLevelId > 0  && schoolFiltered.length > 0 ){
       schoolFiltered = schoolFiltered.filter(function(element){
        return element[1] === selSchoolLevelId;
    });
   }

   var schoolData = schoolFiltered.map(function(school){ return {id: school[0], text: school[3]}; });
   
    VaccinesElms.school_id.select2({data: schoolData, width: '80%'});
    if ( schoolData.length > 0 ) {
        VaccinesElms.school_id.val( '' ).trigger('change');
        changeSchool('');
    }
    else {
         VaccinesElms.school_id.select2([]);
        changeSchool( 0 );
    }
    document.getElementById('school-container').style.display = 'block'; 
  
}


function clearForm () {
    VaccinesElms.patient_id.value = '';
   // VaccinesElms.HealthUnitId.value = '';
    VaccinesElms.RefDate.value = '';
    //VaccinesElms.school_level_id.val([]).trigger('change');
    //VaccinesElms.area_id.val([]).trigger('change');
    //VaccinesElms.school_id.val([]).trigger('change');
    //VaccinesElms.school_class_id.val([]).trigger('change');
    //VaccinesElms.isMale0.checked= false;
    //VaccinesElms.isMale1.checked = false;
    
  
    VaccinesElms.birthday.value = '';
    VaccinesElms.father_profession.value = '';
    VaccinesElms.mother_profession.value = '';
    for ( let i = VaccinesElms.vaccines_checkboxes.length -1 ; i > -1; i -- ) {
        VaccinesElms.vaccines_checkboxes[i].checked = false;
    }
        
}

export { init} 