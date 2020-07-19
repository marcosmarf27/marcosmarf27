<?php
/**

 * @author  Marcos  
 */
class Horario extends TRecord
{
    const TABLENAME = 'ufc_horario_estagio';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}

    private $aluno;
    private $concedente;
    private $professor;
    private $tipo_estagio;
    private $pagamento;
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('dia_semana');
        parent::addAttribute('turno_manha_ini');
        parent::addAttribute('turno_manha_fim');
        parent::addAttribute('turno_tarde_ini');
        parent::addAttribute('turno_tarde_fim');
        parent::addAttribute('turno_noite_ini');
        parent::addAttribute('turno_noite_fim');
        parent::addAttribute('total_dia');
        parent::addAttribute('estagio_id');
        
     

        

    }


    
    
}