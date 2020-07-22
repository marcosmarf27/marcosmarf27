<?php

use Adianti\Widget\Form\TCombo;

/**
 * SaleList
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class EstagioList extends TPage
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    
    use Adianti\Base\AdiantiStandardListTrait;
    
    /**
     * Page constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        
        $this->setDatabase('estagio');          // defines the database
        $this->setActiveRecord('Estagio');         // defines the active record
        $this->setDefaultOrder('id', 'desc');    // defines the default order
        $this->addFilterField('id', '=', 'id'); 
        $this->addFilterField('(SELECT matricula FROM ufc_aluno WHERE ufc_aluno.id = aluno_id)', '=', 'matricula');
        $this->addFilterField('situacao', '=', 'situacao');// filterField, operator, formField
        $this->addFilterField('aluno_id', '=', 'aluno_id'); // filterField, operator, formField
        
        $this->addFilterField('data_ini', '>=', 'date_from', function($value) {
            return TDate::convertToMask($value, 'dd/mm/yyyy', 'yyyy-mm-dd');
        }); // filterField, operator, formField, transformFunction
        
        $this->addFilterField('data_fim', '<=', 'date_to', function($value) {
            return TDate::convertToMask($value, 'dd/mm/yyyy', 'yyyy-mm-dd');
        }); // filterField, operator, formField, transformFunction
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_search_estagios');
        $this->form->setFormTitle('Estágios Recebidos');
        
        // create the form fields
        $id        = new TEntry('id');
        $situacao = new TCombo('situacao');
        $matricula = new TEntry('matricula');
        $situacao->addItems([ '1' => 'Em Avaliação', '2' => 'Estágio Aprovado', '3'=> 'Estágio com Problemas']);
        $date_from = new TDate('date_from');
        $date_to   = new TDate('date_to');
        
        $aluno_id = new TDBUniqueSearch('aluno_id', 'estagio', 'Aluno', 'id', 'nome');
        $aluno_id->setMinLength(1);
        $aluno_id->setMask('{nome} ({id})');
        
        // add the fields
        $this->form->addFields( [new TLabel('Id')],          [$id], [new TLabel('Status')],          [$situacao], [new TLabel('Matricula')],          [$matricula]); 
        $this->form->addFields( [new TLabel('Data Estágio (De)')], [$date_from],
                                [new TLabel('Data Término (à)')],   [$date_to] );
        $this->form->addFields( [new TLabel('Aluno')],    [$aluno_id] );
        
        $id->setSize('50%');
        $date_from->setSize('100%');
        $date_to->setSize('100%');
        $date_from->setMask( 'dd/mm/yyyy' );
        $date_to->setMask( 'dd/mm/yyyy' );
        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('EstagioList_filter_data') );
        
        // add the search form actions
        $this->form->addAction('Procurar', new TAction([$this, 'onSearch']), 'fa:search');
        $this->form->addActionLink('Cadastrar novo termo',  new TAction(['EstagioFormAdmin', 'onClear']), 'fa:plus green');
        $this->form->addActionLink( 'Limpar', new TAction([$this, 'Limpar']), 'fa:eraser red' );
        
        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        // creates the datagrid columns
        $column_id       = new TDataGridColumn('id', 'Id', 'center', '5%');
        $column_situacao    = new TDataGridColumn('situacao', 'Status', 'center', '20%');
        $column_aluno = new TDataGridColumn('aluno->nome', 'Aluno', 'left', '25%');
        $column_concedente = new TDataGridColumn('concedente->nome', 'Empresa/Instituição', 'left', '25%');
        $column_data_ini     = new TDataGridColumn('data_ini', 'Data Inicio', 'center', '15%');
        $column_data_fim    = new TDataGridColumn('data_fim', 'Data Término', 'center', '15%');
       
       // $column_total    = new TDataGridColumn('total', 'Total', 'right', '20%');
        
        // define format function
        $format_value = function($value) {
            if (is_numeric($value)) {
                return 'R$ '.number_format($value, 2, ',', '.');
            }
            return $value;
        };
        
      //  $column_total->setTransformer( $format_value );
        
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_situacao);
        $this->datagrid->addColumn($column_aluno);
        $this->datagrid->addColumn($column_concedente);
        $this->datagrid->addColumn($column_data_ini);
        $this->datagrid->addColumn($column_data_fim);
       

        //Transformação que define a situação do estagio 
        $column_situacao->setTransformer( function($value, $object, $row) {

            switch ($value) {
                case 1:
                    $div = new TElement('span');
                    $div->class="label label-primary";
                     $div->style="text-shadow:none; font-size:12px";
                    $div->add('Em Avaliação');
                    return $div;
                    break;
                case 2:
                    $div = new TElement('span');
                    $div->class="label label-success";
                     $div->style="text-shadow:none; font-size:12px";
                    $div->add('Estágio Aprovado');
                    return $div;
                    break;
                case 3:
                    $div = new TElement('span');
                    $div->class="label label-warning";
                     $div->style="text-shadow:none; font-size:12px";
                    $div->add('Estágio com problemas');
                    return $div;
                    break;
            }

                
           
        });
        
        // creates the datagrid column actions
        $column_id->setAction(new TAction([$this, 'onReload']),   ['order' => 'id']);
        $column_data_ini->setAction(new TAction([$this, 'onReload']), ['order' => 'data_ini']);
        
        // define the transformer method over date
        $column_data_ini->setTransformer( function($value, $object, $row) {
            $date = new DateTime($value);
            return $date->format('d/m/Y');
        });
        $column_data_fim->setTransformer( function($value, $object, $row) {
            $date = new DateTime($value);
            return $date->format('d/m/Y');
        });

       // $action_view   = new TDataGridAction(['SaleSidePanelView', 'onView'],   ['key' => '{id}', 'register_state' => 'false'] );
        $action_edit   = new TDataGridAction(['EstagioFormAdmin', 'onEdit'],   ['key' => '{id}',  'register_state' => 'false']);
        $action_edit_a   = new TDataGridAction(['AlunoFormWindow', 'onEdit'],   ['id' => '{aluno_id}',  'register_state' => 'false']);
        $action_edit_c   = new TDataGridAction(['ConcedenteFormWindow', 'onEdit'],   ['id' => '{concedente_id}',  'register_state' => 'false']);
        $action_delete = new TDataGridAction([$this, 'onDelete'],   ['key' => '{id}'] );
        
        //$this->datagrid->addAction($action_view, _t('View details'), 'fa:search green fa-fw');
        $this->datagrid->addAction($action_edit, 'Editar Termo',   'far:edit blue fa-fw');
        $this->datagrid->addAction($action_delete, 'Deletar Termo', 'far:trash-alt red fa-fw');
        $this->datagrid->addAction($action_edit_a, 'Cadastro Aluno',   'far:user blue fa-fw');
        $this->datagrid->addAction($action_edit_c, 'Cadastro Empresa', 'fas:address-card blue fa-fw');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add($panel = TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        $panel->getBody()->style = 'overflow-x:auto';
        parent::add($container);
    }

    public  function Limpar($param)
    {
        $this->form->clear();
        $this->onSearch();
    }

    
}