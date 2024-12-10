-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando datos para la tabla bdinventario.categorias: ~2 rows (aproximadamente)
INSERT INTO `categorias` (`id`, `nombre`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(3, 'Papeleria', '2024-12-03 20:41:13', '2024-12-03 20:41:13', NULL),
	(4, 'Aseo', '2024-12-04 03:36:04', '2024-12-04 03:36:04', NULL);

-- Volcando datos para la tabla bdinventario.failed_jobs: ~0 rows (aproximadamente)

-- Volcando datos para la tabla bdinventario.infomovimientos: ~4 rows (aproximadamente)
INSERT INTO `infomovimientos` (`id`, `mensaje`, `vicepresidencia`, `observaciones`, `idMovimientoProducto`, `created_at`, `updated_at`, `direccion`, `departamento`) VALUES
	(20, 'Prueba', 'Tecnologia', NULL, 20, '2024-12-04 02:01:17', '2024-12-04 02:01:17', '', ''),
	(21, NULL, 'Tecnologia', NULL, 21, '2024-12-04 04:05:05', '2024-12-04 04:05:05', '', ''),
	(22, NULL, 'Tecnologia', NULL, 22, '2024-12-05 02:55:47', '2024-12-05 02:55:47', 'Finanzas', 'Recursos Humanos'),
	(23, NULL, 'Tecnologia', NULL, 23, '2024-12-10 21:47:32', '2024-12-10 21:47:32', 'Marketing', 'Operaciones');

-- Volcando datos para la tabla bdinventario.migrations: ~0 rows (aproximadamente)

-- Volcando datos para la tabla bdinventario.movimientos_productos: ~4 rows (aproximadamente)
INSERT INTO `movimientos_productos` (`id`, `cantidadUsada`, `idProducto`, `idUsuario`, `fecha`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(20, 1.00, 13, 13, '2024-12-03', '2024-12-04 02:01:17', '2024-12-05 03:18:45', '2024-12-05 03:18:45'),
	(21, 8.00, 14, 13, '2024-12-03', '2024-12-04 04:05:05', '2024-12-09 18:53:58', '2024-12-09 18:53:58'),
	(22, 1.00, 14, 13, '2024-12-04', '2024-12-05 02:55:47', '2024-12-09 18:54:03', '2024-12-09 18:54:03'),
	(23, 1.00, 18, 13, '2024-12-10', '2024-12-10 21:47:32', '2024-12-10 21:47:32', NULL);

-- Volcando datos para la tabla bdinventario.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando datos para la tabla bdinventario.personal_access_tokens: ~0 rows (aproximadamente)

-- Volcando datos para la tabla bdinventario.productos: ~6 rows (aproximadamente)
INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `imagen`, `cantidad`, `idCategoria`, `unidad_medida_id`, `cantidad_minima`, `fecharegistro`, `cantidad_unidad_compuesta`, `cantidad_total`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(13, 'Lapiz', 'Producto', 'uploads/1733242197_logo.png', 0.00, 3, 6, 1.00, '2024-12-03', NULL, NULL, '2024-12-03 20:42:48', '2024-12-09', '2024-12-04 03:44:49'),
	(14, 'Lapiz', 'sasa', 'uploads/1733265739_Log.png', 1.00, 4, 10, 0.00, '2024-12-03', 1.0000, 1.0000, '2024-12-04 03:42:19', '2024-12-09', '2024-12-09 18:53:31'),
	(15, 'Lapiz', 'as', '/assets/Recursos/prodef.jpg', 1.00, 4, 6, 0.00, '2024-12-09', NULL, 1.0000, '2024-12-09 21:06:28', '2024-12-09', NULL),
	(16, 'Lapiz', 'aa', '/assets/Recursos/prodef.jpg', 1.00, 4, 7, 0.00, '2024-12-09', NULL, NULL, '2024-12-09 21:09:51', '2024-12-10', NULL),
	(17, 'asas', 'assas', '/assets/Recursos/prodef.jpg', 1.00, 3, 9, 1.00, '2024-12-10', 1.0000, 1.0000, '2024-12-10 20:30:05', '2024-12-10', NULL),
	(18, 'aa', 'aa', '/assets/Recursos/prodef.jpg', 11.00, 3, 10, 1.00, '2024-12-10', 11.0000, 121.0000, '2024-12-10 21:41:44', '2024-12-10', NULL);

-- Volcando datos para la tabla bdinventario.unidades_compuestas: ~1 rows (aproximadamente)
INSERT INTO `unidades_compuestas` (`id`, `unidad_compuesta_id`, `unidad_simple_id`, `cantidad`, `created_at`, `updated_at`) VALUES
	(2, 10, 6, 1.0000, NULL, NULL);

-- Volcando datos para la tabla bdinventario.unidades_medida: ~5 rows (aproximadamente)
INSERT INTO `unidades_medida` (`id`, `nombre`, `abreviatura`, `es_compuesta`, `cantidad_base`, `factor_conversion`, `tipo`, `created_at`, `updated_at`) VALUES
	(6, 'Kilo', 'Kg', 0, NULL, 0.1000, 'Otro', '2024-12-03 20:41:42', '2024-12-03 20:41:42'),
	(7, 'qw', 'Kg', 0, NULL, NULL, NULL, '2024-12-03 21:11:50', '2024-12-03 21:11:50'),
	(8, 'qw', 'Kg', 0, NULL, NULL, NULL, '2024-12-03 21:11:50', '2024-12-03 21:11:50'),
	(9, 'Unidad', 'Un', 1, NULL, NULL, NULL, '2024-12-03 21:12:48', '2024-12-03 21:12:48'),
	(10, 'Paca', 'Paca', 1, NULL, NULL, NULL, '2024-12-04 03:37:29', '2024-12-04 03:37:29');

-- Volcando datos para la tabla bdinventario.users: ~0 rows (aproximadamente)

-- Volcando datos para la tabla bdinventario.usuarios: ~2 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `imagen`, `email`, `password`, `rol`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(12, 'Eilen', 'Rodriguez', 'uploads/1733780152_images (1).png', 'Eilen.Rodriguez@impresistem.com', '$2y$10$PJKt1r5aA5AzxmCKCXPZfu5m4mb1FN2LDyYXAAeKhkTeW3YQLDIeC', 'Administrador', '2024-12-03 20:36:02', '2024-12-10 02:35:52', NULL),
	(13, 'Tatiana', 'Arias', '/assets/Recursos/prede.jpg', 'tatiana.arias@impresistem.com', '$2y$10$jF7IpIRgO7sgH7rRWeRLZeHzYrIy85Rn4uZTmKFd1U5Pgf.248Yze', 'Usuario', '2024-12-04 02:00:02', '2024-12-04 02:00:02', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
