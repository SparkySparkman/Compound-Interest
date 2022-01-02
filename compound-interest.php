<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
    overflow: hidden;
    text-overflow: ellipsis;
    word-wrap: none;
}
html, body{
    height:100%;
    width:100%;
    padding:5;
    margin:5;
}
table {
    table-layout:fixed;
}
</style>
<title>Simple Interest and Compound Interest</title>
</head>
<body>

<?php
  if (isset($_POST['num1'])) $p = $_POST['num1']; else $p = 0;
  if (isset($_POST['num2'])) $t = $_POST['num2']; else $t = 0;
  if (isset($_POST['num3'])) $r = $_POST['num3']; else $r = 0;
  if (isset($_POST['num4'])) $deduction_free_months = $_POST['num4']; else $deduction_free_months = 0;
  if (isset($_POST['num5'])) $deduction_per_month = $_POST['num5']; else $deduction_per_month = 0;
      if (isset($_POST['popupSelect'])) $period = $_POST['popupSelect'];
  if (isset($_POST['previous'])) $previous = $_POST['previous'];
?>

Compound Interest Calculator<br><br>
<form method="post">
<table border="0">
<tr>
<td>Enter principal</td>
<td> <input type="text" name="num1" value=<?php echo $p; ?> > </td>
</tr>
<tr>
<td><table><tr><td>Enter time period&nbsp;&nbsp;</td><td>
<td><select type="text" name="popupSelect">
      <option value="days"
      <?php if(isset($_POST['popupSelect']) && $_POST['popupSelect'] == 'days')
          echo ' selected="selected"';
      ?> >Days</option>
      <option value="months"
      <?php if(isset($_POST['popupSelect']) && $_POST['popupSelect'] == 'months')
          echo ' selected="selected"';
      ?> >Months</option>
      <option value="years"
      <?php if(isset($_POST['popupSelect']) && $_POST['popupSelect'] == 'years')
          echo ' selected="selected"';
      ?> >Years</option>
  </select></td></tr></table>
<input type="hidden" name="previous" value="<?php echo $period; ?>"/>
</td>
<td> <input type="text" name="num2" value=<?php echo $t; ?> >
</td>
</tr>
<tr>
<td>Rate of interest %</td>
<td> <input type="text" name="num3" value=<?php echo $r; ?> >
</td>
</tr>
<tr>
<td>Deduction free months (*=all)</td>
<td> <input type="text" name="num4" value=<?php echo $deduction_free_months; ?> >
</td>
</tr>
<tr>
<td>Deduction per month</td>
<td> <input type="text" name="num5" value=<?php echo $deduction_per_month; ?> >
</td>
</tr>
<tr>
<br>
<td> <input type="submit" name="submit" value="Calculate interest"/>
</td>
</tr>
</table>
</form>
<?php
//To find Simple Interest and Compound Interest
if(isset($_POST['submit']))
{
$p = $_POST['num1']; // Principal
$t = $_POST['num2']; // periods
$r = $_POST['num3']; // Interest
$period = $_POST['popupSelect'];
switch ($period) {
  case "days":
    $pernr = $t;
  break;
  case "months":
    $pernr = 30.5*$t;
  break;
  case "years":
    $pernr = 365*$t;
  break;
}
//$deduction_per_month = 500;
//$deduction_free_months = 4;
$d_months = 0;
$deducted = 0;

//Simple Interest formula
$si = $p * $t * $r/100;
echo "Simple interest = ".number_format($si, 2)."<br>Principal $p, Time $t periods, period $period, Days ".$pernr.", Interest $r%<br>Deduction per month = $deduction_per_month, Deduction free months $deduction_free_months<br><br>";
echo "Daily compound interest :<br><br>";
//Compound Interest formula
//$amount = $p * pow((1 + $r/100),$pernr);
$amount = $p;
$r = $r / 100;
echo '<table><tr><td>Day</td><td>&nbsp;</td><td>Interest</td></td><td>&nbsp;</td><td>Day</td></td><td>&nbsp;</td><td>Interest</td></td><td>&nbsp;</td><td>Day</td></td><td>&nbsp;</td><td>Interest</td></td><td>&nbsp;</td><td>Day</td></td><td>&nbsp;</td><td>Interest</td></td><td>&nbsp;</td><td>Day</td></td><td>&nbsp;</td><td>Interest</td></tr><tr>';
for ($x = 1; $x <= $pernr; $x++) {
  $interest = $amount * $r;
  $amount = $amount + $interest;
  $amount_minus_principal = $amount - $p;
  echo "<td>".$x."</td></td><td>&nbsp;</td><td>".number_format($amount_minus_principal)."(".number_format($interest).")"."</td></td><td>&nbsp;</td>";
  if ($x / 5 == round($x / 5)) echo "</tr><tr>";
  //else echo ", ";
  if (($x / 30 == round($x / 30)) and ($x < $t-1)) {
    echo "</tr><tr><td>&nbsp;</td></tr><tr>";
    $d_months ++;
    if ($deduction_free_months != "*") {
      if ($d_months >= $deduction_free_months) $amount -= $deduction_per_month;
      if ($d_months > $deduction_free_months) {
        $deducted += $deduction_per_month;
      }
    }
  }
}

echo "</table>";
$ci = $amount - $p;
echo "<br>Compound interest ".number_format($ci, 2)."<br>Months ".$d_months;
if ($deduction_per_month != 0 or $deducted != 0) {
  ", Deduction per month $deduction_per_month, Deductions total ".$deducted."<br><br>" ;
}
else echo ", No deductions<br><br>" ;
if ($deduction_free_months == "*") echo ", No deductions<br><br>" ;
//return 0;
}
?>
</body>
</html>
