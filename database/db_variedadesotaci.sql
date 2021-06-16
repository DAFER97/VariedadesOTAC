-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2021 a las 01:38:05
-- Versión del servidor: 10.4.16-MariaDB
-- Versión de PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_variedadesotaci`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `data` ()  BEGIN
DECLARE usuarios int;
DECLARE clientes int;
DECLARE proveedores int;
DECLARE productos int;
DECLARE ventas int;
SELECT COUNT(*) INTO usuarios FROM tbl_ms_usuario;

SELECT COUNT(*) INTO proveedores FROM tbl_proveedores;
SELECT COUNT(*) INTO productos FROM tbl_productos;
SELECT COUNT(*) INTO ventas FROM tbl_ventas WHERE fecha > CURDATE();

SELECT usuarios, clientes, proveedores, productos, ventas;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_venta` (IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50))  BEGIN
DECLARE factura INT;
DECLARE registros INT;
DECLARE total DECIMAL(10,2);
DECLARE nueva_existencia int;
DECLARE existencia_actual int;

DECLARE tmp_cod_producto int;
DECLARE tmp_cant_producto int;
DECLARE a int;
SET a = 1;

CREATE TEMPORARY TABLE tbl_tmp_tokenuser(
	id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cod_prod BIGINT,
    cant_prod int);
SET registros = (SELECT COUNT(*) FROM detalle_temp WHERE token_user = token);
IF registros > 0 THEN
INSERT INTO tbl_tmp_tokenuser(cod_prod, cant_prod) SELECT codproducto, cantidad FROM detalle_temp WHERE token_user = token;
INSERT INTO factura (usuario,codcliente) VALUES (cod_usuario, cod_cliente);
SET factura = LAST_INSERT_ID();

INSERT INTO detallefactura(nofactura,codproducto,cantidad,precio_venta) SELECT (factura) AS nofactura, codproducto, cantidad,precio_venta FROM detalle_temp WHERE token_user = token;
WHILE a <= registros DO
	SELECT cod_prod, cant_prod INTO tmp_cod_producto,tmp_cant_producto FROM tbl_tmp_tokenuser WHERE id = a;
    SELECT existencia INTO existencia_actual FROM producto WHERE codproducto = tmp_cod_producto;
    SET nueva_existencia = existencia_actual - tmp_cant_producto;
    UPDATE producto SET existencia = nueva_existencia WHERE codproducto = tmp_cod_producto;
    SET a=a+1;
END WHILE;
SET total = (SELECT SUM(cantidad * precio_venta) FROM detalle_temp WHERE token_user = token);
UPDATE factura SET totalfactura = total WHERE nofactura = factura;
DELETE FROM detalle_temp WHERE token_user = token;
TRUNCATE TABLE tbl_tmp_tokenuser;
SELECT * FROM factura WHERE nofactura = factura;
ELSE
SELECT 0;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `splogin` (IN `pusuario` VARCHAR(50), IN `ppass` VARCHAR(200))  begin
	
	declare num int;
    declare numerorestar int;
    declare numm int;
	declare codUsuario int;





 start transaction;


if exists(select * from tbl_ms_usuario where usuario = upper(pusuario) and contrasena = ppass and id_estado_usuario =1 and creado_por = 'Autoregistro' and primer_ingreso=0)THEN 

 	SELECT 2 as codigo;
   

end if;


if exists(select * from tbl_ms_usuario where usuario = upper(pusuario) and contrasena = ppass and id_estado_usuario = 1 and creado_por <> 'Autoregistro' and primer_ingreso=0)THEN 

 	SELECT 3 as codigo;
   

end if;

if exists(select * from tbl_ms_usuario  where usuario = upper(pusuario) and id_estado_usuario =5)THEN 

 	SELECT 1 as codigo, 'El usuario está bloqueadoo, comuniquese con el administrador' as mensaje;

end if;

if exists(select * from tbl_ms_usuario where usuario = upper(pusuario) and id_estado_usuario =2)THEN 

 	SELECT 1 as codigo, 'El usuario está desactivado, comuniquese con el administrador' as mensaje;

end if;

if not exists(select * from tbl_ms_usuario where usuario =upper(pusuario)) then 

   select 1 as codigo,'El usuario no existe' as mensaje;

end if;





