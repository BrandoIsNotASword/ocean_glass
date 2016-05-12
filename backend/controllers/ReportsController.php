<?php 
namespace backend\controllers;

use Yii;
use backend\components\Controller;
use yii\helpers\Url;
use common\models\Sale;
use common\models\Item;
use common\models\Size;
use common\models\SaleItem;
use common\models\ItemColorSize;
class ReportsController extends Controller{
	public function Init()
    {
        $this->enableCsrfValidation = false;
    }
	public function actionIndex(){
		return $this->render("index");
	}
	public function getStyle($style='header')
	{
		$styles['header']=[
			'font' => [
					'bold' => true,
					'color' => ['rgb' => 'FFFFFF']
				],
			'fill' => [
				'type' => \PHPExcel_Style_Fill::FILL_SOLID,
				'color' => ['rgb' => '303030'],
				'size'=>12,
				],
			'alignment' => [
				'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				],
			'borders'=> [
						'allborders' => [
							'style' => \PHPExcel_Style_Border::BORDER_THIN,
							'color' => ['argb' => '#000000']
						]
					]
			];
		$styles['background'] = [
			'fill' => [
				'type' => \PHPExcel_Style_Fill::FILL_SOLID,
				'color' => ['rgb' => 'E0E0E0']
				]
			];

		$styles['background2'] = [
			'fill' => [
				'type' => \PHPExcel_Style_Fill::FILL_SOLID,
				'color' => ['rgb' => '858585']
				]
			];

		$styles['allborders'] = [
			'borders'=> [
						'allborders' => [
							'style' => \PHPExcel_Style_Border::BORDER_THIN,
							'color' => ['argb' => '#000000']
						]
					]
			];
		return $styles[$style];
	}
	public function actionExport()
	{
		if(!isset($_POST['start']) || !isset($_POST['end'])){
			Yii::$app->end("Se esperaban fechas");
		}
		$start = $_POST['start'];
		$end = $_POST['end'];
		$r = new \PHPExcel;
		$r->getProperties()->setTitle("Reporte de Ventas");
		$r->setActiveSheetIndex(0)->setTitle("Ventas");
		$s = $r->getActiveSheet();
		// estilo
		$s->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$s->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$s->getDefaultRowDimension()->setRowHeight(18);
		$s->getDefaultColumnDimension()->setWidth(15);
		// Header
		$col = 'A';
		$s->getColumnDimension($col)->setWidth(25);
		$s->setCellValue(($col++).'1',"Venta");
		$s->setCellValue(($col++).'1',"Cliente");
		$s->setCellValue(($col++).'1',"Articulo");
		$s->setCellValue(($col++).'1',"Precio");
		$s->setCellValue(($col++).'1',"Cantidad");
		$s->setCellValue(($col++).'1',"Total MXN");
		$s->setCellValue(($col++).'1',"Estado");
		$s->getColumnDimension($col)->setWidth(25);
		$s->setCellValue(($col++).'1',"Fecha y Hora de Compra");
		$s->getStyle("A1:K1")->getAlignment()->setWrapText(true);
		$s->getStyle("A1:K1")->applyFromArray($this->getStyle());
		$s->getRowDimension(1)->setRowHeight(30);

		$row=2;
		foreach(SaleItem::find()->joinWith('sale')->where("Sales.insertDate > '$start' AND Sales.insertDate <= '$end'")->all() as $si){
			$col='A';
			$s->setCellValue(($col++).$row,'_'.$si->sale->id.'_');
			$s->setCellValue(($col++).$row,$si->sale->clientName);
			$s->setCellValue(($col++).$row,$si->item->name);
			$s->setCellValue(($col++).$row,$si->total/$si->quantity);
			$s->setCellValue(($col++).$row,$si->quantity);
			$s->setCellValue(($col++).$row,$si->total);
			$s->setCellValue(($col++).$row,Sale::getStatusArray()[$si->sale->status]);
			$s->setCellValue(($col++).$row,$si->sale->insertDate);
			$row++;
		}
		$s->getStyle("A1:A$row")->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$s->getStyle("F1:F$row")->getNumberFormat()->setFormatCode('[$$-80A]#,##0.00;-[$$-80A]#,##0.00');
		$s->getStyle("H1:H$row")->getNumberFormat()->setFormatCode('[$$-80A]#,##0.00;-[$$-80A]#,##0.00');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Ventas.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($r,'Excel5');
		$objWriter->setPreCalculateFormulas(false);
		$objWriter->save('php://output');
      	Yii::$app->end();
	}
	public function actionInventory()
	{
		$status = isset($_POST['status'])?$_POST['status']:[];
		$r = new \PHPExcel;
		$r->getProperties()->setTitle("Reporte de Inventario");
		$r->setActiveSheetIndex(0)->setTitle("Inventario");
		$s = $r->getActiveSheet();
		// estilo
		$s->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$s->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$s->getColumnDimension('A')->setWidth(25);
		// 
		// header
		$s->mergeCells("A1:D1")->setCellValue('A1',"Reporte de inventario");
		$s->setCellValue('A2',"Articulo");
		$s->setCellValue('B2',"Total");
		$auxCol = 'D';
		$s->getStyle("A1:{$auxCol}2")->applyFromArray($this->getStyle('header'));
		$s->getStyle("C1:{$auxCol}2")->getAlignment()->setWrapText(true);
		$auxRow=3;
		$background1 = true;
		foreach(Item::find()->where(['status'=>$status])->all() as $index=>$item){
			$auxStartItemRow = $auxRow;
			$s->setCellValue("A$auxRow",$item->name);
			$s->getStyle("A$auxRow")->applyFromArray(['font'=>['size' => 14]]);
			$s->setCellValue("B$auxRow",$item->inventory);
			foreach ($item->colors as $color) {
				$s->setCellValue("C$auxRow",$color->inventory);
				$s->setCellValue("D$auxRow",$color->color->name);
				$auxCol = 'D';
				foreach ($sizes as $size){
					$auxCol++;
					$aux = $color->getSizes()->where(['sizeID'=>$size->id])->one();
					$s->setCellValue($auxCol.$auxRow,$aux?$aux->quantity:0);
				}
				$auxRow++;
			}
			$s->getStyle('A'.$auxStartItemRow.':'.$auxCol.($auxRow-1))->applyFromArray($this->getStyle($background1?'background':'background2'));
			$s->getStyle('A'.$auxStartItemRow.':'.$auxCol.($auxRow-1))->applyFromArray($this->getStyle('allborders'));
			$s->mergeCells('A'.$auxStartItemRow.':A'.($auxRow-1));
			$s->mergeCells('B'.$auxStartItemRow.':B'.($auxRow-1));
			$background1=!$background1;
			// $auxRow++;
		}
		$s->getDefaultRowDimension()->setRowHeight(18);
		$s->getDefaultColumnDimension()->setWidth(15);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Inventario.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($r,'Excel5');
		$objWriter->setPreCalculateFormulas(false);
		$objWriter->save('php://output');
      	Yii::$app->end();
	}
}
// http://support.hp.com/mx-es/drivers/selfservice/HP-Pavilion-p6-2100-Desktop-PC-series/5187028/model/5204331
 ?>
