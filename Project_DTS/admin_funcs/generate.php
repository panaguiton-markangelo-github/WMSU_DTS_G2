<?php
session_start();
include ("../include/alt_db.php");

if(isset($_POST['generate'])){

    $cur_user = $_SESSION['a_username'];
    
    $office = $_POST['officeName'];

    if($office == ""){
        $_SESSION['message_fail'] = "PLease select an office!";
        header("location: ../include/error.php?office=empty");
        exit();
    }

    $sql = "SELECT documents.*, users.officeName FROM documents INNER JOIN users ON users.id = documents.user_id WHERE users.officeName = ?;";
    $stmt = mysqli_stmt_init($data);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        $_SESSION['message_fail'] = "Unexpected error occured!";
        header("location: ../include/error.php?error=true");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "s", $office);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $no_rows_docs = mysqli_num_rows($result);

        if ($no_rows_docs <= 0) {
            $_SESSION['message_fail'] = "Generation failed! <br> There are no documents/users in this office or there are only users but no documents and vice versa.";
            header("location: ../include/error.php?docs=empty");
            exit();
        }

        else{
            require_once('../TCPDF-main/tcpdf.php');

            class PDF extends TCPDF {

                public function Header() {
                    $image_file = K_PATH_IMAGES.'wmsu_logo.png';
                    $this->Image($image_file, 40, 10, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                    $this->Ln(4);
                    $this->SetFont('helvetica','B',12);
                    $this->Cell(189, 3, 'WMSU Document Tracking System', 0,1, 'C');
                    
                    $this->SetFont('helvetica','',9);
                    $this->Cell(189, 3, 'System Generated Report', 0,1, 'C');
                    $this->Cell(189, 5, 'Western Mindanao State University', 0,1, 'C');  
                    $this->Cell(189, 5, 'Institute of Computer Studies', 0,1, 'C'); 
                    $this->Cell(189, 3, 'Normal Road, Baliwasan, Z.C.', 0,1, 'C');
                    $this->Cell(189, 3, 'wmsudts@gmail.com', 0,1, 'C');                   
                }

                public function Footer() {
                    //bottom most elements.
                    $this->setY(-10);
                    //time/date creation
                    $this->SetFont('helvetica', 'I', 8);
                    date_default_timezone_set("Asia/Manila");
                    $today = date("F j, Y/ g:i A", time());

                    //displaying page number and date/time.
                    $this->Cell(25, 5, 'Generation Date/Time: '.$today, 0, 0, 'L');     
                    // Page number
                    $this->Cell(164, 5, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 
                    0, false, 'R', 0, '', 0, false, 'T', 'M');
                    
                }
            }

            // create new PDF document
            $pdf = new PDF('p', 'mm', 'A4', true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('WMSU|DTS system');
            $pdf->SetTitle('System Generated Report');
            $pdf->SetSubject('Report');
            $pdf->SetKeywords('system, report, generated');

            // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
            $pdf->setFooterData(array(0,64,0), array(0,64,128));

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }

            // set default font subsetting mode
            $pdf->setFontSubsetting(true);

            // Set font
            // dejavusans is a UTF-8 Unicode font, if you only need to
            // print standard ASCII chars, you can use core fonts like
            // helvetica or times to reduce file size.
            $pdf->SetFont('dejavusans', '', 14, '', true);

            // Add a page
            // This method has several options, check the source code documentation for more information.
            $pdf->AddPage();

            $pdf->Ln(18);
            $pdf->SetFont('times','B',10);
            $pdf->Cell(100, 3, 'Requested by: '.$cur_user, 0,0, 'L');
            $pdf->Cell(89, 3, 'Total documents: '.$no_rows_docs, 0,1,'R');
            
            $pdf->Ln(2);
            $pdf->Cell(189, 3, 'Records office: '.$office, 0,1);

            $pdf->Ln(10);
            $pdf->Cell(189, 3, 'DOCUMENTS', 0,1, 'C');

            $pdf->SetFont('times','B',9);
            $pdf->Ln(2);
            $pdf->setFillColor(224, 235, 255);
            $pdf->Cell(10, 3, 'No', 1,0, 'C', 1);
            $pdf->Cell(30, 3, 'Tracking ID', 1,0, 'C', 1);
            $pdf->Cell(40, 3, 'Title', 1,0, 'C', 1);
            $pdf->Cell(50, 3, 'Type', 1,0, 'C', 1);
            $pdf->Cell(40, 3, 'Reason', 1,0, 'C', 1);
            $pdf->Cell(19, 3, 'Status', 1,1, 'C', 1);

            $pdf->SetFont('times','B',7);
            $i_d = 1;
            $max_page_d = 36;
            $sql = "SELECT documents.*, users.officeName FROM documents INNER JOIN users ON users.id = documents.user_id WHERE users.officeName = ?;";
            $stmt = mysqli_stmt_init($data);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "s", $office);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($result)){
                $trackID = $row['trackingID'];
                $title = $row['title'];
                $type = $row['type'];
                $reason = $row['reason'];
                $status = $row['status'];

                if($i_d%$max_page_d == 0){
                    $pdf->AddPage();
    
                    $pdf->Ln(18);
                    $pdf->SetFont('times','B',10);
                    $pdf->Cell(100, 3, 'Requested by: '.$cur_user, 0,0, 'L');
                    $pdf->Cell(89, 3, 'Total documents: '.$no_rows_docs, 0,1,'R');
                    
                    $pdf->Ln(2);
                    $pdf->Cell(189, 3, 'Records office: '.$office, 0,1);
    
                    $pdf->Ln(10);
                    $pdf->Cell(189, 3, 'DOCUMENTS', 0,1, 'C');
    
                    $pdf->SetFont('times','B',9);
                    $pdf->Ln(2);
                    $pdf->setFillColor(224, 235, 255);
                    $pdf->Cell(10, 3, 'No', 1,0, 'C', 1);
                    $pdf->Cell(30, 3, 'Tracking ID', 1,0, 'C', 1);
                    $pdf->Cell(40, 3, 'Title', 1,0, 'C', 1);
                    $pdf->Cell(50, 3, 'Type', 1,0, 'C', 1);
                    $pdf->Cell(40, 3, 'Reason', 1,0, 'C', 1);
                    $pdf->Cell(19, 3, 'Status', 1,1, 'C', 1);
    
                    $pdf->SetFont('times','B',7);
    
                }
                    $pdf->Ln(3);      
                    $pdf->Cell(10, 3,$i_d , 0,0, 'C');          
                    $pdf->Cell(30, 3, $trackID, 0,0, 'C');
                    $pdf->Cell(40, 3, $title , 0,0, 'C');
                    $pdf->Cell(50, 3,$type , 0,0, 'C');
                    $pdf->Cell(40, 3, $reason, 0,0, 'C');
                    $pdf->Cell(19, 3, $status, 0,1, 'C');
                    $i_d++;

            }

            //users
            $pdf->AddPage();

            $sql = "SELECT * FROM users WHERE officeName = ?;";
            $stmt = mysqli_stmt_init($data);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "s", $office);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $no_users = mysqli_num_rows($result);

            $pdf->Ln(18);
            $pdf->SetFont('times','B',10);
            $pdf->Cell(100, 3, 'Requested by: '.$cur_user, 0,0, 'L');
            $pdf->Cell(89, 3, 'Total users: '.$no_users, 0,1,'R');
            
            $pdf->Ln(2);
            $pdf->Cell(189, 3, 'Records office: '.$office, 0,1);

            $pdf->Ln(10);
            $pdf->Cell(189, 3, 'USERS', 0,1, 'C');

            
            $pdf->SetFont('times','B',10);
            $pdf->Ln(2);
            $pdf->setFillColor(224, 235, 255);
            $pdf->Cell(20, 3, 'No', 1,0, 'C', 1);
            $pdf->Cell(70, 3, 'Name', 1,0, 'C', 1);
            $pdf->Cell(70, 3, 'Username', 1,0, 'C', 1);
            $pdf->Cell(29, 3, 'Usertype', 1,1, 'C', 1);

            $pdf->SetFont('times','B',9);
            $i_u = 1;
            $max_page_u = 36;

           

            while($row = mysqli_fetch_assoc($result)){
                $name = $row['name'];
                $username = $row['username'];
                $userType = $row['userType'];

                if($i_u%$max_page_u == 0){
                    $pdf->AddPage();
    
                    $pdf->Ln(18);
                    $pdf->SetFont('times','B',10);
                    $pdf->Cell(100, 3, 'Requested by: '.$cur_user, 0,0, 'L');
                    $pdf->Cell(89, 3, 'Total users: '.$no_users, 0,1,'R');
                    
                    $pdf->Ln(2);
                    $pdf->Cell(189, 3, 'Records office: '.$office, 0,1);
    
                    $pdf->Ln(10);
                    $pdf->Cell(189, 3, 'USERS', 0,1, 'C');
    
                    $pdf->SetFont('times','B',10);
                    $pdf->Ln(2);
                    $pdf->setFillColor(224, 235, 255);
                    $pdf->Cell(20, 3, 'No', 1,0, 'C', 1);
                    $pdf->Cell(70, 3, 'Name', 1,0, 'C', 1);
                    $pdf->Cell(70, 3, 'Username', 1,0, 'C', 1);
                    $pdf->Cell(29, 3, 'Usertype', 1,1, 'C', 1);
    
                    $pdf->SetFont('times','B',9);
    
                }
                    $pdf->Ln(3);      
                    $pdf->Cell(20, 3,$i_u , 0,0, 'C');          
                    $pdf->Cell(70, 3, $name, 0,0, 'C');
                    $pdf->Cell(70, 3, $username , 0,0, 'C');
                    $pdf->Cell(29, 3,$userType , 0,0, 'C');
                    $i_u++;

            }


            // Close and output PDF document
            // This method has several options, check the source code documentation for more information.
            $pdf->Output('system_generated_report.pdf', 'I');
        }
    }

}
else { 
    
    $_SESSION['message_fail'] = "Unexpected error occured!";
    header("location: ../include/error.php?error=true");
    exit();
}


