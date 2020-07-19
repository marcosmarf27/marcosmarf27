<?php
/**

 * @author  Marcos  
 */
class Tipo extends TRecord
{
    const TABLENAME = 'ufc_tipo_estagio';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome');
   

    }
}