-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2016 at 05:55 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lurn_project_management`
--



--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type_id`, `username`, `password`, `created`, `modified`) VALUES
(3, 3, 'paranaque.gov', '$2y$10$j3IaTJXNjXg./mtqvRKgCuh/4dljUIpGWy95Ep6eXYQrQFzYoYMam', '2016-06-14 14:28:46', '2016-06-14 14:28:46'),
(4, 3, 'laspinas.gov', '$2y$10$pVGa005EuYQAcIbp9yfFXe32MbrlIiqrGE.QeOlZK4youzWX4Yjwy', '2016-06-14 14:29:50', '2016-06-14 14:29:50'),
(5, 3, 'cavite.gov', '$2y$10$MPSp2CQ8vvEt6SL9tqfftuymLVObWHFK53NJAfoahhxPuPi7e7gVi', '2016-06-14 14:30:51', '2016-06-14 14:30:51'),
(6, 2, 'rafanotnadal', '$2y$10$GWTH4CuWcdN44WAjLCIBrePSX.kNFZj1VaLwkm4e8G0Mbr7tOUu3e', '2016-06-14 14:32:13', '2016-06-14 14:32:13'),
(7, 2, 'juliusumali', '$2y$10$YUheFoqDrrOSB12N5Zvz3.lZ4SkI1ChZhoqXB/ld3yTjniusFaS3e', '2016-06-14 14:32:59', '2016-06-14 14:32:59'),
(8, 2, 'raymundniel', '$2y$10$pi4jwDnO1JwyMCYzza7Pg.eY4wumGlM3MDWne2qusK0edw51yYQe2', '2016-06-14 14:33:28', '2016-06-14 14:33:28'),
(9, 2, 'antonlaquindanum', '$2y$10$GjiD/q1Ca3d96.UlLj23mOOwLqX5aTYPdoxmYAVrA3.ArbNRdQaoa', '2016-06-14 14:34:08', '2016-06-14 14:34:08'),
(10, 2, 'juandelacruz', '$2y$10$U3DT9kcUdsCHXUauGUWqHOKYw9l5WAy6OUXhG0SK14f.GOR/mqjWq', '2016-06-14 14:35:44', '2016-06-14 14:35:44');



