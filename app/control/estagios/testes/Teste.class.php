<?php

class Teste extends TPage
{
   
    public function __construct()
    {
        parent::__construct();

        $baseDate = clone $date = DateTime::createFromFormat('H:i:s' , '00:00:00');

//dados vindo do banco de dados
$array = [
    '04:30',
   
    
    '03:40',
    '02:30'
];    

//percorre cada valor do array
foreach($array as $time)
{
    //cria-se o date time com o tempo informado
    $dateTime = DateTime::createFromFormat('H:i' , $time);

    //realiza o diff com a $baseDate para criar o DateInterval
    $diff = $baseDate->diff($dateTime);

    //adiciona o diff ao DateTime que somará o tempo
    $date->add($diff);
}

//realiza o último diff entre o DateTime de soma e a base date
$interval = $baseDate->diff($date);

echo '<pre>';

       
print_r($interval);

echo __DIR__;
print_r($_SERVER);
echo $_SERVER['HTTP_REFERER'];

$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
echo $generator->getBarcode('081231723897', $generator::TYPE_CODE_128);
var_dump($generator);


  
  echo '</pre>';

//DateInterval mantêm em dias (%a) tudo que for acima de 24 horas.
$hours = $interval->format('%H') + ($interval->format('%a') * 24);

//exibe o tempo
echo $hours.$interval->format(':%I');

$dados = ['10:00', '02:00'];

echo self::somarHoras($dados);


// This will output the barcode as HTML output to display in the browser



    }

    public static function somarHoras(array $array)
    {
       

        $baseDate = clone $date = DateTime::createFromFormat('H:i:s' , '00:00:00');

   

//percorre cada valor do array
foreach($array as $time)
{
    //cria-se o date time com o tempo informado
    $dateTime = DateTime::createFromFormat('H:i' , $time);

    //realiza o diff com a $baseDate para criar o DateInterval
    $diff = $baseDate->diff($dateTime);

    //adiciona o diff ao DateTime que somará o tempo
    $date->add($diff);
}

//realiza o último diff entre o DateTime de soma e a base date
$interval = $baseDate->diff($date);




  
  

//DateInterval mantêm em dias (%a) tudo que for acima de 24 horas.
 $hours = $interval->format('%H') + ($interval->format('%a') * 24);

//exibe o tempo
return $hours.$interval->format(':%I'); // Saída: 28:23
    }
}
