<?php

use Adianti\Registry\TSession;
use Adianti\Widget\Form\THidden;

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
class AlunoForm extends TPage
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
        $this->setActiveRecord('Aluno');   // defines the active record
        
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_aluno');
        $this->form->setFormTitle('Cadastro de aluno');
        $this->form->setClientValidation(true);
        
        
        // create the form fields
        $id       = new TEntry('id');
        $status       = new THidden('status');
        $status->setValue('S');
        $userid = TSession::getValue('userid');
        $system_user_id       = new THidden('system_user_id');
        $system_user_id->setValue($userid);
        
        $matricula       = new TEntry('matricula');
        $nome     = new TEntry('nome');
        $cidade_id = new TDBCombo('cidade_id', 'estagio', 'Cidade', 'id', 'nome');
        $curso_id = new TDBCombo('curso_id', 'estagio', 'Curso', 'id', 'nome');
        $email     = new TEntry('email');
        $telefone     = new TEntry('telefone');
        $endereco     = new TEntry('endereco');
        $endereco->placeholder = 'Escreva endereço, numero, bairro';

        $telefone->setMask('(99)99999-9999');
        $email->addValidation('email', new TEmailValidator);
        $cidade_id->enableSearch();

        /* parent::addAttribute('nome');
        parent::addAttribute('matricula');
        parent::addAttribute('email');
        parent::addAttribute('curso_id');
        parent::addAttribute('telefone');
        parent::addAttribute('cidade_id');
        parent::addAttribute('endereco'); */
        $id->setEditable(FALSE);
        
        // add the form fields
        $this->form->addFields( [new TLabel('ID')], [$id], [new TLabel('Matricula')], [$matricula] );
        $this->form->addFields( [new TLabel('Nome')], [$nome] );
        $this->form->addFields( [new TLabel('Cidade')], [$cidade_id], [new TLabel('Curso')], [$curso_id] );
        $this->form->addFields( [new TLabel('E-mail')], [$email] );
        $this->form->addFields( [new TLabel('Telefone')], [$telefone] );
        $this->form->addFields( [new TLabel('Endereço')], [$endereco] );
        $this->form->addFields( [$status] );
        $this->form->addFields(  [$system_user_id] );
       
        
        $nome->addValidation( 'nome', new TRequiredValidator);
        //$state_id->addValidation( 'State', new TRequiredValidator);
        
        // define the form action
        $this->form->addAction('Salvar', new TAction(array($this, 'onSave')), 'fa:save green');
        $this->form->addActionLink('Limpar',  new TAction(array($this, 'onClear')), 'fa:eraser red');
       // $this->form->addActionLink('Listar Alunos',  new TAction(array('AlunoList', 'onReload')), 'fa:table blue');
        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', 'AlunoList'));
        $vbox->add($this->form);
        parent::add($vbox);
    }

    public function abrir(){
        TTransaction::open('estagio');
        $user = new SystemUser(TSession::getValue('userid'));

        

        $dados = new stdClass;
        $dados->nome =  $user->name;
        $dados->email = $user->email;
        $this->form->setdata($dados);
        TTransaction::close();
    }
}
