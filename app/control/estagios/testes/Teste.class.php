<?php

use Adianti\Widget\Form\TEditorHtml2;
use Adianti\Widget\Form\THtmlEditor;

class Teste extends TPage
{
   
    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle( 'form' );
        
        // create the form fields
        $html = new THtmlEditor('html');
        $html->setSize('100%', 600);
        //$html->setEditable(FALSE);

        
        $this->form->addFields( [$html] );

        $this->form->addAction('Show', new TAction(array($this, 'onShow')), 'far:check-circle green');
      
        
        // wrap the page content using vertical box
      
        parent::add($this->form);

      /*   $replaces = [];
        $replaces['nome'] = 'Marcos Antônio 3';
        $replaces['empresa'] = 'Apodi Tecnologia';
        $replaces['parecer'] = 'O aluno deve entregar os PDf do estágio';
        $replaces['tipo'] = 'Estágio Obrigatório';
        $html = new THtmlRenderer('app/resources/tutor/email.html');
        $html->enableSection('main', $replaces);
        
        MailService::send( 'marcosmarf27@outlook.com', 'Assunto e-mail teste', $html->getContents(), 'html' );
        new TMessage('info', _t('Message sent successfully'));
 */
      //  SystemNotification::register(1, 'Novo termo recebido', 'Avaliar Termo de Estágio', 'class=EstagioList&method=abrir&termo_id='. $estagio->id, 'Avaliar', 'fa fa-list blue alt');



//5r74ayrqvp3ds7x50iytoy0r6lw8x4ohizx02b8opleul9r4




// This will output the barcode as HTML output to display in the browser



    }

    public function onShow($param)
    {
     
      $this->form->setData( $this->form->getData());
     // put the data back to the form
        echo '<prep>';
var_dump($param);


        echo '</prep>';
        // show the message
     
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
