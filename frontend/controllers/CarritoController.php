<?php
namespace frontend\controllers;

use Yii;
use frontend\components\Controller;
use common\models\Item;
use common\models\Sale;
use common\models\SaleItem;
use common\models\Client;
use common\models\Setting;
use common\models\ItemColorSize;
use common\models\ShippingMethod;
use common\models\PaymentMethod;
use yii\helpers\Url;
use common\components\LogsComponent;
/**
 * Site controller
 */
class CarritoController extends Controller
{
	public function actionIndex()
	{
        $datas=[
            'items'=>$this->cart,
        ];
		return $this->render('index',$datas);
	}
	public function actionInfo()
	{
		$cart = $this->cart;
        if(count($cart)==0) return $this->redirect(Url::toRoute('carrito/'));
		$total=0;
        $totalItems = 0;
		foreach($cart as $itemId => $quantity){
            $it = Item::findOne($itemId);
            $total+=$quantity*$it->price;
            $totalItems+=$quantity;
		}
		$subtotal = $total/1.16;
		$ivaItems = $subtotal*.16;

		$iva = $ivaItems;
		$total=$subtotal+$iva;
        $sale = new Sale;
		$datas =[
            'items'=>$this->cart,
            'totalItems'=>$totalItems,
			'total'=>$total,
			'subtotal'=>$subtotal,
			'iva'=>$iva,
            'sale'=>$sale,
		];
		return $this->render('info',$datas);
	}
	public function actionAdditem()
	{
		$error = "";
		if(isset($_POST['item']) && isset($_POST['quantity'])){
			if($this->addToCart($_POST['item'],$_POST['quantity'],$error)){
				return json_encode(['success'=>true]);
			}
		}
		return json_encode(['success'=>false,'error'=>$error]);
	}
	public function actionDelitem()
	{
        unset($this->cart[$_GET['item']]);
		$this->saveCart();
        return json_encode(['success'=>true]);
	}
	public function actionMakepayment()
	{
        $r=['success'=>false];
        $r['message']="Error en algún lado :}";
        $items = $this->cart;
        $sale = new Sale;
        $sale->clientName = $_POST['clientName'];
        $sale->clientEmail = $_POST['clientEmail'];
        $sale->clientAddress = $_POST['clientAddress'];
        $total=0;
        foreach($items as $itemId => $quantity) {
            $item = Item::findOne($itemId);
            $aux = new SaleItem;
            $aux->itemID = $item->id; 
            $aux->total = round($item->price*$quantity);
            $aux->quantity = $quantity;
            $saleItems[]=$aux;
            $total+=$aux->total;
        }
        $sale->total = $total;
        $sale->status = Sale::StatusPending;
        $sale->token = Yii::$app->security->generateRandomString();
        if($sale->save()){
            foreach($saleItems as $i) $sale->link('saleItems',$i);
            Yii::$app->session->remove("cart");
            $redirect = $this->getPaypalUrl($sale);
            if($redirect){
                $r['redirect']=$redirect;
            }else{
                $r['redirect']=Url::toRoute('carrito/paypal-error');
            }
            $r['success']=true;
        }else{
            $r['message']="Error al finalizar su compra, por favor comunicate con nosotros";
        }
        return json_encode($r);
	}
    public function getPaypalUrl($sale)
    {
        $sandboxRedirect = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey=";
        $liveRedirect = "https://www.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey=";
        $mode = Setting::findOne('paypalEnv')->value;
        $config = [
           'mode' => $mode,
           'acct1.UserName' => Setting::findOne('paypalUser')->value,
           'acct1.Password' => Setting::findOne('paypalPass')->value,           
           "acct1.Signature" => Setting::findOne('paypalSign')->value,
           "acct1.AppId" => Setting::findOne('paypalApp')->value,
        ];
        $requestEnvelope =[
            'errorLanguage'=>"es_MX",
            'detailLevel'=>"ReturnAll",
        ];
        $actionType='PAY';
        $cancelUrl = Url::to(['carrito/pago-error'],true);
        $currencyCode = 'MXN';
        $receiver = new \PayPal\Types\AP\Receiver();
        $receiver->email = Setting::findOne('paypalAccount')->value;
        $receiver->amount = number_format($sale->total,2,'.','');
        $receiverList = new \PayPal\Types\AP\ReceiverList($receiver);
        $returnUrl = Url::to(['carrito/pay','a'=>$sale->id,'b'=>$sale->token],true);

        $payRequest = new \PayPal\Types\AP\PayRequest($requestEnvelope,$actionType,$cancelUrl,$currencyCode,$receiverList,$returnUrl);

        $service = new \PayPal\Service\AdaptivePaymentsService($config);
        $response = $service->Pay($payRequest); 
        if(strtoupper($response->responseEnvelope->ack) == 'SUCCESS'){
            return $mode=='sandbox'?$sandboxRedirect.$response->payKey:$liveRedirect.$response->payKey;
        }else{
            return false;
        }
    }
    public function actionPay($a,$b)
    {
        $sale = Sale::findOne(['id'=>$a,'token'=>$b]);
        if(isset($sale) && $sale->status == Sale::StatusPending){
            $sale->status = Sale::StatusPayed;
            $sale->discountInventory();
            $sale->save();
            $this->sendMail($sale);
            return $this->redirect(Url::toRoute('carrito/pago-realizado'));
        }else if(isset($sale)){
            return $this->redirect(Url::toRoute('carrito/pago-realizado'));
        }else{
            echo "No se encontró pedido";
        }
    }
    public function actionPagoRealizado()
    {   
        return $this->render('success');
    }
    public function actionPagoError()
    {
        return $this->render('error');
    }
    public function actionPaypalError()
    {
        return $this->render('paypalError');
    }
    public function sendMail($sale)
    {
        return Yii::$app->mailer->compose()
        ->setFrom('ventas@oceanglass.com.mx')
        ->setTo($sale->clientEmail)
        ->setBcc(Setting::findOne('principalEmail')->value)
        ->setSubject('Compra en Ocean Glass en linea')
        ->setHtmlBody($this->renderPartial('saleMail',['sale'=>$sale]))
        ->send();
    }
    public function actionTest()
    {
        $r = $this->sendMail(Sale::findOne(2));
        var_dump($r);
        return "asda";
    }
}