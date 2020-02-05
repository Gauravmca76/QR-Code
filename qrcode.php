<?php 
// Include the qrlib file 
require('phpqrcode/qrlib.php');
require('fpdf/fpdf.php'); 
session_start();
$bar=$_SESSION['filename'];
if(isset($_POST["submit"]))
{

$con=mysqli_connect("localhost","root","");
if(!$con)
{
    die('Could not connect: '.mysqli_error());
}
mysqli_select_db($con,"barcode");
$sql="SELECT * FROM tb_filecode39 WHERE file_name='$bar'";
$result=mysqli_query($con,$sql);
if($row=mysqli_fetch_array($result))
{
 $code=$row['file_name'];
}
$pdf=new FPDF();
$pdf->AddPage();
$path = 'images/';
$file = $path.uniqid().".png"; 
$n=uniqid();
$ecc = 'H'; 
$pixel_Size = 4; 
$frame_Size = 8; 
QRcode::png($code, $file, $ecc, $pixel_Size,$frame_Size);
$pdf->Image($file,40,40,50,50,'PNG');
$pdf->setFont('Times','',20);
$pdf->Text(40,100,$n);
$pdf->output();
}
?>