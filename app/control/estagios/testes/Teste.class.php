<?php

class Teste extends TPage
{
   
    public function __construct()
    {
        parent::__construct();

        $replaces = [];
        $replaces['nome'] = 'Marcos Antônio';
        $replaces['parecer'] = 'O aluno deve entregar os PDf do estágio';
        $html = new THtmlRenderer('app/resources/tutor/email.html');
        $html->enableSection('main', $replaces);
        
        MailService::send( 'marcosmarf27@gmail.com', 'Assunto e-mail teste', $html->getContents(), 'html' );
        new TMessage('info', _t('Message sent successfully'));




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
