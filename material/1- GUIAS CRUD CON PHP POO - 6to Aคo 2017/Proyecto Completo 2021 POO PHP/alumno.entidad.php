<?php
class Alumno
{   private $_id;
    private $_Nombre;
    private $_Apellido;
    private $_Sexo;
    private $_FechaNacimiento;

    public function set_id($valor){ $this->_id = $valor; }
    public function set_nombre($valor){ $this->_Nombre = $valor; }
    public function set_apellido($valor){ $this->_Apellido = $valor; }
    public function set_sexo($valor){ $this->_Sexo = $valor; }
    public function set_fecha($valor){ $this->_FechaNacimiento = $valor; }

    public function get_id(){ return $this->_id ; }
    public function get_nombre(){ return $this->_Nombre; }
    public function get_apellido(){ return $this->_Apellido; }
    public function get_sexo(){ return $this->_Sexo; }
    public function get_fecha(){ return $this->_FechaNacimiento; }
}
?>
