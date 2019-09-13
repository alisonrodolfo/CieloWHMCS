<?php 

# Cielo Vers&#227;o Cielo- Payment Gateway Module
$GATEWAYMODULE["cieloname"] = "cielo";
$GATEWAYMODULE["cielovisiblename"] = "Cielo BoxGerencia 1.0";
$GATEWAYMODULE["cielotype"] = "Invoices";
// Notas vers&#227;o/propaganda

$GATEWAYMODULE['cielonotes'] = '
<br>
<br><b>Licenciado Para:</b> ' . $CONFIG['CompanyName'] . ' - <b>Vers&#227;o</b>: 1.0 - 03/09/2015
<br>
<br><b>Desenvolvido por:</b> <a href="http://www.bocgerencia.com.br/" target="_blank"><b>Boxgerencia.com.br</b></a>';

function cielo_activate() {
    defineGatewayField("cielo", "text", "conta", "", "Conta", "30", "Preencher o email principal de sua conta Paypal");
    defineGatewayField("cielo", "text", "taxa", "", "Taxa", "6", "Informar aqui a taxa de percentagem para adicionar &#224; fatura, Ex: 4% digite 0.04, o resultado ser&#225; a seguir, ex: valor fatura R$ 5,00=$2,65 somado a taxa 2.65*0.04+0.60=0.406, o valor a pagar ser&#225;=3.06");
}
function cielo_link($params) {
    //cota&#231;&#227;o
    $a = $params['amount'];
    // taxa
    $b = $params['taxa'];
    $taxa1 = $a * $b;
    // soma taxa
    $a1 = $taxa1;
    $c = 0.25;
    $valort = $a + $a1 + $c;
    $ttaxa = $taxa1 + $c;
    $valort = number_format($valort, "2", ".", ",");
	$valorcielo = ($valort*100);
		# Client Variables
	$firstname = $params['clientdetails']['firstname'];
	$lastname = $params['clientdetails']['lastname'];
	$email = $params['clientdetails']['email'];
	$address1 = $params['clientdetails']['address1'];
	$address2 = $params['clientdetails']['address2'];
	$city = $params['clientdetails']['city'];
	$state = $params['clientdetails']['state'];
	$postcode = str_replace("-", "", $params['clientdetails']['postcode']);
	$country = $params['clientdetails']['country'];
	$phone = str_replace(" ", "", str_replace("-", "", $params['clientdetails']['phonenumber']));
	
    //inicio do form
    $code = '
Valor da Fatura: <b>R$ ' . $params['amount'] . ' </b> <br>
Taxas + IOF (taxa de cobran&#231;a Cielo) R$ ' . $ttaxa . ' <br>
Valor a Pagar: <b>R$ ' . $valort . ' </b><br>

<form action=": https://cieloecommerce.cielo.com.br/Transactional/Order/Index" method="post">
<input type="hidden" name="merchant_id" value="7c70c156-5a1f-4581-914a-7d2647e9b8af" />
<input type="hidden" name="order_number" value="' . $params['invoiceid'] . '" />
<input type="hidden" name="shipping_type" value="5" />
<input type="hidden" name="cart_1_name" value="' . $params['description'] . 'a" />
<input type="hidden" name="cart_1_unitprice" value="' . $valorcielo . '" />
<input type="hidden" name="cart_1_quantity" value="1" />
<input type="hidden" name="cart_1_type" value="2" />

<input type="hidden" name="Customer_Name" value="'.$firstname.' '.$lastname.'" />
<input type="hidden" name="Customer_Email" value="'.$email.'" />
<input type="hidden" name="Customer_Identity" value="26636640650" />
<input type="hidden" name="Customer_Phone" value="1122223333" />';
    $code.= '<input type="submit" value="' . $params['langpaynow'] . '">

	</form><br>
Voc&#234; poder&#225; com os cart&#245;es de cr&#233;dito Internacionais abaixo!<br>
<img src="http://widhost.com.br/images/modulos/logo_cc_visa_37x23.gif" width="37" height="23"> 
<img src="http://widhost.com.br/images/modulos/logo_cc_mc_37x23.gif" width="37" height="23"> 
<img src="http://widhost.com.br/images/modulos/logo_cc_amex_37x23.gif" width="37" height="23"> 
<img src="http://widhost.com.br/images/modulos/logo_cc_disc_37x23.gif" width="37" height="23"><br>';
    return $code;
} ?>