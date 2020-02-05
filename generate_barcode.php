<?php
session_start();
$bar=$_SESSION['filename'];
require('code39.php');
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
$pdf=new PDF_Code39();
$pdf->AddPage();
$pdf->Code39(60,30,$code,1,10);
$pdf->output();
}
?>