<?php

use Adianti\Widget\Form\TEditorHtml2;

class Teste extends TPage
{
   
    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle( 'form' );
        
        // create the form fields
        $html = new TEditorHtml2('html_text');
        $html->setSize('100%', 500);

        
        $this->form->addFields( [$html] );

        $this->form->addAction('Show', new TAction(array($this, 'onShow')), 'far:check-circle green');
      
        
        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%; height: 400px';
       
        $vbox->add($this->form);
        parent::add($vbox);

        $replaces = [];
        $replaces['nome'] = 'Marcos Antônio 3';
        $replaces['empresa'] = 'Apodi Tecnologia';
        $replaces['parecer'] = 'O aluno deve entregar os PDf do estágio';
        $replaces['tipo'] = 'Estágio Obrigatório';
        $html = new THtmlRenderer('app/resources/tutor/email.html');
        $html->enableSection('main', $replaces);
        
        MailService::send( 'marcosmarf27@outlook.com', 'Assunto e-mail teste', $html->getContents(), 'html' );
        new TMessage('info', _t('Message sent successfully'));



//5r74ayrqvp3ds7x50iytoy0r6lw8x4ohizx02b8opleul9r4




// This will output the barcode as HTML output to display in the browser



    }

    public function onShow($param)
    {
        $data = $this->form->getData();
        $this->form->setData($data); // put the data back to the form
        
        // show the message
        new TMessage('info', $data->html_text);
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
