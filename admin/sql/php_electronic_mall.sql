-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2020 at 01:37 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_electronic_mall`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `brand_image` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `date_added` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`, `brand_image`, `status`, `date_added`) VALUES
(1, 'Sony', 'Sony-logo.png', 'active', 1430899303),
(2, 'HP', 'HP-logo.png', 'active', 1430899303),
(3, 'Apple', 'Apple-logo.png', 'active', 1430899303),
(4, 'Dell', 'Dell-logo.png', 'active', 1430899303),
(5, 'Asus', 'ASUS-logo.png', 'active', 1430899303),
(6, 'Samsung', 'Samsung-Logo.jpg', 'active', 1430899303);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `email`, `password`) VALUES
(1, 'Mohammad Naim Faizy', 'mnaimfaizy@yahoo.com', '5f4dcc3b5aa765d61d8327deb882cf99');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `image_name` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `caption` varchar(200) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `image_name`, `size`, `type`, `caption`, `product_id`) VALUES
(1, 'nDMJWQLHhMN4fi8b_500.jpg', '6062', 'image/jpeg', 'ASUS CP6130', 1),
(2, 'P_50013287768924f3386bc5fe80(1).jpg', '6368', 'image/jpeg', '', 1),
(3, 'vx8EzIhsyOV81i8h_500.jpg', '4135', 'image/jpeg', '', 1),
(4, 'b3k0951cYIyn1LDE_500.jpg', '8891', 'image/jpeg', '', 1),
(5, 'uMhBLQB2lSbT9kBm_500.jpg', '5259', 'image/jpeg', '', 1),
(6, 'P_50013287772614f33882d85395(1).jpg', '6495', 'image/jpeg', 'ASUS CP6230', 2),
(7, 'XDhwZOlu58p5FmeS_500.jpg', '5592', 'image/jpeg', '', 2),
(8, 'xMTkMl6sfppE75Wt_500.jpg', '7109', 'image/jpeg', '', 2),
(9, 'YG1btKkZMPz16ZnZ_500.jpg', '8812', 'image/jpeg', '', 2),
(10, 'P_50013287774434f3388e3b9edd(1).jpg', '5401', 'image/jpeg', 'ASUS Essentio CP1130', 3),
(11, 'w91u59ZCZzPzZ8RO_500.jpg', '5135', 'image/jpeg', '', 3),
(12, 'OTPci8iqEoHfq8rX_500.jpg', '4267', 'image/jpeg', '', 3),
(13, 'nO6yAKoQVtSOrbZv_500.jpg', '3546', 'image/jpeg', '', 3),
(14, 'pocket_bell(1).jpg', '57255', 'image/jpeg', 'Packard Bell OneTwo', 4),
(15, 'pocket_bell2.jpg', '55934', 'image/jpeg', '', 4),
(16, '300V5A_Raspberry-Pink_04_6(1).jpg', '5254', 'image/jpeg', 'Series 3 15.6\" Laptop', 5),
(17, '300V5A_Raspberry-Pink_02_2.jpg', '10710', 'image/jpeg', '', 5),
(18, '300V5A_Raspberry-Pink_05.jpg', '5966', 'image/jpeg', '', 5),
(19, '600x600_NP300E5A-A01_main(1).jpg', '5111', 'image/jpeg', 'Series 3 15.6\" Laptop', 6),
(20, '600x600_angle.jpg', '7378', 'image/jpeg', '', 6),
(21, '600x600_front.jpg', '6063', 'image/jpeg', '', 6),
(22, '700Z-side_back_open-01(1).jpg', '3608', 'image/jpeg', 'Series 7 Chronos 14â€ Notebook', 7),
(23, '700Z3A_02.jpg', '9924', 'image/jpeg', '', 7),
(24, '700Z3A_09_2.jpg', '3048', 'image/jpeg', '', 7),
(25, '700Z3A_05.jpg', '4717', 'image/jpeg', '', 7),
(26, '700Z3A_07_2.jpg', '2300', 'image/jpeg', '', 7),
(27, '9-Series-Laptop_04_4(1).jpg', '4887', 'image/jpeg', 'Series 9 13.3\" Laptop', 8),
(28, '9-Series-Laptop_02_2.jpg', '9015', 'image/jpeg', '', 8),
(29, '9-Series-Laptop_05_2.jpg', '6156', 'image/jpeg', '', 8),
(30, '9-Series-Laptop_07_2.jpg', '2115', 'image/jpeg', '', 8),
(31, '9-Series-Laptop_10_2.jpg', '2568', 'image/jpeg', '', 8);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_category` int(11) NOT NULL,
  `product_sub_category` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `price` float NOT NULL,
  `condition` varchar(20) NOT NULL,
  `details` text NOT NULL,
  `date_added` int(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `slider` varchar(30) NOT NULL,
  `in_stock` varchar(10) NOT NULL,
  `quantity` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_category`, `product_sub_category`, `brand`, `price`, `condition`, `details`, `date_added`, `status`, `slider`, `in_stock`, `quantity`) VALUES
