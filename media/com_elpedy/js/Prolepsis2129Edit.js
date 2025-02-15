/*------------------------------------------------------------------------
 # com_elergon - e-logism
 # ------------------------------------------------------------------------
 # author    Christoforos J. Korifidis
 # @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
 # Website: http://www.e-logism.gr
 ----------------------------------**/
var options;



const Prolepsis = (function () {
    const prolepsisForm = document.getElementById('prolepsis2129');
    let options, prolepsis2129Elms;

    const init = (optionsIn) => {
        options = optionsIn;
        prolepsisForm.addEventListener('submit', submitForm);
      
        prolepsis2129Elms = {
            RefDate: document.getElementById('RefDate'),
            id: document.getElementById('id'),  
            samples_to_check: document.getElementById('samples_to_check'),
            result_ok: document.getElementById('result_ok'),
            result_notok: document.getElementById('result_notok'),
            vials_in_stock: document.getElementById('vials_in_stock')           
        };
        loadItem(getId());
    };


    const submitForm = (e) => {

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
        jQuery.post(options.saveUrl, frmValues, saveResponse);
    };

    const saveResponse = (response) => {
        
        elgsJS.renderAppMessages(response, 'HTMLBootstrap', {messageArea: document.querySelector('.prolepsis2129-edit .msg-area')});
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
        elgsJS.showAsReady('#prolepsis2129', '.prolepsis2129-edit .el-busy');
    };

    const getId = () => {
        const match = location.href.match(/[?&]id=([^&]*)/);
        return match ? decodeURIComponent(match[1]) : null;
    };


    const loadItem = (id) => {
        if (!id) return;
        
        elgsJS.showAsBusy('#prolepsis2129', '.prolepsis2129.el-busy');
        jQuery.get(options.dataUrl, 'id=' + id, (response => {
            Object.keys(response.data.data.prolepsis2129Data).forEach(key => {
                try {
                    if (key === 'RefDate') {
                        const dt = moment(response.data.data.prolepsisData[key]);
                        prolepsis2129Elms[key].value = dt.format('DD/MM/YYYY');
                    }
                    else {
                        prolepsis2129Elms[key].value = response.data.data.prolepsisData[key];
                    }
                }
                catch(e) {
                    console.log(key +', ' + e.message);
                }
            });
            elgsJS.showAsReady('#prolepsis2129', '.prolepsis2129.el-busy');
        }));
    };
    
    const  clearForm = () => {
        Object.keys(prolepsis2129Elms).forEach(item =>{
            prolepsis2129Elms[item].value = '';
        });
        prolepsis2129Elms.RefDate.value =  moment(new Date()).format('DD/MM/YYYY');
    };

    const reformDate = (elm) => {
        return elm.value = moment(elm.value, 'DD/MM/YYYY').format('YYYY-MM-DD');
    };


    return {
        init: init
    };

}());
