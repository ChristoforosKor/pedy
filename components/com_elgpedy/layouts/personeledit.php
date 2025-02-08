<?php
/* ------------------------------------------------------------------------
  # com_ElgComponent e-logism
  # ------------------------------------------------------------------------
  # author    e-logism
  # copyright Copyright (C) 2013 e-logism.gr. All Rights Reserved.
  # @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  # Website: http://www.e-logism.gr

  ----------------------------------* */
defined('_JEXEC') or die('Restricted access');
JFactory::getDocument()->addStyleSheet('media/com_elgpedy/css/select2.min.css');
$personelId = $this -> form -> getValue('PersonelId', null, 0);
?>
<script type="application/javascript" src="media/com_elgpedy/js/select2.min.js"></script>
<script type="application/javascript" src="media/com_elgpedy/js/moment.min.js" ></script>
<div class="elg">
    <section>
        <div class="row">
            <h2>Στοιχεία Προσωπικού</h2>
            <form role="form" method="post" action="<?php echo $this->formAction; ?>" id="frmPersonnel">
                <input type="hidden" name="pt" value="1" />
                <fieldset class="col-md-6">
                    <legend><?php echo JText::_('COM_ELGPEDY_PERSONEL_PERSONAL'); ?></legend>
                    <?php
                    foreach ($this->form->getFieldset('personel_personal') as $field):
                        if ($field->hidden):
                            echo $field->input;
                        else:
                            ?>
                            <div class="form-group">
                                <?php echo $field->label, '<br />', $field->input .( 
                                        $field -> getAttribute('name', '') === 'trn' || $field -> getAttribute('name', '') === 'amka' ?
                                        '<img src="media/com_elgpedy/images/ajax-loader.gif" style="display:none" />' :'' );
                                ?>

                            </div>
                        <?php
                        endif;
                    endforeach;
                    unset($field);
                    ?>
                </fieldset>
                <fieldset class="col-md-6">
                    <legend><?php echo JText::_('COM_ELGPEDY_PERSONEL_JOB'); ?></legend>
                    <?php
                    if ($this->form->getValue('PersonelId', null, 0) === 0) :

                        echo '<div class="form-group">',
                        $this->form->getLabel('RefUnitStartDate'),
                        $this->form->getInput('RefUnitStartDate'),
                        '</div>';
                    else:
                        $this->form->setFieldAttribute('HealthUnitId', 'disabled', 'disabled');
                    endif;
                    echo '<div class="form-group">',
                    $this->form->getLabel('HealthUnitId'),
                    $this->form->getInput('HealthUnitId'),
                    '</div>';


                    foreach ($this->form->getFieldset('personel_job') as $field):
                        if ($field->hidden):
                            echo $field->input;
                        elseif ($field->getAttribute('name', '') !== 'HealthUnitId') :
                            ?>
                            <div class="form-group">
                                <?php echo $field->label, '<br />', $field->input; ?> 
                                
                                

                            </div>
                            <?php
                        endif; // HealthUnitId

                    endforeach;
                    unset($field);
                    ?>
                </fieldset>

                <div class="clearfix">&nbsp;</div>
                <div class="form-group">
                    <?php if ( $this -> form -> getValue('StatusId') === '3' ):
                        echo '<p class="text-info">Το επιλεγμένο προσωπικό είναι διαγραμμένο. Ορίστε ενεργή οργανική μονάδα στις κινήσεις ιστορικού παρακάτω για να ενεργοποιηθεί.</p>';
                    else: ?>
                    <button class="btn btn-primary" id="btSbPersonel"><?php echo JText::_('COM_ELG_SUBMIT'); ?></button>
                    <?php endif; ?>
                    
                    <a href="<?php echo JRoute::_('index.php?option=com_elgpedy&view=personels&Itemid=' . $this->state->get('Itemid', 0), false); ?>" class="btn btn-default pull-right" ><?php echo JText::_('COM_ELG_CANCEL'); ?></a>
                </div>
            </form>

        </div>
    </section>
    <section>
        <?php 
        $hasOpen = 0;
        if ($personelId > 0): 
            $moveClass='';
        else:
            $moveClass= 'hidden';
        endif;
        ?>
            <div class="row <?php echo $moveClass; ?>">
                <h2>Ιστορικό Υπηρεσίας </h2> <th>(ΣΗΜΕΙΩΣΗ: Στην παρούσα φάση σε περίπτωση που δε δέχεται την πραγματική ημερομηνία έναρξης της υπηρεσίας βάζετε τη σημερινή ή αυριανή)</th>
                <div class="col-xs-12">
                    <form role="form" method="post"action="<?php echo $this->formAction; ?>" id="frmMovement">
                        <input type="hidden" name="pt" value="2" />
                        <?php
                        $this->form->setValue('HealthUnitId', '');
                        $this->form->setValue('RefHealthUnitId', '');
                        $this->form->setValue('PersonelStatusId', '');
                        $this->form->setValue('RefUnitStartDate', '');
                        $this->form->setValue('RefUnitEndDate', '');
                        $this->form->setFieldAttribute('PersonelId', 'id', 'PersonelId2');
                        $this->form->setFieldAttribute('HealthUnitId', 'id', 'HealthUnitId2');
                        $this->form->setFieldAttribute('HealthUnitId', 'disabled', '');
                        echo $this->form->getInput('PersonelId');
                        ?>
                        <table class="table table-striped table-responsive" >
                            <thead>
                                <tr>
                                    <th>Οργανική Μον.</th>
                                    <th>Μον. Υπηρεσίας</th>
                                    <th>Κατάσταση</th>
                                    <th>Έναρξη</th>
                                    <th>Λήξη</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr style="display:none" id="newMovement">
                                    <td><?php echo $this->form->getInput('HealthUnitId'); ?></td>
                                    <td><?php echo $this->form->getInput('RefHealthUnitId'); ?></td>
                                    <td><?php echo $this->form->getInput('PersonelStatusId'); ?></td>
                                    <td class="calendar" ><?php echo $this->form->getInput('RefUnitStartDate'); ?></td>

                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <button type="button" class="btn btn-default" style="display:none" id="btAddMovement" >Προσθήκη</button>
                                        <button  class="btn btn-primary" style="display:none" id="btSaveMovement" >Ενημέρωση</button>
                                    </td>
                                </tr>
                            </tfoot>
                            <tbody>
    <?php
    
    foreach ($this->storedData['movements'] as $movement):
        ?>
                                    <tr>
                                        <td><?php echo $movement[8]; ?></td>
                                        <td><?php echo $movement[3]; ?></td>
                                        <td><?php echo $movement[7]; ?></td>
                                        <td><?php echo ( $movement[5] === '' ? '' : date('d/m/Y', strtotime($movement[5])) ); ?></td>
                                        <td>
                                            <?php
                                            if ($movement[4] == '' || $movement[4] < '1500') :
                                                echo '';
                                            else:
                                                echo date('d/m/Y', strtotime($movement[4]));
                                            endif;
                                            ?>
                                        </td>
                                    </tr>

                                    <?php
                                endforeach;
                                unset($movement);
                                ?>

                            </tbody>
                        </table>
                    </form>
                </div>
            
        </div>




    </section>

    <script type="application/javascript" src="media/com_elgpedy/js/personeledit.js" ></script>
    <script type="application/javascript">
            personelEditMod.init(
                    {personelId: <?php echo $personelId; ?>, hasOpenMovement: <?php echo $hasOpen; ?>, srPerUrl: '<?php echo JRoute::_('index.php?option=com_elgpedy&view=personels&format=json&Itemid=' . $this->Itemid, false); ?>' }
            );
    </script>
    <div class="row">
        <p class="col-xs-12"><span class="comments-title"><?php echo JText::_('COM_ELG_PEDY_COMMENTS'); ?>:</span><?php echo JText::_('COM_ELG_PEDY_FORM_FOOTER_PERSONEL'); ?></p>
    </div>
    

</div>