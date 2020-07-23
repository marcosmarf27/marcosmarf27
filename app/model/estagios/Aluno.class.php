<?php
/**

 * @author  Marcos  
 */
class Aluno extends TRecord
{
    const TABLENAME = 'ufc_aluno';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}

    private $cidade;
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome');
        parent::addAttribute('matricula');
        parent::addAttribute('email');
        parent::addAttribute('curso_id');
        parent::addAttribute('telefone');
        parent::addAttribute('cidade_id');
        parent::addAttribute('endereco');
        parent::addAttribute('system_user_id');

    }

    function get_cidade()
    {
        // instantiates City, load $this->city_id
        if (empty($this->cidade))
        {
            $this->cidade = new Cidade($this->cidade_id);
        }
        
        // returns the City Active Record
        return $this->cidade;
    }
}