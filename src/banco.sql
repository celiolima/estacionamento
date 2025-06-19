-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.0.25 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Copiando estrutura para tabela estacionamentojn.car
CREATE TABLE IF NOT EXISTS `car` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dirImage` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `car_name_unique` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela estacionamentojn.car: ~158 rows (aproximadamente)
REPLACE INTO `car` (`id`, `name`, `created_at`, `updated_at`, `dirImage`, `type`) VALUES
	(25, 'Entrada car1689001454859', '2023-07-10 15:04:14', '2023-07-10 15:04:14', 'uploads/car/car1689001454859.jpg', 'Entrada '),
	(26, 'Entrada car1689001546626', '2023-07-10 15:05:46', '2023-07-10 15:05:46', 'uploads/car/car1689001546626.jpg', 'Entrada '),
	(27, 'Entrada car1689001550814', '2023-07-10 15:05:50', '2023-07-10 15:05:50', 'uploads/car/car1689001550814.jpg', 'Entrada '),
	(28, 'Entrada car1689005247323', '2023-07-10 16:07:27', '2023-07-10 16:07:27', 'uploads/car/car1689005247323.jpg', 'Entrada '),
	(29, 'Entrada car1689005267428', '2023-07-10 16:07:47', '2023-07-10 16:07:47', 'uploads/car/car1689005267428.jpg', 'Entrada '),
	(30, 'Entrada car1689005558612', '2023-07-10 16:12:38', '2023-07-10 16:12:38', 'uploads/car/car1689005558612.jpg', 'Entrada '),
	(31, 'Entrada car1689005570699', '2023-07-10 16:12:50', '2023-07-10 16:12:50', 'uploads/car/car1689005570699.jpg', 'Entrada '),
	(32, 'Entrada car1689005592915', '2023-07-10 16:13:12', '2023-07-10 16:13:12', 'uploads/car/car1689005592915.jpg', 'Entrada '),
	(33, 'Entrada car1689030013789', '2023-07-10 23:00:13', '2023-07-10 23:00:13', 'uploads/car/car1689030013789.jpg', 'Entrada '),
	(34, 'Entrada car1689030093500', '2023-07-10 23:01:33', '2023-07-10 23:01:33', 'uploads/car/car1689030093500.jpg', 'Entrada '),
	(35, 'Entrada car1689034578520', '2023-07-11 00:16:18', '2023-07-11 00:16:18', 'uploads/car/car1689034578520.jpg', 'Entrada '),
	(36, 'Entrada car1689036715975', '2023-07-11 00:51:55', '2023-07-11 00:51:55', 'uploads/car/car1689036715975.jpg', 'Entrada '),
	(37, 'Entrada car1689036718140', '2023-07-11 00:51:58', '2023-07-11 00:51:58', 'uploads/car/car1689036718140.jpg', 'Entrada '),
	(38, 'Entrada car1689119510274', '2023-07-11 23:51:50', '2023-07-11 23:51:50', 'uploads/car/car1689119510274.jpg', 'Entrada '),
	(39, 'Entrada car1689204045650', '2023-07-12 23:20:45', '2023-07-12 23:20:45', 'uploads/car/car1689204045650.jpg', 'Entrada '),
	(40, 'Entrada car1689209561318', '2023-07-13 00:52:41', '2023-07-13 00:52:41', 'uploads/car/car1689209561318.jpg', 'Entrada '),
	(41, 'Entrada car1689209562976', '2023-07-13 00:52:42', '2023-07-13 00:52:42', 'uploads/car/car1689209562976.jpg', 'Entrada '),
	(42, 'Entrada car1689209579137', '2023-07-13 00:52:59', '2023-07-13 00:52:59', 'uploads/car/car1689209579137.jpg', 'Entrada '),
	(43, 'Entrada car1689209581172', '2023-07-13 00:53:01', '2023-07-13 00:53:01', 'uploads/car/car1689209581172.jpg', 'Entrada '),
	(44, 'Entrada car1689264913719', '2023-07-13 16:15:13', '2023-07-13 16:15:13', 'uploads/car/car1689264913719.jpg', 'Entrada '),
	(45, 'Entrada car1689265088840', '2023-07-13 16:18:08', '2023-07-13 16:18:08', 'uploads/car/car1689265088840.jpg', 'Entrada '),
	(46, 'Entrada car1689265196115', '2023-07-13 16:19:56', '2023-07-13 16:19:56', 'uploads/car/car1689265196115.jpg', 'Entrada '),
	(47, 'Entrada car1689265201814', '2023-07-13 16:20:01', '2023-07-13 16:20:01', 'uploads/car/car1689265201814.jpg', 'Entrada '),
	(48, 'Entrada car1689265209451', '2023-07-13 16:20:09', '2023-07-13 16:20:09', 'uploads/car/car1689265209451.jpg', 'Entrada '),
	(49, 'Entrada car1689266351185', '2023-07-13 16:39:11', '2023-07-13 16:39:11', 'uploads/car/car1689266351185.jpg', 'Entrada '),
	(50, 'Entrada car1689363746585', '2023-07-14 19:42:26', '2023-07-14 19:42:26', 'uploads/car/car1689363746585.jpg', 'Entrada '),
	(51, 'Entrada car1689364137240', '2023-07-14 19:48:57', '2023-07-14 19:48:57', 'uploads/car/car1689364137240.jpg', 'Entrada '),
	(52, 'Entrada car1689364647405', '2023-07-14 19:57:27', '2023-07-14 19:57:27', 'uploads/car/car1689364647405.jpg', 'Entrada '),
	(53, 'Entrada car1689364652126', '2023-07-14 19:57:32', '2023-07-14 19:57:32', 'uploads/car/car1689364652126.jpg', 'Entrada '),
	(54, 'Entrada car1689364770508', '2023-07-14 19:59:30', '2023-07-14 19:59:30', 'uploads/car/car1689364770508.jpg', 'Entrada '),
	(55, 'Entrada car1689364773254', '2023-07-14 19:59:33', '2023-07-14 19:59:33', 'uploads/car/car1689364773254.jpg', 'Entrada '),
	(56, 'Entrada car1689364779277', '2023-07-14 19:59:39', '2023-07-14 19:59:39', 'uploads/car/car1689364779277.jpg', 'Entrada '),
	(57, 'Entrada car1689364909439', '2023-07-14 20:01:49', '2023-07-14 20:01:49', 'uploads/car/car1689364909439.jpg', 'Entrada '),
	(58, 'Entrada car1689364946715', '2023-07-14 20:02:26', '2023-07-14 20:02:26', 'uploads/car/car1689364946715.jpg', 'Entrada '),
	(59, 'Entrada car1689365129984', '2023-07-14 20:05:29', '2023-07-14 20:05:29', 'uploads/car/car1689365129984.jpg', 'Entrada '),
	(60, 'Entrada car1689365597972', '2023-07-14 20:13:17', '2023-07-14 20:13:17', 'uploads/car/car1689365597972.jpg', 'Entrada '),
	(61, 'Entrada car1689372965751', '2023-07-14 22:16:05', '2023-07-14 22:16:05', 'uploads/car/car1689372965751.jpg', 'Entrada '),
	(62, 'Entrada car1689372968436', '2023-07-14 22:16:08', '2023-07-14 22:16:08', 'uploads/car/car1689372968436.jpg', 'Entrada '),
	(63, 'Entrada car1689372971952', '2023-07-14 22:16:11', '2023-07-14 22:16:11', 'uploads/car/car1689372971952.jpg', 'Entrada '),
	(64, 'Entrada car1689372987891', '2023-07-14 22:16:27', '2023-07-14 22:16:27', 'uploads/car/car1689372987891.jpg', 'Entrada '),
	(65, 'Entrada car1689373364513', '2023-07-14 22:22:44', '2023-07-14 22:22:44', 'uploads/car/car1689373364513.jpg', 'Entrada '),
	(66, 'Entrada car1689373730512', '2023-07-14 22:28:50', '2023-07-14 22:28:50', 'uploads/car/car1689373730512.jpg', 'Entrada '),
	(67, 'Entrada car1689374234240', '2023-07-14 22:37:14', '2023-07-14 22:37:14', 'uploads/car/car1689374234240.jpg', 'Entrada '),
	(68, 'Entrada car1689375914216', '2023-07-14 23:05:14', '2023-07-14 23:05:14', 'uploads/car/car1689375914216.jpg', 'Entrada '),
	(69, 'Entrada car1689375918939', '2023-07-14 23:05:18', '2023-07-14 23:05:18', 'uploads/car/car1689375918939.jpg', 'Entrada '),
	(70, 'Entrada car1689375925797', '2023-07-14 23:05:25', '2023-07-14 23:05:25', 'uploads/car/car1689375925797.jpg', 'Entrada '),
	(71, 'Entrada car1689375928020', '2023-07-14 23:05:28', '2023-07-14 23:05:28', 'uploads/car/car1689375928020.jpg', 'Entrada '),
	(72, 'Entrada car1689375931424', '2023-07-14 23:05:31', '2023-07-14 23:05:31', 'uploads/car/car1689375931424.jpg', 'Entrada '),
	(73, 'Entrada car1689375933280', '2023-07-14 23:05:33', '2023-07-14 23:05:33', 'uploads/car/car1689375933280.jpg', 'Entrada '),
	(74, 'Entrada car1689375940167', '2023-07-14 23:05:40', '2023-07-14 23:05:40', 'uploads/car/car1689375940167.jpg', 'Entrada '),
	(75, 'Entrada car1689375942582', '2023-07-14 23:05:42', '2023-07-14 23:05:42', 'uploads/car/car1689375942582.jpg', 'Entrada '),
	(76, 'Entrada car1689375950648', '2023-07-14 23:05:50', '2023-07-14 23:05:50', 'uploads/car/car1689375950648.jpg', 'Entrada '),
	(77, 'Entrada car1689375968098', '2023-07-14 23:06:08', '2023-07-14 23:06:08', 'uploads/car/car1689375968098.jpg', 'Entrada '),
	(78, 'Entrada car1689375976618', '2023-07-14 23:06:16', '2023-07-14 23:06:16', 'uploads/car/car1689375976618.jpg', 'Entrada '),
	(79, 'Entrada car1689375978586', '2023-07-14 23:06:18', '2023-07-14 23:06:18', 'uploads/car/car1689375978586.jpg', 'Entrada '),
	(80, 'Entrada car1689375982088', '2023-07-14 23:06:22', '2023-07-14 23:06:22', 'uploads/car/car1689375982088.jpg', 'Entrada '),
	(81, 'Entrada car1689376001710', '2023-07-14 23:06:41', '2023-07-14 23:06:41', 'uploads/car/car1689376001710.jpg', 'Entrada '),
	(82, 'Entrada car1689377948601', '2023-07-14 23:39:08', '2023-07-14 23:39:08', 'uploads/car/car1689377948601.jpg', 'Entrada '),
	(83, 'Entrada car1689377950329', '2023-07-14 23:39:10', '2023-07-14 23:39:10', 'uploads/car/car1689377950329.jpg', 'Entrada '),
	(84, 'Entrada car1689377951801', '2023-07-14 23:39:11', '2023-07-14 23:39:11', 'uploads/car/car1689377951801.jpg', 'Entrada '),
	(85, 'Entrada car1689377953642', '2023-07-14 23:39:13', '2023-07-14 23:39:13', 'uploads/car/car1689377953642.jpg', 'Entrada '),
	(86, 'Entrada car1689377954968', '2023-07-14 23:39:14', '2023-07-14 23:39:14', 'uploads/car/car1689377954968.jpg', 'Entrada '),
	(87, 'Entrada car1689377957154', '2023-07-14 23:39:17', '2023-07-14 23:39:17', 'uploads/car/car1689377957154.jpg', 'Entrada '),
	(88, 'Entrada car1689377960510', '2023-07-14 23:39:20', '2023-07-14 23:39:20', 'uploads/car/car1689377960510.jpg', 'Entrada '),
	(89, 'Entrada car1689377963565', '2023-07-14 23:39:23', '2023-07-14 23:39:23', 'uploads/car/car1689377963565.jpg', 'Entrada '),
	(90, 'Entrada car1689377965150', '2023-07-14 23:39:25', '2023-07-14 23:39:25', 'uploads/car/car1689377965150.jpg', 'Entrada '),
	(91, 'Entrada car1689377968581', '2023-07-14 23:39:28', '2023-07-14 23:39:28', 'uploads/car/car1689377968581.jpg', 'Entrada '),
	(92, 'Entrada car1689377981796', '2023-07-14 23:39:41', '2023-07-14 23:39:41', 'uploads/car/car1689377981796.jpg', 'Entrada '),
	(93, 'Entrada car1689378033554', '2023-07-14 23:40:33', '2023-07-14 23:40:33', 'uploads/car/car1689378033554.jpg', 'Entrada '),
	(95, 'Entrada car1689956593988', '2023-07-21 16:23:13', '2023-07-21 16:23:13', 'uploads/car/car1689956593988.jpg', 'Entrada '),
	(96, 'Entrada car1689956601188', '2023-07-21 16:23:21', '2023-07-21 16:23:21', 'uploads/car/car1689956601188.jpg', 'Entrada '),
	(97, 'Entrada car1689956614726', '2023-07-21 16:23:34', '2023-07-21 16:23:34', 'uploads/car/car1689956614726.jpg', 'Entrada '),
	(98, 'Entrada car1689956618399', '2023-07-21 16:23:38', '2023-07-21 16:23:38', 'uploads/car/car1689956618399.jpg', 'Entrada '),
	(99, 'Entrada car1689956955802', '2023-07-21 16:29:15', '2023-07-21 16:29:15', 'uploads/car/car1689956955802.jpg', 'Entrada '),
	(100, 'Entrada car1689956958853', '2023-07-21 16:29:18', '2023-07-21 16:29:18', 'uploads/car/car1689956958853.jpg', 'Entrada '),
	(101, 'Entrada car1689956959027', '2023-07-21 16:29:19', '2023-07-21 16:29:19', 'uploads/car/car1689956959027.jpg', 'Entrada '),
	(102, 'Entrada car1689956960308', '2023-07-21 16:29:20', '2023-07-21 16:29:20', 'uploads/car/car1689956960308.jpg', 'Entrada '),
	(103, 'Entrada car1689956961529', '2023-07-21 16:29:21', '2023-07-21 16:29:21', 'uploads/car/car1689956961529.jpg', 'Entrada '),
	(104, 'Entrada car1689956964097', '2023-07-21 16:29:24', '2023-07-21 16:29:24', 'uploads/car/car1689956964097.jpg', 'Entrada '),
	(105, 'Entrada car1689956968390', '2023-07-21 16:29:28', '2023-07-21 16:29:28', 'uploads/car/car1689956968390.jpg', 'Entrada '),
	(106, 'Entrada car1689956973824', '2023-07-21 16:29:33', '2023-07-21 16:29:33', 'uploads/car/car1689956973824.jpg', 'Entrada '),
	(107, 'Entrada car1689956975358', '2023-07-21 16:29:35', '2023-07-21 16:29:35', 'uploads/car/car1689956975358.jpg', 'Entrada '),
	(108, 'Entrada car1689956977607', '2023-07-21 16:29:37', '2023-07-21 16:29:37', 'uploads/car/car1689956977607.jpg', 'Entrada '),
	(109, 'Entrada car1689956981198', '2023-07-21 16:29:41', '2023-07-21 16:29:41', 'uploads/car/car1689956981198.jpg', 'Entrada '),
	(110, 'Entrada car1689956984577', '2023-07-21 16:29:44', '2023-07-21 16:29:44', 'uploads/car/car1689956984577.jpg', 'Entrada '),
	(111, 'Entrada car1689956987506', '2023-07-21 16:29:47', '2023-07-21 16:29:47', 'uploads/car/car1689956987506.jpg', 'Entrada '),
	(112, 'Entrada car1689956990845', '2023-07-21 16:29:50', '2023-07-21 16:29:50', 'uploads/car/car1689956990845.jpg', 'Entrada '),
	(113, 'Entrada car1689956995398', '2023-07-21 16:29:55', '2023-07-21 16:29:55', 'uploads/car/car1689956995398.jpg', 'Entrada '),
	(114, 'Entrada car1689957015905', '2023-07-21 16:30:15', '2023-07-21 16:30:15', 'uploads/car/car1689957015905.jpg', 'Entrada '),
	(115, 'Entrada car1689957018648', '2023-07-21 16:30:18', '2023-07-21 16:30:18', 'uploads/car/car1689957018648.jpg', 'Entrada '),
	(116, 'Entrada car1689957021021', '2023-07-21 16:30:21', '2023-07-21 16:30:21', 'uploads/car/car1689957021021.jpg', 'Entrada '),
	(117, 'Entrada car1689957022734', '2023-07-21 16:30:22', '2023-07-21 16:30:22', 'uploads/car/car1689957022734.jpg', 'Entrada '),
	(118, 'Entrada car1689957025671', '2023-07-21 16:30:25', '2023-07-21 16:30:25', 'uploads/car/car1689957025671.jpg', 'Entrada '),
	(119, 'Entrada car1689957031338', '2023-07-21 16:30:31', '2023-07-21 16:30:31', 'uploads/car/car1689957031338.jpg', 'Entrada '),
	(120, 'Entrada car1689957034684', '2023-07-21 16:30:34', '2023-07-21 16:30:34', 'uploads/car/car1689957034684.jpg', 'Entrada '),
	(121, 'Entrada car1689957035744', '2023-07-21 16:30:35', '2023-07-21 16:30:35', 'uploads/car/car1689957035744.jpg', 'Entrada '),
	(122, 'Entrada car1689957039937', '2023-07-21 16:30:39', '2023-07-21 16:30:39', 'uploads/car/car1689957039937.jpg', 'Entrada '),
	(123, 'Entrada car1689957043100', '2023-07-21 16:30:43', '2023-07-21 16:30:43', 'uploads/car/car1689957043100.jpg', 'Entrada '),
	(124, 'Entrada car1689957045679', '2023-07-21 16:30:45', '2023-07-21 16:30:45', 'uploads/car/car1689957045679.jpg', 'Entrada '),
	(125, 'Entrada car1689957051437', '2023-07-21 16:30:51', '2023-07-21 16:30:51', 'uploads/car/car1689957051437.jpg', 'Entrada '),
	(126, 'Entrada car1689957053479', '2023-07-21 16:30:53', '2023-07-21 16:30:53', 'uploads/car/car1689957053479.jpg', 'Entrada '),
	(127, 'Entrada car1689957056963', '2023-07-21 16:30:56', '2023-07-21 16:30:56', 'uploads/car/car1689957056963.jpg', 'Entrada '),
	(128, 'Entrada car1689957618432', '2023-07-21 16:40:18', '2023-07-21 16:40:18', 'uploads/car/car1689957618432.jpg', 'Entrada '),
	(129, 'Entrada car1689957639081', '2023-07-21 16:40:39', '2023-07-21 16:40:39', 'uploads/car/car1689957639081.jpg', 'Entrada '),
	(130, 'Entrada car1689957642503', '2023-07-21 16:40:42', '2023-07-21 16:40:42', 'uploads/car/car1689957642503.jpg', 'Entrada '),
	(131, 'Entrada car1689957647247', '2023-07-21 16:40:47', '2023-07-21 16:40:47', 'uploads/car/car1689957647247.jpg', 'Entrada '),
	(132, 'Entrada car1689957650489', '2023-07-21 16:40:50', '2023-07-21 16:40:50', 'uploads/car/car1689957650489.jpg', 'Entrada '),
	(133, 'Entrada car1689957654178', '2023-07-21 16:40:54', '2023-07-21 16:40:54', 'uploads/car/car1689957654178.jpg', 'Entrada '),
	(134, 'Entrada car1689957656631', '2023-07-21 16:40:56', '2023-07-21 16:40:56', 'uploads/car/car1689957656631.jpg', 'Entrada '),
	(135, 'Entrada car1689957691062', '2023-07-21 16:41:31', '2023-07-21 16:41:31', 'uploads/car/car1689957691062.jpg', 'Entrada '),
	(136, 'Entrada car1689957696660', '2023-07-21 16:41:36', '2023-07-21 16:41:36', 'uploads/car/car1689957696660.jpg', 'Entrada '),
	(137, 'Entrada car1689957701997', '2023-07-21 16:41:42', '2023-07-21 16:41:42', 'uploads/car/car1689957701997.jpg', 'Entrada '),
	(138, 'Entrada car1689957759456', '2023-07-21 16:42:39', '2023-07-21 16:42:39', 'uploads/car/car1689957759456.jpg', 'Entrada '),
	(139, 'Entrada car1689957761350', '2023-07-21 16:42:41', '2023-07-21 16:42:41', 'uploads/car/car1689957761350.jpg', 'Entrada '),
	(140, 'Entrada car1689957768440', '2023-07-21 16:42:48', '2023-07-21 16:42:48', 'uploads/car/car1689957768440.jpg', 'Entrada '),
	(141, 'Entrada car1689958331847', '2023-07-21 16:52:11', '2023-07-21 16:52:11', 'uploads/car/car1689958331847.jpg', 'Entrada '),
	(142, 'Entrada car1689958337416', '2023-07-21 16:52:17', '2023-07-21 16:52:17', 'uploads/car/car1689958337416.jpg', 'Entrada '),
	(143, 'Entrada car1689958340986', '2023-07-21 16:52:20', '2023-07-21 16:52:20', 'uploads/car/car1689958340986.jpg', 'Entrada '),
	(144, 'Entrada car1689958344816', '2023-07-21 16:52:24', '2023-07-21 16:52:24', 'uploads/car/car1689958344816.jpg', 'Entrada '),
	(145, 'Entrada car1689958353529', '2023-07-21 16:52:33', '2023-07-21 16:52:33', 'uploads/car/car1689958353529.jpg', 'Entrada '),
	(146, 'Entrada car1689958359716', '2023-07-21 16:52:39', '2023-07-21 16:52:39', 'uploads/car/car1689958359716.jpg', 'Entrada '),
	(147, 'Entrada car1689958364935', '2023-07-21 16:52:44', '2023-07-21 16:52:44', 'uploads/car/car1689958364935.jpg', 'Entrada '),
	(148, 'Entrada car1689958375689', '2023-07-21 16:52:55', '2023-07-21 16:52:55', 'uploads/car/car1689958375689.jpg', 'Entrada '),
	(149, 'Entrada car1689958381160', '2023-07-21 16:53:01', '2023-07-21 16:53:01', 'uploads/car/car1689958381160.jpg', 'Entrada '),
	(150, 'Entrada car1689958482097', '2023-07-21 16:54:42', '2023-07-21 16:54:42', 'uploads/car/car1689958482097.jpg', 'Entrada '),
	(151, 'Saida car1689958485684', '2023-07-21 16:54:45', '2023-07-21 16:54:45', 'uploads/car/car1689958485684.jpg', 'Saida '),
	(152, 'Saida car1689958487657', '2023-07-21 16:54:47', '2023-07-21 16:54:47', 'uploads/car/car1689958487657.jpg', 'Saida '),
	(153, 'Saida car1689958490414', '2023-07-21 16:54:50', '2023-07-21 16:54:50', 'uploads/car/car1689958490414.jpg', 'Saida '),
	(154, 'Saida car1689958491928', '2023-07-21 16:54:51', '2023-07-21 16:54:51', 'uploads/car/car1689958491928.jpg', 'Saida '),
	(155, 'Saida car1689958493634', '2023-07-21 16:54:53', '2023-07-21 16:54:53', 'uploads/car/car1689958493634.jpg', 'Saida '),
	(156, 'Saida car1689958498612', '2023-07-21 16:54:58', '2023-07-21 16:54:58', 'uploads/car/car1689958498612.jpg', 'Saida '),
	(157, 'Saida car1689958502605', '2023-07-21 16:55:02', '2023-07-21 16:55:02', 'uploads/car/car1689958502605.jpg', 'Saida '),
	(158, 'Entrada car1689958510827', '2023-07-21 16:55:10', '2023-07-21 16:55:10', 'uploads/car/car1689958510827.jpg', 'Entrada '),
	(159, 'Saida car1689958514430', '2023-07-21 16:55:14', '2023-07-21 16:55:14', 'uploads/car/car1689958514430.jpg', 'Saida '),
	(160, 'Saida car1689958517146', '2023-07-21 16:55:17', '2023-07-21 16:55:17', 'uploads/car/car1689958517146.jpg', 'Saida '),
	(161, 'Saida car1689958518970', '2023-07-21 16:55:18', '2023-07-21 16:55:18', 'uploads/car/car1689958518970.jpg', 'Saida '),
	(162, 'Saida car1689962517476', '2023-07-21 18:01:57', '2023-07-21 18:01:57', 'uploads/car/car1689962517476.jpg', 'Saida '),
	(163, 'Saida car1689962525962', '2023-07-21 18:02:05', '2023-07-21 18:02:05', 'uploads/car/car1689962525962.jpg', 'Saida '),
	(164, 'Entrada car1689962534973', '2023-07-21 18:02:14', '2023-07-21 18:02:14', 'uploads/car/car1689962534973.jpg', 'Entrada '),
	(165, 'Entrada car1689962537578', '2023-07-21 18:02:17', '2023-07-21 18:02:17', 'uploads/car/car1689962537578.jpg', 'Entrada '),
	(166, 'Entrada car1689962539584', '2023-07-21 18:02:19', '2023-07-21 18:02:19', 'uploads/car/car1689962539584.jpg', 'Entrada '),
	(167, 'Entrada car1689962541868', '2023-07-21 18:02:21', '2023-07-21 18:02:21', 'uploads/car/car1689962541868.jpg', 'Entrada '),
	(168, 'Entrada car1689962543578', '2023-07-21 18:02:23', '2023-07-21 18:02:23', 'uploads/car/car1689962543578.jpg', 'Entrada '),
	(169, 'Entrada car1689962545408', '2023-07-21 18:02:25', '2023-07-21 18:02:25', 'uploads/car/car1689962545408.jpg', 'Entrada '),
	(170, 'Entrada car1689962580257', '2023-07-21 18:03:00', '2023-07-21 18:03:00', 'uploads/car/car1689962580257.jpg', 'Entrada '),
	(171, 'Saida car1689962586651', '2023-07-21 18:03:06', '2023-07-21 18:03:06', 'uploads/car/car1689962586651.jpg', 'Saida '),
	(172, 'Saida car1689962880927', '2023-07-21 18:08:00', '2023-07-21 18:08:00', 'uploads/car/car1689962880927.jpg', 'Saida '),
	(173, 'Entrada car1689962885180', '2023-07-21 18:08:05', '2023-07-21 18:08:05', 'uploads/car/car1689962885180.jpg', 'Entrada '),
	(174, 'Saida car1689964163167', '2023-07-21 18:29:23', '2023-07-21 18:29:23', 'uploads/car/car1689964163167.jpg', 'Saida '),
	(175, 'Saida car1689966571868', '2023-07-21 19:09:31', '2023-07-21 19:09:31', 'uploads/car/car1689966571868.jpg', 'Saida '),
	(176, 'Entrada car1689966618973', '2023-07-21 19:10:18', '2023-07-21 19:10:18', 'uploads/car/car1689966618973.jpg', 'Entrada '),
	(177, 'Entrada car1689966624605', '2023-07-21 19:10:24', '2023-07-21 19:10:24', 'uploads/car/car1689966624605.jpg', 'Entrada '),
	(178, 'Entrada car1689966630441', '2023-07-21 19:10:30', '2023-07-21 19:10:30', 'uploads/car/car1689966630441.jpg', 'Entrada '),
	(179, 'Entrada car1689966632943', '2023-07-21 19:10:32', '2023-07-21 19:10:32', 'uploads/car/car1689966632943.jpg', 'Entrada '),
	(180, 'Entrada car1689966637190', '2023-07-21 19:10:37', '2023-07-21 19:10:37', 'uploads/car/car1689966637190.jpg', 'Entrada '),
	(181, 'Entrada car1689966640951', '2023-07-21 19:10:40', '2023-07-21 19:10:40', 'uploads/car/car1689966640951.jpg', 'Entrada '),
	(182, 'Entrada car1689966643541', '2023-07-21 19:10:43', '2023-07-21 19:10:43', 'uploads/car/car1689966643541.jpg', 'Entrada '),
	(183, 'Entrada car1689966644399', '2023-07-21 19:10:44', '2023-07-21 19:10:44', 'uploads/car/car1689966644399.jpg', 'Entrada '),
	(184, 'Saida car1689966671340', '2023-07-21 19:11:11', '2023-07-21 19:11:11', 'uploads/car/car1689966671340.jpg', 'Saida '),
	(185, 'Saida car1689966673699', '2023-07-21 19:11:13', '2023-07-21 19:11:13', 'uploads/car/car1689966673699.jpg', 'Saida '),
	(186, 'Saida car1689966675756', '2023-07-21 19:11:15', '2023-07-21 19:11:15', 'uploads/car/car1689966675756.jpg', 'Saida '),
	(187, 'Saida car1689966677057', '2023-07-21 19:11:17', '2023-07-21 19:11:17', 'uploads/car/car1689966677057.jpg', 'Saida '),
	(188, 'Entrada car1689966683037', '2023-07-21 19:11:23', '2023-07-21 19:11:23', 'uploads/car/car1689966683037.jpg', 'Entrada '),
	(189, 'Saida car1689966685642', '2023-07-21 19:11:25', '2023-07-21 19:11:25', 'uploads/car/car1689966685642.jpg', 'Saida '),
	(190, 'Entrada car1689966688613', '2023-07-21 19:11:28', '2023-07-21 19:11:28', 'uploads/car/car1689966688613.jpg', 'Entrada '),
	(191, 'Entrada car1689966692067', '2023-07-21 19:11:32', '2023-07-21 19:11:32', 'uploads/car/car1689966692067.jpg', 'Entrada '),
	(192, 'Entrada car1689966695367', '2023-07-21 19:11:35', '2023-07-21 19:11:35', 'uploads/car/car1689966695367.jpg', 'Entrada '),
	(194, 'Saida car1689967703006', '2023-07-21 19:28:23', '2023-07-21 19:28:23', 'uploads/car/car1689967703006.jpg', 'Saida ');

-- Copiando estrutura para tabela estacionamentojn.fot
CREATE TABLE IF NOT EXISTS `fot` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dirImage` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `car_name_unique` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela estacionamentojn.fot: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela estacionamentojn.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `expires` int unsigned NOT NULL,
  `data` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Copiando dados para a tabela estacionamentojn.sessions: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela estacionamentojn.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `pass` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rol` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `username_UNIQUE` (`user`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- Copiando dados para a tabela estacionamentojn.users: ~1 rows (aproximadamente)
REPLACE INTO `users` (`id`, `name`, `user`, `pass`, `email`, `rol`) VALUES
	(1, '', 'admin', '$2a$06$HT.EmXYUUhNo3UQMl9APmeC0SwoGsx7FtMoAWdzGicZJ4wR1J8alW', 'ocelio.bernardo@gmail.com', 'admin'),
	(5, 'celio', 'celiolima', '$2a$08$rwyXsP9Ea/w.Fz1ENICYteLsAT0MHDxLKEZx3oFt6uq2MFJ6c0mrG', '', 'user');

-- Copiando estrutura para tabela estacionamentojn.veic
CREATE TABLE IF NOT EXISTS `veic` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `total_car_mes` int unsigned DEFAULT NULL,
  `total_car` int unsigned DEFAULT NULL,
  `total_mot_mes` int unsigned DEFAULT NULL,
  `total_mot` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela estacionamentojn.veic: ~1 rows (aproximadamente)
REPLACE INTO `veic` (`id`, `total_car_mes`, `total_car`, `total_mot_mes`, `total_mot`, `created_at`) VALUES
	(1, 12, 14, 28, 31, '2023-07-16 22:17:29');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
