<?php
/**

 * @author  Marcos  
 */
class Pendencia extends TRecord
{
    const TABLENAME = 'ufc_pendencia_estagio';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    use SystemChangeLogTrait;
   
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('data_reg');
        parent::addAttribute('tipo_pendencia');
        parent::addAttribute('descricao');
        parent::addAttribute('parecer');
        parent::addAttribute('estagio_id');
        parent::addAttribute('status');
        parent::addAttribute('system_user_id');

    }

    

 
}