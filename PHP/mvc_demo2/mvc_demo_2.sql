
/* Database: `mvc_demo_2` */

CREATE TABLE IF NOT EXISTS `product` (
`id` int(10) AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(50) NOT NULL,
  `category` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL,
  `price` int(50) NOT NULL,
  `quantity` int(20) NOT NULL,
  `status` int(1) NOT NULL,
  `isDelete` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `category` (
`id` int(20) AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(50) NOT NULL,
  `status` varchar(1) NOT NULL,
  `image` varchar(100) NOT NULL,
  `isDelete` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
	