(1, 'ASUS CP6130', 1, 1, 5, 972, 'New', 'A glossy surface gives the CP6130 an air of elegance, while and an eye-catching power button inspired from the halo of a lunar eclipse seamlessly blends in to the front of the case.<br><b>Features:<br></b><ul><li><b>Operating System: &nbsp; &nbsp;</b> &nbsp;&nbsp;<i>Windows 7 Home Premium</i></li><li><b>Storage Capacity: &nbsp; &nbsp; &nbsp; &nbsp;</b><i>1 TB</i><i><br></i></li></ul><br>', 1430656190, 'active', 'slide', 'Yes', 8),
(2, 'ASUS CP6230', 1, 1, 5, 610.99, 'New', 'The ASUS CP6230 features a space-saving design with a hexagonal pattern lid that easily fits anywhere in your home. It draws you in with its elegant aesthetics but holds your attention with its computer power to tackle any task.<br><b>Features:<br></b><ul><li><b>Operating System: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</b><i>Windows 7 Home Premium</i></li><li><i><b></b></i><b>Storage Capacity: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</b><i>500 GB</i><br></li></ul>', 1430656686, 'active', 'slide', 'Yes', 12),
(3, 'ASUS Essentio CP1130', 1, 1, 5, 459.99, 'New', 'The ASUS new Essentio CP1130 has sleek appearance and small size make it\r\n perfectly fit anywhere in your home. At the same time, it provides \r\ncomplete function and delivers ultimate performance for daily computing.<br><br><b>Features:<br></b><ul><li><b></b><b>Operating System: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</b><i>Windows 7 Home Basic</i></li><li><i><b></b></i><b>Storage&nbsp;Capacity: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</b><i>320 GB</i><br></li></ul>', 1430656934, 'active', 'slide', 'Yes', 9),
(4, 'Packard Bell OneTwo', 1, 1, 5, 729.99, 'Used', 'Great Packard Bell all in one PC with 23\" HD  LCD Multi Touchscreen and \r\nWindows 7. The PC is in perfect working order. The LCD screen is very \r\ncrisp and bright and the touchscreen is responsive and easy to use  The \r\ncasing is in good but used condition, there is hardly a  mark on it and \r\nonly noticeable very close up.  Comes with an Intel i3 CPU and a \r\ndedicated nVidia Geforce 315 video card for superb performance. Also has\r\n a Freeview TV card so you can watch and record TV.It  has an HDMI out \r\nport making it simple to connect to a larger TV if required.  It has had\r\n a fresh install of Windows 7 including the full Packard Bell software \r\nsuite. Windows has been fully updated and you are ready to go straight \r\nout of the box.  Has an active recovery partition enabling you to \r\nperform a full reset to factory defaults straight from the hard drive \r\nand also create a spare set of recovery discs.&nbsp;', 1430711349, 'active', 'slide', 'Yes', 6),
(5, 'Series 3 15.6', 1, 2, 6, 529.99, 'New', '<span>Don\'t be weighed down by wasted time, let your PC come alive when you need it. Your life happens on the go, you don\'t have time to wait for PC to shut down and power up. With Samsung\'s exclusive Fast Start technology, simply close the lid to enter a hybrid sleep mode. When you open the lid, you are up and running in less than 3 sec.<br><br><b>Features:<br><br></b></span><div><b>Operating System: </b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<i>Windows 7 Home Premium</i></div><div><b>Display: </b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<i>15.6\"</i></div><div><b>Storage Capacity: </b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<i>640 GB</i></div>', 1430713996, 'active', 'slide', 'Yes', 12),
(6, 'Series 3 15.6', 1, 2, 6, 529.99, 'Used', '<span>Don\'t be weighed down by wasted time, let your PC come alive when you need it. Your life happens on the go, you don\'t have time to wait for PC to shut down and power up. With Samsung\'s exclusive Fast Start technology, simply close the lid to enter a hybrid sleep mode. When you open the lid, you are up and running in less than 3 sec.<br><br></span><b>Features:<br></b><ul><li><b>Operating System:</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<i>Windows 7 Home Premium</i></li><li><i><b>Display:</b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</i><i><div>15.6\"</div></i></li><li><i><b>Storage Capacity:</b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;640 GB<br></i></li></ul>', 1430714323, 'active', 'no_slide', 'No', 15),
(7, 'Series 7 Chronos 14â€ Notebook', 1, 2, 6, 1099.99, 'New', '<span>Cutting edge design: Sleek aluminum, a stunning screen, cutting edge performance, all seamlessly blended in one of the worldâ€™s thinnest quad core PC.<br><br><b>Features:<br></b></span><div><b>Operating System:</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<i>Windows 7 Home Premium</i></div><div><b>Display: </b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<i>14.0\"</i></div><div><b>Storage Capacity:</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<i>750GB</i></div>', 1430714955, 'active', 'slide', 'Yes', 10),
(8, 'Series 9 13.3', 1, 2, 6, 2049, 'New', '<span>You no longer have to shut down your Samsung computer, just close its lid and it goes into a special powerless sleep mode. When you open the lid your computer comes back to life in 3 seconds and you are exactly at the same place as when you shut the lid. Fast Start saves your data and system configurations to your hard drive and PC memory. So, when you power it back on it is just like you left it.<br><br><b>Features:<br></b></span><div><b>Operating System: </b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Windows 7 Home Premium</div><div><b>Display:</b> &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 13.3\"</div><div><b>Storage Capacity:</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;256 GB</div>', 1430715112, 'active', 'slide', 'Yes', 20);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `status` varchar(30) NOT NULL,
  `date_added` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`category_id`, `category_name`, `description`, `status`, `date_added`) VALUES
