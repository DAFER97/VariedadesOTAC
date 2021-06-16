CREATE DATABASE IF NOT EXISTS `db_variedadesotaci`;

USE `db_variedadesotaci`;

SET foreign_key_checks = 0;

DROP TABLE IF EXISTS `tbl_categoria`;

CREATE TABLE `tbl_categoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(30) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `creado_por` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_categoria`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_categoria` VALUES (13,"hj","2021-05-26 21:30:17",NULL),
(14,"aaa","2021-05-26 21:30:46",NULL);


DROP TABLE IF EXISTS `tbl_clientes`;

CREATE TABLE `tbl_clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `DNI` varchar(20) NOT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `telefono_cliente` int(11) NOT NULL,
  `direccion_cliente` varchar(100) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_cliente`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `tbl_compras`;

CREATE TABLE `tbl_compras` (
  `id_compra` int(11) NOT NULL AUTO_INCREMENT,
  `desc_compra` varchar(100) NOT NULL,
  `fecha_orden` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `cantidad_compra` int(11) NOT NULL,
  `cantidad_recibida` int(11) NOT NULL,
  `TBL_PROVEEDORES_id_proveedor` int(11) NOT NULL,
  PRIMARY KEY (`id_compra`) USING BTREE,
  KEY `fk_TBL_COMPRAS_TBL_PROVEEDORES1_idx` (`TBL_PROVEEDORES_id_proveedor`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `tbl_detalle_venta`;

CREATE TABLE `tbl_detalle_venta` (
  `id_detalle_venta` int(11) NOT NULL AUTO_INCREMENT,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_total` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id_detalle_venta`) USING BTREE,
  KEY `id_venta` (`id_venta`) USING BTREE,
  CONSTRAINT `tbl_detalle_venta_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `tbl_ventas` (`id_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `tbl_devoluciones`;

CREATE TABLE `tbl_devoluciones` (
  `id_devolucion` int(11) NOT NULL,
  `cantidad_dev` int(11) NOT NULL,
  `TBL_PRODUCTOS_id_producto` int(11) NOT NULL,
  `TBL_KARDEX_id_kardex` int(11) NOT NULL,
  PRIMARY KEY (`id_devolucion`) USING BTREE,
  KEY `fk_TBL_DEVOLUCIONES_TBL_PRODUCTOS1_idx` (`TBL_PRODUCTOS_id_producto`) USING BTREE,
  KEY `fk_TBL_DEVOLUCIONES_TBL_KARDEX1_idx` (`TBL_KARDEX_id_kardex`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `tbl_kardex`;

CREATE TABLE `tbl_kardex` (
  `id_kardex` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad_kardex` int(11) NOT NULL,
  `precio` decimal(9,2) NOT NULL,
  `fecha_kardex` datetime NOT NULL DEFAULT current_timestamp(),
  `id_producto` int(11) NOT NULL,
  `id_tipo_kardex` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_kardex`) USING BTREE,
  KEY `id_producto` (`id_producto`) USING BTREE,
  KEY `id_tipo_kardex` (`id_tipo_kardex`) USING BTREE,
  KEY `id_usuario` (`id_usuario`) USING BTREE,
  CONSTRAINT `tbl_kardex_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`),
  CONSTRAINT `tbl_kardex_ibfk_2` FOREIGN KEY (`id_tipo_kardex`) REFERENCES `tbl_tipo_kardex` (`id_tipo_kardex`),
  CONSTRAINT `tbl_kardex_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_ms_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `tbl_ms_bitacora`;

CREATE TABLE `tbl_ms_bitacora` (
  `id_bitacora` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `TBL_MS_USUARIO_id_usuario` int(11) NOT NULL,
  `TBL_MS_OBJETOS_id_objeto` int(11) NOT NULL,
  `accion` varchar(20) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `creado_por` varchar(15) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `modificado_por` varchar(15) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  PRIMARY KEY (`id_bitacora`) USING BTREE,
  KEY `fk_TBL_MS_BITACORA_TBL_MS_USUARIO1_idx` (`TBL_MS_USUARIO_id_usuario`) USING BTREE,
  KEY `fk_TBL_MS_BITACORA_TBL_MS_OBJETOS1_idx` (`TBL_MS_OBJETOS_id_objeto`) USING BTREE,
  CONSTRAINT `fk_TBL_MS_BITACORA_TBL_MS_OBJETOS1` FOREIGN KEY (`TBL_MS_OBJETOS_id_objeto`) REFERENCES `tbl_ms_objetos` (`id_objeto`),
  CONSTRAINT `fk_TBL_MS_BITACORA_TBL_MS_USUARIO1` FOREIGN KEY (`TBL_MS_USUARIO_id_usuario`) REFERENCES `tbl_ms_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2735 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_ms_bitacora` VALUES (2647,"2021-05-05",1,39,"Ingreso","Ingreso a módulo de Productos",NULL,"2021-05-05",NULL,NULL),
(2648,"2021-05-05",1,44,"Ingreso","Ingreso a módulo de Productos",NULL,"2021-05-05",NULL,NULL),
(2649,"2021-05-05",1,44,"Ingreso","Ingreso a módulo de inventario",NULL,"2021-05-05",NULL,NULL),
(2650,"2021-05-05",1,44,"Ingreso","Ingreso a módulo de usuarios",NULL,"2021-05-05",NULL,NULL),
(2651,"2021-05-05",36,8,"Ingreso","Ingreso a creación de usuario por administración",NULL,"2021-05-05",NULL,NULL),
(2652,"2021-05-05",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-05",NULL,NULL),
(2653,"2021-05-05",1,44,"Ingreso","Ingreso a módulo de Productos",NULL,"2021-05-05",NULL,NULL),
(2654,"2021-05-05",1,44,"Ingreso","Ingreso a módulo de Productos",NULL,"2021-05-05",NULL,NULL),
(2655,"2021-05-05",1,44,"Ingreso","Ingreso a módulo de Productos",NULL,"2021-05-05",NULL,NULL),
(2656,"0000-00-00",2,12,"Ingreso","Ingreso a módulo de roles",NULL,"2021-05-05",NULL,NULL),
(2657,"2021-05-05",1,12,"Ingreso","Ingreso a módulo de Productos",NULL,"2021-05-05",NULL,NULL),
(2658,"2021-05-24",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-24",NULL,NULL),
(2660,"2021-05-26",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-26",NULL,NULL),
(2661,"0000-00-00",2,13,"Ingreso","Ingreso a módulo de permisos",NULL,"2021-05-26",NULL,NULL),
(2662,"0000-00-00",2,13,"Ingreso","Ingreso a módulo de permisos",NULL,"2021-05-26",NULL,NULL),
(2663,"0000-00-00",2,13,"Ingreso","Ingreso a módulo de permisos",NULL,"2021-05-26",NULL,NULL),
(2664,"0000-00-00",2,13,"Ingreso","Ingreso a módulo de permisos",NULL,"2021-05-26",NULL,NULL),
(2665,"2021-05-26",2,8,"Ingreso","Ingreso a módulo de permisos por Admin",NULL,"2021-05-26",NULL,NULL),
(2666,"2021-05-26",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-26",NULL,NULL),
(2667,"2021-05-26",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-26",NULL,NULL),
(2668,"2021-05-26",2,8,"Ingreso","Ingreso a módulo de permisos por Admin",NULL,"2021-05-26",NULL,NULL),
(2669,"2021-05-26",2,8,"Ingreso","Ingreso a módulo de permisos por Admin",NULL,"2021-05-26",NULL,NULL),
(2670,"2021-05-26",1,13,"Ingreso","Ingreso a módulo de Productos",NULL,"2021-05-26",NULL,NULL),
(2671,"2021-05-26",2,8,"Ingreso","Ingreso a módulo de permisos por Admin",NULL,"2021-05-26",NULL,NULL),
(2672,"2021-05-26",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-26",NULL,NULL),
(2673,"2021-05-26",1,44,"Ingreso","Ingreso a módulo de Productos",NULL,"2021-05-26",NULL,NULL),
(2674,"2021-05-26",1,39,"Ingreso","Ingreso a módulo de Productos",NULL,"2021-05-26",NULL,NULL),
(2675,"2021-05-26",2,38,"Ingreso","Ingreso a creación de productos por administración",NULL,"2021-05-26",NULL,NULL),
(2676,"2021-05-26",1,44,"Ingreso","Ingreso a módulo de Productos",NULL,"2021-05-26",NULL,NULL),
(2677,"2021-05-26",1,44,"Ingreso","Ingreso a módulo de Productos",NULL,"2021-05-26",NULL,NULL),
(2678,"2021-05-26",1,44,"Ingreso","Ingreso a módulo de Productos",NULL,"2021-05-26",NULL,NULL),
(2679,"2021-05-26",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-26",NULL,NULL),
(2680,"2021-05-26",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-26",NULL,NULL),
(2681,"2021-05-27",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-27",NULL,NULL),
(2682,"2021-05-29",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-29",NULL,NULL),
(2684,"2021-05-29",2,8,"Ingreso","Ingreso a creación de usuario por administración",NULL,"2021-05-29",NULL,NULL),
(2685,"0000-00-00",2,12,"Ingreso","Ingreso a módulo de roles",NULL,"2021-05-29",NULL,NULL),
(2686,"2021-05-29",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-29",NULL,NULL),
(2687,"2021-05-29",1,36,"Ingreso","Ingreso a módulo de usuarios",NULL,"2021-05-29",NULL,NULL),
(2688,"2021-05-29",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-29",NULL,NULL),
(2689,"2021-05-31",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-31",NULL,NULL),
(2690,"2021-05-31",1,2,"Ingreso","Ingreso a recuperación por correo",NULL,"2021-05-31",NULL,NULL),
(2691,"2021-05-31",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-31",NULL,NULL),
(2692,"2021-05-31",1,5,"Ingreso","Ingreso a restablecer contraseña por correo",NULL,"2021-05-31",NULL,NULL),
(2693,"2021-05-31",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-31",NULL,NULL),
(2694,"2021-05-31",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-31",NULL,NULL),
(2695,"2021-05-31",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-31",NULL,NULL),
(2696,"2021-05-31",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-31",NULL,NULL),
(2697,"2021-05-31",1,3,"Ingreso","Ingreso a recuperación por pregunta",NULL,"2021-05-31",NULL,NULL),
(2698,"2021-05-31",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-31",NULL,NULL),
(2699,"2021-05-31",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-05-31",NULL,NULL),
(2700,"2021-06-02",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-06-02",NULL,NULL),
(2701,"2021-06-02",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-06-02",NULL,NULL),
(2702,"0000-00-00",2,12,"Ingreso","Ingreso a módulo de roles",NULL,"2021-06-02",NULL,NULL),
(2703,"2021-06-02",2,8,"Ingreso","Ingreso a módulo de permisos por Admin",NULL,"2021-06-02",NULL,NULL),
(2704,"0000-00-00",2,13,"Ingreso","Ingreso a módulo de permisos",NULL,"2021-06-02",NULL,NULL),
(2705,"2021-06-02",1,13,"Ingreso","Ingreso a módulo de usuarios",NULL,"2021-06-02",NULL,NULL),
(2706,"2021-06-02",1,13,"Ingreso","Ingreso a módulo de usuarios",NULL,"2021-06-02",NULL,NULL),
(2707,"2021-06-02",2,9,"Ingreso","Ingreso a edición de usuarios por administración",NULL,"2021-06-02",NULL,NULL),
(2708,"2021-06-02",2,7,"Actualizo","Actualizo Usuario",NULL,"2021-06-02",NULL,NULL),
(2709,"2021-06-02",1,13,"Ingreso","Ingreso a módulo de usuarios",NULL,"2021-06-02",NULL,NULL),
(2710,"2021-06-02",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-06-02",NULL,NULL),
(2711,"2021-06-02",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-06-02",NULL,NULL),
(2712,"2021-06-02",1,2,"Ingreso","Ingreso a recuperación por correo",NULL,"2021-06-02",NULL,NULL),
(2713,"2021-06-02",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-06-02",NULL,NULL),
(2714,"2021-06-02",1,5,"Ingreso","Ingreso a restablecer contraseña por correo",NULL,"2021-06-02",NULL,NULL),
(2715,"2021-06-02",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-06-02",NULL,NULL),
(2716,"2021-06-02",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-06-02",NULL,NULL),
(2717,"2021-06-02",2,8,"Ingreso","Ingreso a módulo de permisos por Admin",NULL,"2021-06-02",NULL,NULL),
(2718,"2021-06-02",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-06-02",NULL,NULL),
(2719,"2021-06-02",1,2,"Ingreso","Ingreso a recuperación por correo",NULL,"2021-06-02",NULL,NULL),
(2720,"2021-06-02",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-06-02",NULL,NULL),
(2721,"2021-06-02",1,5,"Ingreso","Ingreso a restablecer contraseña por correo",NULL,"2021-06-02",NULL,NULL),
(2722,"2021-06-02",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-06-02",NULL,NULL),
(2723,"2021-06-02",1,5,"Ingreso","Ingreso a restablecer contraseña por correo",NULL,"2021-06-02",NULL,NULL),
(2724,"2021-06-02",1,5,"Ingreso","Ingreso a restablecer contraseña por correo",NULL,"2021-06-02",NULL,NULL),
(2725,"2021-06-02",1,5,"Ingreso","Ingreso a restablecer contraseña por correo",NULL,"2021-06-02",NULL,NULL),
(2726,"2021-06-02",1,5,"Ingreso","Ingreso a restablecer contraseña por correo",NULL,"2021-06-02",NULL,NULL),
(2727,"2021-06-02",2,8,"Ingreso","Ingreso a módulo de permisos por Admin",NULL,"2021-06-02",NULL,NULL),
(2728,"2021-06-02",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-06-02",NULL,NULL),
(2729,"2021-06-02",1,5,"Ingreso","Ingreso a restablecer contraseña por correo",NULL,"2021-06-02",NULL,NULL),
(2730,"2021-06-02",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-06-02",NULL,NULL),
(2731,"2021-06-02",1,5,"Ingreso","Ingreso a restablecer contraseña por correo",NULL,"2021-06-02",NULL,NULL),
(2732,"2021-06-02",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-06-02",NULL,NULL),
(2733,"2021-06-02",1,1,"Ingreso","Ingreso a iniciar sesión",NULL,"2021-06-02",NULL,NULL),
(2734,"2021-06-02",1,39,"Ingreso","Ingreso a módulo de Productos",NULL,"2021-06-02",NULL,NULL);


DROP TABLE IF EXISTS `tbl_ms_estado_usuario`;

CREATE TABLE `tbl_ms_estado_usuario` (
  `id_estado_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(40) NOT NULL,
  PRIMARY KEY (`id_estado_usuario`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_ms_estado_usuario` VALUES (1,"Activo"),
(2,"Inactivo"),
(3,"Desactivado"),
(4,"Nuevo"),
(5,"Bloqueado");


DROP TABLE IF EXISTS `tbl_ms_hist_contraseña`;

CREATE TABLE `tbl_ms_hist_contraseña` (
  `id_hist` int(11) NOT NULL AUTO_INCREMENT,
  `TBL_MS_USUARIO_id_usuario` int(11) NOT NULL,
  `contraseña` varchar(100) NOT NULL,
  `creado_por` varchar(15) DEFAULT NULL,
  `fecha_creacion` varchar(45) DEFAULT NULL,
  `modificado_por` varchar(15) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  PRIMARY KEY (`id_hist`) USING BTREE,
  KEY `fk_TBL_MS_HIST_CONTRASEÑA_TBL_MS_USUARIO1_idx` (`TBL_MS_USUARIO_id_usuario`) USING BTREE,
  CONSTRAINT `fk_TBL_MS_HIST_CONTRASEÑA_TBL_MS_USUARIO1` FOREIGN KEY (`TBL_MS_USUARIO_id_usuario`) REFERENCES `tbl_ms_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `tbl_ms_objetos`;

CREATE TABLE `tbl_ms_objetos` (
  `id_objeto` int(11) NOT NULL AUTO_INCREMENT,
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
  `fecha_modificacion` date DEFAULT NULL,
  PRIMARY KEY (`id_objeto`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_ms_objetos` VALUES (1,"Login","Inicio sesión","Módulo",0,NULL,NULL,NULL,"desactivado",NULL,NULL,NULL),
(2,"Recuperación por Correo","Método de seguridad","Módulo",0,NULL,NULL,NULL,"desactivado",NULL,NULL,NULL),
(3,"Recuperación por pregunta secreta","Método de seguridad","Módulo",0,NULL,NULL,NULL,"desactivado",NULL,NULL,NULL),
(4,"Autoregistro","Creación propia de un perfil","Módulo",0,NULL,NULL,NULL,"desactivado",NULL,NULL,NULL),
(5,"Restablecer contraseña por correo","Método de seguridad","Módulo",0,NULL,NULL,NULL,"desactivado",NULL,NULL,NULL),
(6,"Restablecer contraseña por pregunta","Método de seguridad","Módulo",0,NULL,NULL,NULL,"desactivado",NULL,NULL,NULL),
(7,"Usuarios","Vista usuarios","Modulo",10,"fa fa-users","Admin/usuarios",NULL,"activo",NULL,NULL,NULL),
(8,"Creacion de usuario","Crear usuario","Modulo",0,NULL,NULL,NULL,"desactivado",NULL,NULL,NULL),
(9,"Actualizar usuario","Editar usuario","Modulo",0,NULL,NULL,NULL,"desactivado",NULL,NULL,NULL),
(10,"Mantenimiento","mantenimiento del sistema","Modulo",0,"fa fa-archive",NULL,"Admin","activo",NULL,NULL,NULL),
(11,"Seguridad","Seguridad del sistema","Modulo",0,"fas fa-shield-alt",NULL,"Admin","activo",NULL,NULL,NULL),
(12,"Roles","Roles de los usuarios","Módulo",11,"fas fa-user-shield","Admin/roles","Admin","activo",NULL,NULL,NULL),
(13,"Permisos","Permisos de los modulos para los usuarios","Módulo",11,"fas fa-door-closed","Admin/permisos","Admin","activo",NULL,NULL,NULL),
(14,"Objetos","Menus ","Modulo",11,"fa fa-bookmark","Admin/objetos",NULL,"activo",NULL,"ROOT","2021-03-25"),
(23,"Bitacora","Modulo de bitacora","Modulo",11,"fa fa-users","Admin/BitacoraList","ROOT","activo","2021-03-17",NULL,NULL),
(29,"Clientes","Modulo de clientes","Modulo",0,"fa fa-users","","ROOT","activo","2021-03-22",NULL,NULL),
(30,"Clientes","Modulo de clientes","Modulo",29,"fa fa-users","Admin/Clientes","ROOT","activo","2021-03-22","ROOT","2021-03-26"),
(32,"Proveedores","Modulo de Proveedores","Modulo",0,"fa fa-truck","","ROOT","activo","2021-03-25",NULL,NULL),
(33,"Proveedores","Modulo de Proveedores","Modulo",32,"fa fa-truck","Admin/proveedores","ROOT","activo","2021-03-25",NULL,NULL),
(34,"Ventas","Modulo de venta","Modulo",0,"fa fa-money","","ROOT","activo","2021-03-25",NULL,NULL),
(35,"Ventas","Modulo de venta","Modulo",34,"fa fa-bars","Admin/Ventas","ROOT","activo","2021-03-25",NULL,NULL),
(36,"Nueva Venta","Modulo de Nueva venta","Modulo",34,"fa fa-plus","Admin/VentasNew","ROOT","activo","2021-03-25","ROOT","2021-03-25"),
(37,"Nuevo Proveedor","Modulo de nuevo proveedor","Modulo",32,"fas fa-user-plus","Admin/proveedoresnew","ROOT","activo","2021-03-25",NULL,NULL),
(38,"Productos","Modulo de productos","Modulo",0,"fa fa-cubes","","ROOT","activo","2021-03-25",NULL,NULL),
(39,"Productos ","Lista de productos ","Modulo",38,"fa fa-bars","Admin/Productos","ROOT","activo","2021-03-25",NULL,NULL),
(40,"Nuevo producto","Nuevo producto","Modulo",38,"fa fa-plus","Admin/productosnew","ROOT","activo","2021-03-25",NULL,NULL),
(41,"Nuevo Cliente","Crear nuevo cliente","Modulo",29,"fas fa-user-plus","Admin/clientesnew","ROOT","activo","2021-03-26",NULL,NULL),
(43,"Actualizar Contraseña","Pantallapara actualizar contra","Modulo",10,"fas fa-ui","Admin/ActualizarContra","ROOT","activo","2021-04-05","ROOT","2021-04-05"),
(44,"Categoría productos","Modulo de productos","Modulo",38,"fa fa-bars","Admin/Categoria","ROOT","activo","2021-04-06",NULL,NULL),
(48,"Inventario","Modulo de clientes","Modulo",0,"fa fa-bar-chart","","ROOT","activo","2021-04-18",NULL,NULL),
(49,"Generar compra","Modulo de inventario","Modulo",50,"fa fa-plus","Admin/inventario","ROOT","activo","2021-04-18",NULL,NULL),
(50,"Compras","Modulo de compras","Modulo",0,"fa fa-tags","","ROOT","activo","2021-04-18",NULL,NULL),
(51,"Nueva compra","Modulo de compras","Modulo",50,"fa fa-plus","Admin/compras","ROOT","activo","2021-04-18","ROOT","2021-04-18"),
(52,"Compras","Modulo de compras","Modulo",50,"fa fa-bars","admin/compraslist","ROOT","activo","2021-04-18",NULL,NULL),
(53,"Respaldo","Modulo de backup","Modulo",0,"fa fa-cloud","","ROOT","activo","2021-04-18",NULL,NULL),
(55,"Inventario Disponible","Modulo de inventario","Modulo",48,"fa fa-balance","admin/inventariolista","ROOT","activo","2021-04-19","ROOT","2021-04-19"),
(56,"Backup ","Modulo de Backup","Modulo",53,"fa fa-cloud-upload","admin/backup","ROOT","activo","2021-04-19","ROOT","2021-04-20"),
(58,"Restore","Modulo de Backup","Modulo",53,"fa fa-cloud-download","admin/restore","ROOT","activo","2021-04-20",NULL,NULL);


DROP TABLE IF EXISTS `tbl_ms_parametros`;

CREATE TABLE `tbl_ms_parametros` (
  `id_parametro` int(11) NOT NULL AUTO_INCREMENT,
  `parametro` varchar(50) NOT NULL,
  `valor` varchar(100) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `creado_por` varchar(15) DEFAULT NULL,
  `modificado_por` varchar(15) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  `TBL_MS_USUARIO_id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_parametro`) USING BTREE,
  KEY `fk_TBL_MS_PARAMETROS_TBL_MS_USUARIO1_idx` (`TBL_MS_USUARIO_id_usuario`) USING BTREE,
  CONSTRAINT `fk_TBL_MS_PARAMETROS_TBL_MS_USUARIO1` FOREIGN KEY (`TBL_MS_USUARIO_id_usuario`) REFERENCES `tbl_ms_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_ms_parametros` VALUES (1,"Correo_host","smtp.gmail.com","2021-02-22",NULL,NULL,NULL,1),
(2,"Correo_usuario","variedadesotac@gmail.com","2021-02-22",NULL,NULL,NULL,1),
(3,"Correo_contraseña","VOtac2021","2021-02-22",NULL,NULL,NULL,1),
(4,"Correo_tipo_smtp","TLS","2021-02-22",NULL,NULL,NULL,1),
(5,"Correo_puerto",587,"2021-02-22",NULL,NULL,NULL,1),
(6,"Correo_nombre","Solutions Team",NULL,NULL,NULL,NULL,1),
(7,"Correo_horas_token",24,NULL,NULL,NULL,NULL,1),
(8,"ADMIN_INTENTOS",3,NULL,NULL,NULL,NULL,1);


DROP TABLE IF EXISTS `tbl_ms_permisos`;

CREATE TABLE `tbl_ms_permisos` (
  `id_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `TBL_MS_ROLES_id_rol` int(11) DEFAULT NULL,
  `TBL_MS_OBJETOS_id_objeto` int(11) DEFAULT NULL,
  `permiso_insercion` int(11) DEFAULT NULL,
  `permiso_eliminacion` int(11) DEFAULT NULL,
  `permiso_actualizacion` int(11) DEFAULT NULL,
  `permiso_consultar` int(11) DEFAULT NULL,
  `creado_por` varchar(15) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `modificado_por` varchar(15) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  PRIMARY KEY (`id_permiso`) USING BTREE,
  KEY `tbl_ms_permisos_FK` (`TBL_MS_ROLES_id_rol`) USING BTREE,
  KEY `tbl_ms_permisos_FK_1` (`TBL_MS_OBJETOS_id_objeto`) USING BTREE,
  CONSTRAINT `tbl_ms_permisos_FK` FOREIGN KEY (`TBL_MS_ROLES_id_rol`) REFERENCES `tbl_ms_roles` (`id_rol`),
  CONSTRAINT `tbl_ms_permisos_FK_1` FOREIGN KEY (`TBL_MS_OBJETOS_id_objeto`) REFERENCES `tbl_ms_objetos` (`id_objeto`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

INSERT INTO `tbl_ms_permisos` VALUES (6,2,11,1,1,1,1,"Admin",NULL,"ROOT","2021-03-15"),
(7,2,12,1,1,1,1,"Admin",NULL,"ROOT","2021-03-15"),
(8,2,13,1,1,1,1,"Admin",NULL,"ROOT","2021-03-15"),
(9,1,4,1,0,1,1,"ROOT","2021-03-12","ROOT","2021-03-13"),
(10,1,2,1,1,0,1,"ROOT","2021-03-12","ROOT","2021-03-14"),
(11,3,11,0,0,1,0,"ROOT","2021-03-13","ROOT","2021-03-13"),
(18,2,7,1,1,1,1,"ROOT","2021-03-13",NULL,NULL),
(19,2,14,1,1,1,1,"ROOT","2021-03-13","ROOT","2021-03-15"),
(23,4,9,1,1,1,1,"ROOT","2021-03-13",NULL,NULL),
(24,1,9,1,0,1,1,"ROOT","2021-03-13","ROOT","2021-03-14"),
(25,4,10,1,1,1,0,"ROOT","2021-03-13",NULL,NULL),
(26,4,14,0,0,0,1,"ROOT","2021-03-13",NULL,NULL),
(27,4,13,0,0,0,0,"ROOT","2021-03-13",NULL,NULL),
(28,4,12,0,0,0,0,"ROOT","2021-03-13",NULL,NULL),
(29,3,2,1,1,1,0,"ROOT","2021-03-13",NULL,NULL),
(30,3,14,1,1,0,0,"ROOT","2021-03-13",NULL,NULL),
(31,3,13,0,0,0,0,"ROOT","2021-03-13","ROOT","2021-03-17"),
(32,3,10,1,1,0,1,"ROOT","2021-03-13",NULL,NULL),
(34,4,10,1,1,1,1,"ROOT","2021-03-14","ROOT","2021-03-14"),
(37,2,23,1,1,1,1,"ROOT","2021-03-17",NULL,NULL),
(38,3,23,0,0,0,1,"ROOT","2021-03-17",NULL,NULL),
(42,2,30,1,1,1,1,"ROOT","2021-03-22",NULL,NULL),
(46,2,33,1,1,1,1,"ROOT","2021-03-25",NULL,NULL),
(47,2,35,1,1,1,1,"ROOT","2021-03-25",NULL,NULL),
(48,2,36,1,1,1,1,"ROOT","2021-03-25",NULL,NULL),
(49,2,37,1,1,1,1,"ROOT","2021-03-25",NULL,NULL),
(50,2,39,1,1,1,1,"ROOT","2021-03-25",NULL,NULL),
(51,2,40,1,1,1,1,"ROOT","2021-03-25",NULL,NULL),
(52,2,41,1,1,1,1,"ROOT","2021-03-26",NULL,NULL),
(53,3,30,1,1,1,1,"ROOT","2021-03-26",NULL,NULL),
(55,2,44,1,1,1,1,"ROOT","2021-04-06",NULL,NULL),
(57,2,49,1,1,1,1,"ROOT","2021-04-18",NULL,NULL),
(61,2,55,1,1,1,1,"ROOT","2021-04-19",NULL,NULL),
(62,2,56,1,1,1,1,"ROOT","2021-04-19",NULL,NULL),
(63,2,58,1,1,1,1,"ROOT","2021-04-20",NULL,NULL),
(65,3,39,1,1,1,1,"ROOT","2021-04-29",NULL,NULL),
(66,3,33,1,1,1,1,"ROOT","2021-05-05",NULL,NULL),
(67,3,35,1,1,1,1,"ROOT","2021-05-05",NULL,NULL),
(68,3,36,1,1,1,1,"ROOT","2021-05-05",NULL,NULL),
(69,3,37,1,1,1,1,"ROOT","2021-05-05",NULL,NULL),
(70,3,41,1,1,1,1,"ROOT","2021-05-05",NULL,NULL),
(71,3,48,1,1,1,1,"ROOT","2021-05-05",NULL,NULL),
(72,3,44,1,1,1,1,"ROOT","2021-05-05",NULL,NULL),
(73,3,55,1,1,1,1,"ROOT","2021-05-05",NULL,NULL),
(74,3,40,1,1,1,1,"ROOT","2021-05-05",NULL,NULL),
(75,3,49,1,1,1,1,"ROOT","2021-05-05",NULL,NULL),
(76,3,56,1,1,1,1,"ROOT","2021-05-05",NULL,NULL),
(77,2,43,1,1,1,1,"ROOT","2021-05-26",NULL,NULL),
(78,6,49,1,1,1,1,"ROOT","2021-06-02",NULL,NULL);


DROP TABLE IF EXISTS `tbl_ms_preguntas`;

CREATE TABLE `tbl_ms_preguntas` (
  `id_pregunta` int(11) NOT NULL AUTO_INCREMENT,
  `pregunta` varchar(100) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `creado_por` varchar(15) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  `modificado_por` varchar(15) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_pregunta`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_ms_preguntas` VALUES (1,"¿Cuál es tu color favorito?",NULL,NULL,NULL,NULL,1),
(2,"¿Cuál es tu país favorito?",NULL,NULL,NULL,NULL,1),
(3,"¿Cuál es el nombre de tu mascota?",NULL,NULL,NULL,NULL,0);


DROP TABLE IF EXISTS `tbl_ms_preguntas_usuario`;

CREATE TABLE `tbl_ms_preguntas_usuario` (
  `id_preguntas_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_pregunta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `respuesta` varchar(30) NOT NULL,
  `creado_por` varchar(20) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_modificacion` date NOT NULL,
  `modificado_por` varchar(20) NOT NULL,
  PRIMARY KEY (`id_preguntas_usuario`) USING BTREE,
  KEY `usuarios_preguntas_respuestas` (`id_pregunta`) USING BTREE,
  CONSTRAINT `usuarios_preguntas_respuestas` FOREIGN KEY (`id_pregunta`) REFERENCES `tbl_ms_preguntas` (`id_pregunta`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_ms_preguntas_usuario` VALUES (16,1,27,"AZUL",27,"0000-00-00","0000-00-00",27),
(17,1,29,"ROJO",29,"0000-00-00","0000-00-00",29),
(18,1,30,"ROJO",30,"0000-00-00","0000-00-00",30),
(19,1,31,"ROJO",31,"0000-00-00","0000-00-00",31),
(20,1,33,"ROJO",33,"0000-00-00","0000-00-00",33),
(21,1,34,"ROJO",34,"0000-00-00","0000-00-00",34),
(22,1,35,"ROJO",35,"0000-00-00","0000-00-00",35),
(23,1,36,"VERDE",36,"0000-00-00","0000-00-00",36);


DROP TABLE IF EXISTS `tbl_ms_roles`;

CREATE TABLE `tbl_ms_roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(30) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `creado_por` varchar(15) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  `modificado_por` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_rol`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_ms_roles` VALUES (1,"Default",".","2021-02-22",NULL,"2021-03-25","ROOT"),
(2,"Administrador","Usuario administrativo","2021-02-22",NULL,"2021-03-13","ROOT"),
(3,"GERENTE","Usuario de ventas",NULL,NULL,"2021-04-29","ROOT"),
(4,"Ejecutivo","Usuario gerente","2021-03-13","",NULL,NULL),
(6,"EMPLEADO","EMPLEADO DE EMPRESA ","2021-04-29"," ",NULL,NULL);


DROP TABLE IF EXISTS `tbl_ms_token_usuario`;

CREATE TABLE `tbl_ms_token_usuario` (
  `id_token` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(60) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_inicial` varchar(30) NOT NULL,
  `fecha_final` varchar(30) NOT NULL,
  PRIMARY KEY (`id_token`) USING BTREE,
  KEY `token_usuario` (`id_usuario`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `tbl_ms_usuario`;

CREATE TABLE `tbl_ms_usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
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
  `intentos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`) USING BTREE,
  KEY `fk_TBL_MS_USUARIO_TBL_MS_ROLES1_idx` (`TBL_MS_ROLES_id_rol`) USING BTREE,
  KEY `estados_usuarios` (`id_estado_usuario`) USING BTREE,
  CONSTRAINT `estados_usuarios` FOREIGN KEY (`id_estado_usuario`) REFERENCES `tbl_ms_estado_usuario` (`id_estado_usuario`) ON UPDATE CASCADE,
  CONSTRAINT `fk_TBL_MS_USUARIO_TBL_MS_ROLES1` FOREIGN KEY (`TBL_MS_ROLES_id_rol`) REFERENCES `tbl_ms_roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_ms_usuario` VALUES (1,"Sin Registrar",1,"99875d29b6df38b2b484f1e8ec5979c7","","","","",2,"2021-02-22",NULL,NULL,NULL,"2021-02-25",NULL,NULL,NULL,"aEB2WDtQ6wJRYHb","23-02-2021 13:57:08","24-02-2021 13:57:08",NULL),
(2,"ROOT",1,"3d35b9cf36e4c5b56c13bdc336c39df4","Variedades","OTAC","M","CABRERAF8@GMAIL.COM",2,"2021-02-23","SUPERADMIN","2021-03-03",19,"2021-06-02","2021-02-23",NULL,1,"Token reclamado","31-05-2021 16:22:16","01-06-2021 16:22:16",3),
(36,"IRIS",1,"5dd8ca9c27af50d4c6a5de80bf0769b5","IRIS","TRIMINIO","F","CABRERAF83@GMAIL.COM",6,"2021-05-05","ROOT","2021-06-02",2,"2021-06-02","2021-05-05",NULL,1,"Token reclamado","02-06-2021 23:02:29","03-06-2021 23:02:29",3);


DROP TABLE IF EXISTS `tbl_perdidas`;

CREATE TABLE `tbl_perdidas` (
  `id_perdida` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad_perdida` int(11) NOT NULL,
  `TBL_PRODUCTOS_id_producto` int(11) NOT NULL,
  `TBL_KARDEX_id_kardex` int(11) NOT NULL,
  PRIMARY KEY (`id_perdida`) USING BTREE,
  KEY `fk_TBL_PERDIDAS_TBL_PRODUCTOS1_idx` (`TBL_PRODUCTOS_id_producto`) USING BTREE,
  KEY `fk_TBL_PERDIDAS_TBL_KARDEX1_idx` (`TBL_KARDEX_id_kardex`) USING BTREE,
  CONSTRAINT `fk_TBL_PERDIDAS_TBL_PRODUCTOS1` FOREIGN KEY (`TBL_PRODUCTOS_id_producto`) REFERENCES `tbl_productos` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `tbl_productos`;

CREATE TABLE `tbl_productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `id_proveedor` int(11) NOT NULL,
  `nombre_producto` varchar(45) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `desc_producto` varchar(100) NOT NULL,
  `precio_venta` decimal(9,2) NOT NULL,
  `cantidad_max` int(11) NOT NULL,
  `cantidad_min` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_producto`) USING BTREE,
  KEY `nombre_categoria` (`id_categoria`) USING BTREE,
  KEY `id_proveedor` (`id_proveedor`) USING BTREE,
  CONSTRAINT `tbl_productos_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `tbl_proveedores` (`id_proveedor`),
  CONSTRAINT `tbl_productos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `tbl_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `tbl_proveedores`;

CREATE TABLE `tbl_proveedores` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `proveedor` varchar(45) NOT NULL,
  `contacto` varchar(45) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_proveedor`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `tbl_tipo_kardex`;

CREATE TABLE `tbl_tipo_kardex` (
  `id_tipo_kardex` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo_kardex` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tipo_kardex`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_tipo_kardex` VALUES (1,"ENTRADA"),
(2,"SALIDA");


DROP TABLE IF EXISTS `tbl_ventas`;

CREATE TABLE `tbl_ventas` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_venta` datetime NOT NULL DEFAULT current_timestamp(),
  `isv` decimal(9,2) NOT NULL DEFAULT 0.00,
  `total_venta` decimal(10,2) NOT NULL,
  `usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  PRIMARY KEY (`id_venta`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;



SET foreign_key_checks = 1;
