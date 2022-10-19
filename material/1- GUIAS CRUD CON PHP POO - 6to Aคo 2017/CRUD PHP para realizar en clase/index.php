<?php
require_once 'alumno.entidad.php';
require_once 'alumno.model.php';

// Logica
$alm = new Alumno();
$model = new AlumnoModel();

if(isset($_REQUEST['operacion']))
{
    //echo "ACTIOOOOOOOON".$_REQUEST['action'];
    switch($_REQUEST['operacion'])
    {
        case 'actualizar':
            $alm->set_id($_REQUEST['id']);
            $alm->set_nombre($_REQUEST['Nombre']);
            $alm->set_apellido($_REQUEST['Apellido']);
            $alm->set_sexo($_REQUEST['Sexo']);
            $alm->set_fecha($_REQUEST['FechaNacimiento']);

            $model->Actualizar($alm);
            //header('Location: index.php');
            $alm = new Alumno();
            break;

        case 'registrar':
            $alm->set_nombre($_REQUEST['Nombre']);
            $alm->set_apellido($_REQUEST['Apellido']);
            $alm->set_sexo($_REQUEST['Sexo']);
            $alm->set_fecha($_REQUEST['FechaNacimiento']);

            $model->Registrar($alm);
            //header('Location: index.php');
            $alm = new Alumno();
            break;

        case 'eliminar':
            $model->Eliminar($_REQUEST['id']);
            //header('Location: index.php');
            break;

        case 'editar':
            $alm = $model->Obtener($_REQUEST['id']);
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>ProyectoWeb</title>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
    </head>
    <body >

        <div class="pure-g">
            <div class="pure-u-1-12">

                <form action="index.php" method="post" class="pure-form pure-form-stacked" >
                    <input type="hidden" name="id" value="<?php echo $alm->get_id(); ?>" />
                    <input type="hidden" name="operacion" value="<?php echo $alm->get_id() > 0 ? 'actualizar' : 'registrar'; ?>" />

                    <table >
                        <tr>
                            <th >Nombre</th>
                            <td><input type="text" name="Nombre" value="<?php echo $alm->get_nombre(); ?>"  /></td>
                        </tr>
                        <tr>
                            <th >Apellido</th>
                            <td><input type="text" name="Apellido" value="<?php echo $alm->get_apellido(); ?>"  /></td>
                        </tr>
                        <tr>
                            <th >Sexo</th>
                            <td>
                                <select name="Sexo" >
                                    <option value="1" <?php $alm->get_sexo() == 1  ? 'selected' : '';?>>Masculino</option>
                                    <option value="2" <?php $alm->get_sexo() == 2  ? 'selected' : '';?>>Femenino</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th >Fecha</th>
                            <td><input type="date" name="FechaNacimiento" value="<?php echo $alm->get_fecha(); ?>"  /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit" class="pure-button pure-button-primary">Guardar</button>
                            </td>
                        </tr>
                    </table>
                </form>

                <table class="pure-table pure-table-horizontal">
                    <thead>
                        <tr>
                            <th >Nombre</th>
                            <th >Apellido</th>
                            <th >Sexo</th>
                            <th >Nacimiento</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php foreach($model->Listar() as $r): ?>
                        <tr>
                            <td><?php echo $r->get_nombre(); ?></td>
                            <td><?php echo $r->get_apellido(); ?></td>
                            <td><?php echo $r->get_sexo() == 1 ? 'M' : 'F'; ?></td>
                            <td><?php $fecha = date_create($r->get_fecha());

                                      $fecha = date_format($fecha, 'd/m/Y');

                                      echo $fecha;
                                ?></td>
                            <td>
                                <!--<a href="?action=editar&id=<?php //echo $r->get_id(); ?>">Editar</a>-->
                                <form method="post" action="index.php">
                                    <input type="hidden" name="operacion" value="editar">
                                    <input type="hidden" name="id" value="<?php echo $r->get_id(); ?>">
                                    <input type="submit" value="Editar">
                                </form>

                            </td>
                            <td>
                                <!--<a href="?action=eliminar&id=<?php //echo $r->get_id(); ?>">Eliminar</a>-->
                                <form method="post" action="index.php">
                                    <input type="hidden" name="operacion" value="eliminar">
                                    <input type="hidden" name="id" value="<?php echo $r->get_id(); ?>">
                                    <input type="submit" value="Eliminar">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            </div>
        </div>

    </body>
</html>
