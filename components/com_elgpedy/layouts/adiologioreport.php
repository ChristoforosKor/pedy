<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined('_JEXEC') or die('Restricted access'); 

?>


<script type="application/javascript" src="media/com_elgpedy/js/select2.js"></script>
<!-- script type="application/javascript" src="media/com_elgpedy/js/bootstrap-table.min.js"></script -->
<div class="elg">
    <form method="post" id="adiaFilters"  onsubmit="return formSubmitReport()">
        <div class="col-md-3">
            <?php echo $this->rafinaForm->getLabel('PersonelId') , '<br />', $this->rafinaForm->getInput('PersonelId')?>
        </div>
         <div class="col-md-3">
            <?php echo $this->rafinaForm->getLabel('StartDate') , '<br />', $this->rafinaForm->getInput('StartDate')?>
        </div>
         <div class="col-md-3">
            <?php echo $this->rafinaForm->getLabel('EndDate') , '<br />', $this->rafinaForm->getInput('EndDate')?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 no-prin">
           <br /> <button class="btn btn-primary">Αναζήτηση</button>
        </div>
    </form>
    
    <div class="clearfix"></div>
   
    <?php if(count($this->rafinaData) > 0 ) : ?>
    <button type="button" onClick ="getPDF()" class="btn btn-primary pull-right">Εξαγωγή Αναφοράς</button>
    
    <table class="table table-borderd table-striped" id="attendanceTable">
        <thead>
            
            <tr>
                <th>Α/Α</th>
                <th ><?php echo JText::_('COM_ELG_PEDY_PERSONEL'); ?></th>                
                <th>Άδεια</th>
                <th>Έναρξη</th>
                <th>Λήξη</th>
                <th>Ημέρες αδείας <p>(χωρίς σαββατοκύριακα και αργίες)</th>
                <th>ΠΑΡΑΤΗΡΗΣΕΙΣ</th>
            </tr>
        </thead>
        <tbody>
            <?php $cnt = 1;
            foreach($this->rafinaData as  $item): ?>
            <tr id="r<?php echo $item['PersonelAttendanceBookRafinaId']; ?>">
                <td><?php echo $cnt++; ?></td>
                <td><?php echo $item['LastName'], ' ' , $item['FirstName']; ?></td>
                <td><span><?php echo $item['PersonelStatus']; ?></span><br /><a class="btn btn-default" href="<?php echo $this->editURL?>&id=<?php echo $item['PersonelAttendanceBookRafinaId']; ?>" >...</a>
                    <button  type="button" class="btn btn-warning" onclick="confirmDeleteAdiologio(this, <?php echo $item['PersonelAttendanceBookRafinaId']; ?>)">X</button>
                </td>
                <td><?php echo ComponentUtils::getDateFormated($item['StartDate'], 'Y-m-d', 'd/m/Y'); ?></td>
                <td><?php echo ComponentUtils::getDateFormated($item['EndDate'], 'Y-m-d', 'd/m/Y'); ?></td>
                <td><?php echo $item['Duration']; ?></td>
                <td><?php echo $item['Details']; ?></td>
            </tr>
            <?php
            endforeach;
            unset($item);
            ?>
        </tbody>
    </table>
    <?php elseif($this->rafinaForm->getValue('StartDate') !== null): ?>
    <p><?php echo jText::_('COM_ELG_NO_RECORDS'); ?></p>
    <?php endif; ?>
    <form method="post" id="frmDel">
        <input type="hidden" name="delId" id="delId" />
    </form>
<script type="text/javascript"  >
        var personelData = [];
        <?php echo json_encode($this->personelData); ?>.forEach(function(val){ personelData.push({id: val.PersonelId, text: val.LastName + ' ' + val.FirstName});});
</script> 
<script type="application/javascript" src="media/com_elgpedy/js/adiologio.js" async></script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa fa-times"></span></button>
        <h4 class="modal-title" id="myModalLabel">Επιβεβαίωση διαγραφής</h4>
      </div>
      <div class="modal-body">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo JText::_('JNO'); ?></button>
        <button type="button" class="btn btn-danger" onclick="deleteAdiologioRecord()" ><?php echo JText::_('JYES'); ?></button>
      </div>
    </div>
  </div>
</div>