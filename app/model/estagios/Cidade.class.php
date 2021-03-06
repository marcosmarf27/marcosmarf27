<?php
/**

 * @author  Marcos  
 */
class Cidade extends TRecord
{
    const TABLENAME = 'ufc_cidade';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    private $estado;
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome');
        parent::addAttribute('estado_id');
       


        
    }

    function get_estado()
    {
        // instantiates City, load $this->city_id
        if (empty($this->estado))
        {
            $this->estado = new Estado($this->estado_id);
        }
        
        // returns the City Active Record
        return $this->estado;
    }
}