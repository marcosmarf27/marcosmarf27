<?php
/**
 * StandardDataGridView Listing
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class ConcedenteList extends TPage
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    
    // trait with onReload, onSearch, onDelete...
    use Adianti\Base\AdiantiStandardListTrait;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('estagio');        // defines the database
        $this->setActiveRecord('Concedente');       // defines the active record
        $this->addFilterField('nome', 'ilike', 'nome'); // filter field, operator, form field
        $this->setDefaultOrder('id', 'desc');  // define the default order
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_search_City');
        $this->form->setFormTitle('Lista de Empresas');
        
        $nome = new TEntry('nome');
        $this->form->addFields( [new TLabel('Name:')], [$nome] );
        
        // add form actions
        $this->form->addAction('Buscar', new TAction([$this, 'onSearch']), 'fa:search blue');
        $this->form->addActionLink('Novo',  new TAction(['ConcedenteForm', 'onClear']), 'fa:plus-circle green');
        $this->form->addActionLink('Limpar',  new TAction([$this, 'clear']), 'fa:eraser red');
        
        // keep the form filled with the search data
        $this->form->setData( TSession::getValue('ConcedenteForm_filter_data') );
        
        // creates the DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = "100%";
        
        // creates the datagrid columns
        $col_id    = new TDataGridColumn('id', 'Id', 'right', '5%');
        $col_name  = new TDataGridColumn('nome', 'Name', 'left', '30%');
        $col_situacao  = new TDataGridColumn('situacao', 'Status', 'left', '30%');
        $col_representante= new TDataGridColumn('representante', 'Representante', 'left', '20%');
        $col_email  = new TDataGridColumn('email', 'E-mail', 'left', '20%');
        $cidade = new TDataGridColumn('cidade->nome', 'Cidade', 'center', '10%');
       
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_name);
        $this->datagrid->addColumn($col_situacao);
        $this->datagrid->addColumn($col_representante);
        $this->datagrid->addColumn($col_email);
      $this->datagrid->addColumn($cidade);

      $col_situacao->setTransformer(array($this, 'Ajustar'));
     
        
        $col_id->setAction( new TAction([$this, 'onReload']),   ['order' => 'id']);
        $col_name->setAction( new TAction([$this, 'onReload']), ['order' => 'nome']);
        
        $action1 = new TDataGridAction(['ConcedenteForm', 'onEdit'],   ['key' => '{id}'] );
        $action2 = new TDataGridAction([$this, 'onDelete'],   ['key' => '{id}'] );
        $action3 = new TDataGridAction(['ListEstagioEmpresa', 'onReload'],   ['key' => '{id}'] );
        
        $this->datagrid->addAction($action1, 'Editar',   'far:edit blue');
        $this->datagrid->addAction($action2, 'Deletar', 'far:trash-alt red');
        $this->datagrid->addAction($action3, 'Ver Estágios', 'fas:eye fa-fw');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        
        // creates the page structure using a table
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        $vbox->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        // add the table inside the page
        parent::add($vbox);
    }
    
    /**
     * Clear filters
     */
    function clear()
    {
        $this->clearFilters();
        $this->onReload();
    }

    public function ajustar($value, $object, $row){
        switch ($value) {
            case 1:
                $div = new TElement('span');
                $div->class="label label-warning";
                 $div->style="text-shadow:none; font-size:12px";
                $div->add('Não conveniada');
                return $div;
                break;
            case 2:
                $div = new TElement('span');
                $div->class="label label-success";
                 $div->style="text-shadow:none; font-size:12px";
                $div->add('Empresa Conveniada');
                return $div;
                break;
    
                case 3:
                    $div = new TElement('span');
                    $div->class="label label-primary";
                     $div->style="text-shadow:none; font-size:12px";
                    $div->add('Processando');
                    return $div;
                    break;
    
                    case 4:
                        $div = new TElement('span');
                        $div->class="label label-danger";
                         $div->style="text-shadow:none; font-size:12px";
                        $div->add('Convenio com problemas');
                        return $div;
                        break;
    
                      
             
                    
                
         
        }
    }
    
}
