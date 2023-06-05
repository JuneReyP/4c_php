<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo 'Juan' ?></title>
</head>
<body>
    <?php 
    
    echo 'Hello world!';

    // if(condition){
    //     //execution
    // }

    // for($a = 0; condition; $a++){

    // }
    $f_name = 'Juan';
    $num1 = 23;
    $sample = true;

    if(!$sample){
        echo '<hr>';
        echo 'The condition is true!';
    }
    //assocciative array
    $age = array('Peter'=>'22','Ben'=>'20', 'Joe'=>'18');

    echo '<br>';
    // echo $age['Ben'];
    foreach($age as $edad => $value){
        echo 'Key = '.$edad. '<br>'. 'Value = '.$value;
    }
    ?>
</body>
</html>