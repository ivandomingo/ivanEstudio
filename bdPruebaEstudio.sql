-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.6.14 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura de base de datos para pruebaestudio
CREATE DATABASE IF NOT EXISTS `pruebaestudio` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `pruebaestudio`;


-- Volcando estructura para tabla pruebaestudio.articulos
CREATE TABLE IF NOT EXISTS `articulos` (
  `idArticulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombreArticulo` varchar(50) NOT NULL DEFAULT '0',
  `descripcionArticulo` varchar(50) DEFAULT '0',
  `precioArticulo` decimal(10,2) DEFAULT '0.00',
  `idCategorias` int(11) DEFAULT '0',
  PRIMARY KEY (`idArticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Volcando datos para la tabla pruebaestudio.articulos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `articulos` DISABLE KEYS */;
INSERT INTO `articulos` (`idArticulo`, `nombreArticulo`, `descripcionArticulo`, `precioArticulo`, `idCategorias`) VALUES
	(1, 'Windows 8', 'Sistema Operativo', 200.00, 1),
	(2, 'Photoshop CS7', 'Diseñador', 150.00, 2);
/*!40000 ALTER TABLE `articulos` ENABLE KEYS */;


-- Volcando estructura para tabla pruebaestudio.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCategoria` varchar(50) NOT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Volcando datos para la tabla pruebaestudio.categorias: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` (`idCategoria`, `nombreCategoria`) VALUES
	(1, 'S.O'),
	(2, 'Diseño');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;


-- Volcando estructura para tabla pruebaestudio.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `telefono` int(9) NOT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Volcando datos para la tabla pruebaestudio.clientes: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`idCliente`, `nombre`, `apellido1`, `apellido2`, `telefono`, `direccion`, `email`, `dni`, `login`, `password`) VALUES
	(1, 'Emilio', 'Honrubia', 'Marin', 961330445, 'Reyes Catolicos 9-19', 'emilioxiri@gmail.com', '48584765w', 'emilioxiri', 'root'),
	(2, 'Christian', 'Perez', 'Bernal', 961330554, 'Palleter 3A Pta 3', 'christianperez33@gmail.com', '47755210H', 'christianperez33', 'root');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;


-- Volcando estructura para tabla pruebaestudio.detallepedidos
CREATE TABLE IF NOT EXISTS `detallepedidos` (
  `idDetallePedidos` int(11) NOT NULL AUTO_INCREMENT,
  `idPedido` int(11) NOT NULL DEFAULT '0',
  `idProducto` int(11) NOT NULL DEFAULT '0',
  `precioUnidad` int(11) NOT NULL DEFAULT '0',
  `unidades` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idDetallePedidos`,`idPedido`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla pruebaestudio.detallepedidos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `detallepedidos` DISABLE KEYS */;
INSERT INTO `detallepedidos` (`idDetallePedidos`, `idPedido`, `idProducto`, `precioUnidad`, `unidades`) VALUES
	(1, 4, 1, 200, 3),
	(2, 4, 2, 150, 3);
/*!40000 ALTER TABLE `detallepedidos` ENABLE KEYS */;


-- Volcando estructura para tabla pruebaestudio.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `idPedido` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `totalPedido` double DEFAULT '0',
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPedido`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla pruebaestudio.pedidos: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` (`idPedido`, `fecha`, `totalPedido`, `usuario`) VALUES
	(1, '0000-00-00', 600, 1),
	(2, '0000-00-00', 600, 1),
	(3, '0000-00-00', 1050, 1),
	(4, '0000-00-00', 1050, 1);
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
