<?php
require_once("conexion.php");

class AlumnoModel
{
    private $pdo;

    public function __construct()
    {
     $con = New conexion();
     $this->pdo = $con->getConexion();
    }

    public function Listar()
    {
        try
        {
            $result = array();

            $stm = $this->pdo->prepare("SELECT * FROM alumnos");
            $stm->execute();

            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
            {
                $alm = new Alumno();

                $alm->set_id($r->id);
                $alm->set_nombre($r->Nombre);
                $alm->set_apellido($r->Apellido);
                $alm->set_sexo($r->Sexo);
                $alm->set_fecha($r->FechaNacimiento);

                $result[] = $alm;
            }

            return $result;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
}

    public function Obtener($id)
    {
        try
        {
            $stm = $this->pdo->prepare("SELECT * FROM alumnos WHERE id = ?");
            $stm->execute(array($id));

            $r = $stm->fetch(PDO::FETCH_OBJ);

            $alm = new Alumno();

            $alm->set_id($r->id);
            $alm->set_nombre($r->Nombre);
            $alm->set_apellido($r->Apellido);
            $alm->set_sexo($r->Sexo);
            $alm->set_fecha($r->FechaNacimiento);

            return $alm;
        } catch (Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Eliminar($id)
    {
        try
        {
            $stm = $this->pdo->prepare("DELETE FROM alumnos WHERE id = ?");
            $stm->execute(array($id));
        } catch (Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Actualizar(Alumno $data)
    {
        try
        {
          $sql = "UPDATE alumnos SET
                        Nombre          = ?,
                        Apellido        = ?,
                        Sexo            = ?,
                        FechaNacimiento = ?
                    WHERE id = ?";

          $this->pdo->prepare($sql)
               ->execute(
                array(
                    $data->get_nombre(),
                    $data->get_apellido(),
                    $data->get_sexo(),
                    $data->get_fecha(),
                    $data->get_id()
                    )
                ); 
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
