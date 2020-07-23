<?php

use Adianti\Control\TWindow;
use Adianti\Registry\TSession;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\THtmlEditor;
use Adianti\Widget\Form\TText;

/**
 * StandardFormDataGridView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class PendenciaFormList extends TWindow
{
    protected $form;      // form
    protected $datagrid;  // datagrid
    protected $loaded;
    protected $pageNavigation;  // pagination component
    
    // trait with onSave, onEdit, onDelete, onReload, onSearch...
    use Adianti\Base\AdiantiStandardFormListTrait;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param)
    {
        parent::__construct();
        TSession::setValue('estagio_pendencia', $param['estagio_id']);
        TSession::setValue('usuario_pendencia', $param['usuario_id']);
    
       
        parent::setSize(0.9, 0.9);
        
        $this->setDatabase('estagio'); // define the database
        $this->setActiveRecord('Pendencia'); // define the Active Record
        $this->setDefaultOrder('id', 'desc'); // define the default order
        $this->setLimit(-1); // turn off limit for datagrid
        $criteria = new TCriteria();
        $criteria->add(new TFilter('estagio_id','=', TSession::getValue('estagio_pendencia')));
        $this->setCriteria($criteria);
   

        
        // create the form
        $this->form = new BootstrapFormBuilder('form_pendencias');
        $this->form->setFormTitle('Resgistrar Pendências');
        
        // create the form fields
        $id     = new TEntry('id');
        $estagio_id    = new TEntry('estagio_id');
        $system_user_id     = new TEntry('system_user_id');
        $data_reg = new TDate('data_reg');
        $tipo_pendencia = new TCombo('tipo_pendencia');
        $tipo_pendencia->addItems([ '1' => 'Ausencia de Assinaturas', '2' => 'Empresa não conveniada']);
        $descricao = new TText('descricao');
        $descricao->setSize('100%', 40);
        $descricao->placeholder = 'Resuma aqui os problemas encontrados';
       $parecer = new THtmlEditor('parecer');
       $parecer->setSize('100%', 50);
        
        // add the form fields
       
        $this->form->addFields([new TLabel('ID')],    [$id] ,  [new TLabel('Usuário')],  [$system_user_id], [new TLabel('Número do Estágio')],  [$estagio_id] );
        $this->form->addFields( [new TLabel('Registro data')],  [$data_reg], [new TLabel('Tipo de Pendência')],  [$tipo_pendencia] );
        $this->form->addFields( [new TLabel('Descrição')],    [$descricao] );

        $label = new TLabel('Parecer', '#7D78B6', 12, 'bi');
        $label->style='text-align:left;border-bottom:1px solid #c0c0c0;width:100%';
        $this->form->addContent( [$label] );
        
        $this->form->addFields( [$parecer] );
       
        
      //  $name->addValidation('Name', new TRequiredValidator);
        
        // define the form actions
        $this->form->addAction( 'Salvar Registro', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink( 'Novo Registro',new TAction([$this, 'onClear']), 'fa:eraser red');
        
        // make id not editable
        $id->setEditable(FALSE);
        $estagio_id->setEditable(FALSE);
        $system_user_id->setEditable(FALSE);
        // create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        // add the columns
        $col_id    = new TDataGridColumn('id', 'Id', 'right', '10%');
        $col_tipo = new TDataGridColumn('tipo_pendencia', 'Tipo Pendência', 'left', '20%');
        $col_descricao  = new TDataGridColumn('descricao', 'Descrição ', 'left', '60%');
        $col_data_reg  = new TDataGridColumn('data_reg', 'Data de registro', 'left', '20%');
        
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_tipo);
        $this->datagrid->addColumn($col_descricao);
        $this->datagrid->addColumn($col_data_reg);
        
        $col_id->setAction( new TAction([$this, 'onReload']),   ['order' => 'id']);
        $col_data_reg->setAction( new TAction([$this, 'onReload']), ['order' => 'data_reg']);
        
        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'],   ['key' => '{id}'] );
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{id}'] );
        
        $this->datagrid->addAction($action1, 'Editar',   'far:edit blue');
        $this->datagrid->addAction($action2, 'Deletar', 'far:trash-alt red');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // wrap objects inside a table
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', 'EstagioList'));
        $vbox->add($this->form);
        $vbox->add(TPanelGroup::pack('', $this->datagrid));
        
        // pack the table inside the page
        parent::add($vbox);
    }

    public function registraPendencia($param){

          

        TSession::setValue('estagio_pendencia', $param['estagio_id']);
        TSession::setValue('usuario_pendencia', $param['usuario_id']);
      
        $dados = $this->form->getData();
        $dados->estagio_id = TSession::getValue('estagio_pendencia');
        $dados->system_user_id = TSession::getValue('usuario_pendencia');

        $this->form->setData($dados);

       



        
    }
    public function onClear($param){

        $this->form->clear();

        
      //  TSession::setValue('usuario', $param['id_user']);
        $dados = $this->form->getData();
        $dados->estagio_id = TSession::getValue('estagio_pendencia');
        $dados->system_user_id = TSession::getValue('usuario_pendencia');

        $this->form->setData($dados);



        
    }

    
}
