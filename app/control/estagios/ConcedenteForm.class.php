<?php
/**
 * StandardFormView Registration
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class ConcedenteForm extends TPage
{
    protected $form; // form
    
    // trait with onSave, onClear, onEdit
    use Adianti\Base\AdiantiStandardFormTrait;
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('estagio');    // defines the database
        $this->setActiveRecord('Concedente');   // defines the active record
        
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_concedente');
        $this->form->setFormTitle('Cadastro de Empresa');
        $this->form->setClientValidation(true);
        
        
        // create the form fields
        $id       = new TEntry('id');
       
        $nome     = new TEntry('nome');
        $cidade_id = new TDBCombo('cidade_id', 'estagio', 'Cidade', 'id', 'nome');
        $representante     = new TEntry('representante');
        $email     = new TEntry('email');
        $telefone     = new TEntry('telefone');
        $endereco     = new TEntry('endereco');
        $endereco->placeholder = 'Escreva endereço, numero, bairro';
        $cidade_id->enableSearch();

        $telefone->setMask('(99)99999-9999');
        $email->addValidation('email', new TEmailValidator);

        /* parent::addAttribute('nome');
        parent::addAttribute('matricula');
        parent::addAttribute('email');
        parent::addAttribute('curso_id');
        parent::addAttribute('telefone');
        parent::addAttribute('cidade_id');
        parent::addAttribute('endereco'); */
        $id->setEditable(FALSE);
        
        // add the form fields
        $this->form->addFields( [new TLabel('ID')], [$id]);
        $this->form->addFields( [new TLabel('Nome', 'red')], [$nome] );
        $this->form->addFields( [new TLabel('Cidade', 'red')], [$cidade_id]);
        $this->form->addFields( [new TLabel('E-mail', 'red')], [$email] );
        $this->form->addFields( [new TLabel('Representante', 'red')], [$representante] );
        $this->form->addFields( [new TLabel('Telefone', 'red')], [$telefone] );
        $this->form->addFields( [new TLabel('Endereço', 'red')], [$endereco] );
        $cidade_id->enableSearch();
       
        
        $nome->addValidation( 'nome', new TRequiredValidator);
        //$state_id->addValidation( 'State', new TRequiredValidator);
        
        // define the form action
        $this->form->addAction('Cadastrar', new TAction(array($this, 'onSave')), 'fa:save green');
        $this->form->addActionLink('Limpar',  new TAction(array($this, 'onClear')), 'fa:eraser red');
        $this->form->addActionLink('Listar Empresas',  new TAction(array('ConcedenteList', 'onReload')), 'fa:table blue');
        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        parent::add($vbox);
    }
}
