<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['format']) && isset($_GET['startnumber'])) {
	// Include the main TCPDF library (search for installation path).
	require_once('tcpdf/tcpdf_import.php');
	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, "in", "LETTER", true, 'UTF-8', false);
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	// remove default header/footer
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	// add a page
	$pdf->AddPage();

	$startnumber = $_GET['startnumber'];
	$currentnumber = $startnumber;
	if ($_GET['format'] == 1) {
		$vsize = .5;
		$hsize = .5;
		$hmargin = .25;
		$vmargin = .2505;
		$hspacing = .125;
		$vspacing = .125;
		$hpadding = .1;
		$vpadding = .1;
		$hcount = 13;
		$vcount = 17;
		for ($v=0; $v < $vcount; $v++) { 
			$y = $vmargin + (($vsize + $vspacing) * $v);
			for ($h=0; $h < $hcount; $h++) { 
				$x = $hmargin + (($hsize + $hspacing) * $h);
				$style = array(
					'border' => false,
					'padding' => 0,
					'fgcolor' => false,
					'bgcolor' => false
				);
				$pdf->write2DBarcode("WCC".sprintf('%06d', $currentnumber), 'QRCODE,H', $x+$hpadding, $y+$vpadding, $hsize-$hpadding, $vsize-$vpadding, $style, 'N');

				//increment the current number
				$currentnumber++;
			}
		}

	}elseif ($_GET['format'] == 2) {
		# code...
	}

	//Close and output pdf
	$pdf->Output('labels.pdf', 'I');
}else {
	?>
	<!doctype html>
	<html lang="en">
	<head>
		<meta charset="utf-8">

		<title>Asset tag generator</title>
		<style type="text/css">
			#formBox{
				display:flex;
				position:absolute;
				top:0;
				bottom:0;
				right:0;
				left:0;
			}
			form{
				margin:auto;
				padding: 10px 20px;
				border: solid 1px black;
				border-radius: 9px 9px 9px 9px;
				box-shadow: 10px 10px 28px -4px rgba(0,0,0,0.75);
			}​
		</style>
	</head>
	<body>
		<div id="formBox">
			<form action="#" method="GET">
				<h3>Generate a tag sheet</h1>
				<input type="text" name="startnumber" placeholder="Starting number" required="true"><br><br>
				<select name="format">
					<option value="1" disabled="true" selected="true">Select a format</option>
					<option value="1">Square mini tag</option>
					<option value="2">Large "return address" rectangles</option>
				</select><br><br>
				<input type="submit" >
			</form>
		</div>
	</body>
	</html>
	<?php
}
?>