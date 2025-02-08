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
?>
<div class="elg">
    <h2>ΑΤΟΜΙΚΟ ΔΕΛΤΙΟ ΟΔΟΝΤΙΑΤΡΙΚΗΣ ΕΞΕΤΑΣΗΣ ΜΑΘΗΤΗ/ΤΡΙΑΣ </h2>
    <form method="post" action="<?php echo $this->formAction; ?>" id="dentalForm">
            <?php echo $this->formDentalExamEdit->getInput('dental_transaction_id'); ?>
        <div class="row" >
<?php require JPATH_COMPONENT_SITE . '/layouts/partchronodatetimeinputs.php'; ?>
        </div>
        <h3>1. Στοιχεία μαθητή/ριας και σχολείου</h3>
        <fieldset>
            <div class="row">
                <div class="col-md-4">
                    <?php echo $this->formDentalExamEdit->getLabel('school_level_id'), '<br />', $this->formDentalExamEdit->getInput('school_level_id'); ?>
                <br />
                    <?php echo $this->formDentalExamEdit->getLabel('area'), '<br />', $this->formDentalExamEdit->getInput('area'); ?>
         </div>
                <div id="area-type-container"  class="col-md-4" >
                    <fieldset>
                        <legend>Τύπος περιοχής</legend>
                        <div class="form-group">
                            <input checked="checked" type="radio" name="area_type" class="area_type" value="1" > <label> ΑΣΤΙΚΗ ΠΕΡΙΟΧΗ </label>
                        </div>
                        <div class="form-group hidden">
                            <input type="radio" name="area_type" value="2" class="area_type" > <label> ΗΜΙ ΑΣΤΙΚΗ ΠΕΡΙΟΧΗ </label>
                        </div>
                        <div class="form-group hidden">
                            <input type="radio" name="area_type" value="3"  class="area_type" > <label> ΑΓΡΟΤΙΚΗ ΠΕΡΙΟΧΗ </label>
                        </div>
                    </fieldset>
                </div> 

            </div>
            <div class="row">    
                <div  class="col-md-8"  id="school-container" >
                        <?php echo $this->formDentalExamEdit->getLabel('school_id'), '<br />', $this->formDentalExamEdit->getInput('school_id'); ?>
                </div>   
               
				 
				<div  class="col-md-8"  id="class-container"  >
					<?php echo $this->formDentalExamEdit->getLabel('school_class_id'), '<br />', $this->formDentalExamEdit->getInput('school_class_id'); ?>
                </div>
				<div  class="col-md-8">
					<?php echo $this->formDentalExamEdit->getLabel('info_level'), '<br />', $this->formDentalExamEdit->getInput('info_level'); ?>
                </div>				
            </div>
			<div class="row">    
                 <hr />              
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">	
                        <div class="form-group" >
                            <?php echo $this->formDentalExamEdit->getLabel('ssn'), '<br />', $this->formDentalExamEdit->getInput('ssn'); ?>
                        </div>
                        <?php echo $this->formDentalExamEdit->getLabel('birthday'); ?>
                    <div class="input-group date form_datetime"  data-date="">
<?php echo $this->formDentalExamEdit->getInput('birthday'); ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                    </div>	
                    </div>
                    <div class="form-group" >
<?php echo $this->formDentalExamEdit->getLabel('nationality_id'), '<br />', $this->formDentalExamEdit->getInput('nationality_id'); ?>
                    </div>
                </div>
                <div class="form-group col-md-4 " id="isMaleContainer">
<?php echo $this->formDentalExamEdit->getInput('isMale'); ?>
                </div>
            </div>           
            <div class="row" >
                <div class="form-group col-md-4" >
<?php echo $this->formDentalExamEdit->getLabel('father_profession'), '<br />', $this->formDentalExamEdit->getInput('father_profession'); ?>
                </div>
                <div class="form-group col-md-4" >