if exists(select * from tbl_ms_usuario where usuario = upper(pusuario) and  contrasena = ppass and id_estado_usuario = 1) THEN 

	
	      update tbl_ms_usuario set fecha_ultima_conexion = curdate() where usuario = upper(pusuario);
	      set num = (select valor from tbl_ms_parametros where parametro = 'ADMIN_INTENTOS');
          update tbl_ms_usuario set intentos = num where usuario = upper(pusuario);
          commit;

	       SELECT * from tbl_ms_usuario where usuario =upper(pusuario);
	      
		else

		 set num = (select intentos from tbl_ms_usuario where usuario = upper(pusuario));
         set numerorestar=(num-1);
         update tbl_ms_usuario set intentos = numerorestar where usuario = upper(pusuario) and usuario <> 'ROOT';
         set numm = (select intentos from tbl_ms_usuario where usuario = upper(pusuario));
         commit;

        if(numm = -1) then
          update tbl_ms_usuario set id_estado_usuario = 5 where usuario =upper(pusuario);
          select 1 as codigo,'Se ha bloqueado el usuario, comuniquese con el administrador' as mensaje;
        end if;
         select 1 as codigo, 'El usuario o la contraseña son incorrectos' as mensaje;
  end if;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTblBitacoraInsert` (IN `codu` INT, IN `codo` INT, IN `accion` VARCHAR(100), IN `descrip` VARCHAR(100))  begin

	insert into tbl_ms_bitacora (TBL_MS_USUARIO_id_usuario,TBL_MS_OBJETOS_id_objeto,accion,descripcion,fecha_creacion) values (codu,codo,accion,descrip,sysdate());

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_CateEliminar` (IN `Pid` INT)  begin
 delete from tbl_categoria where id_categoria = Pid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_ClientesEliminar` (IN `Pid` INT)  begin
 delete from tbl_clientes where id_cliente = Pid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_Objetos_Actualizar` (IN `pcod` INT, IN `pobjeto` VARCHAR(100), IN `pdescripcion` VARCHAR(100), IN `ptipo` VARCHAR(15), IN `pidpadre` INT, IN `picono` VARCHAR(100), IN `purl` VARCHAR(100), IN `pestado` VARCHAR(100), IN `pcreado` VARCHAR(100))  begin

	start transaction;

	update tbl_ms_objetos set objeto = pobjeto, descripcion = pdescripcion, tipo_objeto = ptipo, idPadre = pidpadre, icono = picono,

			url = purl, estado = pestado, modificado_por = pcreado, fecha_modificacion = curdate() where id_objeto = pcod; 

	commit;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_Objetos_Insertar` (IN `pobjeto` VARCHAR(100), IN `pdescripcion` VARCHAR(100), IN `ptipo` VARCHAR(15), IN `pidpadre` INT, IN `picono` VARCHAR(100), IN `purl` VARCHAR(100), IN `pestado` VARCHAR(100), IN `pcreado` VARCHAR(100))  begin

	start transaction;

	insert into tbl_ms_objetos(objeto,descripcion,tipo_objeto,idPadre,icono,url,estado,creado_por,fecha_creacion)

	values(pobjeto,pdescripcion,ptipo,pidpadre,picono,purl,pestado,pcreado,curdate());

	commit;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_Objetos_Mostrar` ()  begin

	select * from tbl_ms_objetos;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_Permisos_Actualizar` (`pinsertar` INT(1), `peliminar` INT(1), `pactualizar` INT(1), `pconsultar` INT(1), `pcreadopor` VARCHAR(15), `pcod` INT(11))  begin

	start transaction;

	update tbl_ms_permisos SET  permiso_insercion = pinsertar, permiso_eliminacion = peliminar,

								 permiso_actualizacion = pactualizar, permiso_consultar = pconsultar, modificado_por = pcreadopor, fecha_modificacion = curdate() where id_permiso = pcod;

	commit;

  select 0 as codigo,'Se ha actualizado correctamente' as mensaje;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_Permisos_Eliminar` (`pcod` INT(11))  begin

	start transaction;

		delete from tbl_ms_permisos where id_permiso = pcod;

	commit;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_Permisos_Insertar` (`prol` INT(11), `pobjeto` INT(11), `pinsertar` INT(1), `peliminar` INT(1), `pactualizar` INT(1), `pconsultar` INT(1), `pcreadopor` VARCHAR(15))  begin

	

	if exists(select TBL_MS_ROLES_id_rol from tbl_ms_permisos where TBL_MS_ROLES_id_rol = prol and TBL_MS_OBJETOS_id_objeto = pobjeto) then 

	select 1 as codigo,'No pueden existir valores duplicados' as mensaje;



	ELSE

start transaction;

		insert into tbl_ms_permisos (TBL_MS_ROLES_id_rol,TBL_MS_OBJETOS_id_objeto,permiso_insercion,permiso_eliminacion,permiso_actualizacion,permiso_consultar,creado_por,fecha_creacion)

				values(prol,pobjeto,pinsertar,peliminar,pactualizar,pconsultar,pcreadopor,curdate());

			commit;

		

		  select 0 as codigo,'Se ha creado correctamente' as mensaje;

		 end if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_Permisos_Mostrar` ()  begin

	SELECT p.id_permiso, p.TBL_MS_ROLES_id_rol AS roll, p.TBL_MS_OBJETOS_id_objeto AS obj ,r.rol,o.objeto,p.permiso_insercion,

	p.permiso_eliminacion,p.permiso_actualizacion,p.permiso_consultar,

	p.creado_por AS creado, p.modificado_por AS modificado, p.fecha_creacion AS fech_crea , 

	p.fecha_modificacion AS fech_mod

	

	from tbl_ms_permisos p join tbl_ms_roles r on p.TBL_MS_ROLES_id_rol = r.id_rol 

	join tbl_ms_objetos o on p.TBL_MS_OBJETOS_id_objeto = o.id_objeto;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_ProductosEliminar` (IN `Pid` INT)  begin
 delete from tbl_productos where id_producto = Pid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_ProveedorEliminar` (IN `Pid` INT)  begin
 delete from tbl_proveedores where id_proveedor = Pid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_Roles_Actualizar` (IN `pcod` INT(11), IN `prol` VARCHAR(30), IN `pdescripcion` VARCHAR(100), IN `pmodificado` VARCHAR(15))  begin

	start transaction;

	update tbl_ms_roles set rol = prol, descripcion = pdescripcion, modificado_por = pmodificado, fecha_modificacion = curdate() where id_rol = pcod; 

	commit;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_Roles_Insertar` (IN `prol` VARCHAR(30), IN `pdescripcion` VARCHAR(100), IN `pcreado` VARCHAR(15))  begin

	start transaction;

	insert into tbl_ms_roles(rol,descripcion,fecha_creacion,creado_por) Values(prol,pdescripcion,curdate(),pcreado);

	commit;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_Roles_Mostrar` ()  begin

	select * from tbl_ms_roles;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_UsuariosEliminar` (IN `Pid` INT)  begin
	delete from tbl_ms_usuario where id_usuario = Pid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_UsuariosInsertar` (IN `pusuario` VARCHAR(50), IN `pidestado` INT, IN `Ppasswordd` VARCHAR(100), IN `pNom_persona` VARCHAR(50), IN `pApellido` VARCHAR(50), IN `pSexo` ENUM('F','M'), IN `Pcorreo` VARCHAR(50), IN `PcodRol` BIGINT, IN `pcreadopor` VARCHAR(15), IN `pUsr_registro` VARCHAR(50))  BEGIN

  declare num int;
  declare limite int;
  declare vigencia_dias int;
  declare vigencia int;

    if exists(SELECT * from tbl_ms_usuario where correo_usuario = pCorreo)then
    select 1 as codigo, 'Ya existe un usuario con este correo' as mensaje;
    ELSE 
    start transaction;

    set num = (select valor from tbl_ms_parametros where parametro = 'ADMIN_INTENTOS');
    set limite = (select valor from tbl_ms_parametros where parametro = 'ADMIN_VIGENCIA_USUARIO_DIAS');
	set vigencia_dias = (select curdate() + INTERVAL limite day); 
    set vigencia = (SELECT DATEDIFF(vigencia_dias, curdate()));

   
  insert into tbl_ms_usuario (usuario,id_estado_usuario ,contrasena ,nombre_usuario ,apellido_usuario 
  ,genero_usuario ,correo_usuario ,TBL_MS_ROLES_id_rol ,fecha_creacion ,creado_por,fecha_vencimiento,primer_ingreso)
 values (pusuario,pidestado,Ppasswordd,pNom_persona ,pApellido,pSexo,UPPER(Pcorreo),PcodRol,curdate(),pcreadopor,curdate(),0);

 

  COMMIT;

  select 0 as codigo, 'Se ha registrado correctamente' as mensaje;

 end if;

 end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTbl_ms_UsuariosInsertaraA` (IN `pusuario` VARCHAR(50), IN `pidestado` INT, IN `Ppasswordd` VARCHAR(100), IN `pNom_persona` VARCHAR(50), IN `pApellido` VARCHAR(50), IN `pSexo` ENUM('F','M'), IN `Pcorreo` VARCHAR(50), IN `PcodRol` BIGINT, IN `pcreadopor` VARCHAR(15))  begin
	
  declare num int;
  declare limite int;
  declare vigencia_dias int;
  declare vigencia int;

    if exists(SELECT * from tbl_ms_usuario where correo_usuario = pCorreo)then
    select 1 as codigo, 'Ya existe un usuario con este correo' as mensaje;
    end if;
   
    if exists(SELECT * from tbl_ms_usuario where usuario = pusuario)then
    select 1 as codigo, 'Ya existe un usuario con este nombre' as mensaje;
    end if;
   
    start transaction;

    set num = (select valor from tbl_ms_parametros where parametro = 'ADMIN_INTENTOS');
    set limite = (select valor from tbl_ms_parametros where parametro = 'ADMIN_VIGENCIA_USUARIO_DIAS');
	set vigencia_dias = (select curdate() + INTERVAL limite day); 
    set vigencia = (SELECT DATEDIFF(vigencia_dias, curdate()));

   
  insert into tbl_ms_usuario (usuario,id_estado_usuario ,contrasena ,nombre_usuario ,apellido_usuario 
  ,genero_usuario ,correo_usuario ,TBL_MS_ROLES_id_rol ,fecha_creacion ,creado_por,fecha_vencimiento,primer_ingreso)
 values (pusuario,pidestado,Ppasswordd,pNom_persona ,pApellido,pSexo,UPPER(Pcorreo),PcodRol,curdate(),pcreadopor,curdate(),0);

 

  COMMIT;

  select 0 as codigo, 'Se ha registrado correctamente' as mensaje;

 
 end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tt` ()  BEGIN
 select * from tbl_ms_preguntas;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_categoria`
--

CREATE TABLE `tbl_categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(30) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `creado_por` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_categoria`
--

