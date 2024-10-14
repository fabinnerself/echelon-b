-- --------------------------------------------------------
-- Host:                         192.168.1.10
-- Server version:               8.0.39-0ubuntu0.20.04.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_echelon
DROP DATABASE IF EXISTS `db_echelon`;
CREATE DATABASE IF NOT EXISTS `db_echelon` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_echelon`;

-- Dumping structure for function db_echelon.fn_login
DELIMITER //
CREATE FUNCTION `fn_login`(
	`str_login` VARCHAR(50),
	`str_contrasenia` VARCHAR(50)
) RETURNS int
    READS SQL DATA
BEGIN
    DECLARE int_result INT;
    DECLARE int_count INT;

    /*

    select fn_login('soletud','1')

    */

    SELECT count(*) INTO  int_count
    FROM s_usuario
    WHERE u_login = str_login AND u_contrasenia = str_contrasenia;

    IF int_count = 0 THEN
        SELECT count(*) INTO int_count
        FROM s_usuario
        WHERE u_login = str_login;

        IF int_count >= 1 THEN
            SET int_result = -1;
        ELSE
            SELECT count(*) INTO int_count
            FROM s_usuario
            WHERE u_login = str_login and u_contrasenia = str_contrasenia;

            IF int_count >= 1 THEN
                SET int_result = -2;
            ELSE
                SET int_result = -3;
            END IF;
        END IF;
	else 
		SELECT usuario_id INTO  int_result
		FROM s_usuario
		WHERE u_login = str_login AND u_contrasenia = str_contrasenia;

    END IF;

    RETURN int_result;
END//
DELIMITER ;

-- Dumping structure for table db_echelon.s_usuario
CREATE TABLE IF NOT EXISTS `s_usuario` (
  `usuario_id` int NOT NULL AUTO_INCREMENT,
  `u_id_persona` int DEFAULT NULL,
  `u_nivel` int DEFAULT NULL,
  `u_login` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `u_contrasenia` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `u_id_usuario` int DEFAULT NULL,
  `u_fecha_add` datetime DEFAULT NULL,
  `u_id_usuario_mod` int DEFAULT NULL,
  `u_fecha_mod` datetime DEFAULT NULL,
  PRIMARY KEY (`usuario_id`),
  KEY `fk_id_persona` (`u_id_persona`),
  CONSTRAINT `s_usuario_ibfk_1` FOREIGN KEY (`u_id_persona`) REFERENCES `t_persona` (`persona_codigo`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Dumping data for table db_echelon.s_usuario: ~10 rows (approximately)
INSERT INTO `s_usuario` (`usuario_id`, `u_id_persona`, `u_nivel`, `u_login`, `u_contrasenia`, `u_id_usuario`, `u_fecha_add`, `u_id_usuario_mod`, `u_fecha_mod`) VALUES
	(1, 16, 100, 'sisec', '2', NULL, NULL, NULL, NULL),
	(6, 1, 1, 'sisec', '3', NULL, NULL, NULL, NULL),
	(7, 36, 1, 'medwin', '22', NULL, NULL, 1, '2024-06-29 03:22:54'),
	(8, 28, 1, 'lMECHI', '3', NULL, NULL, 1, '2024-06-29 03:24:00'),
	(9, 34, 1, 'Nadja', '123', NULL, NULL, NULL, NULL),
	(16, 103, 1, 'user1', '1', NULL, NULL, NULL, NULL),
	(17, 14, 1, 'user4', '9', NULL, NULL, NULL, NULL),
	(18, 107, 1, 'fmedina', '1', NULL, NULL, NULL, NULL),
	(19, 103, 1, 'user3', '1', NULL, NULL, NULL, NULL),
	(25, 17, 1, 'jmbarri', '3', 1, '2024-06-29 03:40:23', 1, '2024-06-29 03:41:16');

-- Dumping structure for table db_echelon.t_persona
CREATE TABLE IF NOT EXISTS `t_persona` (
  `persona_codigo` int NOT NULL AUTO_INCREMENT,
  `persona_primer_nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `persona_segundo_nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `persona_primer_apellido` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `persona_segundo_apellido` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `persona_ci` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `sexo` enum('M','F') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado_civil` enum('soltero','casado','divorciado','viudo') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `ciudad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `provincia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `pais` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `celular` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `titulo` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `p_fecha_nacimiento` datetime DEFAULT NULL,
  `p_user_add` int DEFAULT NULL,
  `p_fecha_add` datetime DEFAULT NULL,
  `p_user_mod` int DEFAULT NULL,
  `p_fecha_mod` datetime DEFAULT NULL,
  PRIMARY KEY (`persona_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Dumping data for table db_echelon.t_persona: ~42 rows (approximately)
INSERT INTO `t_persona` (`persona_codigo`, `persona_primer_nombre`, `persona_segundo_nombre`, `persona_primer_apellido`, `persona_segundo_apellido`, `persona_ci`, `sexo`, `estado_civil`, `direccion`, `ciudad`, `provincia`, `pais`, `email`, `telefono`, `celular`, `titulo`, `p_fecha_nacimiento`, `p_user_add`, `p_fecha_add`, `p_user_mod`, `p_fecha_mod`) VALUES
	(1, 'teresa', 'maria', 'Becerra', 'ferrufino', '457698lp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Lic', '1970-03-24 00:00:00', NULL, NULL, 10, '2024-06-28 20:04:28'),
	(2, 'Jorge', NULL, 'Miranda', 'Rios', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(3, 'Carlos', 'Rafael', 'Ledezma', 'Jordan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(4, 'DOROTHY', '', '', 'ANGULO', '', 'F', 'viudo', '', '', '', '', '', '', '', 'Ing.', '1970-12-01 00:00:00', NULL, NULL, 6, '2024-06-29 23:57:28'),
	(5, 'JUAN ', '', 'AYALA ', 'FUENTES', '123456', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '2024-06-03 00:00:00', NULL, NULL, NULL, NULL),
	(7, 'MARIO', 'FERNANDO', ' COSIO ', 'O.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(8, 'MARIO ', 'ENRIQUE ', 'SEVERICH', 'BUSTAMENTE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ing.', NULL, NULL, NULL, NULL, NULL),
	(9, 'JOSE', ' NELSON ', 'ROJAS ', 'ANGULO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(10, 'ROBERTO', NULL, ' JIMENEZ ', 'FERRUFINO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(11, 'WILSON', NULL, ' PONCE ', 'MONTERO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(13, 'raul', NULL, 'sanchez', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ing.', NULL, NULL, NULL, NULL, NULL),
	(14, 'Sabino ', NULL, 'Arnez ', 'Camacho', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(15, 'Norman  ', NULL, 'Juanes', 'Sanchez', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ing.', NULL, NULL, NULL, NULL, NULL),
	(16, 'sisec', NULL, '', NULL, '123456lp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ing.', '2013-11-01 00:00:00', NULL, NULL, NULL, NULL),
	(17, 'JUAN', 'MANUEL', 'BARRIENTOS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ing.', NULL, NULL, NULL, NULL, NULL),
	(18, 'ESTANISLAO', NULL, 'ALIAGA', 'FLORES', '471139 1H', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ing.', NULL, NULL, NULL, NULL, NULL),
	(19, 'ERWIN', 'SERGEI', 'VON BORRIES', 'DELGADILLO', '4829493 LP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Lic', '1981-05-05 00:00:00', NULL, NULL, NULL, NULL),
	(20, 'JUAN', 'CARLOS', 'CORONADO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ing.', NULL, NULL, NULL, NULL, NULL),
	(22, 'JUAN', 'PABLO', 'DIAZ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ing.', NULL, NULL, NULL, NULL, NULL),
	(24, 'ORLANDO', NULL, 'REYES', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ing.', NULL, NULL, NULL, NULL, NULL),
	(25, 'jose', NULL, 'mariaca', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(26, 'pablo', NULL, 'palacios', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(27, 'pablo', NULL, 'badani', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(28, 'MERCEDES', NULL, 'LOAYZA', 'MOLINA', '147212', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Lic', NULL, NULL, NULL, NULL, NULL),
	(29, 'FERNANDO', NULL, 'GIL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ing.', NULL, NULL, NULL, NULL, NULL),
	(30, 'RODMY', NULL, 'ALANEZ', 'MEDINA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(31, 'MAURICIO', NULL, 'ROJAS', 'QUIROZ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(32, 'WALTER', NULL, 'ZULETA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(33, 'Monica', NULL, 'Coria', 'Martinez', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(34, 'Nadja', 'Carmen', 'Peña', 'Chumacero', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(35, 'RONALD', NULL, 'OVANDO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(36, 'EDWIN', NULL, 'MERCADO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(37, 'TICONA', '', 'Waltico', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '2022-06-01 00:00:00', NULL, NULL, NULL, NULL),
	(38, 'OMAR', '', 'FERREIRA', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Lic', '2024-06-01 00:00:00', NULL, NULL, NULL, NULL),
	(99, 'iñigo', '', 'walters', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '2024-06-24 00:00:00', NULL, NULL, NULL, NULL),
	(101, 'bb', '', 'aa', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '2024-06-07 00:00:00', NULL, NULL, NULL, NULL),
	(102, 'aa', 'erty', 'b', 'gfg', '451278', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ing.', '2024-06-08 00:00:00', NULL, NULL, NULL, NULL),
	(103, ' bb', '', 'aa', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '2024-01-03 00:00:00', NULL, NULL, NULL, NULL),
	(104, 'cc', '', 'aa', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '2024-02-01 00:00:00', NULL, NULL, NULL, NULL),
	(106, 'juan', 'carlos', 'mendoza', 'medrano', '561234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Doc', '2024-06-02 00:00:00', NULL, NULL, 10, '2024-06-28 20:03:24'),
	(107, 'favian', '', 'medina', '', '3499808', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Lic', '1973-01-20 00:00:00', NULL, NULL, NULL, NULL),
	(111, 'raul', 'gato', 'Bolivia', 'tigre', '', 'M', 'soltero', 'calle corneta mamani #12', '', 'La Paz', 'Bolivia', 'gato.negro@yahoo.com', '2238178', '73888773', 'Ing.', '2024-06-05 00:00:00', 6, '2024-06-29 23:18:27', 6, '2024-06-29 23:55:24');

-- Dumping structure for view db_echelon.v_empresa
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_empresa` (
	`empresa_id` INT(10) NOT NULL,
	`e_nombre` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`e_tipo` VARCHAR(10) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`e_direccion` VARCHAR(15) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`e_pais` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`e_email` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`e_celular` VARCHAR(20) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`e_duns` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_spanish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_echelon.v_persona
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_persona` (
	`persona_codigo` INT(10) NOT NULL,
	`nombres` VARCHAR(203) NULL COLLATE 'utf8mb4_spanish_ci',
	`ci` VARCHAR(10) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`fecha_nacimiento` VARCHAR(10) NOT NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_echelon.v_usuario
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_usuario` (
	`usuario_id` INT(10) NOT NULL,
	`u_nivel` INT(10) NULL,
	`u_login` VARCHAR(20) NULL COLLATE 'utf8mb4_spanish_ci',
	`nombres` VARCHAR(203) NULL COLLATE 'utf8mb4_spanish_ci',
	`ci` VARCHAR(10) NOT NULL COLLATE 'utf8mb4_spanish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_echelon.v_empresa
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_empresa`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_empresa` AS select `t_empresa`.`empresa_id` AS `empresa_id`,`t_empresa`.`e_nombre` AS `e_nombre`,coalesce(`t_empresa`.`e_tipo`,'') AS `e_tipo`,coalesce(left(`t_empresa`.`e_direccion`,15),'') AS `e_direccion`,coalesce(`t_empresa`.`e_pais`,'') AS `e_pais`,coalesce(`t_empresa`.`e_email`,'') AS `e_email`,coalesce(`t_empresa`.`e_celular`,'') AS `e_celular`,coalesce(`t_empresa`.`e_duns`,'') AS `e_duns` from `t_empresa`;

-- Dumping structure for view db_echelon.v_persona
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_persona`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_persona` AS select `p`.`persona_codigo` AS `persona_codigo`,trim(upper(concat_ws(' ',`p`.`persona_primer_apellido`,trim(coalesce(`p`.`persona_segundo_apellido`,'')),trim(`p`.`persona_primer_nombre`),trim(coalesce(`p`.`persona_segundo_nombre`,''))))) AS `nombres`,coalesce(`p`.`persona_ci`,'') AS `ci`,coalesce(date_format(`p`.`p_fecha_nacimiento`,'%d-%m-%Y'),'') AS `fecha_nacimiento` from `t_persona` `p` where (`p`.`persona_codigo` <> 16);

-- Dumping structure for view db_echelon.v_usuario
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_usuario`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_usuario` AS select `s_usuario`.`usuario_id` AS `usuario_id`,`s_usuario`.`u_nivel` AS `u_nivel`,`s_usuario`.`u_login` AS `u_login`,`v_persona`.`nombres` AS `nombres`,`v_persona`.`ci` AS `ci` from (`s_usuario` join `v_persona` on((`s_usuario`.`u_id_persona` = `v_persona`.`persona_codigo`)));

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
