<?php

require('emiCalculation.php');
$principal = $_POST['principal'];
$rate = $_POST['rate'];
$tenure = $_POST['tenure'];
$tenureType = $_POST['tenureType'];
$emiMode = $_POST['emiMode'];
$loanType = $_POST['loanType'];
$date = $_POST['emiDate'];
$emi = new EmiCalculation();
$data = $emi->CalEmi($principal, $tenure, $tenureType, $rate, $emiMode, $date, $loanType);
//echo '<pre>';
//print_r($data);die();
?>
<table border=1>
    <tr>
        <td>S No.</td>
        <td>Begining Balance</td>
        <td>Emi</td>
        <td>Principal</td>
        <td>Intrest</td>
        <td>Emi Date</td>
        <td>Ending Balance</td>
    </tr>
    <?php foreach($data as $entry){ ?> 
        <tr>
            <td><?php echo $entry['emi_count'];?></td>
            <td><?php echo $entry['begining_balance'];?></td>
            <td><?php echo $entry['emi'];?></td>
            <td><?php echo $entry['principal'];?></td>
            <td><?php echo $entry['interest'];?></td>
            <td><?php echo $entry['emiDate'];?></td>
            <td><?php echo $entry['ending_balance'];?></td>
        <tr>
    <?php } ?>
</table>