INSERT INTO `tbl_categoria` (`id_categoria`, `nombre_categoria`, `fecha_creacion`, `creado_por`) VALUES
(13, 'hj', '2021-05-26 21:30:17', NULL),
(14, 'aaa', '2021-05-26 21:30:46', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_clientes`
--

CREATE TABLE `tbl_clientes` (
  `id_cliente` int(11) NOT NULL,
  `DNI` varchar(20) NOT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `telefono_cliente` int(11) NOT NULL,
  `direccion_cliente` varchar(100) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_compras`
--

CREATE TABLE `tbl_compras` (
  `id_compra` int(11) NOT NULL,
  `desc_compra` varchar(100) NOT NULL,
  `fecha_orden` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `cantidad_compra` int(11) NOT NULL,
  `cantidad_recibida` int(11) NOT NULL,
  `TBL_PROVEEDORES_id_proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detalle_venta`
--

CREATE TABLE `tbl_detalle_venta` (
  `id_detalle_venta` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_devoluciones`
--

CREATE TABLE `tbl_devoluciones` (
  `id_devolucion` int(11) NOT NULL,
  `cantidad_dev` int(11) NOT NULL,
  `TBL_PRODUCTOS_id_producto` int(11) NOT NULL,
  `TBL_KARDEX_id_kardex` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_kardex`
--

CREATE TABLE `tbl_kardex` (
  `id_kardex` int(11) NOT NULL,
  `cantidad_kardex` int(11) NOT NULL,
  `precio` decimal(9,2) NOT NULL,
  `fecha_kardex` datetime NOT NULL DEFAULT current_timestamp(),
  `id_producto` int(11) NOT NULL,
  `id_tipo_kardex` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_bitacora`
--

CREATE TABLE `tbl_ms_bitacora` (
  `id_bitacora` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `TBL_MS_USUARIO_id_usuario` int(11) NOT NULL,
  `TBL_MS_OBJETOS_id_objeto` int(11) NOT NULL,
  `accion` varchar(20) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `creado_por` varchar(15) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `modificado_por` varchar(15) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_ms_bitacora`
--

INSERT INTO `tbl_ms_bitacora` (`id_bitacora`, `fecha`, `TBL_MS_USUARIO_id_usuario`, `TBL_MS_OBJETOS_id_objeto`, `accion`, `descripcion`, `creado_por`, `fecha_creacion`, `modificado_por`, `fecha_modificacion`) VALUES
(2647, '2021-05-05', 1, 39, 'Ingreso', 'Ingreso a módulo de Productos', NULL, '2021-05-05', NULL, NULL),
(2648, '2021-05-05', 1, 44, 'Ingreso', 'Ingreso a módulo de Productos', NULL, '2021-05-05', NULL, NULL),
(2649, '2021-05-05', 1, 44, 'Ingreso', 'Ingreso a módulo de inventario', NULL, '2021-05-05', NULL, NULL),
(2650, '2021-05-05', 1, 44, 'Ingreso', 'Ingreso a módulo de usuarios', NULL, '2021-05-05', NULL, NULL),
(2651, '2021-05-05', 36, 8, 'Ingreso', 'Ingreso a creación de usuario por administración', NULL, '2021-05-05', NULL, NULL),
(2652, '2021-05-05', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-05', NULL, NULL),
(2653, '2021-05-05', 1, 44, 'Ingreso', 'Ingreso a módulo de Productos', NULL, '2021-05-05', NULL, NULL),
(2654, '2021-05-05', 1, 44, 'Ingreso', 'Ingreso a módulo de Productos', NULL, '2021-05-05', NULL, NULL),
(2655, '2021-05-05', 1, 44, 'Ingreso', 'Ingreso a módulo de Productos', NULL, '2021-05-05', NULL, NULL),
(2656, '0000-00-00', 2, 12, 'Ingreso', 'Ingreso a módulo de roles', NULL, '2021-05-05', NULL, NULL),
(2657, '2021-05-05', 1, 12, 'Ingreso', 'Ingreso a módulo de Productos', NULL, '2021-05-05', NULL, NULL),
(2658, '2021-05-24', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-24', NULL, NULL),
(2660, '2021-05-26', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-26', NULL, NULL),
(2661, '0000-00-00', 2, 13, 'Ingreso', 'Ingreso a módulo de permisos', NULL, '2021-05-26', NULL, NULL),
(2662, '0000-00-00', 2, 13, 'Ingreso', 'Ingreso a módulo de permisos', NULL, '2021-05-26', NULL, NULL),
(2663, '0000-00-00', 2, 13, 'Ingreso', 'Ingreso a módulo de permisos', NULL, '2021-05-26', NULL, NULL),
(2664, '0000-00-00', 2, 13, 'Ingreso', 'Ingreso a módulo de permisos', NULL, '2021-05-26', NULL, NULL),
(2665, '2021-05-26', 2, 8, 'Ingreso', 'Ingreso a módulo de permisos por Admin', NULL, '2021-05-26', NULL, NULL),
(2666, '2021-05-26', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-26', NULL, NULL),
(2667, '2021-05-26', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-26', NULL, NULL),
(2668, '2021-05-26', 2, 8, 'Ingreso', 'Ingreso a módulo de permisos por Admin', NULL, '2021-05-26', NULL, NULL),
(2669, '2021-05-26', 2, 8, 'Ingreso', 'Ingreso a módulo de permisos por Admin', NULL, '2021-05-26', NULL, NULL),
(2670, '2021-05-26', 1, 13, 'Ingreso', 'Ingreso a módulo de Productos', NULL, '2021-05-26', NULL, NULL),
(2671, '2021-05-26', 2, 8, 'Ingreso', 'Ingreso a módulo de permisos por Admin', NULL, '2021-05-26', NULL, NULL),
(2672, '2021-05-26', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-26', NULL, NULL),
(2673, '2021-05-26', 1, 44, 'Ingreso', 'Ingreso a módulo de Productos', NULL, '2021-05-26', NULL, NULL),
(2674, '2021-05-26', 1, 39, 'Ingreso', 'Ingreso a módulo de Productos', NULL, '2021-05-26', NULL, NULL),
(2675, '2021-05-26', 2, 38, 'Ingreso', 'Ingreso a creación de productos por administración', NULL, '2021-05-26', NULL, NULL),
(2676, '2021-05-26', 1, 44, 'Ingreso', 'Ingreso a módulo de Productos', NULL, '2021-05-26', NULL, NULL),
(2677, '2021-05-26', 1, 44, 'Ingreso', 'Ingreso a módulo de Productos', NULL, '2021-05-26', NULL, NULL),
(2678, '2021-05-26', 1, 44, 'Ingreso', 'Ingreso a módulo de Productos', NULL, '2021-05-26', NULL, NULL),
(2679, '2021-05-26', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-26', NULL, NULL),
(2680, '2021-05-26', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-26', NULL, NULL),
(2681, '2021-05-27', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-27', NULL, NULL),
(2682, '2021-05-29', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-29', NULL, NULL),
(2684, '2021-05-29', 2, 8, 'Ingreso', 'Ingreso a creación de usuario por administración', NULL, '2021-05-29', NULL, NULL),
(2685, '0000-00-00', 2, 12, 'Ingreso', 'Ingreso a módulo de roles', NULL, '2021-05-29', NULL, NULL),
(2686, '2021-05-29', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-29', NULL, NULL),
(2687, '2021-05-29', 1, 36, 'Ingreso', 'Ingreso a módulo de usuarios', NULL, '2021-05-29', NULL, NULL),
(2688, '2021-05-29', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-29', NULL, NULL),
(2689, '2021-05-31', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-31', NULL, NULL),
(2690, '2021-05-31', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-05-31', NULL, NULL),
(2691, '2021-05-31', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-31', NULL, NULL),
(2692, '2021-05-31', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-05-31', NULL, NULL),
(2693, '2021-05-31', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-31', NULL, NULL),
(2694, '2021-05-31', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-31', NULL, NULL),
(2695, '2021-05-31', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-31', NULL, NULL),
(2696, '2021-05-31', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-31', NULL, NULL),
(2697, '2021-05-31', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-05-31', NULL, NULL),
(2698, '2021-05-31', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-31', NULL, NULL),
(2699, '2021-05-31', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-05-31', NULL, NULL),
(2700, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2701, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2702, '0000-00-00', 2, 12, 'Ingreso', 'Ingreso a módulo de roles', NULL, '2021-06-02', NULL, NULL),
(2703, '2021-06-02', 2, 8, 'Ingreso', 'Ingreso a módulo de permisos por Admin', NULL, '2021-06-02', NULL, NULL),
(2704, '0000-00-00', 2, 13, 'Ingreso', 'Ingreso a módulo de permisos', NULL, '2021-06-02', NULL, NULL),
(2705, '2021-06-02', 1, 13, 'Ingreso', 'Ingreso a módulo de usuarios', NULL, '2021-06-02', NULL, NULL),
(2706, '2021-06-02', 1, 13, 'Ingreso', 'Ingreso a módulo de usuarios', NULL, '2021-06-02', NULL, NULL),
(2707, '2021-06-02', 2, 9, 'Ingreso', 'Ingreso a edición de usuarios por administración', NULL, '2021-06-02', NULL, NULL),
(2708, '2021-06-02', 2, 7, 'Actualizo', 'Actualizo Usuario', NULL, '2021-06-02', NULL, NULL),
(2709, '2021-06-02', 1, 13, 'Ingreso', 'Ingreso a módulo de usuarios', NULL, '2021-06-02', NULL, NULL),
(2710, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2711, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2712, '2021-06-02', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-02', NULL, NULL),
(2713, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2714, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2715, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2716, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2717, '2021-06-02', 2, 8, 'Ingreso', 'Ingreso a módulo de permisos por Admin', NULL, '2021-06-02', NULL, NULL),
(2718, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2719, '2021-06-02', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-02', NULL, NULL),
(2720, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2721, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2722, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2723, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2724, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2725, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2726, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2727, '2021-06-02', 2, 8, 'Ingreso', 'Ingreso a módulo de permisos por Admin', NULL, '2021-06-02', NULL, NULL),
(2728, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2729, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2730, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2731, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2732, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2733, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2734, '2021-06-02', 1, 39, 'Ingreso', 'Ingreso a módulo de Productos', NULL, '2021-06-02', NULL, NULL),
(2735, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2736, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2737, '2021-06-02', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-02', NULL, NULL),
(2738, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2739, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2740, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2741, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2742, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2743, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2744, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2745, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2746, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2747, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2748, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2749, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2750, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2751, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2752, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2753, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2754, '2021-06-02', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-02', NULL, NULL),
(2755, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2756, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2757, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2758, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2759, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2760, '2021-06-02', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-02', NULL, NULL),
(2761, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2762, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2763, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2764, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2765, '2021-06-03', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-03', NULL, NULL),
(2766, '2021-06-03', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-03', NULL, NULL),
(2767, '2021-06-03', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-03', NULL, NULL),
(2768, '2021-06-03', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-03', NULL, NULL),
(2769, '2021-06-03', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-03', NULL, NULL),
(2770, '2021-06-03', 1, 5, 'Ingreso', 'Ingreso a restablecer contraseña por correo', NULL, '2021-06-03', NULL, NULL),
(2771, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2772, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2773, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2774, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2775, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2776, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2777, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2778, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2779, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2780, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2781, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2782, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2783, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2784, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2785, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2786, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2787, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2788, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2789, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2790, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2791, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2792, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2793, '2021-06-03', 1, 6, 'Ingreso', 'Ingreso a restablecer contraseña por pregunta', NULL, '2021-06-03', NULL, NULL),
(2794, '2021-06-03', 1, 6, 'Ingreso', 'Ingreso a restablecer contraseña por pregunta', NULL, '2021-06-03', NULL, NULL),
(2795, '2021-06-03', 1, 6, 'Ingreso', 'Ingreso a restablecer contraseña por pregunta', NULL, '2021-06-03', NULL, NULL),
(2796, '2021-06-03', 1, 6, 'Ingreso', 'Ingreso a restablecer contraseña por pregunta', NULL, '2021-06-03', NULL, NULL),
(2797, '2021-06-03', 1, 6, 'Ingreso', 'Ingreso a restablecer contraseña por pregunta', NULL, '2021-06-03', NULL, NULL),
(2798, '2021-06-03', 1, 6, 'Ingreso', 'Ingreso a restablecer contraseña por pregunta', NULL, '2021-06-03', NULL, NULL),
(2799, '2021-06-03', 1, 6, 'Ingreso', 'Ingreso a restablecer contraseña por pregunta', NULL, '2021-06-03', NULL, NULL),
(2800, '2021-06-03', 1, 6, 'Ingreso', 'Ingreso a restablecer contraseña por pregunta', NULL, '2021-06-03', NULL, NULL),
(2801, '2021-06-03', 1, 6, 'Ingreso', 'Ingreso a restablecer contraseña por pregunta', NULL, '2021-06-03', NULL, NULL),
(2802, '2021-06-03', 1, 6, 'Ingreso', 'Ingreso a restablecer contraseña por pregunta', NULL, '2021-06-03', NULL, NULL),
(2803, '2021-06-03', 1, 6, 'Ingreso', 'Ingreso a restablecer contraseña por pregunta', NULL, '2021-06-03', NULL, NULL),
(2804, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2805, '2021-06-03', 1, 6, 'Ingreso', 'Ingreso a restablecer contraseña por pregunta', NULL, '2021-06-03', NULL, NULL),
(2806, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2807, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2808, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2809, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2810, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2811, '2021-06-03', 1, 6, 'Ingreso', 'Ingreso a restablecer contraseña por pregunta', NULL, '2021-06-03', NULL, NULL),
(2812, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2813, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2814, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2815, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2816, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2817, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2818, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2819, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2820, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2821, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2822, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2823, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2824, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2825, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2826, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2827, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2828, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2829, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2830, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2831, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2832, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2833, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2834, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2835, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2836, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2837, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2838, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2839, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2840, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2841, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2842, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2843, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2844, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2845, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2846, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2847, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2848, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2849, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2850, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2851, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2852, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2853, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2854, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2855, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2856, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2857, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2858, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2859, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2860, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2861, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2862, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2863, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2864, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2865, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2866, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2867, '2021-06-03', 1, 2, 'Ingreso', 'Ingreso a recuperación por correo', NULL, '2021-06-03', NULL, NULL),
(2868, '2021-06-03', 1, 3, 'Ingreso', 'Ingreso a recuperación por pregunta', NULL, '2021-06-03', NULL, NULL),
(2869, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2870, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2871, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2873, '2021-06-03', 2, 9, 'Ingreso', 'Ingreso a edición de usuarios por administración', NULL, '2021-06-03', NULL, NULL),
(2874, '2021-06-03', 2, 7, 'Actualizo', 'Actualizo Usuario', NULL, '2021-06-03', NULL, NULL),
(2876, '2021-06-03', 2, 9, 'Ingreso', 'Ingreso a edición de usuarios por administración', NULL, '2021-06-03', NULL, NULL),
(2877, '2021-06-03', 2, 7, 'Actualizo', 'Actualizo Usuario', NULL, '2021-06-03', NULL, NULL),
(2879, '2021-06-03', 2, 8, 'Ingreso', 'Ingreso a creación de usuario por administración', NULL, '2021-06-03', NULL, NULL),
(2881, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2882, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2883, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2884, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2885, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2886, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2887, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2888, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2889, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2890, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2891, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2892, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2893, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2894, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2895, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2896, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2897, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2898, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2899, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2900, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2901, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2902, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2903, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2904, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2905, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2906, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2907, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2908, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2909, '2021-06-03', 1, 1, 'Ingreso', 'Ingreso a iniciar sesión', NULL, '2021-06-03', NULL, NULL),
(2910, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2911, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2912, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL),
(2913, '2021-06-03', 1, 4, 'Ingreso', 'Ingreso a Autoregistro', NULL, '2021-06-03', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_estado_usuario`
--

CREATE TABLE `tbl_ms_estado_usuario` (
  `id_estado_usuario` int(11) NOT NULL,
  `descripcion` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_ms_estado_usuario`
--

INSERT INTO `tbl_ms_estado_usuario` (`id_estado_usuario`, `descripcion`) VALUES
(1, 'Activo'),
(2, 'Inactivo'),
(3, 'Desactivado'),
(4, 'Nuevo'),
(5, 'Bloqueado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_hist_contraseña`
--

CREATE TABLE `tbl_ms_hist_contraseña` (
  `id_hist` int(11) NOT NULL,
  `TBL_MS_USUARIO_id_usuario` int(11) NOT NULL,
  `contraseña` varchar(100) NOT NULL,
  `creado_por` varchar(15) DEFAULT NULL,
  `fecha_creacion` varchar(45) DEFAULT NULL,
  `modificado_por` varchar(15) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_objetos`
--

CREATE TABLE `tbl_ms_objetos` (
  `id_objeto` int(11) NOT NULL,
  `objeto` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `tipo_objeto` varchar(15) NOT NULL,
  `idPadre` int(11) DEFAULT NULL,
  `icono` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `creado_por` varchar(15) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `modificado_por` varchar(15) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_ms_objetos`
--

INSERT INTO `tbl_ms_objetos` (`id_objeto`, `objeto`, `descripcion`, `tipo_objeto`, `idPadre`, `icono`, `url`, `creado_por`, `estado`, `fecha_creacion`, `modificado_por`, `fecha_modificacion`) VALUES
(1, 'Login', 'Inicio sesión', 'Módulo', 0, NULL, NULL, NULL, 'desactivado', NULL, NULL, NULL),
(2, 'Recuperación por Correo', 'Método de seguridad', 'Módulo', 0, NULL, NULL, NULL, 'desactivado', NULL, NULL, NULL),
(3, 'Recuperación por pregunta secreta', 'Método de seguridad', 'Módulo', 0, NULL, NULL, NULL, 'desactivado', NULL, NULL, NULL),
(4, 'Autoregistro', 'Creación propia de un perfil', 'Módulo', 0, NULL, NULL, NULL, 'desactivado', NULL, NULL, NULL),
(5, 'Restablecer contraseña por correo', 'Método de seguridad', 'Módulo', 0, NULL, NULL, NULL, 'desactivado', NULL, NULL, NULL),
(6, 'Restablecer contraseña por pregunta', 'Método de seguridad', 'Módulo', 0, NULL, NULL, NULL, 'desactivado', NULL, NULL, NULL),
(7, 'Usuarios', 'Vista usuarios', 'Modulo', 10, 'fa fa-users', 'Admin/usuarios', NULL, 'activo', NULL, NULL, NULL),
(8, 'Creacion de usuario', 'Crear usuario', 'Modulo', 0, NULL, NULL, NULL, 'desactivado', NULL, NULL, NULL),
(9, 'Actualizar usuario', 'Editar usuario', 'Modulo', 0, NULL, NULL, NULL, 'desactivado', NULL, NULL, NULL),
(10, 'Mantenimiento', 'mantenimiento del sistema', 'Modulo', 0, 'fa fa-archive', NULL, 'Admin', 'activo', NULL, NULL, NULL),
(11, 'Seguridad', 'Seguridad del sistema', 'Modulo', 0, 'fas fa-shield-alt', NULL, 'Admin', 'activo', NULL, NULL, NULL),
(12, 'Roles', 'Roles de los usuarios', 'Módulo', 11, 'fas fa-user-shield', 'Admin/roles', 'Admin', 'activo', NULL, NULL, NULL),
(13, 'Permisos', 'Permisos de los modulos para los usuarios', 'Módulo', 11, 'fas fa-door-closed', 'Admin/permisos', 'Admin', 'activo', NULL, NULL, NULL),
(14, 'Objetos', 'Menus ', 'Modulo', 11, 'fa fa-bookmark', 'Admin/objetos', NULL, 'activo', NULL, 'ROOT', '2021-03-25'),
(23, 'Bitacora', 'Modulo de bitacora', 'Modulo', 11, 'fa fa-users', 'Admin/BitacoraList', 'ROOT', 'activo', '2021-03-17', NULL, NULL),
(29, 'Clientes', 'Modulo de clientes', 'Modulo', 0, 'fa fa-users', '', 'ROOT', 'activo', '2021-03-22', NULL, NULL),
(30, 'Clientes', 'Modulo de clientes', 'Modulo', 29, 'fa fa-users', 'Admin/Clientes', 'ROOT', 'activo', '2021-03-22', 'ROOT', '2021-03-26'),
(32, 'Proveedores', 'Modulo de Proveedores', 'Modulo', 0, 'fa fa-truck', '', 'ROOT', 'activo', '2021-03-25', NULL, NULL),
(33, 'Proveedores', 'Modulo de Proveedores', 'Modulo', 32, 'fa fa-truck', 'Admin/proveedores', 'ROOT', 'activo', '2021-03-25', NULL, NULL),
(34, 'Ventas', 'Modulo de venta', 'Modulo', 0, 'fa fa-money', '', 'ROOT', 'activo', '2021-03-25', NULL, NULL),
(35, 'Ventas', 'Modulo de venta', 'Modulo', 34, 'fa fa-bars', 'Admin/Ventas', 'ROOT', 'activo', '2021-03-25', NULL, NULL),
(36, 'Nueva Venta', 'Modulo de Nueva venta', 'Modulo', 34, 'fa fa-plus', 'Admin/VentasNew', 'ROOT', 'activo', '2021-03-25', 'ROOT', '2021-03-25'),
(37, 'Nuevo Proveedor', 'Modulo de nuevo proveedor', 'Modulo', 32, 'fas fa-user-plus', 'Admin/proveedoresnew', 'ROOT', 'activo', '2021-03-25', NULL, NULL),
(38, 'Productos', 'Modulo de productos', 'Modulo', 0, 'fa fa-cubes', '', 'ROOT', 'activo', '2021-03-25', NULL, NULL),
(39, 'Productos ', 'Lista de productos ', 'Modulo', 38, 'fa fa-bars', 'Admin/Productos', 'ROOT', 'activo', '2021-03-25', NULL, NULL),
(40, 'Nuevo producto', 'Nuevo producto', 'Modulo', 38, 'fa fa-plus', 'Admin/productosnew', 'ROOT', 'activo', '2021-03-25', NULL, NULL),
(41, 'Nuevo Cliente', 'Crear nuevo cliente', 'Modulo', 29, 'fas fa-user-plus', 'Admin/clientesnew', 'ROOT', 'activo', '2021-03-26', NULL, NULL),
(43, 'Actualizar Contraseña', 'Pantallapara actualizar contra', 'Modulo', 10, 'fas fa-ui', 'Admin/ActualizarContra', 'ROOT', 'activo', '2021-04-05', 'ROOT', '2021-04-05'),
(44, 'Categoría productos', 'Modulo de productos', 'Modulo', 38, 'fa fa-bars', 'Admin/Categoria', 'ROOT', 'activo', '2021-04-06', NULL, NULL),
(48, 'Inventario', 'Modulo de clientes', 'Modulo', 0, 'fa fa-bar-chart', '', 'ROOT', 'activo', '2021-04-18', NULL, NULL),
(49, 'Generar compra', 'Modulo de inventario', 'Modulo', 50, 'fa fa-plus', 'Admin/inventario', 'ROOT', 'activo', '2021-04-18', NULL, NULL),
(50, 'Compras', 'Modulo de compras', 'Modulo', 0, 'fa fa-tags', '', 'ROOT', 'activo', '2021-04-18', NULL, NULL),
(51, 'Nueva compra', 'Modulo de compras', 'Modulo', 50, 'fa fa-plus', 'Admin/compras', 'ROOT', 'activo', '2021-04-18', 'ROOT', '2021-04-18'),
(52, 'Compras', 'Modulo de compras', 'Modulo', 50, 'fa fa-bars', 'admin/compraslist', 'ROOT', 'activo', '2021-04-18', NULL, NULL),
(53, 'Respaldo', 'Modulo de backup', 'Modulo', 0, 'fa fa-cloud', '', 'ROOT', 'activo', '2021-04-18', NULL, NULL),
(55, 'Inventario Disponible', 'Modulo de inventario', 'Modulo', 48, 'fa fa-balance', 'admin/inventariolista', 'ROOT', 'activo', '2021-04-19', 'ROOT', '2021-04-19'),
(56, 'Backup ', 'Modulo de Backup', 'Modulo', 53, 'fa fa-cloud-upload', 'admin/backup', 'ROOT', 'activo', '2021-04-19', 'ROOT', '2021-04-20'),
(58, 'Restore', 'Modulo de Backup', 'Modulo', 53, 'fa fa-cloud-download', 'admin/restore', 'ROOT', 'activo', '2021-04-20', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_parametros`
--

CREATE TABLE `tbl_ms_parametros` (
  `id_parametro` int(11) NOT NULL,
  `parametro` varchar(50) NOT NULL,
  `valor` varchar(100) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `creado_por` varchar(15) DEFAULT NULL,
  `modificado_por` varchar(15) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  `TBL_MS_USUARIO_id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_ms_parametros`
--

INSERT INTO `tbl_ms_parametros` (`id_parametro`, `parametro`, `valor`, `fecha_creacion`, `creado_por`, `modificado_por`, `fecha_modificacion`, `TBL_MS_USUARIO_id_usuario`) VALUES
(1, 'Correo_host', 'smtp.gmail.com', '2021-02-22', NULL, NULL, NULL, 1),
(2, 'Correo_usuario', 'variedadesotac@gmail.com', '2021-02-22', NULL, NULL, NULL, 1),
(3, 'Correo_contraseña', 'VOtac2021', '2021-02-22', NULL, NULL, NULL, 1),
(4, 'Correo_tipo_smtp', 'TLS', '2021-02-22', NULL, NULL, NULL, 1),
(5, 'Correo_puerto', '587', '2021-02-22', NULL, NULL, NULL, 1),
(6, 'Correo_nombre', 'Solutions Team', NULL, NULL, NULL, NULL, 1),
(7, 'Correo_horas_token', '24', NULL, NULL, NULL, NULL, 1),
(8, 'ADMIN_INTENTOS', '3', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_permisos`
--

CREATE TABLE `tbl_ms_permisos` (
  `id_permiso` int(11) NOT NULL,
  `TBL_MS_ROLES_id_rol` int(11) DEFAULT NULL,
  `TBL_MS_OBJETOS_id_objeto` int(11) DEFAULT NULL,
  `permiso_insercion` int(11) DEFAULT NULL,
  `permiso_eliminacion` int(11) DEFAULT NULL,
  `permiso_actualizacion` int(11) DEFAULT NULL,
  `permiso_consultar` int(11) DEFAULT NULL,
  `creado_por` varchar(15) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `modificado_por` varchar(15) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_ms_permisos`
--

INSERT INTO `tbl_ms_permisos` (`id_permiso`, `TBL_MS_ROLES_id_rol`, `TBL_MS_OBJETOS_id_objeto`, `permiso_insercion`, `permiso_eliminacion`, `permiso_actualizacion`, `permiso_consultar`, `creado_por`, `fecha_creacion`, `modificado_por`, `fecha_modificacion`) VALUES
(6, 2, 11, 1, 1, 1, 1, 'Admin', NULL, 'ROOT', '2021-03-15'),
(7, 2, 12, 1, 1, 1, 1, 'Admin', NULL, 'ROOT', '2021-03-15'),
(8, 2, 13, 1, 1, 1, 1, 'Admin', NULL, 'ROOT', '2021-03-15'),
(9, 1, 4, 1, 0, 1, 1, 'ROOT', '2021-03-12', 'ROOT', '2021-03-13'),
(10, 1, 2, 1, 1, 0, 1, 'ROOT', '2021-03-12', 'ROOT', '2021-03-14'),
(11, 3, 11, 0, 0, 1, 0, 'ROOT', '2021-03-13', 'ROOT', '2021-03-13'),
(18, 2, 7, 1, 1, 1, 1, 'ROOT', '2021-03-13', NULL, NULL),
(19, 2, 14, 1, 1, 1, 1, 'ROOT', '2021-03-13', 'ROOT', '2021-03-15'),
(23, 4, 9, 1, 1, 1, 1, 'ROOT', '2021-03-13', NULL, NULL),
(24, 1, 9, 1, 0, 1, 1, 'ROOT', '2021-03-13', 'ROOT', '2021-03-14'),
(25, 4, 10, 1, 1, 1, 0, 'ROOT', '2021-03-13', NULL, NULL),
(26, 4, 14, 0, 0, 0, 1, 'ROOT', '2021-03-13', NULL, NULL),
(27, 4, 13, 0, 0, 0, 0, 'ROOT', '2021-03-13', NULL, NULL),
(28, 4, 12, 0, 0, 0, 0, 'ROOT', '2021-03-13', NULL, NULL),
(29, 3, 2, 1, 1, 1, 0, 'ROOT', '2021-03-13', NULL, NULL),
(30, 3, 14, 1, 1, 0, 0, 'ROOT', '2021-03-13', NULL, NULL),
(31, 3, 13, 0, 0, 0, 0, 'ROOT', '2021-03-13', 'ROOT', '2021-03-17'),
(32, 3, 10, 1, 1, 0, 1, 'ROOT', '2021-03-13', NULL, NULL),
(34, 4, 10, 1, 1, 1, 1, 'ROOT', '2021-03-14', 'ROOT', '2021-03-14'),
(37, 2, 23, 1, 1, 1, 1, 'ROOT', '2021-03-17', NULL, NULL),
(38, 3, 23, 0, 0, 0, 1, 'ROOT', '2021-03-17', NULL, NULL),
(42, 2, 30, 1, 1, 1, 1, 'ROOT', '2021-03-22', NULL, NULL),
(46, 2, 33, 1, 1, 1, 1, 'ROOT', '2021-03-25', NULL, NULL),
(47, 2, 35, 1, 1, 1, 1, 'ROOT', '2021-03-25', NULL, NULL),
(48, 2, 36, 1, 1, 1, 1, 'ROOT', '2021-03-25', NULL, NULL),
(49, 2, 37, 1, 1, 1, 1, 'ROOT', '2021-03-25', NULL, NULL),
(50, 2, 39, 1, 1, 1, 1, 'ROOT', '2021-03-25', NULL, NULL),
(51, 2, 40, 1, 1, 1, 1, 'ROOT', '2021-03-25', NULL, NULL),
(52, 2, 41, 1, 1, 1, 1, 'ROOT', '2021-03-26', NULL, NULL),
(53, 3, 30, 1, 1, 1, 1, 'ROOT', '2021-03-26', NULL, NULL),
(55, 2, 44, 1, 1, 1, 1, 'ROOT', '2021-04-06', NULL, NULL),
(57, 2, 49, 1, 1, 1, 1, 'ROOT', '2021-04-18', NULL, NULL),
(61, 2, 55, 1, 1, 1, 1, 'ROOT', '2021-04-19', NULL, NULL),
(62, 2, 56, 1, 1, 1, 1, 'ROOT', '2021-04-19', NULL, NULL),
(63, 2, 58, 1, 1, 1, 1, 'ROOT', '2021-04-20', NULL, NULL),
(65, 3, 39, 1, 1, 1, 1, 'ROOT', '2021-04-29', NULL, NULL),
(66, 3, 33, 1, 1, 1, 1, 'ROOT', '2021-05-05', NULL, NULL),
(67, 3, 35, 1, 1, 1, 1, 'ROOT', '2021-05-05', NULL, NULL),
(68, 3, 36, 1, 1, 1, 1, 'ROOT', '2021-05-05', NULL, NULL),
(69, 3, 37, 1, 1, 1, 1, 'ROOT', '2021-05-05', NULL, NULL),
(70, 3, 41, 1, 1, 1, 1, 'ROOT', '2021-05-05', NULL, NULL),
(71, 3, 48, 1, 1, 1, 1, 'ROOT', '2021-05-05', NULL, NULL),
(72, 3, 44, 1, 1, 1, 1, 'ROOT', '2021-05-05', NULL, NULL),
(73, 3, 55, 1, 1, 1, 1, 'ROOT', '2021-05-05', NULL, NULL),
(74, 3, 40, 1, 1, 1, 1, 'ROOT', '2021-05-05', NULL, NULL),
(75, 3, 49, 1, 1, 1, 1, 'ROOT', '2021-05-05', NULL, NULL),
(76, 3, 56, 1, 1, 1, 1, 'ROOT', '2021-05-05', NULL, NULL),
(77, 2, 43, 1, 1, 1, 1, 'ROOT', '2021-05-26', NULL, NULL),
(78, 6, 49, 1, 1, 1, 1, 'ROOT', '2021-06-02', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_preguntas`
--

CREATE TABLE `tbl_ms_preguntas` (
  `id_pregunta` int(11) NOT NULL,
  `pregunta` varchar(100) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `creado_por` varchar(15) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  `modificado_por` varchar(15) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_ms_preguntas`
--

INSERT INTO `tbl_ms_preguntas` (`id_pregunta`, `pregunta`, `fecha_creacion`, `creado_por`, `fecha_modificacion`, `modificado_por`, `estado`) VALUES
(1, '¿Cuál es tu color favorito?', NULL, NULL, NULL, NULL, 1),
(2, '¿Cuál es tu país favorito?', NULL, NULL, NULL, NULL, 1),
(3, '¿Cuál es el nombre de tu mascota?', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_preguntas_usuario`
--

CREATE TABLE `tbl_ms_preguntas_usuario` (
  `id_preguntas_usuario` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `respuesta` varchar(30) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_modificacion` date NOT NULL,
  `modificado_por` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_ms_preguntas_usuario`
--

INSERT INTO `tbl_ms_preguntas_usuario` (`id_preguntas_usuario`, `id_pregunta`, `id_usuario`, `respuesta`, `creado_por`, `fecha_creacion`, `fecha_modificacion`, `modificado_por`) VALUES
(16, 1, 27, 'AZUL', '27', '0000-00-00', '0000-00-00', '27'),
(17, 1, 29, 'ROJO', '29', '0000-00-00', '0000-00-00', '29'),
(18, 1, 30, 'ROJO', '30', '0000-00-00', '0000-00-00', '30'),
(19, 1, 31, 'ROJO', '31', '0000-00-00', '0000-00-00', '31'),
(20, 1, 33, 'ROJO', '33', '0000-00-00', '0000-00-00', '33'),
(21, 1, 34, 'ROJO', '34', '0000-00-00', '0000-00-00', '34'),
(22, 1, 35, 'ROJO', '35', '0000-00-00', '0000-00-00', '35'),
(23, 1, 36, 'VERDE', '36', '0000-00-00', '0000-00-00', '36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_roles`
--

CREATE TABLE `tbl_ms_roles` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(30) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `creado_por` varchar(15) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  `modificado_por` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_ms_roles`
--

INSERT INTO `tbl_ms_roles` (`id_rol`, `rol`, `descripcion`, `fecha_creacion`, `creado_por`, `fecha_modificacion`, `modificado_por`) VALUES
(1, 'Default', '.', '2021-02-22', NULL, '2021-03-25', 'ROOT'),
(2, 'Administrador', 'Usuario administrativo', '2021-02-22', NULL, '2021-03-13', 'ROOT'),
(3, 'GERENTE', 'Usuario de ventas', NULL, NULL, '2021-04-29', 'ROOT'),
(4, 'Ejecutivo', 'Usuario gerente', '2021-03-13', '', NULL, NULL),
(6, 'EMPLEADO', 'EMPLEADO DE EMPRESA ', '2021-04-29', ' ', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_token_usuario`
--

CREATE TABLE `tbl_ms_token_usuario` (
  `id_token` int(11) NOT NULL,
  `token` varchar(60) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_inicial` varchar(30) NOT NULL,
  `fecha_final` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ms_usuario`
--

CREATE TABLE `tbl_ms_usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `id_estado_usuario` int(11) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `apellido_usuario` varchar(100) NOT NULL,
  `genero_usuario` varchar(15) NOT NULL,
  `correo_usuario` varchar(45) NOT NULL,
  `TBL_MS_ROLES_id_rol` int(11) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `creado_por` varchar(15) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  `modificado_por` varchar(15) DEFAULT NULL,
  `fecha_ultima_conexion` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `preguntas_contestadas` int(11) DEFAULT NULL,
  `primer_ingreso` int(11) DEFAULT NULL,
  `token` varchar(60) DEFAULT NULL,
  `fecha_inicial` varchar(30) DEFAULT NULL,
  `fecha_final` varchar(30) DEFAULT NULL,
  `intentos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_ms_usuario`
--

INSERT INTO `tbl_ms_usuario` (`id_usuario`, `usuario`, `id_estado_usuario`, `contrasena`, `nombre_usuario`, `apellido_usuario`, `genero_usuario`, `correo_usuario`, `TBL_MS_ROLES_id_rol`, `fecha_creacion`, `creado_por`, `fecha_modificacion`, `modificado_por`, `fecha_ultima_conexion`, `fecha_vencimiento`, `preguntas_contestadas`, `primer_ingreso`, `token`, `fecha_inicial`, `fecha_final`, `intentos`) VALUES
(1, 'Sin Registrar', 1, '99875d29b6df38b2b484f1e8ec5979c7', '', '', '', '', 2, '2021-02-22', NULL, NULL, NULL, '2021-02-25', NULL, NULL, NULL, 'aEB2WDtQ6wJRYHb', '23-02-2021 13:57:08', '24-02-2021 13:57:08', NULL),
(2, 'ROOT', 1, '3d35b9cf36e4c5b56c13bdc336c39df4', 'Variedades', 'OTAC', 'M', 'CABRERAF8@GMAIL.COM', 2, '2021-02-23', 'SUPERADMIN', '2021-03-03', '19', '2021-06-03', '2021-02-23', NULL, 1, 'Token reclamado', '31-05-2021 16:22:16', '01-06-2021 16:22:16', 3),
(36, 'IRIS', 1, '20a67808f5a1bb2bbd77bc22c857b265', 'IRIS', 'TRIMINIO', 'F', 'CABRERAF83@GMAIL.COM', 6, '2021-05-05', 'ROOT', '2021-06-03', '2', '2021-06-03', '2021-05-05', NULL, 1, 'Token reclamado', '03-06-2021 12:51:34', '04-06-2021 12:51:34', 3),
(37, 'IRISS', 2, '3d35b9cf36e4c5b56c13bdc336c39df4', 'FERNANDO', 'CABRERA', 'M', 'FERNANDO.CABRERA@UNAH.HN', 1, '2021-06-03', 'Autoregistro', NULL, NULL, NULL, '2021-06-03', NULL, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_perdidas`
--

CREATE TABLE `tbl_perdidas` (
  `id_perdida` int(11) NOT NULL,
  `cantidad_perdida` int(11) NOT NULL,
  `TBL_PRODUCTOS_id_producto` int(11) NOT NULL,
  `TBL_KARDEX_id_kardex` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_productos`
--

CREATE TABLE `tbl_productos` (
  `id_producto` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `nombre_producto` varchar(45) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `desc_producto` varchar(100) NOT NULL,
  `precio_venta` decimal(9,2) NOT NULL,
  `cantidad_max` int(11) NOT NULL,
  `cantidad_min` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_proveedores`
--

CREATE TABLE `tbl_proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `proveedor` varchar(45) NOT NULL,
  `contacto` varchar(45) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipo_kardex`
--

CREATE TABLE `tbl_tipo_kardex` (
  `id_tipo_kardex` int(11) NOT NULL,
  `nombre_tipo_kardex` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_tipo_kardex`
--

INSERT INTO `tbl_tipo_kardex` (`id_tipo_kardex`, `nombre_tipo_kardex`) VALUES
(1, 'ENTRADA'),
(2, 'SALIDA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ventas`
--

CREATE TABLE `tbl_ventas` (
  `id_venta` int(11) NOT NULL,
  `fecha_venta` datetime NOT NULL DEFAULT current_timestamp(),
  `isv` decimal(9,2) NOT NULL DEFAULT 0.00,
  `total_venta` decimal(10,2) NOT NULL,
  `usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  ADD PRIMARY KEY (`id_categoria`) USING BTREE;

--
-- Indices de la tabla `tbl_clientes`
--
ALTER TABLE `tbl_clientes`
  ADD PRIMARY KEY (`id_cliente`) USING BTREE;

--
-- Indices de la tabla `tbl_compras`
--
ALTER TABLE `tbl_compras`
  ADD PRIMARY KEY (`id_compra`) USING BTREE,
  ADD KEY `fk_TBL_COMPRAS_TBL_PROVEEDORES1_idx` (`TBL_PROVEEDORES_id_proveedor`) USING BTREE;

--
-- Indices de la tabla `tbl_detalle_venta`
--
ALTER TABLE `tbl_detalle_venta`
  ADD PRIMARY KEY (`id_detalle_venta`) USING BTREE,
  ADD KEY `id_venta` (`id_venta`) USING BTREE;

--
-- Indices de la tabla `tbl_devoluciones`
--
ALTER TABLE `tbl_devoluciones`
  ADD PRIMARY KEY (`id_devolucion`) USING BTREE,
  ADD KEY `fk_TBL_DEVOLUCIONES_TBL_PRODUCTOS1_idx` (`TBL_PRODUCTOS_id_producto`) USING BTREE,
  ADD KEY `fk_TBL_DEVOLUCIONES_TBL_KARDEX1_idx` (`TBL_KARDEX_id_kardex`) USING BTREE;

--
-- Indices de la tabla `tbl_kardex`
--
ALTER TABLE `tbl_kardex`
  ADD PRIMARY KEY (`id_kardex`) USING BTREE,
  ADD KEY `id_producto` (`id_producto`) USING BTREE,
  ADD KEY `id_tipo_kardex` (`id_tipo_kardex`) USING BTREE,
  ADD KEY `id_usuario` (`id_usuario`) USING BTREE;

--
-- Indices de la tabla `tbl_ms_bitacora`
--
ALTER TABLE `tbl_ms_bitacora`
  ADD PRIMARY KEY (`id_bitacora`) USING BTREE,
  ADD KEY `fk_TBL_MS_BITACORA_TBL_MS_USUARIO1_idx` (`TBL_MS_USUARIO_id_usuario`) USING BTREE,
  ADD KEY `fk_TBL_MS_BITACORA_TBL_MS_OBJETOS1_idx` (`TBL_MS_OBJETOS_id_objeto`) USING BTREE;

--
-- Indices de la tabla `tbl_ms_estado_usuario`
--
ALTER TABLE `tbl_ms_estado_usuario`
  ADD PRIMARY KEY (`id_estado_usuario`) USING BTREE;

--
-- Indices de la tabla `tbl_ms_hist_contraseña`
--
ALTER TABLE `tbl_ms_hist_contraseña`
  ADD PRIMARY KEY (`id_hist`) USING BTREE,
  ADD KEY `fk_TBL_MS_HIST_CONTRASEÑA_TBL_MS_USUARIO1_idx` (`TBL_MS_USUARIO_id_usuario`) USING BTREE;

--
-- Indices de la tabla `tbl_ms_objetos`
--
ALTER TABLE `tbl_ms_objetos`
  ADD PRIMARY KEY (`id_objeto`) USING BTREE;

--
-- Indices de la tabla `tbl_ms_parametros`
--
ALTER TABLE `tbl_ms_parametros`
  ADD PRIMARY KEY (`id_parametro`) USING BTREE,
  ADD KEY `fk_TBL_MS_PARAMETROS_TBL_MS_USUARIO1_idx` (`TBL_MS_USUARIO_id_usuario`) USING BTREE;

--
-- Indices de la tabla `tbl_ms_permisos`
--
ALTER TABLE `tbl_ms_permisos`
  ADD PRIMARY KEY (`id_permiso`) USING BTREE,
  ADD KEY `tbl_ms_permisos_FK` (`TBL_MS_ROLES_id_rol`) USING BTREE,
  ADD KEY `tbl_ms_permisos_FK_1` (`TBL_MS_OBJETOS_id_objeto`) USING BTREE;

--
-- Indices de la tabla `tbl_ms_preguntas`
--
ALTER TABLE `tbl_ms_preguntas`
  ADD PRIMARY KEY (`id_pregunta`) USING BTREE;

--
-- Indices de la tabla `tbl_ms_preguntas_usuario`
--
ALTER TABLE `tbl_ms_preguntas_usuario`
  ADD PRIMARY KEY (`id_preguntas_usuario`) USING BTREE,
  ADD KEY `usuarios_preguntas_respuestas` (`id_pregunta`) USING BTREE;

--
-- Indices de la tabla `tbl_ms_roles`
--
ALTER TABLE `tbl_ms_roles`
  ADD PRIMARY KEY (`id_rol`) USING BTREE;

--
-- Indices de la tabla `tbl_ms_token_usuario`
--
ALTER TABLE `tbl_ms_token_usuario`
  ADD PRIMARY KEY (`id_token`) USING BTREE,
  ADD KEY `token_usuario` (`id_usuario`) USING BTREE;

--
-- Indices de la tabla `tbl_ms_usuario`
--
ALTER TABLE `tbl_ms_usuario`
  ADD PRIMARY KEY (`id_usuario`) USING BTREE,
  ADD KEY `fk_TBL_MS_USUARIO_TBL_MS_ROLES1_idx` (`TBL_MS_ROLES_id_rol`) USING BTREE,
  ADD KEY `estados_usuarios` (`id_estado_usuario`) USING BTREE;

--
-- Indices de la tabla `tbl_perdidas`
--
ALTER TABLE `tbl_perdidas`
  ADD PRIMARY KEY (`id_perdida`) USING BTREE,
  ADD KEY `fk_TBL_PERDIDAS_TBL_PRODUCTOS1_idx` (`TBL_PRODUCTOS_id_producto`) USING BTREE,
  ADD KEY `fk_TBL_PERDIDAS_TBL_KARDEX1_idx` (`TBL_KARDEX_id_kardex`) USING BTREE;

--
-- Indices de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  ADD PRIMARY KEY (`id_producto`) USING BTREE,
  ADD KEY `nombre_categoria` (`id_categoria`) USING BTREE,
  ADD KEY `id_proveedor` (`id_proveedor`) USING BTREE;

--
-- Indices de la tabla `tbl_proveedores`
--
ALTER TABLE `tbl_proveedores`
  ADD PRIMARY KEY (`id_proveedor`) USING BTREE;

--
-- Indices de la tabla `tbl_tipo_kardex`
--
ALTER TABLE `tbl_tipo_kardex`
  ADD PRIMARY KEY (`id_tipo_kardex`) USING BTREE;

--
-- Indices de la tabla `tbl_ventas`
--
ALTER TABLE `tbl_ventas`
  ADD PRIMARY KEY (`id_venta`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tbl_clientes`
--
ALTER TABLE `tbl_clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `tbl_compras`
--
ALTER TABLE `tbl_compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_detalle_venta`
--
ALTER TABLE `tbl_detalle_venta`
  MODIFY `id_detalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `tbl_kardex`
--
ALTER TABLE `tbl_kardex`
  MODIFY `id_kardex` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_bitacora`
--
ALTER TABLE `tbl_ms_bitacora`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2914;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_estado_usuario`
--
ALTER TABLE `tbl_ms_estado_usuario`
  MODIFY `id_estado_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_hist_contraseña`
--
ALTER TABLE `tbl_ms_hist_contraseña`
  MODIFY `id_hist` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_objetos`
--
ALTER TABLE `tbl_ms_objetos`
  MODIFY `id_objeto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_parametros`
--
ALTER TABLE `tbl_ms_parametros`
  MODIFY `id_parametro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_permisos`
--
ALTER TABLE `tbl_ms_permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_preguntas`
--
ALTER TABLE `tbl_ms_preguntas`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_preguntas_usuario`
--
ALTER TABLE `tbl_ms_preguntas_usuario`
  MODIFY `id_preguntas_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_roles`
--
ALTER TABLE `tbl_ms_roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_token_usuario`
--
ALTER TABLE `tbl_ms_token_usuario`
  MODIFY `id_token` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_ms_usuario`
--
ALTER TABLE `tbl_ms_usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `tbl_perdidas`
--
ALTER TABLE `tbl_perdidas`
  MODIFY `id_perdida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `tbl_proveedores`
--
ALTER TABLE `tbl_proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_kardex`
--
ALTER TABLE `tbl_tipo_kardex`
  MODIFY `id_tipo_kardex` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_ventas`
--
ALTER TABLE `tbl_ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_detalle_venta`
--
ALTER TABLE `tbl_detalle_venta`
  ADD CONSTRAINT `tbl_detalle_venta_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `tbl_ventas` (`id_venta`);

--
-- Filtros para la tabla `tbl_kardex`
--
ALTER TABLE `tbl_kardex`
  ADD CONSTRAINT `tbl_kardex_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`),
  ADD CONSTRAINT `tbl_kardex_ibfk_2` FOREIGN KEY (`id_tipo_kardex`) REFERENCES `tbl_tipo_kardex` (`id_tipo_kardex`),
  ADD CONSTRAINT `tbl_kardex_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_ms_usuario` (`id_usuario`);

--
-- Filtros para la tabla `tbl_ms_bitacora`
--
ALTER TABLE `tbl_ms_bitacora`
  ADD CONSTRAINT `fk_TBL_MS_BITACORA_TBL_MS_OBJETOS1` FOREIGN KEY (`TBL_MS_OBJETOS_id_objeto`) REFERENCES `tbl_ms_objetos` (`id_objeto`),
  ADD CONSTRAINT `fk_TBL_MS_BITACORA_TBL_MS_USUARIO1` FOREIGN KEY (`TBL_MS_USUARIO_id_usuario`) REFERENCES `tbl_ms_usuario` (`id_usuario`);

--
-- Filtros para la tabla `tbl_ms_hist_contraseña`
--
ALTER TABLE `tbl_ms_hist_contraseña`
  ADD CONSTRAINT `fk_TBL_MS_HIST_CONTRASEÑA_TBL_MS_USUARIO1` FOREIGN KEY (`TBL_MS_USUARIO_id_usuario`) REFERENCES `tbl_ms_usuario` (`id_usuario`);

--
-- Filtros para la tabla `tbl_ms_parametros`
--
ALTER TABLE `tbl_ms_parametros`
  ADD CONSTRAINT `fk_TBL_MS_PARAMETROS_TBL_MS_USUARIO1` FOREIGN KEY (`TBL_MS_USUARIO_id_usuario`) REFERENCES `tbl_ms_usuario` (`id_usuario`);

--
-- Filtros para la tabla `tbl_ms_permisos`
--
ALTER TABLE `tbl_ms_permisos`
  ADD CONSTRAINT `tbl_ms_permisos_FK` FOREIGN KEY (`TBL_MS_ROLES_id_rol`) REFERENCES `tbl_ms_roles` (`id_rol`),
  ADD CONSTRAINT `tbl_ms_permisos_FK_1` FOREIGN KEY (`TBL_MS_OBJETOS_id_objeto`) REFERENCES `tbl_ms_objetos` (`id_objeto`);

--
-- Filtros para la tabla `tbl_ms_preguntas_usuario`
--
ALTER TABLE `tbl_ms_preguntas_usuario`
  ADD CONSTRAINT `usuarios_preguntas_respuestas` FOREIGN KEY (`id_pregunta`) REFERENCES `tbl_ms_preguntas` (`id_pregunta`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_ms_usuario`
--
ALTER TABLE `tbl_ms_usuario`
  ADD CONSTRAINT `estados_usuarios` FOREIGN KEY (`id_estado_usuario`) REFERENCES `tbl_ms_estado_usuario` (`id_estado_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_TBL_MS_USUARIO_TBL_MS_ROLES1` FOREIGN KEY (`TBL_MS_ROLES_id_rol`) REFERENCES `tbl_ms_roles` (`id_rol`);

--
-- Filtros para la tabla `tbl_perdidas`
--
ALTER TABLE `tbl_perdidas`
  ADD CONSTRAINT `fk_TBL_PERDIDAS_TBL_PRODUCTOS1` FOREIGN KEY (`TBL_PRODUCTOS_id_producto`) REFERENCES `tbl_productos` (`id_producto`);

--
-- Filtros para la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  ADD CONSTRAINT `tbl_productos_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `tbl_proveedores` (`id_proveedor`),
  ADD CONSTRAINT `tbl_productos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `tbl_categoria` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
