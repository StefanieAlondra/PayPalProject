<?php

if(!isset($_POST['producto'], $_POST['precio'])){
    exit("hubo un error");
}

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

require 'config.php';

$producto = htmlspecialchars($_POST['producto']);
$precio = htmlspecialchars($_POST['precio']);
$precio = (int) $precio;
$envio = 3;
$total = $precio + $envio;

$compra = new Payer();
$compra->setPaymentMethod('paypal');
 
//echo $compra->getPaymentMethod();
//estos x cada articulo
$articulo = new Item();
$articulo->setName($producto)
        ->setCurrency('MXN')
        ->setQuantity(1)
        ->setPrice($precio);
//echo $articulo->getQuantity();

$listaArticulos = new ItemList();
$listaArticulos->setItems(array($articulo)); //,asqui puedo agregar mas 

$detalles = new Details();
$detalles->setShipping($envio)
            ->setSubtotal($precio);

$cantidad = new Amount();
$cantidad->setCurrency('MXN')
    ->setTotal($total)
    ->setDetails($detalles);

$transaccion = new Transaction();
$transaccion->setAmount($cantidad)
            ->setItemList($listaArticulos)
            ->setDescription('Pago ')
            ->setInvoiceNumber(uniqid());

//echo $transaccion->getInvoiceNumber();

$redireccionar = new RedirectUrls();
$redireccionar->setReturnUrl(URL_SITIO . "/pago_finalizado.php?exito=true")
            ->setCancelUrl(URL_SITIO . "/pago_finalizado.php?exito=false");

            //echo $redireccionar->getReturnUrl();

// if($_GET['exito'] == true){
//     echo "El pagop fue correcto";
// } else {
//     echo "hubo un error";
// }


$pago = new Payment();
$pago->setIntent("sale")
    ->setPayer($compra)
    ->setRedirectUrls($redireccionar)
    ->setTransactions(array($transaccion));
try {
  $pago->create($apiContext);
} catch (PayPal\Exception\PayPalConnectionException $pce) {
    echo "<pre>";
    print_r(json_decode($pce->getData()));
    exit;
    echo "</pre>";
}

$aprobado = $pago->getApprovalLink();
header("Location:{$aprobado}");

















?>