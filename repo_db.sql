-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para repo_poo
CREATE DATABASE IF NOT EXISTS `repo_poo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `repo_poo`;

-- Volcando estructura para tabla repo_poo.carreras
CREATE TABLE IF NOT EXISTS `carreras` (
  `carrera_id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `escuela_id` int NOT NULL,
  PRIMARY KEY (`carrera_id`),
  KEY `FK_carreras_escuelas` (`escuela_id`),
  CONSTRAINT `FK_carreras_escuelas` FOREIGN KEY (`escuela_id`) REFERENCES `escuelas` (`escuela_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla repo_poo.carreras: ~18 rows (aproximadamente)
INSERT INTO `carreras` (`carrera_id`, `nombre`, `escuela_id`) VALUES
	(1, 'Ingeniería de Software con Inteligencia Artificial', 1),
	(2, 'Desarrollo de Software', 1),
	(3, 'Soporte y Mantenimiento de Equipos de Computación', 1),
	(4, 'Diseño Gráfico Digital', 1),
	(5, 'Diseño de Estructuras Metálicas y de Construcción', 1),
	(6, 'Redes y seguridad Infromática', 1),
	(7, 'Ingeniería de Ciberseguridad', 1),
	(8, 'Ingenería de Soporte de TI ', 1),
	(9, 'Mecánico Automotriz', 2),
	(10, 'Mecánico de Mantenimiento de Maquinaria Pesada', 2),
	(11, 'Mecánico de Maquinaria Pesada', 2),
	(12, 'Mecatrónica Automotriz', 2),
	(13, 'Administración Industrial', 7),
	(14, 'Seguridad Industrial y Prevención de Riesgos', 7),
	(15, 'Seguridad Industrial y Prevención de Riesgos', 7),
	(16, 'Administración de Empresas', 7),
	(17, 'Administración de Negocios Internacionales', 7),
	(18, 'Mecatrónica Textil', 8);

-- Volcando estructura para tabla repo_poo.detalle_tramite
CREATE TABLE IF NOT EXISTS `detalle_tramite` (
  `detalle_id` int NOT NULL AUTO_INCREMENT,
  `tramite_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `instructor_id` int DEFAULT NULL,
  `estado_id` tinyint(1) NOT NULL,
  `jurados` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `fecha_revision` datetime DEFAULT NULL,
  `fecha_sustentacion` datetime DEFAULT NULL,
  `fecha_publicacion` datetime DEFAULT NULL,
  `nota` tinyint DEFAULT NULL,
  PRIMARY KEY (`detalle_id`),
  KEY `FK_detalle_tramite_tramites` (`tramite_id`),
  KEY `FK_detalle_tramite_usuarios` (`instructor_id`),
  KEY `FK_detalle_tramite_estados` (`estado_id`),
  CONSTRAINT `FK_detalle_tramite_estados` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`estado_id`),
  CONSTRAINT `FK_detalle_tramite_tramites` FOREIGN KEY (`tramite_id`) REFERENCES `tramites` (`tramite_id`),
  CONSTRAINT `FK_detalle_tramite_usuarios` FOREIGN KEY (`instructor_id`) REFERENCES `usuarios` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='campo estado:\r\n0=cancelado\r\n1= enviado,\r\n2=observado,\r\n3=corregido,\r\n4=revisado,\r\n5=sustentacion,\r\n6=desaprobado,\r\n7=aprobado,\r\n8=publicado,';

