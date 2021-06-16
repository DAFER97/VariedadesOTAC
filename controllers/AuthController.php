<?php
require_once 'models/Auth.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'public/phpmailer/vendor/autoload.php';
date_default_timezone_set("America/Tegucigalpa"); 

class AuthController
{
    public function VerificarCorreo()
    {
        if (isset($_POST['btncorreo']))
        {
            $InputUsuario= $_POST['InputUsuario'];
            $Auth = new Auth();
            $Correo_BD=$Auth->Get_correo($InputUsuario);

                    function CrearToken($length = 15) { 
                    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);}
                    $ValorToken = CrearToken(); 
                    $Vigenciatoken=$Auth->ParamToken();
                    //var_dump($Vigenciatoken);
                    $HorasToken = "+" . $Vigenciatoken . " Hours";
                    $fecha_inicial = strtotime("now");
                    $fecha_final = strtotime($HorasToken, $fecha_inicial);
                    $fecha_final = date("d-m-Y H:i:s", $fecha_final);
                    $fecha_inicial = date("d-m-Y H:i:s", $fecha_inicial);
                    $Auth->ActualizarToken($ValorToken, $fecha_inicial,$fecha_final,$InputUsuario);
                    //Datos parametrizado para el correo
                    $Correo_host=$Auth->ParamHost();
                    $Correo_usuario=$Auth->ParamUsuario();
                    $Correo_contra=$Auth->ParamContra();
                    $Correo_smtp=$Auth->ParamSMTP();
                    $Correo_puerto=$Auth->ParamPuerto();
                    $Correo_nombre=$Auth->ParamNombre();
                    // --------------- PROCESO DE ENVÍO DE CORREO BAJO PARAMETROS -----------------------
                    $mail = new PHPMailer(true);

                    try 
                    {

                        //Server settings
                        $mail->SMTPDebug = 0;                      // Enable verbose debug output
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = $Correo_host;                    // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->Username   = $Correo_usuario;                     // SMTP username
                        $mail->Password   = $Correo_contra;                               // SMTP password*
                        $mail->SMTPSecure = $Correo_smtp;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = $Correo_puerto;
                        $mail->SMTPOptions = array(
                            'ssl' => array
                            (
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                            )
                            );           
                        $mail->setFrom($Correo_usuario, $Correo_nombre);
                        $mail->addAddress($Correo_BD); 


                        $Body = "  <center> <h1 > ¡RECUPERA EL ACCESO DE TU CUENTA!". " </h1> </center>
                       
                        <p>Se ha solicitado el restablecimiento de contraseña a el sistema VARIEDADESOTAC, si usted no hizo
                        esta solicitud ignore este mensaje.</p>
                        
                        <p style='font-size=15px;'><b>El siguiente enlace tiene una duraci&oacute;n de ".  $Vigenciatoken . "hrs unicamente, en caso de mostrarse inválido repita la transacción.</b></p>
                        
                        <p style='line-height:19px;'>" .
                          "<br>".
                          "Presione: " 
                         . '<a href="https://localhost/variedades-OTAC/inicio/RestablecerContraCorreo&user=' . $Correo_BD . '&codigopersonal=' . $ValorToken . '"> aqu&iacute; </a>'.
                         "<center><p>[Honduras]  &middot; [Francisco Morazán]  &middot; [Distrito central]</p></center>"; 

                        $subject ='SISTEMA - VARIEDADESOTAC';
                        $subject = utf8_decode($subject);
                        
                        $mail->isHTML(true);                                
                        $mail->Subject = $subject;
                        $mail->Body    = $Body;
                        $mail->AltBody = strip_tags($Body);
                    
                        
                        $mail->send();
                    echo "<script> alert('¡Solicitud enviada con éxito!'); </script>";
                    echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/'; </script>";
                    //header("location:" . base_url);
                   

                } 
                catch (Exception $e) 
                {
                    echo "<script> alert('Error en el envío de correo, trate de nuevo'); </script>";
                    echo "<script> history.go(-1) </script>";
               
                }
                
            } 
            else {
                echo "<script> alert('Error en el envío de correo, trate de nuevo'); </script>";
                    echo "<script> history.go(-1) </script>";
            }
             
            
          
        
    }
    public function VerificarPregunta()
    {
        if (isset($_POST['btnrespuesta']))
        {
            $Auth = new Auth();
            $inputusuario= $_POST['inputusuario'];
            $selectpregunta= $_POST['selectpregunta'];
            $inputrespuesta= $_POST['inputrespuesta'];
            $EncontrarUsu=$Auth->TodosUsuarios($inputusuario);


            if (!$EncontrarUsu) 
            {
                echo "<script> alert('El usuario no existe, inténtelo de nuevo'); </script>";
                echo "<script> history.go(-1) </script>";
            }

            else 
            
            {
            $Id_usuario=$Auth->IDUsuarioPre($inputusuario);
            $RespuestaBD=$Auth->RespuestaUsuario($selectpregunta,$Id_usuario);

            if ($inputrespuesta == $RespuestaBD) 
            {
                
                echo "<script> alert('La respuesta ingresada es correcta'); </script>";
                $_SESSION["inputusuario"] = ($_POST['inputusuario']);
                echo "<script>  window.location.href = '../inicio/RestablecerContraPregunta'; </script>";
            }
            else
            {
                echo "<script> alert('La respuesta ingresada es incorrecta'); </script>";
                echo "<script> history.go(-1) </script>";
            }
            }

         
        }
    }

    public function ValidarRestablecer()
    {  $Auth = new Auth();

        if (isset($_POST['btnrestablecercorreo']))
        {
            $Correo_url =  $_SESSION["Correo_url"];
            $Contranueva= $_POST['Contranueva'];
            $Confirnueva= $_POST['Confirnueva'];

           
               if ($Contranueva <> $Confirnueva) 
               {
                echo "<script> alert('Las contraseñas no coinciden'); </script>";
                echo "<script> history.go(-1) </script>";
               }
               else 
               {
                
                $Confirnueva= md5($Confirnueva); 
                $VerificaPass=$Auth->ContractualCorreo($Correo_url);
                if ($VerificaPass===$Confirnueva) 
                {
                    echo "<script> alert('La nueva contraseña nueva no puede ser igual a la contraseña actual'); </script>";
                    echo "<script> history.go(-1) </script>";
                }

                else {
                echo "<script> alert('¡Se ha restablecido su contraseña con éxito!'); </script>";
                echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/'; </script>";
                $Auth->CambioContra($Confirnueva, $Correo_url);
                $Auth->ActivarUsuarioCorreo($Correo_url);
                $Auth->TokenUtilizado($Correo_url);
                }
              
               }

        } 
        elseif (isset($_POST['btnrestablecerpregun']))
        {
            $Usuario = $_SESSION["inputusuario"];
            $Contranueva= $_POST['Contranueva'];
            $Confirnueva= $_POST['Confirnueva'];

           
               if ($Contranueva <> $Confirnueva) 
               {
                echo "<script> alert('Las contraseñas no coinciden'); </script>";
                echo "<script> history.go(-1) </script>";
               }
               else 
               {
                $Confirnueva= md5($Contranueva); 
                $VerificaPass=$Auth->ContractualPregun($Usuario);
                
                if ($VerificaPass===$Confirnueva) 
                {
                    echo "<script> alert('La nueva contraseña nueva no puede ser igual a la contraseña actual'); </script>";
                    echo "<script> history.go(-1) </script>";
                }
                else 
                {
                //$Confirnueva= md5($Confirnueva); 
                $Auth-> CambioContraPre($Confirnueva, $Usuario);
                $Auth->ActivarUsuarioPregunta($Usuario);
                echo "<script> alert('¡Se ha restablecido su contraseña con éxito!'); </script>";
                echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/'; </script>";
                }
                

               }
        }   
        
           

        
    }


    public function Validalogin(){

        $Auth = new Auth();
        if(isset($_POST['login']))
        {
           $correo = $_POST['usuario'];
           $pass = $_POST['password'];
           $_SESSION['usuario'] = $correo;
           $pass= md5($pass); 
           
          $result=$Auth->validalogin($correo,$pass);
          foreach($result as $r){
          if($r['codigo']==1){
             $_SESSION['mensaje'] = $r['mensaje'];
             header("location:" . base_url);
          }elseif($r['codigo']== 2){
            $_SESSION['admin'] = $r;
            header("location:" . base_url.'inicio/PreguntaSeguridad');
          }elseif($r['codigo']== 3){
            $_SESSION['admin'] = $r;
            header("location:" . base_url.'inicio/Preguntaprime');
          }else {
            $_SESSION['admin'] = $r;
            header("location:" . base_url."admin/principal");
          }
          
         }
        
        }
    }


    public function RegisUsuarios()
    {
        if(isset($_POST['registro']))
        {
           $Auth = new Auth();
           $usuario=$_POST['usuario'];
           $nombre = $_POST['nombre'];
           $apellido =$_POST['apellido'];
           $genero=$_POST['selectgenero'];
           $correo = $_POST['correo'];
           $pass1 = $_POST['password1'];
           $pass2 = $_POST['password2'];
           
           $ValidacionU=$Auth->ValidacionExistenteU($usuario);
           $ValidacionC=$Auth->ValidacionExistenteC($correo);

           if ($ValidacionU == $usuario) 
           {
               echo "<script> alert('El usuario ya se encuentra registrado, inténtelo de nuevo'); </script>";
               echo "<script> history.go(-1) </script>";
           }
           elseif ($ValidacionC == $correo) 
           {
            echo "<script> alert('El correo electrónico ya se encuentra registrado, inténtelo de nuevo'); </script>";
            echo "<script> history.go(-1) </script>";
           }
           else 
           {
            $Auth = new Auth();

            if($pass1==$pass2){
                $pass1= md5($pass2); 
                $result = $Auth->RegistroUsuarios($usuario,$pass1,$nombre,$apellido, $genero,$correo);
               // var_dump($result);
                foreach($result as $r){
                 
                   if($r['codigo']==1){
                       $_SESSION['exito'] = $r['mensaje'];
                       
                       header("location:" . base_url."/inicio/Registro");
                      // echo "<script> alert('¡Ya existe un usuario con ese correo!'); </script>";
                      // echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/'; </script>";
                   }else{
                     $_SESSION['exito'] = 'Registrado correctamente';
                     header("location:" . base_url."/inicio/Registro");
                    // echo "<script> alert('¡El usuario ha sido ingresado con éxito!'); </script>";
                     //header("location:" . base_url."/inicio/Registro");
                    // echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/'; </script>";
                   }
                }
 
                
            }
           }


          
        }
    }

    public function PreguntaSeguridad()
    {
        $Auth = new Auth();
        $Usuario = $_SESSION['usuario'];
        $selectpregunta= $_POST['selectpregunta'];
        $inputrespuesta= $_POST['inputrespuesta'];
        $id_usuario= $Auth->Id_usuario($Usuario);

        $Auth->InsertarPregunta($selectpregunta,$id_usuario,$inputrespuesta);
        $Auth->ActualizarEstado($id_usuario);
        
        echo "<script> alert('¡Tu respuesta ha sido ingresada con éxito!'); </script>";
        echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/admin/principal'; </script>";


    }

    public function PreguntaSeguridaduser()
    {
        $Auth = new Auth();
        $Usuario = $_SESSION['usuario'];
        $selectpregunta= $_POST['selectpregunta'];
        $inputrespuesta= $_POST['inputrespuesta'];
        $id_usuario= $Auth->Id_usuario($Usuario);

        $Auth->InsertarPregunta($selectpregunta,$id_usuario,$inputrespuesta);
        $Auth->ActualizarEstado($id_usuario);
        
        echo "<script> alert('¡Tu respuesta ha sido ingresada con éxito!'); </script>";
        echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/inicio/cambiodecontraprime'; </script>";


    }


    public function cambiodepass(){
        $Auth = new Auth();
       if (isset($_POST['btnrestablecerpregun']))
        {
            $Usuario = $_SESSION['usuario'];
            $Contranueva= $_POST['Contranueva'];
            $Confirnueva= $_POST['Confirnueva'];

          
           
               if ($Contranueva <> $Confirnueva) 
               {
                echo "<script> alert('Las contraseñas no coinciden'); </script>";
                echo "<script> history.go(-1) </script>";
               }
               else 
               {
                $Confirnueva= md5($Contranueva); 
                $VerificaPass=$Auth->ContractualPregun($Usuario);
                
                if ($VerificaPass===$Confirnueva) 
                {
                    echo "<script> alert('La nueva contraseña nueva no puede ser igual a la contraseña actual'); </script>";
                    echo "<script> history.go(-1) </script>";
                }
                else 
                {
                //$Confirnueva= md5($Confirnueva); 
                $Auth-> CambioContraPre($Confirnueva, $Usuario);
                $Auth->ActivarUsuarioPregunta($Usuario);
                 unset($_SESSION['admin']);
                echo "<script> alert('¡Se ha restablecido su contraseña con éxito!'); </script>";
                echo "<script>  window.location.href = 'http://localhost/variedades-OTAC/'; </script>";
                }
            }
        }
    }
}
