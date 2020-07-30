<?php
/**

 * @author  Marcos  
 */
class Solucao extends TRecord
{
    const TABLENAME = 'ufc_tipo_solu';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome');
        parent::addAttribute('solucao');
        parent::addAttribute('problema');
   

    }
}