--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `user_id`, `company_name`, `key_person`, `contact_number`, `email`, `address`, `created`, `modified`) VALUES
(1, 3, 'Paranaque Government', 'Engr. Aser S. Mallari', '(02) 872-4744', 'aser.mallari@gmail.com', 'Paranaque', '2016-06-14 14:28:46', '2016-06-14 14:28:46'),
(2, 4, 'Las Pinas Government', 'Engr. Rosabella A. Bantog ', '(02) 826-8272', 'rosabella.bantog@gmail.com', 'Las Pinas', '2016-06-14 14:29:50', '2016-06-14 14:29:50'),
(3, 5, 'Cavite Government', 'Engr. Jesus D. Francisco', '(046) 434-6616', 'jesus.francisco@gmail.com', 'Cavite', '2016-06-14 14:30:51', '2016-06-14 14:30:51');

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `employee_type_id`, `name`, `employment_date`, `termination_date`, `created`, `modified`) VALUES
(2, 6, 2, 'Carlos Rafael Ramirez de Cartagena ', '2016-03-28 00:00:00', '2016-06-14 00:00:00', '2016-06-14 14:32:13', '2016-06-14 14:32:23'),
(3, 7, 3, 'Julius Andre Umali', '2016-03-28 00:00:00', NULL, '2016-06-14 14:32:59', '2016-06-14 14:32:59'),
(4, 8, 3, 'Raymund Niel Norada', '2016-03-28 00:00:00', NULL, '2016-06-14 14:33:28', '2016-06-14 14:33:28'),
(5, 9, 2, 'Juan Anton Laquindanum', '2016-03-28 00:00:00', NULL, '2016-06-14 14:34:08', '2016-06-14 14:34:08'),
(6, 10, 4, 'Juan Dela Cruz', '2016-03-28 00:00:00', '2016-06-14 00:00:00', '2016-06-14 14:35:44', '2016-06-14 14:35:56');

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_number`, `email`, `address`, `created`, `modified`) VALUES
(1, 'Ace Hardware', '9178686729', 'ace@hardware.com', 'Manila', '2016-06-14 14:51:07', '2016-06-14 14:51:07'),
(2, 'Wood & Cement Co.', '9178686729', 'wood@cement.com', 'Manila', '2016-06-14 14:51:40', '2016-06-14 14:51:40'),
(3, 'General Hardware', '9178686729', 'gen.hardware@gmail.com', 'Manila', '2016-06-14 14:52:31', '2016-06-14 14:52:31'),
(4, 'Trucks and Large Equipments', '9178686729', 'trucks.equip@gmail.com', 'Manila', '2016-06-14 14:53:08', '2016-06-14 14:53:08');
--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Backhoe', '2016-06-21 10:47:18', '2016-07-18 12:54:01'),
(2, 'Concrete Vibrator', '2016-06-21 10:47:33', '2016-07-18 12:54:01'),
(3, 'Welding Machine', '2016-06-21 10:47:43', '2016-07-18 12:13:52'),
(4, 'Bulldozer', '2016-06-21 10:48:08', '2016-06-21 10:48:08'),
(5, 'Mallet', '2016-06-21 10:48:14', '2016-07-18 12:54:01'),
(6, 'Shovel', '2016-06-21 10:48:21', '2016-07-18 12:13:52'),
(7, 'Drill', '2016-06-21 10:48:32', '2016-07-18 12:54:01'),
(8, 'Wheel Barrow', '2016-06-21 10:48:46', '2016-06-21 10:48:46'),
(9, 'Cement Mixer', '2016-06-21 10:48:52', '2016-07-18 12:13:52'),
(10, 'Screw Driver', '2016-06-21 10:49:14', '2016-06-21 10:49:14');

--
-- Dumping data for table `equipment_suppliers`
--

INSERT INTO `equipment_suppliers` (`id`, `equipment_id`, `supplier_id`, `created`, `modified`) VALUES
(1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 2, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 3, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 4, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 5, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');


--
-- Dumping data for table `manpower`
--

INSERT INTO `manpower` (`id`, `project_id`, `task_id`, `manpower_type_id`, `name`, `created`, `modified`) VALUES
(1, NULL, NULL, 2, 'Carl Cruz', '2016-06-14 14:36:41', '2016-07-18 12:41:00'),
(2, NULL, NULL, 1, 'Gino Mercado', '2016-06-14 14:36:55', '2016-07-18 12:41:00'),
(3, NULL, NULL, 2, 'Ely Buendia', '2016-06-14 14:37:06', '2016-07-18 12:41:00'),
(4, NULL, NULL, 1, 'Charles Marquez', '2016-06-14 14:37:18', '2016-07-18 12:41:00'),
(5, NULL, NULL, 2, 'Dean Gomez', '2016-06-14 14:37:38', '2016-07-18 12:41:00'),
(6, NULL, NULL, 2, 'Francis Verana', '2016-06-14 14:38:01', '2016-07-18 12:41:00'),
(7, NULL, NULL, 2, 'Kiko Matos', '2016-06-14 14:38:13', '2016-07-18 12:41:00'),
(8, NULL, NULL, 2, 'Baron Geisler', '2016-06-14 14:38:24', '2016-07-18 12:41:00'),
(9, NULL, NULL, 2, 'Yuji Lim', '2016-06-14 14:38:36', '2016-07-18 12:41:00'),
(10, NULL, NULL, 1, 'Robert Manalig', '2016-06-14 14:38:52', '2016-07-18 12:41:00'),
(11, NULL, NULL, 1, 'Warren Tumpalan', '2016-06-14 14:39:04', '2016-07-18 12:41:00'),
(12, NULL, NULL, 1, 'James Huang', '2016-06-14 14:39:36', '2016-07-18 12:41:00'),
(13, NULL, NULL, 1, 'Leonard Lapid', '2016-06-14 14:39:58', '2016-07-18 12:41:00'),
(14, NULL, NULL, 2, 'Vince Carter', '2016-06-14 14:40:14', '2016-07-18 12:41:00'),
(15, NULL, NULL, 1, 'Paul Laquian', '2016-06-14 14:40:34', '2016-07-18 12:41:00'),
(16, NULL, NULL, 2, 'Jimboy Navad', '2016-06-14 14:41:45', '2016-10-20 10:16:20'),
(17, NULL, NULL, 2, 'Gerry Tumbalan', '2016-06-14 14:42:20', '2016-10-20 10:16:20'),
(18, NULL, NULL, 1, 'Sean Winston', '2016-06-14 14:42:55', '2016-07-18 12:41:00'),
(19, NULL, NULL, 2, 'James Reid', '2016-07-18 12:18:32', '2016-10-20 10:16:20'),
(20, NULL, NULL, 1, 'Xian Lim', '2016-07-18 12:18:48', '2016-07-18 12:55:45'),
(21, NULL, NULL, 1, 'Jericho Rosales', '2016-07-18 12:18:59', '2016-11-23 16:29:26'),
(22, NULL, NULL, 1, 'Luis Manzano', '2016-07-18 12:19:12', '2016-07-18 12:19:12'),
(23, NULL, NULL, 2, 'Josh Peck', '2016-07-18 12:46:46', '2016-07-18 12:55:45'),
(24, NULL, NULL, 2, 'David Lim', '2016-07-18 12:47:03', '2016-07-18 12:55:45'),
(25, NULL, NULL, 2, 'Bruce Wayne', '2016-07-18 12:47:15', '2016-07-18 12:55:45'),
(26, NULL, NULL, 2, 'Harvey Dent', '2016-07-18 12:47:26', '2016-07-18 12:47:26'),
(27, NULL, NULL, 1, 'Jake Rivera', '2016-07-18 12:47:56', '2016-07-18 12:47:56');



--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `name`, `unit_measure`, `created`, `modified`) VALUES
(1, 'Cement', 'bags', '2016-06-14 14:43:21', '2016-07-18 12:17:47'),
(2, 'Screw', 'boxes', '2016-06-14 14:43:35', '2016-07-18 12:55:45'),
(3, '2x2 Wood Planks', 'pcs', '2016-06-14 14:43:49', '2016-07-18 12:55:45'),
(4, '4x4 Wood Planks', 'pcs', '2016-06-14 14:44:04', '2016-07-18 12:55:45'),
(5, '8x8 Wood Planks', 'pcs', '2016-06-14 14:44:17', '2016-07-18 12:55:45'),
(6, 'Ply Wood', 'pcs', '2016-06-14 14:44:26', '2016-07-18 12:55:45'),
(7, 'PVC Pipes', 'pcs', '2016-06-14 14:44:38', '2016-07-18 12:17:47'),
(8, 'Metal Pipes', 'pcs', '2016-06-14 14:44:51', '2016-07-18 12:17:47'),
(9, 'Small Bolts', 'boxes', '2016-06-14 14:45:03', '2016-07-18 12:17:47'),
(10, 'Big Bolts', 'boxes', '2016-06-14 14:45:17', '2016-06-14 14:45:17'),
(11, 'Sand', 'bags', '2016-06-14 14:45:40', '2016-07-18 12:17:47'),
(12, 'Hollow Blocks', 'pcs', '2016-06-14 14:45:56', '2016-06-14 14:45:56'),
(13, 'Gravel', 'bags', '2016-06-14 14:46:04', '2016-06-14 14:46:04'),
(14, 'Red Paint', 'cans', '2016-06-14 14:46:20', '2016-06-14 14:46:20'),
(15, 'Brown Paint', 'cans', '2016-06-14 14:46:28', '2016-06-14 14:46:47'),
(16, 'Yellow Paint', 'cans', '2016-06-14 14:46:40', '2016-06-14 14:46:40'),
(17, 'Door Frame', 'pcs', '2016-06-14 14:47:04', '2016-06-14 14:47:04'),
(18, 'Window Frame', 'pcs', '2016-06-14 14:47:12', '2016-06-14 14:47:12'),
(19, 'Marble Stone', 'bags', '2016-06-14 14:47:27', '2016-06-14 14:47:27'),
(20, 'Granite Stone', 'bags', '2016-06-14 14:47:42', '2016-06-14 14:47:42'),
(21, 'Glass', 'pcs', '2016-06-14 14:47:52', '2016-06-14 14:47:52'),
(22, 'Nails', 'boxes', '2016-06-14 14:48:02', '2016-07-18 12:17:47'),
(23, 'Light Bulb', 'pcs', '2016-06-14 14:48:14', '2016-06-14 14:48:14'),
(24, 'Aluminum', 'boxes', '2016-06-14 14:48:30', '2016-06-14 14:48:30'),
(25, 'Iron', 'pcs', '2016-06-14 14:48:43', '2016-07-18 12:55:45'),
(26, 'Steel', 'pcs', '2016-06-14 14:48:55', '2016-06-14 14:48:55'),
(27, 'Tiles', 'pcs', '2016-06-14 14:49:02', '2016-06-14 14:49:02'),
(28, 'Adobe Brick', 'pcs', '2016-06-14 14:49:21', '2016-06-14 14:49:21'),
(29, 'Admixture', 'bags', '2016-06-14 14:49:30', '2016-06-14 14:49:41'),
(30, 'Lumber', 'pcs', '2016-06-14 14:50:01', '2016-06-14 14:50:01'),
(31, 'Sheet Glass', 'pcs', '2016-06-14 14:50:12', '2016-06-14 14:50:12');



--
-- Dumping data for table `materials_suppliers`
--

INSERT INTO `materials_suppliers` (`id`, `material_id`, `supplier_id`, `created`, `modified`) VALUES
(1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 3, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 4, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 5, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 1, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 2, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 3, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 4, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 5, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 2, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 3, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 4, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 5, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