-- Volcando datos para la tabla repo_poo.detalle_tramite: ~11 rows (aproximadamente)
INSERT INTO `detalle_tramite` (`detalle_id`, `tramite_id`, `instructor_id`, `estado_id`, `jurados`, `fecha_revision`, `fecha_sustentacion`, `fecha_publicacion`, `nota`) VALUES
	(1, 'TR_6449368b649ae_1341793', 1341790, 6, '1341791,1341800', '2023-05-02 17:10:59', '2023-05-02 14:14:00', '2023-05-02 17:44:46', 13),
	(2, 'TR_6449368b649ae_1341792', 1341790, 6, '1341791,1341800', '2023-05-02 17:10:59', '2023-05-02 14:14:00', '2023-05-02 17:44:46', 14),
	(3, 'TR_6449678fadb7e_1341797', 1341791, 7, NULL, NULL, NULL, NULL, NULL),
	(4, 'TR_644967d03a511_1341796', 1341798, 4, '1341799', '2023-05-02 16:29:44', '2023-05-09 19:34:00', NULL, NULL),
	(5, 'TR_644ee2491f8ff_1341795', 1341800, 4, '1341791', '2023-05-02 19:58:09', '2023-05-07 14:59:00', NULL, NULL),
	(6, 'TR_644ee56ea2b42_1341794', NULL, 7, NULL, NULL, NULL, NULL, NULL),
	(7, 'TR_644ee66794794_1341794', 1341799, 6, '1341790,1341791', '2023-05-03 15:02:45', '2023-05-10 16:31:00', '2023-05-11 15:28:24', 11),
	(8, 'TR_6452d706d5c5f_1341801', 1341800, 4, '1341790,1341799', '2023-05-03 16:51:49', '2023-05-15 16:00:00', NULL, NULL),
	(10, 'TR_6457ad40ca619_1341802', 1341790, 7, NULL, '2023-05-07 12:52:18', NULL, NULL, NULL),
	(11, 'TR_6457f1612515d_1341803', 1341790, 3, NULL, '2023-05-07 22:38:10', NULL, NULL, NULL),
	(12, 'TR_6457f1612515d_1341802', 1341790, 3, NULL, '2023-05-07 22:38:10', NULL, NULL, NULL);

