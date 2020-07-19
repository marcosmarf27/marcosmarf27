<?php
/**

 * @author  Marcos  
 */
class Estado extends TRecord
{
    const TABLENAME = 'ufc_estado';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome');
        parent::addAttribute('uf');
        
     
    }
}