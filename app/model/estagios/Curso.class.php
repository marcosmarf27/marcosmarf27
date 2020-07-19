<?php
/**

 * @author  Marcos  
 */
class Curso extends TRecord
{
    const TABLENAME = 'ufc_curso';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome');
   

    }
}