-- Volcando estructura para tabla repo_poo.escuelas
CREATE TABLE IF NOT EXISTS `escuelas` (
  `escuela_id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`escuela_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla repo_poo.escuelas: ~16 rows (aproximadamente)
INSERT INTO `escuelas` (`escuela_id`, `nombre`) VALUES
	(1, 'Tecnologías de la Información'),
	(2, 'Mecánica Automotriz'),
	(3, 'Escuela Superior de Tecnología'),
	(4, 'Electrotecnia'),
	(5, 'Agroindustria'),
	(6, 'Industrias Alimentarias'),
	(7, 'Administración de empresas'),
	(8, 'Textil'),
	(9, 'Confecciones'),
	(10, 'Tecnologías Ambientales'),
	(11, 'Artes Gráficas'),
	(12, 'Metalmecánica'),
	(13, 'Mantenimiento'),
	(14, 'Hotelería y Turismo'),
	(15, 'Comunicaciones'),
	(16, 'Centro Tecnológico de Textiles y Confecciones');

-- Volcando estructura para tabla repo_poo.estados
CREATE TABLE IF NOT EXISTS `estados` (
  `estado_id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`estado_id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Tabla de estados en los que se puede encontrar un tramite.';

-- Volcando datos para la tabla repo_poo.estados: ~7 rows (aproximadamente)
INSERT INTO `estados` (`estado_id`, `nombre`, `descripcion`, `color`) VALUES
	(1, 'ENVIADO', 'El proyecto ya fue subido, espere a que el área académica lo derive a un instructor el cual lo revisará.', '#000'),
	(2, 'EN REVISIÓN', 'Su proyecto ya fue asignado a un instructor y se encuentra en revisión. Espere la aprobación o las observaciones del instructor.', '#ffc107'),
	(3, 'PASADO', 'El instructor aprobó tu proyecto, ahora pasó a disposición del área académica. Espere la agenda de sustentación o las observaciones.', '#0049d0'),
	(4, 'EN SUSTENTACIÓN', 'Ya se agendó la sustentación de tu proyecto. Los detalles se enviaron a tu correo institucional.', '#023047'),
	(5, 'CALIFICADO', 'Su proyecto ya fue calificado. Los detalles de la sustentación puede verlos en la vista de tu proyecto.', '#1998BD'),
	(6, 'PUBLICADO', 'Tu proyecto fue publicado en el repositorio insititucional.', '#47c387'),
	(7, 'CANCELADO', 'Cancelaste este proceso. Puedes generar otro si deseas.', '#363f48');

-- Volcando estructura para tabla repo_poo.observaciones
CREATE TABLE IF NOT EXISTS `observaciones` (
  `observacion_id` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `proyecto_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `autor_id` int NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `fecha_gen` datetime NOT NULL,
  PRIMARY KEY (`observacion_id`),
  KEY `FK_observaciones_proyectos` (`proyecto_id`),
  KEY `FK_observaciones_usuarios` (`autor_id`),
  CONSTRAINT `FK_observaciones_proyectos` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`proyecto_id`),
  CONSTRAINT `FK_observaciones_usuarios` FOREIGN KEY (`autor_id`) REFERENCES `usuarios` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Tabla de observaciones a los proyectos de los tramites.puden ser generados por el instructore o por el area academica.\r\nel estado de la sustentacion por defecto: tine valores:\r\n1=por corregir \r\n2=corregida.\r\n3=verificada';

-- Volcando datos para la tabla repo_poo.observaciones: ~5 rows (aproximadamente)
INSERT INTO `observaciones` (`observacion_id`, `descripcion`, `proyecto_id`, `autor_id`, `estado`, `fecha_gen`) VALUES
	(7, 'tambein corrige esto mano\r\n', 'PR_6457ad40caa04', 1341790, 3, '2023-05-07 10:15:16'),
	(8, 'esto tambien corrige', 'PR_6457ad40caa04', 1341790, 3, '2023-05-07 10:28:09'),
	(9, 'sdsdfsd', 'PR_6457ad40caa04', 1341790, 3, '2023-05-07 12:48:45'),
	(10, 'corige', 'PR_6457f16125169', 1341790, 3, '2023-05-07 21:50:26'),
	(11, 'esto tambien', 'PR_6457f16125169', 1341790, 3, '2023-05-07 21:50:34');

-- Volcando estructura para tabla repo_poo.proyectos
CREATE TABLE IF NOT EXISTS `proyectos` (
  `proyecto_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `titulo` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tipo` tinyint(1) NOT NULL,
  `descripcion` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nombre_archivo` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`proyecto_id`),
  UNIQUE KEY `nombre_archivo` (`nombre_archivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla repo_poo.proyectos: ~9 rows (aproximadamente)
INSERT INTO `proyectos` (`proyecto_id`, `titulo`, `tipo`, `descripcion`, `nombre_archivo`) VALUES
	('PR_6449368b649de', 'SISTEMA DE FACTURACIÓN GENÉRICO', 2, 'De proyecto es nuestri y ba  bla bla bak jia ddjflj hdfjashdfjkshdjfhsakjdf kdjh jsd fsadiu h adsua diuh apdiufhpqw 9e usdhfpjash dfjiwhdj ahdfjash dhoqwheoh´qh fhdnxcvzxnvb zbvzc,mbzmcvn{,n{pqj ´fijh eoihkjsbcvnb adljkvb ajsdv.', '1682890268_PROYECTO_DE_MEJORA.pdf'),
	('PR_6449678fadb88', 'SISTEMA DE ANNY', 1, 'EIUh ih isdh isuhd iusdh iusd fiushdi usdihcbojvoeurygoweu ghfuhfdiuvhiodfvb ojbpsifvp sdfv bfvbfpivh isofjvh oijdfvh oiufhv ui hfh  if uhdfvi dfuv iudfhv iufh viudfhiu fh vuidf vu fd.', '1682532239_carta_de_garantia_ASUS .pdf'),
	('PR_644967d03a51b', 'PROYECTO DE JULIAN', 3, 'jdsh iusdhfiushdfi ushdfiuhs difuh sdiuf hisduhoauihdiuahdslihasd fhisahdf asdh fia ashg ajdgsh ajdshgjasdasd asd.', '1683062960_clase_060423.pdf'),
	('PR_644ee2491fbcf', 'SISTEMA DE LICY', 1, 'este proyecto es de licy hjd fgalkjsdhfglajksdhflkajsdhflkajshd flkjahsdflkjahsldkjfh alksdjfh lakjsdh flkajsdh ilajsh.', '1682891337_MUÑOZ_CARRILLO_(1).pdf'),
	('PR_644ee56ea2b4c', 'SISTEMA DE JOSUE', 3, 'Este sistema pertenece a jhon sdhgf asudg faisghdfhagsdkfhgaskdfhgasdufya . jhon.', '1682892142_Fundamentos_del_AZURE.pdf'),
	('PR_644ee667947a4', 'SISTEMA DE JOSUE', 3, 'este sistema es de jhon sdghasdfkahgsdfkjhagsdfjkhags dkfjhg diugwoeiugfqiub.', '1682893185_20608004590-03-B004-00001446.pdf'),
	('PR_6452d706d5dbc', 'SISTEMA DE DENNIS', 1, 'Este es mi sistema, sistema de dennis asdhfvbajkshdfg ahsjdfgajk hsdgfkaj hgdfkjhagskdjfhgak dhfg udhg akjhdsfgkajhds.', '1683150598_carta_de_garantia_ASUS_.pdf'),
	('PR_6457ad40caa04', 'SISTEMA DE KEVIN', 3, 'sdf swertyu ytq werewrsdfasdfasd', '1683467584_20608004590-03-B004-00001446.pdf'),
	('PR_6457f16125169', 'SISTEMA DE KEVIN Y KIMMY', 3, 'Este sistema es de kevin y jimmyjh dfkjsdfjsdhfjklsdfjhksdfkhjgs djkhfg sjkhdfg jshd fjhsgdfhjk skdhfg kshjdfg kjshdg fkhjsgdkjh gsjkhdg fhjksdg fkhjsdg fjkhsdgfkjhsg.', '1683485025_PEA_PIAD_202010_–_Ingeniería_de_Software_con_Inteligencia_Artificial_(inc_CC)_(1).pdf');

-- Volcando estructura para tabla repo_poo.sedes
CREATE TABLE IF NOT EXISTS `sedes` (
  `sede_id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `zonal_id` int NOT NULL,
  PRIMARY KEY (`sede_id`),
  KEY `FK_sedes_zonales` (`zonal_id`),
  CONSTRAINT `FK_sedes_zonales` FOREIGN KEY (`zonal_id`) REFERENCES `zonales` (`zonal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla repo_poo.sedes: ~13 rows (aproximadamente)
INSERT INTO `sedes` (`sede_id`, `nombre`, `zonal_id`) VALUES
	(1, 'Ayacucho', 5),
	(2, 'Callao', 9),
	(3, 'Cercado de Lima', 9),
	(4, 'Arequipa', 2),
	(5, 'Cajamarca', 3),
	(6, 'Callao - Ventanilla', 9),
	(7, 'Cercado de Lima', 9),
	(8, 'Cusco', 4),
	(9, 'Ica', 5),
	(10, 'Pisco', 5),
	(11, 'Tarapoto', 10),
	(12, 'Tumbes', 12),
	(13, 'Tacna', 11);

-- Volcando estructura para tabla repo_poo.tramites
CREATE TABLE IF NOT EXISTS `tramites` (
  `tramite_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `estudiante_id` int NOT NULL,
  `estudiante_generador` int NOT NULL,
  `proyecto_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_gen` datetime NOT NULL,
  PRIMARY KEY (`tramite_id`),
  KEY `FK_tramites_proyectos` (`proyecto_id`),
  KEY `FK_tramites_usuarios` (`estudiante_id`),
  KEY `FK_tramites_usuarios_2` (`estudiante_generador`),
  CONSTRAINT `FK_tramites_proyectos` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`proyecto_id`),
  CONSTRAINT `FK_tramites_usuarios` FOREIGN KEY (`estudiante_id`) REFERENCES `usuarios` (`usuario_id`),
  CONSTRAINT `FK_tramites_usuarios_2` FOREIGN KEY (`estudiante_generador`) REFERENCES `usuarios` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla repo_poo.tramites: ~11 rows (aproximadamente)
INSERT INTO `tramites` (`tramite_id`, `estudiante_id`, `estudiante_generador`, `proyecto_id`, `fecha_gen`) VALUES
	('TR_6449368b649ae_1341792', 1341792, 1341793, 'PR_6449368b649de', '2023-04-26 09:34:51'),
	('TR_6449368b649ae_1341793', 1341793, 1341793, 'PR_6449368b649de', '2023-04-26 09:34:51'),
	('TR_6449678fadb7e_1341797', 1341797, 1341797, 'PR_6449678fadb88', '2023-04-26 13:03:59'),
	('TR_644967d03a511_1341796', 1341796, 1341796, 'PR_644967d03a51b', '2023-04-26 13:05:04'),
	('TR_644ee2491f8ff_1341795', 1341795, 1341795, 'PR_644ee2491fbcf', '2023-04-30 16:48:57'),
	('TR_644ee56ea2b42_1341794', 1341794, 1341794, 'PR_644ee56ea2b4c', '2023-04-30 17:02:22'),
	('TR_644ee66794794_1341794', 1341794, 1341794, 'PR_644ee667947a4', '2023-04-30 17:06:31'),
	('TR_6452d706d5c5f_1341801', 1341801, 1341801, 'PR_6452d706d5dbc', '2023-05-03 16:49:58'),
	('TR_6457ad40ca619_1341802', 1341802, 1341802, 'PR_6457ad40caa04', '2023-05-07 08:53:04'),
	('TR_6457f1612515d_1341802', 1341802, 1341802, 'PR_6457f16125169', '2023-05-07 13:43:45'),
	('TR_6457f1612515d_1341803', 1341803, 1341802, 'PR_6457f16125169', '2023-05-07 13:43:45');

-- Volcando estructura para tabla repo_poo.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuario_id` int NOT NULL AUTO_INCREMENT,
  `dni` int NOT NULL DEFAULT '0',
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `telefono` int NOT NULL,
  `direccion` varchar(70) NOT NULL,
  `tipo` tinyint(1) NOT NULL DEFAULT '0',
  `sede_id` int NOT NULL,
  `carrera_id` int DEFAULT NULL,
  `isActive` bit(1) NOT NULL,
  PRIMARY KEY (`usuario_id`) USING BTREE,
  UNIQUE KEY `dni` (`dni`),
  UNIQUE KEY `correo` (`correo`),
  KEY `FK_usuarios_sedes` (`sede_id`),
  KEY `FK_usuarios_carreras` (`carrera_id`),
  CONSTRAINT `FK_usuarios_carreras` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`carrera_id`),
  CONSTRAINT `FK_usuarios_sedes` FOREIGN KEY (`sede_id`) REFERENCES `sedes` (`sede_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1341806 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla repo_poo.usuarios: ~18 rows (aproximadamente)
INSERT INTO `usuarios` (`usuario_id`, `dni`, `nombres`, `apellidos`, `correo`, `password`, `telefono`, `direccion`, `tipo`, `sede_id`, `carrera_id`, `isActive`) VALUES
	(1341788, 48494848, 'JHON', 'MUÑOZ', 'jhon@senati.pe', 'jhon123', 989098098, '-...', 1, 1, NULL, b'1'),
	(1341789, 44444444, 'ALICIA', 'CONCYTEC', 'alicia@senati.pe', 'alicia123', 999999999, '.....', 1, 2, NULL, b'1'),
	(1341790, 45645645, 'JOSE', 'VALENCIA', 'jose@senati.pe', 'jose123', 900000000, '....', 2, 1, 1, b'1'),
	(1341791, 45432121, 'JENNY', 'ORTEGA', 'jenny@senati.pe', 'jenny123', 955555555, '.---', 2, 1, 1, b'1'),
	(1341792, 71749111, 'ISRAEL', 'MUÑOZ CARRILLO', '1341792@senati.pe', 'isra123', 921921921, '...', 3, 1, 1, b'1'),
	(1341793, 71749122, 'JHONAN', 'MUÑOZ CARRILLO', '1341793@senati.pe', 'jhonan123', 993884118, '....', 3, 1, 1, b'1'),
	(1341794, 71749123, 'JOSUE', 'MUÑOZ CARRILLO', '1341794@senati.pe', 'josue123', 909090909, '...', 3, 1, 2, b'1'),
	(1341795, 71749124, 'LICY', 'ORTEGA', '1341795@senati.pe', 'licy123', 909898989, '...', 3, 1, 1, b'1'),
	(1341796, 71749125, 'JULIAN', 'QQQQ', '1341796@senati.pe', 'julian123', 987678767, '...', 3, 1, 2, b'1'),
	(1341797, 71749126, 'ANNY', 'HUEE', '1341797@senati.pe', 'anny123', 909000000, '...', 3, 1, 1, b'1'),
	(1341798, 67676767, 'INS', 'DEL VALLE', 'ins@senati.pe', 'ins123', 900909099, '...', 2, 1, 2, b'1'),
	(1341799, 73737373, 'JACK', 'MORALES', 'jack@senati.pe', 'jack123', 990909878, '...', 2, 1, 2, b'1'),
	(1341800, 77777777, 'LUCIANO', 'URBANO', 'luciano@senati.pe', 'luciano123', 909878767, '..', 2, 1, 1, b'1'),
	(1341801, 43456545, 'DENNIS', 'JERI', '1341801@senati.pe', 'dennis123', 909898765, '...', 3, 1, 1, b'1'),
	(1341802, 12121212, 'KEVIN', 'CONTERAS MUJE', '1341802@senati.pe', 'kevin123', 989878987, '...', 3, 1, 1, b'1'),
	(1341803, 12131313, 'JIMMY', 'MUJE', '1341803@senati.pe', 'jimmy123', 908990989, '...', 3, 1, 1, b'1'),
	(1341804, 44454545, 'JEE', 'HIEL', '1341804@senati.pe', 'je123', 909098987, '..', 3, 1, 1, b'1'),
	(1341805, 66766766, 'YOY', 'SANCHES', '1341805@senati.pe', 'yoy123', 909019000, '..', 3, 1, 1, b'1');

-- Volcando estructura para tabla repo_poo.zonales
CREATE TABLE IF NOT EXISTS `zonales` (
  `zonal_id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`zonal_id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla repo_poo.zonales: ~13 rows (aproximadamente)
INSERT INTO `zonales` (`zonal_id`, `nombre`) VALUES
	(1, 'Zonal Ancash'),
	(2, 'Zonal Arequipa - Puno'),
	(3, 'Zonal Cajamarca-Amazonas-San Martín'),
	(4, 'Zonal Cusco - Apurimac - Madre de Dios'),
	(5, 'Zonal Ica - Ayacucho'),
	(6, 'Zonal Junín - Pasco - Huancavelica'),
	(7, 'Zonal La Libertad'),
	(8, 'Zonal Lambayeque'),
	(9, 'Zonal Lima - Callao'),
	(10, 'Zonal Loreto'),
	(11, 'Zonal Moquegua - Tacna'),
	(12, 'Zonal Piura - Tumbes'),
	(13, 'Zonal Ucayali - Huánuc');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
