/*------------------------------------------------------------------------
 # com_elergon - e-logism
 # ------------------------------------------------------------------------
 # author    Christoforos J. Korifidis
 # @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
 # Website: http://www.e-logism.gr
 ----------------------------------**/
var options;



const Prolepsis = (function () {
    const prolepsisForm = document.getElementById('prolepsisHPV3065');
    let options, prolepsis3065Elms;

    const init = (optionsIn) => {
        options = optionsIn;
        prolepsisForm.addEventListener('submit', submitForm);
      
        prolepsis3065Elms = {
            RefDate: document.getElementById('RefDate'),
            id: document.getElementById('id'),  
            healthunit_id: document.getElementById('healthunit_id'),
            exam_center_id: document.getElementById('exam_center_id'),
            vials_received: document.getElementById('vials_received'),
            samples_to_hc: document.getElementById('samples_to_hc'),
            result_negative: document.getElementById('result_negative'),
            result_positive_hpv16: document.getElementById('result_positive_hpv16'),
            result_positive_hpv18: document.getElementById('result_positive_hpv18'),
            result_positive_ascsus: document.getElementById('result_positive_ascsus'),
            result_positive_to_pap_negative: document.getElementById('result_positive_to_pap_negative'),
            vials_in_stock: document.getElementById('vials_in_stock')           
        };
        loadItem(getId());
    };


    const submitForm = (e) => {
        elgsJS.showAsBusy('#prolepsisHPV3065', '.prolepsisHPV3065.el-busy');
        e.preventDefault();
        const frmValues = jQuery(e.target).serializeArray();
        const sampleDateIndex = frmValues.findIndex(elm => {
            return elm.name === 'RefDate';
        });
        frmValues[sampleDateIndex] = {
            name: 'RefDate',
            value: reformDate(frmValues[sampleDateIndex])
        };
        const action = e.submitter.value ? e.submitter.value : 'save';
        frmValues.push({
           name:'act',
           value: action
        });
        jQuery.post(options.saveUrl, frmValues, saveResponse).fail(failResponse);
    };

    const saveResponse = (response) => {
        
        elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: document.querySelector('.prolepsis-edit .msg-area')});
        if (elgsJS.hasErrors(response)) {
            return;
        }
        switch (response.data.act) {
            case 'save': 
                location.href = options.listUrl;
                return;
            case 'saveandnew':
                clearForm();
                break;
            default:
                document.getElementById('id').value = response.data.id;
        }
        elgsJS.showAsReady('#prolepsisHPV3065', '.prolepsis-edit .el-busy');
        
    };

    const failResponse = (response) => {
        elgsJS.renderAppMessages(response.responseJSON, 'HTMLBootstrap', {messageArea: document.querySelector('.prolepsis-edit .msg-area')});
        elgsJS.showAsReady('#prolepsisHPV3065', '.prolepsis-edit .el-busy');
        if (response.status === 401) {
            setTimeout( () => { window.location.href ='/'; }, 2000);
        } 
    };

    const getId = () => {
        const match = location.href.match(/[?&]id=([^&]*)/);
        return match ? decodeURIComponent(match[1]) : null;
    };


    const loadItem = (id) => {
        if (!id) return;
        
        elgsJS.showAsBusy('#prolepsisHPV3065', '.prolepsisHPV3065.el-busy');
        jQuery.get(options.dataUrl, 'id=' + id, (response => {
            Object.keys(response.data.data.prolepsisData).forEach(key => {
                try {
                    if (key === 'RefDate') {
                        const dt = moment(response.data.data.prolepsisData[key]);
                        prolepsis3065Elms[key].value = dt.format('DD/MM/YYYY');
                    }
                    else {
                        prolepsis3065Elms[key].value = response.data.data.prolepsisData[key];
                    }
                }
                catch(e) {
                    console.log(key +', ' + e.message);
                }
            });
            elgsJS.showAsReady('#prolepsisHPV3065', '.prolepsis-edit .el-busy');
        }));
    };
    
    const  clearForm = () => {
        Object.keys(prolepsis3065Elms).forEach(item =>{
            prolepsis3065Elms[item].value = '';
        });
        prolepsis3065Elms.RefDate.value =  moment(new Date()).format('DD/MM/YYYY');
    };

    const reformDate = (elm) => {
        return elm.value = moment(elm.value, 'DD/MM/YYYY').format('YYYY-MM-DD');
    };


    return {
        init: init
    };

}());
