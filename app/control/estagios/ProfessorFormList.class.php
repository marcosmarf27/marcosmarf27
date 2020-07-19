<?php
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
class ProfessorFormList extends TPage
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
    public function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('estagio'); // define the database
        $this->setActiveRecord('Professor'); // define the Active Record
        $this->setDefaultOrder('id', 'asc'); // define the default order
        $this->setLimit(-1); // turn off limit for datagrid
        
        // create the form
        $this->form = new BootstrapFormBuilder('form_curso');
        $this->form->setFormTitle('Cadastro e Lista de Professores');
        
        // create the form fields
        $id     = new TEntry('id');
        $siape   = new TEntry('siape');
        $nome   = new TEntry('nome');
        $email   = new TEntry('email');
        $telefone  = new TEntry('telefone');
        
        // add the form fields
        $this->form->addFields( [new TLabel('ID')],    [$id] );
        $this->form->addFields( [new TLabel('Siape', 'red')],  [$siape] );
        $this->form->addFields( [new TLabel('Nome', 'red')],  [$nome] );
        $this->form->addFields( [new TLabel('E-mail', 'red')],  [$email], [new TLabel('Telefone', 'red')],  [$telefone] );
        
        $telefone->setMask('(99)99999-9999');
        $email->addValidation('email', new TEmailValidator);
        
        
        $nome->addValidation('Nome', new TRequiredValidator);
        
        // define the form actions
        $this->form->addAction( 'Cadastrar', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink( 'Limpar',new TAction([$this, 'onClear']), 'fa:eraser red');
        
        // make id not editable
        $id->setEditable(FALSE);
        
        // create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        // add the columns
        $col_id    = new TDataGridColumn('id', 'Id', 'right', '10%');
        $col_nome  = new TDataGridColumn('nome', 'Nome', 'left', '30%');
        $col_siape  = new TDataGridColumn('siape', 'Siape', 'left', '20%');
        $col_email = new TDataGridColumn('email', 'E-mail', 'left', '20%');
        $col_telefone = new TDataGridColumn('telefone', 'Telefone', 'left', '20%');
        
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_nome);
        $this->datagrid->addColumn($col_siape);
        $this->datagrid->addColumn($col_email);
        $this->datagrid->addColumn($col_telefone);
        
        $col_id->setAction( new TAction([$this, 'onReload']),   ['order' => 'id']);
        $col_nome->setAction( new TAction([$this, 'onReload']), ['order' => 'nome']);
        
        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'],   ['key' => '{id}'] );
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{id}'] );
        
        $this->datagrid->addAction($action1, 'Edit',   'far:edit blue');
        $this->datagrid->addAction($action2, 'Delete', 'far:trash-alt red');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // wrap objects inside a table
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        $vbox->add(TPanelGroup::pack('', $this->datagrid));
        
        // pack the table inside the page
        parent::add($vbox);
    }
}
