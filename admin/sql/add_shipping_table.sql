-- Shipping table for managing shipping costs
-- Add this to the database

CREATE TABLE `shipping` (
  `shipping_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` varchar(2) NOT NULL,
  `province_id` int(11) NOT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `delivery_time` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active',
  `date_added` int(11) NOT NULL,
  PRIMARY KEY (`shipping_id`),
  KEY `country_id` (`country_id`),
  KEY `province_id` (`province_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample shipping rates
-- US shipping rates
INSERT INTO `shipping` (`country_id`, `province_id`, `zip_code`, `shipping_cost`, `delivery_time`, `status`, `date_added`) VALUES
('US', 1, NULL, 15.00, '3-5 business days', 'Active', UNIX_TIMESTAMP()),
('US', 5, NULL, 12.00, '3-5 business days', 'Active', UNIX_TIMESTAMP()),
('US', 32, NULL, 10.00, '2-4 business days', 'Active', UNIX_TIMESTAMP()),
('US', 43, NULL, 14.00, '4-6 business days', 'Active', UNIX_TIMESTAMP());

-- Canada shipping rates
INSERT INTO `shipping` (`country_id`, `province_id`, `zip_code`, `shipping_cost`, `delivery_time`, `status`, `date_added`) VALUES
('CA', 51, NULL, 20.00, '5-7 business days', 'Active', UNIX_TIMESTAMP()),
('CA', 52, NULL, 22.00, '5-7 business days', 'Active', UNIX_TIMESTAMP()),
('CA', 60, NULL, 18.00, '4-6 business days', 'Active', UNIX_TIMESTAMP());

-- Australia shipping rates  
INSERT INTO `shipping` (`country_id`, `province_id`, `zip_code`, `shipping_cost`, `delivery_time`, `status`, `date_added`) VALUES
('AU', 65, NULL, 25.00, '7-10 business days', 'Active', UNIX_TIMESTAMP()),
('AU', 71, NULL, 25.00, '7-10 business days', 'Active', UNIX_TIMESTAMP());

-- UK shipping rates
INSERT INTO `shipping` (`country_id`, `province_id`, `zip_code`, `shipping_cost`, `delivery_time`, `status`, `date_added`) VALUES
('GB', 73, NULL, 18.00, '5-7 business days', 'Active', UNIX_TIMESTAMP()),
('GB', 74, NULL, 18.00, '5-7 business days', 'Active', UNIX_TIMESTAMP());

-- India shipping rates
INSERT INTO `shipping` (`country_id`, `province_id`, `zip_code`, `shipping_cost`, `delivery_time`, `status`, `date_added`) VALUES
('IN', 88, NULL, 8.00, '4-6 business days', 'Active', UNIX_TIMESTAMP()),
('IN', 90, NULL, 8.00, '4-6 business days', 'Active', UNIX_TIMESTAMP()),
('IN', 101, NULL, 9.00, '5-7 business days', 'Active', UNIX_TIMESTAMP());
