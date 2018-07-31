<?php

namespace App\Http\Controllers\admin;

use App\Model\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController extends Controller
{
    /**
     * basic1 generate excel file
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function basic1(){
        //storage_path('local');

        //e.g. how to use elasticsearch ??? looks like it look trough the database
//        Member::search($keyword)->paginate(2);
        $res = Member::search("新名字")->paginate(2);
var_dump($res);



        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator('Maarten Balliauw')
            ->setLastModifiedBy('Maarten Balliauw')
            ->setTitle('PhpSpreadsheet Test Document')
            ->setSubject('PhpSpreadsheet Test Document')
            ->setDescription('Test document for PhpSpreadsheet, generated using PHP classes.')
            ->setKeywords('office PhpSpreadsheet php')
            ->setCategory('Test result file');


        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

        $spreadsheet->getActiveSheet()
            ->setCellValue('A8', "Hello\nWorld");
        $spreadsheet->getActiveSheet()
            ->getRowDimension(8)
            ->setRowHeight(-1);
        $spreadsheet->getActiveSheet()
            ->getStyle('A8')
            ->getAlignment()
            ->setWrapText(true);

        $value = "-ValueA\n-Value B\n-Value C";
        $spreadsheet->getActiveSheet()
            ->setCellValue('A10', $value);
        $spreadsheet->getActiveSheet()
            ->getRowDimension(10)
            ->setRowHeight(-1);
        $spreadsheet->getActiveSheet()
            ->getStyle('A10')
            ->getAlignment()
            ->setWrapText(true);
        $spreadsheet->getActiveSheet()
            ->getStyle('A10')
            ->setQuotePrefix(true);

        // Rename worksheet
        $spreadsheet->getActiveSheet()
            ->setTitle('Simple');
         $a = storage_path().'\\app\\public\\';
        $writer = new Xlsx($spreadsheet);

//        $writer->save($a."basic1.xlsx");

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $worksheet = $reader->load($a."basic1.xlsx")->getActiveSheet();
       $a =  $worksheet->getCellByColumnAndRow(1,4);
        echo $a;

        return "<h1>generated excel file basic1.xlsx in publi folder";

    }

    /**
     * generate ods file to download for openoffice
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */

    public function basic2(){
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties

        $spreadsheet->getProperties()->setCreator('Maarten Balliauw')
            ->setLastModifiedBy('Maarten Balliauw')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');

// Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');

// Miscellaneous glyphs, UTF-8
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

// Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Simple');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Ods)
        header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
        header('Content-Disposition: attachment;filename="01simple.ods"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Ods');
        $writer->save('php://output');
        exit;

    }

    public function basic3(){
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

// Set document properties
        $spreadsheet->getProperties()->setCreator('Maarten Balliauw')
            ->setLastModifiedBy('Maarten Balliauw')
            ->setTitle('PDF Test Document')
            ->setSubject('PDF Test Document')
            ->setDescription('Test document for PDF, generated using PHP classes.')
            ->setKeywords('pdf php')
            ->setCategory('Test result file');

// Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');

// Miscellaneous glyphs, UTF-8
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

// Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Simple');
        $spreadsheet->getActiveSheet()->setShowGridLines(false);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        IOFactory::registerWriter('Pdf', Mpdf::class);

// Redirect output to a client’s web browser (PDF)
        // Redirect output to a client’s web browser (Ods)
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="01simple.pdf"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'xlsx');
        $writer->save('php://output');
        exit;


    }
}
