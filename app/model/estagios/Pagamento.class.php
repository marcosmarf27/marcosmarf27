<?php
/**

 * @author  Marcos  
 */
class Pagamento extends TRecord
{
    const TABLENAME = 'ufc_pagamento';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome');
   

    }
}