(1, 'Computers', 'Computers such as Laptops, Desktops, Tablets, Monitors, Networking, printers and scanners...  ', 'active', 1430231787),
(2, 'Car Electronics', 'Car Electronics includes, GPS & Navigation, In-dash stereos, speakers, subwoofers, amplifiers and car DVD & Video... ', 'active', 1430234443),
(3, 'TV & Video', 'TV & Video includes, LED TVs, Plasma TVs, 3D TVs, DVD & Blu-ray Players and Home theater system... ', 'active', 1430234503),
(4, 'Cell Phones', 'Cell Phones includes; Apple iPhone, HTC, Motorola, Nokia, Samsung... ', 'active', 1430234574),
(5, 'MP3 Players', 'MP3 Players includes; iPods, Android, MP3 Players, MP3 Speaker System and Headphones... ', 'active', 1430234610),
(6, 'Cameras', 'Cameras includes; Digital Cameras, DSLR Cameras, Camcorders and Lenses... ', 'active', 1430234659),
(7, 'Bikes', 'Bikes includes; Comfort & cruisers, Road Bikes, Mountain Bikes... ', 'active', 1430234694),
(8, 'Golf', 'Golf includes; Golf clubs, Golf Balls, Golf Bags & carts... ', 'active', 1430234726),
(9, 'Camping', 'Camping includes; Back Packs, Sleeping bags and tents... ', 'active', 1430234754),
(10, 'Men\'s Clothing', 'Men\'s Clothing includes; T-shirts, pants, suites, socks... ', 'active', 1430234803),
(11, 'Women\'s Clothing', 'Women\'s Clothing includes; dresses, socks, skirts, winter cloths... ', 'active', 1430234839),
(12, 'Shoes', 'Shoes ', 'active', 1430234848),
(13, 'Watches & Jewelry', 'Watches and Jewelry ', 'active', 1430234866),
(14, 'Music', 'Music includes; Music discs of Blues, Classical, Jazz and Rock... ', 'active', 1430234898),
(15, 'Movies & TV', 'Moves & TV includes; Blu-ray Discs, Movies (DVD) and TV Shows (DVD) ', 'active', 1430234929),
(16, 'Video Games', 'Video Games includes; Playstation 3, Playstation Vita, Xbox 360 and Games for playstation, xbox and PC... ', 'active', 1430234972);

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

