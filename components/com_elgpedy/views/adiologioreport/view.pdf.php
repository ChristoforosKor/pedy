<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/
 
    defined( '_JEXEC' ) or die( 'Restricted access' );
    define("_SYSTEM_TTFONTS", JPATH_COMPONENT_SITE . '/libraries/php/3dparty/tfpdf/font/unifont/');
    require JPATH_COMPONENT_SITE .'/libraries/php/3dparty/tfpdf/tfpdf.php';
    class FPDF extends tFPDF
    {
            /**
             * "Remembers" the template id of the imported page
             */
            protected $_tplIdx;
           
    }
    require JPATH_COMPONENT_SITE .'/libraries/php/3dparty/fpdi/fpdi.php';
   
   class ElgPedyViewAdiologioReport extends JViewBase
   {
        public function render()
        {
            $data = $this->model->getState()->get('data')['rafinaAttendance'];
            $form = $this->model->getState()->get('forms')['adiologioReport'];
            $rows = count($data);
            $pdf = new FPDI('L', 'mm','A4');
            $pdf->AddFont('DejaVu', '', '/DejaVuSansCondensed.ttf',true);
            $pdf->AddFont('DejaVuBold', '', '/DejaVuSansCondensed-Bold.ttf',true);
            $pdf->setSourceFile(JPATH_SITE . '/media/com_elgpedy/templates/rafina.pdf');
            $pdf->AddPage();
            $tplIdx = $pdf->importPage(1);
            $pdf->useTemplate($tplIdx);
            $pdf->SetFont('DejaVu','', 10);
            $pdf->setXY(10,30);
            $pdf->SetFont('DejaVuBold','', 10);
            $pdf->Write(10,'Περίοδος Αναφοράς'.' '. ComponentUtils::getDateFormated($form->getValue('StartDate'), 'Y-m-d', 'd/m/Y') . ' - ' . ComponentUtils::getDateFormated($form->getValue('EndDate'), 'Y-m-d', 'd/m/Y'));
            $pdf->Ln();
            $pdf->Cell(10,10, 'Α/Α', 'B', 'C');
            $pdf->Cell(70,10, 'Ονοματεπώνυμο', 'B', 'C');
            $pdf->Cell(60,10, 'Άδεια' , 'B', 'C');
            $pdf->Cell(20,10, 'Έναρξή' , 'B', 'C');
            $pdf->Cell(20,10, 'Λήξη' , 'B', 'C');
            $pdf->Cell(20,10, 'Ημέρες' , 'B', 'L');
            $pdf->Cell(80,10, 'ΠαΡατηΡΗΣΕΙΣ' , 'B', 'L');
            $pdf->Ln();
            $pg =1;
            $rowPerPage = 12;
            $pgNo = $rows / $rowPerPage;
            if (floor($pgNo) < $pgNo):
                $pgNo = floor($pgNo) + 1;
            endif;
			
            $pdf->SetFont('DejaVu','', 10);
            for($row = 0; $row < $rows ; $row ++):
                if( ($row + 1) % $rowPerPage === 0 &&  $row > 0 ):
				$pdf->setXY(200,180);
                    $pdf->SetFont('DejaVu','', 8);
					$pdf->Write(8,"Κ.Υ. Ραφήνας, Κατάσταση αδειών, σελ. $pg / $pgNo");
                    $pdf->AddPage();
					$pdf->setXY(200,180);
                    $pdf->SetFont('DejaVu','', 8);
					$pg ++;
                    $pdf->Write(8,"Κ.Υ. Ραφήνας, Κατάσταση αδειών, σελ. $pg / $pgNo");
                    $pdf->setXY(10,30);
                    $pdf->SetFont('DejaVuBold','', 10);
                    $pdf->Write(10,'Περίοδος Αναφοράς'.' '. ComponentUtils::getDateFormated($form->getValue('StartDate'), 'Y-m-d', 'd/m/Y') . ' - ' . ComponentUtils::getDateFormated($form->getValue('EndDate'), 'Y-m-d', 'd/m/Y'));
                    $pdf->Ln();
                    $pdf->importPage(1);
                    $pdf->useTemplate($tplIdx);
                    $pdf->setXY(10,40);
					$pdf->Cell(10,10, 'Α/Α', 'B', 'C');
					$pdf->Cell(70,10, 'Ονοματεπώνυμο', 'B', 'C');
					$pdf->Cell(60,10, 'Άδεια' , 'B', 'C');
					$pdf->Cell(20,10, 'Έναρξή' , 'B', 'C');
					$pdf->Cell(20,10, 'Λήξη' , 'B', 'C');
					$pdf->Cell(20,10, 'Ημέρες' , 'B', 'L');
                                        $pdf->Cell(80,10, 'ΠαΡατηΡΗΣΕΙΣ' , 'B', 'L');
                                        $pdf->Ln();
                    $pdf->setFont('DejaVu','',10);
                    
                endif;
                $pdf->SetFont('Arial','', 10);
                $pdf->Cell(10,10, $row + 1, 'B', 'C');
                $pdf->SetFont('DejaVu','', 8);
                $pdf->Cell(70,10, $data[$row]['LastName'] . ' - ' . $data[$row]['FirstName'], 'B', 'C');
                $pdf->Cell(60,10, $data[$row]['PersonelStatus'] ,'B','L');
                $pdf->Cell(20,10, ComponentUTils::getDateFormated($data[$row]['StartDate'], 'Y-m-d', 'd/m/Y') , 'B', 'C');
                $pdf->Cell(20,10, ComponentUTils::getDateFormated($data[$row]['EndDate'], 'Y-m-d', 'd/m/Y') , 'B', 'C');
                $pdf->Cell(20,10, $data[$row]['Duration'] , 'B', 'L');
                $pdf->Cell(80,10, $data[$row]['Details'] , 'B', 'L');
                $pdf->Ln();
            endfor;
            //$pdf->importPage(1);
           
            $pdf->Output('report_' . date('d-m-y h-i-s').'.pdf', 'I');
            exit();           
        }
        
       
   }
