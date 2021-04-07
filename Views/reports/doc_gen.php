<?php
include_once "../../app/php/Modal.php";

require_once '../../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$data = $_SESSION['reports_data'];
$data = json_decode($data);
$format = $data->Format;


switch ($format) {
    case 'CSV':
        $csv_data = $data->table_data;

        function object_to_array($data)
        {
            if (is_array($data) || is_object($data))
            {
                $result = array();
                foreach ($data as $key => $value)
                {
                    $result[$key] = object_to_array($value);
                }
                return $result;
            }
            return $data;
        }

        $csv_data = object_to_array($csv_data);

        $admin->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
        echo $admin->csv_converter($csv_data);
        die();
        break;
    case 'PDF':
            ob_start();
            include dirname(__FILE__).'/reports_template.php';
            $content = ob_get_clean();
            // echo $content;

            $html2pdf = new Html2Pdf('P', 'A4', 'fr',null,null,array(0,0,0,0));
            $html2pdf->setDefaultFont('Arial');
            $html2pdf->writeHTML($content);
            exit();
            $html2pdf->output('example00.pdf');
        
        break;
    case 'View':
        echo "hi";
        break;
    default:
        # code...
        break;
}
