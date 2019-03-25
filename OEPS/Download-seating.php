<?php
session_start();
ob_start();
require_once 'includes/config.php';
error_reporting(0);
require_once 'pdf/fpdf.php';


 class PDF extends FPDF {

    
        function header() {
            //Insert image
            $this->Image('images/student.jpg',10,6,20,'R');
            $this->Image('images/student.jpg',270,6,20,'L');
            // Select Arial bold 15
            $this->SetFont('Arial', 'B', 20);
            $this->SetDrawColor(80, 100, 180);
            $this->SetFillColor(230, 230, 0);
            $this->SetTextColor(220, 50, 50);
            // Thickness of frame (1 mm)
            $this->SetLineWidth(1);
                        
            // Move to the Center
            $this->Cell(280, 20, 'SEATING NUMBER', 0, 0, 'C');        

            $this->Ln();
            // Line break
            $this->Ln(10);
        }

        function footer() {
            // Go to 1.5 cm from bottom
            $this->SetY(-15);
            // Select Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Print current and total page numbers
            $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }

        function headerTable() {
            // Colors, line width and bold font
            $this->SetDrawColor(500, 100, 100);
            $this->SetFillColor(400, 200, 5);
            $this->SetLineWidth(.10);
            $this->SetFont('Times', 'B', 12);

            //The heading of the table
            $this->Cell(9, 10, '#', 1, 0, 'C','C');             
            $this->Cell(60, 10, 'Course Name', 1, 0, 'C','C');
            $this->Cell(20, 10, 'Section', 1, 0, 'C','C');
            $this->Cell(30, 10,'Exam Date', 1, 0,'C', 'C');
            $this->Cell(35, 10, 'Exam Time', 1, 0,'C', 'C');
           
            $this->Cell(90, 10, 'Venue', 1, 0,'C', 'C');
            $this->Cell(35, 10, 'Seating Number', 1, 0, 'C','C');
            $this->Ln();
        }        

        function viewTable($dbh) {
            $this->SetFont('Times', '', 12);
            // Colors, line width and bold font
            $this->SetFillColor(255, 0, 0);     
            $this->SetDrawColor(128, 0, 0); 

           
            $_SESSION['matricno'] = $matricno;
           $sql = "SELECT * from studentinfo Limit 1";
            $query = $dbh->prepare($sql);            
                     
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $cnt = 1;
            if ($query->rowCount() > 0) {
                foreach ($results as $result) {                   

                    $this->Cell(9, 10, htmlentities($cnt), 1, 0, 'C');
                   // $this->Cell(60, 10, $result->StudentName, 1, 0, 'L');
                   // $this->Cell(40, 10, $result->MatricNumber, 1, 0, 'L');

                 
                    $this->Cell(60, 10, $result->CourseName, 1, 0, 'C');
                    $this->Cell(20, 10, $result->Section, 1, 0, 'C');
                    $this->Cell(30, 10, $result->ExamDate , 1, 0, 'C');
                    $this->Cell(35, 10, "$result->StartTime - $result->EndTime",  1, 0, 'C');
                    $this->Cell(90, 10, "$result->HallName, Level $result->LevelNumber, Wing  $result->Wing,UNITAR $result->Region" , 1, 0, 'C');
                   /* $this->Cell(20, 10, $result->LevelNumber, 1, 0, 'C');
                    $this->Cell(20, 10, $result->Wing, 1, 0, 'C');
                    $this->Cell(20, 10, $result->Region, 1, 0, 'C'); */
                    $this->Cell(35, 10, $result->SeatingNumber, 1, 0, 'C');
                    $this->Ln();
                    $cnt = $cnt + 1;
                    
                }
                $this->Cell(280, 20, 'Good Luck!!', 0, 0, 'C');
            }
        }

    }

    
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L', 'A4', 0);
    $pdf->headerTable();
    $pdf->viewTable($dbh);
    $pdf->Output();

?>