CREATE TABLE `product_review` (
  `review_id` int(11) NOT NULL,
  `review` text NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rating` int(10) NOT NULL,
  `date_added` int(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_review`
--

INSERT INTO `product_review` (`review_id`, `review`, `name`, `email`, `rating`, `date_added`, `product_id`, `status`) VALUES
(1, 'This is so nice laptop, really like it.', 'Mohammad Naim Faizy', 'mnaimfaizy@yahoo.com', 4, 1430728550, 6, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `sub_cat_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_cat_name` varchar(100) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `date_added` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`sub_cat_id`, `category_id`, `sub_cat_name`, `description`, `status`, `date_added`) VALUES
(1, 1, 'Desktops', ' Desktops includes; complete computer which contains one system box, monitor, mouse and keyboard\r\n                                     ', 'active', 0),
(2, 1, 'Laptops', 'Laptops includes; Complete computer which can have battery for working everywehere.', 'active', 1430237466),
(3, 1, 'Tablets', ' Tablets', 'active', 1430239854),
(4, 1, 'Monitors', ' Displays pictures, movies, music and documents...', 'active', 1430239887),
(5, 1, 'Networking', ' Network equipments, Routers, switches...', 'active', 1430239913),
(6, 1, 'Printers', ' Prints documents and pictures...', 'active', 1430239950),
(7, 1, 'Scanners', ' Scan\'s documents and pictures', 'active', 1430239965),
(8, 1, 'Processors', ' Desktop and Server computers processors', 'active', 1430239981),
(9, 2, 'GPS & Navigation', ' \r\n                                      GPS for tracking places or vehicles, \r\nNavigation for navigating the way for you', 'active', 1430240036),
(10, 2, 'In-Dash Stereos', ' In-Dash Stereos', 'active', 1430240062),
(11, 2, 'Speakers', ' Speakers to listen music and other...', 'active', 1430241168),
(12, 2, 'Subwoofers', ' Subwoofers', 'active', 1430241184),
(13, 2, 'Amplifiers', ' Amplifiers', 'active', 1430241198),
(14, 2, 'Car DVD & Video', ' Car DVD & Video', 'active', 1430241218),
(15, 3, 'LED TVs', ' LED TVs', 'active', 1430241249),
(16, 3, 'Plasma TVs', ' Plasma TVs', 'active', 1430241267),
(17, 3, '3D TVs', ' 3D TVs', 'active', 1430241283),
(18, 3, 'DVD & Blu-ray Players', ' DVD & Blu-ray Players', 'active', 1430241303),
(19, 3, 'Home Theater System', ' Home Theater System', 'active', 1430241320),
(20, 4, 'Apple iPhone', ' Apple smartphones', 'active', 1430241342),
(21, 4, 'HTC', ' ', 'active', 1430241349),
(22, 4, 'Motorola', ' ', 'active', 1430241357),
(23, 4, 'Nokia', ' ', 'active', 1430241365),
(24, 4, 'Samsung', ' ', 'active', 1430241372),
(25, 5, 'iPods', ' ', 'active', 1430241382),
(26, 5, 'Android', ' ', 'active', 1430241390),
(27, 5, 'MP3 Players', ' ', 'active', 1430241399),
(28, 5, 'MP3 Speaker Systems', ' ', 'active', 1430241410),
(29, 5, 'Headphones', ' ', 'active', 1430241422),
(30, 6, 'Digital Cameras', ' ', 'active', 1430241445),
(31, 6, 'DSLR Cameras', ' ', 'active', 1430241455),
(32, 6, 'Camcorders', ' ', 'active', 1430241463),
(33, 6, 'Lenses', ' ', 'active', 1430241475),
(34, 7, 'Comfort & Cruisers', ' ', 'active', 1430241489),
(35, 7, 'Road Bikes', ' ', 'active', 1430241502),
(36, 7, 'Mountain Bikes', ' ', 'active', 1430241513),
(37, 8, 'Golf clubs', ' ', 'active', 1430241526),
(38, 8, 'Golf Balls', ' ', 'active', 1430241534),
(39, 8, 'Golf Bags & Carts', ' ', 'active', 1430241546),
(40, 9, 'Back Packs', ' ', 'active', 1430241556),
(41, 9, 'Sleeping Bags', ' ', 'active', 1430241568),
(42, 9, 'Tents', ' ', 'active', 1430241575),
(43, 14, 'Blues', ' ', 'active', 1430241590),
(44, 14, 'Classical', ' ', 'active', 1430241604),
(45, 14, 'Jazz', ' ', 'active', 1430241614),
(46, 14, 'Rock', ' ', 'active', 1430241622),
(47, 15, 'Blu-ray Discs', ' ', 'active', 1430241636),
(48, 15, 'Movies (DVD)', ' ', 'active', 1430241645),
(49, 15, 'TV Shows (DVD)', ' ', 'active', 1430241656),
(50, 16, 'Playstation 3', ' ', 'active', 1430241667),
(51, 16, 'Playstation Vita', ' ', 'active', 1430241678),
(52, 16, 'Xbox 360', ' ', 'active', 1430241689);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(60) NOT NULL,
  `group_id` int(11) NOT NULL,
  `date_joined` int(30) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `group_id`, `date_joined`, `photo`, `status`) VALUES
(1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'Mohammad Naim Faizy', 1, 1428605949, 'avatar_small.png', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`id`, `group_name`) VALUES
(1, 'Administrator'),
(2, 'Standard User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `product_review`
--
ALTER TABLE `product_review`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`sub_cat_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_review`
--
ALTER TABLE `product_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `sub_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
