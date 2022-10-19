<?php
require_once("conexion.php");

class AlumnoModel 
{   
    //atributos
    //private $con;
    private $pdo;
    
    //metodos
     
    public function __construct() 
    {
     $con = New conexion(); //instancia de la clase conexion
     $this->pdo = $con->getConexion();  //guardo en pdo la conexion misma
    }     
    
    public function Listar()
    {
        try
        {
            $result = array();
   
            $stm = $this->pdo->prepare("SELECT * FROM alumnos"); //directiva de traer toda la tabla alumno
            $stm->execute(); //ejecuta la consulta

            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r) //recorre una lista de objetos alumno que lo guarda en la variable r
            {
                $alm = new Alumno(); //se crea una instancia de alumno

                $alm->set_id($r->id); //guarda en la isntancia alumno, el id del objeto recuperado de la lista de objetos
                $alm->set_nombre($r->Nombre);
                $alm->set_apellido($r->Apellido);
                $alm->set_sexo($r->Sexo);
                $alm->set_fecha($r->FechaNacimiento);

                $result[] = $alm; //guarda cada isntancia de alumno en el arreglo result
            }

            return $result; //devuelve un arreglo de objetos alumnos
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
}

    public function Obtener($id) //busca un objeto alumno segun un id
    {
        try 
        {
            $stm = $this->pdo->prepare("SELECT * FROM alumnos WHERE id = ?"); //prepara la consulta
            $stm->execute(array($id)); //ejecuta la consulta y pasa por parametro el id a buscar
           
            $r = $stm->fetch(PDO::FETCH_OBJ); //guarda en r el objeto de la clase alumno

            $alm = new Alumno(); //crea un objeto alm, una instancia de la clase alumno

            $alm->set_id($r->id); // guarda en la instancia alm, el id del objeto de la clase alumno
            $alm->set_nombre($r->Nombre);// lo mismo para el resto de los datos
            $alm->set_apellido($r->Apellido);
            $alm->set_sexo($r->Sexo);
            $alm->set_fecha($r->FechaNacimiento);

            return $alm; // segun el id especificado, devuelve un objeto de la clase alumno
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function Eliminar($id) //elimina un objeto de la clase alumno segun un id // elimina un registro de la tabla
    {
        try 
        {
            $stm = $this->pdo->prepare("DELETE FROM alumnos WHERE id = ?");       // crea la consulta               
            $stm->execute(array($id)); // ejecuta la consulta
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function Actualizar(Alumno $data) //actualiza un registro de la tabla con un dato de tipo clase alumno
    {
        try 
        {
          $sql = "UPDATE alumnos SET  
                        Nombre          = ?, 
                        Apellido        = ?,
                        Sexo            = ?, 
                        FechaNacimiento = ?
                    WHERE id = ?"; // crea la consulta

          $this->pdo->prepare($sql) 
               ->execute(
                array(
                    $data->get_nombre(), 
                    $data->get_apellido(), 
                    $data->get_sexo(),
                    $data->get_fecha(),
                    $data->get_id()
                    )
                ); //ejecutla la consulta
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function Registrar(Alumno $data)
    {
        try 
        {
        $sql = "INSERT INTO alumnos (Nombre,Apellido,Sexo,FechaNacimiento) 
                VALUES (?, ?, ?, ?)";

        $this->pdo->prepare($sql)
             ->execute(
            array(
                $data->get_nombre(), 
                $data->get_apellido(), 
                $data->get_sexo(),
                $data->get_fecha()
              )
            );
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
}
?>