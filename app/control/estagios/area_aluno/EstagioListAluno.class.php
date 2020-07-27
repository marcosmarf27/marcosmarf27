<?php

use Adianti\Database\TTransaction;
use Adianti\Registry\TSession;
use Adianti\Widget\Dialog\TMessage;
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
class EstagioListAluno extends TPage
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    
    use Adianti\Base\AdiantiStandardListTrait;
    
    /**
     * Page constructor
     */
    public function __construct($param)
    {
        parent::__construct();

       
    
        
        $criteria = new TCriteria();
        $criteria->add(new TFilter('system_user_id','=', TSession::getValue('userid')));
        $this->setCriteria($criteria);
        
        $this->setDatabase('estagio');          // defines the database
        $this->setActiveRecord('Estagio');         // defines the active record
        $this->setDefaultOrder('id', 'desc');    // defines the default order
     
        
        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
       // $this->datagrid->height = '500px';
     
        
        // creates the datagrid columns
        $column_id       = new TDataGridColumn('id', 'nº Estágio', 'center', '5%');
        $column_situacao    = new TDataGridColumn('situacao', 'Status', 'center', '20%');
        $column_aluno = new TDataGridColumn('aluno->nome', 'Aluno', 'left', '25%');
        $column_concedente = new TDataGridColumn('concedente->nome', 'Empresa/Instituição', 'left', '25%');
        $column_data_ini     = new TDataGridColumn('data_ini', 'Data Inicio', 'center', '15%');
        $column_data_fim    = new TDataGridColumn('data_fim', 'Data Término', 'center', '15%');
       
       
        
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_situacao);
        $this->datagrid->addColumn($column_aluno);
        $this->datagrid->addColumn($column_concedente);
        $this->datagrid->addColumn($column_data_ini);
        $this->datagrid->addColumn($column_data_fim);
       

        //Transformação que define a situação do estagio 
        $column_situacao->setTransformer( array($this, 'ajustarSituacao'));
        
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

  
      //  $action_delete = new TDataGridAction([$this, 'onDelete'],   ['key' => '{id}'] );
      

       // $this->datagrid->addAction($action_delete, 'Deletar Termo', 'far:trash-alt red fa-fw');


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
        
    }

    public function abrir($param){

        TScript::create("Template.closeRightPanel()");
     
    }

   public function ajustarSituacao($value, $object, $row){

    TScript::create("Template.closeRightPanel()");

    $pendencias = Pendencia::where('estagio_id', '=', $object->id)->where('status', '=', 'N')->load();

    if($pendencias){
        
     TTransaction::open('estagio');
     



    $estagio = Estagio::find($object->id);
    $estagio->situacao = '3';
    $estagio->store();
    $value = $estagio->situacao;

    $div = new TElement('span');
    $div->class="label label-warning";
     $div->style="text-shadow:none; font-size:12px";
    $div->add('Estágio com problemas');
    return $div;
    TTransaction::close();

 

    

     TTransaction::close();
    }
    
    if(!($pendencias) and $object->situacao == '3'){
        TScript::create("Template.closeRightPanel()");
     

        TTransaction::open('estagio');

    $estagio = Estagio::find($object->id);
    $estagio->situacao = '2';
    $estagio->store();
    $value = $estagio->situacao;

    $div = new TElement('span');
    $div->class="label label-success";
     $div->style="text-shadow:none; font-size:12px";
    $div->add('Estágio Aprovado');
    return $div;
    TTransaction::close();

    }
       
    
    

    TScript::create("Template.closeRightPanel()");


    switch ($object->situacao) {
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
     
    }
   }

   public static function onClosePanel($param)
   {
       TScript::create("Template.closeRightPanel()");
   }
   
   
   
   public function aprovarTermo($param){

    TTransaction::open('estagio');
     



    $estagio = Estagio::find($param['id']);
    $estagio->situacao = '2';
    $estagio->store();
 

 
    TTransaction::close();
    $action1 = new TAction(array($this, 'onReload'));
   // $action2 = new TAction(array($this, 'onReload'));
    // define os parâmetros de cada ação
   
    
    // shows the question dialog
    new TMessage('info', 'Termo
    de estágio aprovado', $action1);


   }
    
}