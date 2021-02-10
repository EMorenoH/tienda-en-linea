<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';

?>

<?php
if($_POST){

	$total=0;
	$SID=session_id();
	$Correo=$_POST['email'];

	foreach($_SESSION['CARRITO'] as $indice=>$producto) {

		$total=$total+($producto['PRECIO']*$producto['CANTIDAD']);

	}

		$sentencia=$pdo->prepare("INSERT INTO `tblventas` 
							(`ID`, `ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `status`) 
		VALUES (NULL, :ClaveTransaccion, '', NOW(),:Correo,:Total, 'Pendiente');");

		$sentencia->bindParam(":ClaveTransaccion",$SID);
		$sentencia->bindParam(":Correo",$Correo);
		$sentencia->bindParam(":Total",$total);
		$sentencia->execute();
		$idVenta=$pdo->lastInsertId();

		foreach($_SESSION['CARRITO'] as $indice=>$producto) {

			$sentencia=$pdo->prepare ("INSERT INTO 
			`tblDetalleVenta` (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `DESCARGADO`) 
			VALUES (NULL, :IDVENTA, :IDPRODUCTO, :PRECIOUNITARIO, :CANTIDAD, '0');");


			$sentencia->bindParam(":IDVENTA",$idVenta);
			$sentencia->bindParam(":IDPRODUCTO",$producto['ID']);
			$sentencia->bindParam(":PRECIOUNITARIO",$producto['PRECIO']);
			$sentencia->bindParam(":CANTIDAD",$producto['CANTIDAD']);
			$sentencia->execute();

		}


	//echo "<h3>".$total."</h3>";

}

?>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<style>
	@media screen and (max-width: 400px) {
			#paypal-button-container{
				width: 100%;		
			}
		}	

	@media screen and (min-width: 400px) {
			#paypal-button-container{
				width: 250px;
				display: inline-block;				
			}
		}		
</style>

<div class="jumbotron text-center">
	<h1 class="display-4">¡Paso Final!</h1>
	<hr class="my-4">
	<p class="lead">Estas a punto de pagar con paypal la cantidad de:
		<h4>$<?php echo number_format($total,2); ?></h4>
		<div id="paypal-button-container"></div>
	</p>
		<p>Los productos podran ser descargados una vez que se procese el pago<br/>
		<strong>(Para aclaraciones enviar email a: efren.moreno2012@gmail.com)</strong>
		</p>

</div>

<script>
	paypal.Button.render({
		env: 'sandbox',	//	sandbox / production 
		style: {
			label: 'checkout',	// checkout / credit / pay / buynow / generic
			size: 'responsive',	// small / medium / large / responsive
			shape: 'pill',	// pill / rect
			color: 'gold'	// gold / blue / silver / black
		},


		client: {
			sandbox: 	'AZx5iy9mDemInd-sw7jG07zq0IybmnGQVDK9nlk_xIzKOKqfF0A6-kVPh9tivpCcmiHTCNgs9eYUPb7r',
			production: 'AdQUnogkdBG4PXMgZQd7jkRmNoig3mBONukzH3Ck68eCcBwBwdTrMgmHiFbgotgJrubsbfnqlQJTneNI'
		},
		payment: function(data, actions) {
			return actions.payment.create({
				payment: {
					transactions: [
						{
							amount: { total: '<?php echo $total;?>', currency: 'MXN' },
							description:"Compra de productos a Anayancy:$<?php  echo number_format($total,2);?>",
							custom:"<?php echo $SID;?>#<?php echo openssl_encrypt($idVenta,COD,KEY); ?>"
						}
					]
				}
			});
		},
	

	onAuthorize: function(data, actions) {
		return actions.payment.execute().then(function() {
			//window.alert('Payment Complete!');
			console.log(data);
			window.lotation="verificador.php?paymentToken="+data.paymentToken
		});
	}
}, '#paypal-button-container');


</script>





<?php  include 'templates/pie.php'; ?>