<?php echo $this->formDentalExamEdit->getLabel('mother_profession'), '<br />', $this->formDentalExamEdit->getInput('mother_profession'); ?>
                </div>
            </div>
        </fieldset>
        <h3>2. Κλινική εκτίμηση οδοντικής τερηδόνας</h3>

        <dl class="dental-who">
            
        </dl>
        <p class="dental text-info">
            <em>WHO Codes</em>, συμπληρώστε τον αντίστοιχο κωδικό μόνο όταν το δόντι δεν είναι υγιές.
        </p>
        <fieldset class="tooth-condition">
            <legend>ΝΕΟΓΙΛΑ ΔΟΝΤΙΑ</legend>
            <div class="col-md-12 jaw">
                <div>
                    <label>55</label>
                    <input type="text" value="1" class="tooth" id="t55" name="tooth[55]"  class="tooth" />
                </div>
                <div>
                    <label>54</label>
                    <input type="text" value="1" class="tooth" id="t54" name="tooth[54]"  class="tooth" />
                </div>
                <div>
                    <label>53</label>
                    <input type="text" value="1" class="tooth" id="t53" name="tooth[53]"  class="tooth" />
                </div>
                <div>
                    <label>52</label>
                    <input type="text" value="1" class="tooth" id="t52" name="tooth[52]"  class="tooth" />
                </div>
                <div>
                    <label>51</label>
                    <input type="text" value="1" class="tooth" id="t51" name="tooth[51]"  class="tooth" />
                </div>
                <div>
                    <label>61</label>
                    <input type="text" value="1" class="tooth" id="t61" name="tooth[61]"  class="tooth" />
                </div>
                <div>
                    <label>62</label>
                    <input type="text" value="1" class="tooth" id="t62" name="tooth[62]"  class="tooth" />
                </div>
                <div>
                    <label>63</label>
                    <input type="text" value="1" class="tooth" id="t63"  name="tooth[63]"  class="tooth" />
                </div>
                <div>
                    <label>64</label>
                    <input type="text" value="1" class="tooth"  id="t64"  name="tooth[64]"  class="tooth" />
                </div>
                <div>
                    <label>65</label>
                    <input type="text" value="1" class="tooth"  id="t65"  name="tooth[65]"  class="tooth" />
                </div>
            </div>
            <div class="col-md-12 jaw">
                <div>
                    <label>85</label>
                    <input type="text" value="1" class="tooth"  id="t85"  name="tooth[85]"  class="tooth" />
                </div>
                <div>
                    <label>84</label>
                    <input type="text" value="1" class="tooth" id="t84" name="tooth[84]"  class="tooth" />
                </div>
                <div>
                    <label>83</label>
                    <input type="text" value="1" class="tooth" id="t83" name="tooth[83]"  class="tooth" />
                </div>
                <div>
                    <label>82</label>
                    <input type="text" value="1" class="tooth" id="t82" name="tooth[82]"  class="tooth" />
                </div>
                <div>
                    <label>81</label>
                    <input type="text" value="1" class="tooth" id="t81" name="tooth[81]"  class="tooth" />
                </div>
                <div>
                    <label>71</label>
                    <input type="text" value="1" class="tooth" id="t71" name="tooth[71]"  class="tooth" />
                </div>
                <div>
                    <label>72</label>
                    <input type="text" value="1" class="tooth"  id="t72"  name="tooth[72]"  class="tooth" />
                </div>
                <div>
                    <label>73</label>
                    <input type="text" value="1" class="tooth"  id="t73"  name="tooth[73]"  class="tooth" />
                </div>
                <div>
                    <label>74</label>
                    <input type="text" value="1" class="tooth"  id="t74"  name="tooth[74]"  class="tooth" />
                </div>
                <div>
                    <label>75</label>
                    <input type="text" value="1" class="tooth"  id="t75"  name="tooth[75]"  class="tooth" />
                </div>

            </div>        
        </fieldset>
        <fieldset class="tooth-condition" >
            <legend>ΜΟΝΙΜΑ ΔΟΝΤΙΑ</legend>

            <div class="col-md-12 jaw">
                <div>
                    <label>17</label>
                    <input type="text" class="tooth"  id="t17" name="tooth[17]"  class="tooth" />
                </div>
                <div>
                    <label>16</label>
                    <input type="text" class="tooth" id="t16" name="tooth[16]"  class="tooth" />
                </div>
                <div>
                    <label>15</label>
                    <input type="text" class="tooth" id="t15" name="tooth[15]"  class="tooth" />
                </div>
                <div>
                    <label>14</label>
                    <input type="text" class="tooth" id="t14" name="tooth[14]"  class="tooth" />
                </div>
                <div>
                    <label>13</label>
                    <input type="text" class="tooth" id="t13" name="tooth[13]"  class="tooth" />
                </div>
                <div>
                    <label>12</label>
                    <input type="text" class="tooth" id="t12" name="tooth[12]"  class="tooth" />
                </div>
                <div>
                    <label>11</label>
                    <input type="text" class="tooth" id="t11" name="tooth[11]"  class="tooth" />
                </div>
                <div>
                    <label>21</label>
                    <input type="text" class="tooth" id="t21" name="tooth[21]"  class="tooth" />
                </div>
                <div>
                    <label>22</label>
                    <input type="text" class="tooth" id="t22" name="tooth[22]"  class="tooth" />
                </div>
                <div>
                    <label>23</label>
                    <input type="text" class="tooth" id="t23" name="tooth[23]"  class="tooth" />
                </div>
                <div>
                    <label>24</label>
                    <input type="text" class="tooth" id="t24" name="tooth[24]"  class="tooth" />
                </div>
                <div>
                    <label>25</label>
                    <input type="text" class="tooth" id="t25" name="tooth[25]"  class="tooth" />
                </div>
                <div>
                    <label>26</label>
                    <input type="text" class="tooth" id="t26" name="tooth[26]"  class="tooth" />
                </div>
                <div>
                    <label>27</label>
                    <input type="text" class="tooth" id="t27" name="tooth[27]"  class="tooth" />
                </div>
            </div>
            <div class="col-md-12 jaw">
                <div>
                    <label>47</label>
                    <input type="text" class="tooth" id="t47" name="tooth[47]"  class="tooth" />
                </div>
                <div>
                    <label>46</label>
                    <input type="text" class="tooth" id="t46" name="tooth[46]"  class="tooth" />
                </div>
                <div>
                    <label>45</label>
                    <input type="text" class="tooth" id="t45" name="tooth[45]"  class="tooth" />
                </div>
                <div>
                    <label>44</label>
                    <input type="text" class="tooth" id="t44" name="tooth[44]"  class="tooth" />
                </div>
                <div>
                    <label>43</label>
                    <input type="text" class="tooth" id="t43" name="tooth[43]"  class="tooth" />
                </div>
                <div>
                    <label>42</label>
                    <input type="text" class="tooth" id="t42" name="tooth[42]"  class="tooth" />
                </div>
                <div>
                    <label>41</label>
                    <input type="text" class="tooth" id="t41" name="tooth[41]"  class="tooth" />
                </div>
                <div>
                    <label>31</label>
                    <input type="text" class="tooth" id="t31" name="tooth[31]"  class="tooth" />
                </div>
                <div>
                    <label>32</label>
                    <input type="text" class="tooth" id="t32" name="tooth[32]"  class="tooth" />
                </div>
                <div>
                    <label>33</label>
                    <input type="text" class="tooth" id="t33" name="tooth[33]"  class="tooth" />
                </div>
                <div>
                    <label>34</label>
                    <input type="text" class="tooth" id="t34" name="tooth[34]"  class="tooth" />
                </div>
                <div>
                    <label>35</label>
                    <input type="text" class="tooth" id="t35" name="tooth[35]"  class="tooth" />
                </div>
                <div>
                    <label>36</label>
                    <input type="text" class="tooth" id="t36" name="tooth[36]"  class="tooth" />
                </div>
                <div>
                    <label>37</label>
                    <input type="text" class="tooth" id="t37" name="tooth[37]"  class="tooth" />
                </div>
            </div>     
        </fieldset>
        <div class="row mouth-problems" >
                <div class="col-md-4">
                    <?php echo $this->formDentalExamEdit->getLabel('problem_category_2') . $this->formDentalExamEdit->getInput('problem_category_2'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $this->formDentalExamEdit->getLabel('problem_category_3') . $this->formDentalExamEdit->getInput('problem_category_3'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $this->formDentalExamEdit->getLabel('problem_category_4') . $this->formDentalExamEdit->getInput('problem_category_4'); ?>
                </div>
        </div>
        <h3>3. Άλλες παθήσεις σκληρών και μαλακών ιστών του στόματος</h3>
        <div class="mouth-conditons">
<?php echo $this->formDentalExamEdit->getInput('dental_mouthcondition'); ?>
        </div>   
            <div class="mouth-conditons">

        </div>
        <div class="clearfix">&nbsp;</div>
        <div>
            <button class="btn-primary"><?php echo JText::_('COM_ELG_SUBMIT'); ?></button>
        </div>
    </form>
</div>

<script type="application/javascript">
    var form = document.getElementById('dentalForm');
    form.noValidate = true;
    form.onsubmit = validateDentalForm;
    
    function validateDentalForm() {
        var msg = '';
        var rD = moment(document.getElementById('RefDate').value, 'DD/MM/YYYY');
        if(!rD.isValid())  msg += 'Το πεδιό ημερομηνία είναι υποχρεωτικό\n';
        if(document.getElementById('area').value === '') msg += 'Το πεδίο περιοχή είναι υποχρεωτικό\n';
        if(document.getElementById('school_id').value === '') msg += 'Το πεδίο σχολείο είναι υποχρεωτικό\n';
        if(document.getElementById('school_class_id').value === '') msg +='Το πεδίο τάξη είναι υποχρεωτικό\n';
        var rB = moment(document.getElementById('birthday').value, 'DD/MM/YYYY');
        if(!rB.isValid()) msg += 'Το πεδίο Ημερομηνία γέννησης είναι υποχρεωτικό\n';
        if (msg !== '') {
            alert ('Παρακαλώ ελέγξετε τις τιμές που καταχωρείσατε\n' + msg);
            return false;
        }
        else
           return true;            
    }
</script>