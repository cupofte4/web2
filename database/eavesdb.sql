-- 
-- 

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */; 

-- 
-- 

CREATE TABLE `customer` (
  `customer_id` INT AUTO_INCREMENT PRIMARY KEY,
  `first_name` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(100) NOT NULL,
  `email` varchar(150) NOT NULL UNIQUE,
  `phone` varchar(20) NULL,
  `street` varchar(50) NULL,
  `ward` varchar(50) NULL,
  `district` varchar(50) NULL,
  `city` varchar(50) NULL,
  `password` varchar(32) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 
-- 

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `email`, `phone`, `street`, `ward`, `district`, `city`, `password`, `status`) VALUES
(1, 'Trần', 'Như', 'trannhu@gmail.com', '01212729580', '400 Âu Cơ', '8736', '554', '50', 'c3eb4bd8dfc3dac74e8cfc3d7918d6b1', 1);


-- 
-- 

CREATE TABLE `manager` (
  `username` varchar(20) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `street` varchar(50) NOT NULL,
  `ward` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`username`, `fullname`, `email`, `phone`, `street`, `ward`, `district`, `city`, `password`, `status`) VALUES
('Cobexinhdep', 'Cô Bé Xinh Đẹp', 'cobexinhdep@gmail.com', '0906666344', '123 Nguyễn Tri Phương', '8863', '562', '50', '2f68b7cc67237e87a5499a740c73682b', 1);

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` varchar(50) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 
-- 

INSERT INTO `category` (`category_id`, `category_name`) VALUES
('whatsnew', "WHAT'S NEW"),
('men', 'MEN'),
('women', 'WOMEN');

-- 
-- 

CREATE TABLE `type` (
  `type_id` varchar(50) NOT NULL PRIMARY KEY,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 
-- 


INSERT INTO `type` (`type_id`, `type_name`) VALUES
('jacket', "Jacket"),
('jean', 'Jean'),
('sweatshirt', 'Sweatshirt');

-- 
-- 

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(200) NOT NULL,
  `image` varchar(500) NOT NULL,
  `category_id` varchar(50) NOT NULL,
  `type_id` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 
-- 

INSERT INTO `product` (`ProductID`, `name`, `image`, `category_id`, `type_id`, `price`, `description`, `status`) VALUES
(1, 'allover crinkle logo print regular fit padded bomber jacket', 'mjacket1.jpg', 'men','jacket', 385, "Crafted in a muted charcoal gray, this bomber jacket is adorned with subtle, wrinkled EK logo prints that add depth to its design. The front pocket features a refined orange brand woven label, elevating the jacket's overall distinction.", 1),
(2, "distressed edges inserted daicock baggy jeans","mjean1.webp","men", 'jean',645,"These baggy cargo jeans feature an acid wash and multi-pockets, combined with a unique seagull print.", 1),
(3, 'potassium spray seagull boxy long-sleeve t-shirt', 'msweatshirt1.webp','men', 'sweatshirt', 175, 'Relax in style with this sweatshirt featuring a logo and Ninja Daruma Daicock print for a bold, comfortable look.', 1),
(4, "Daruma Leather Patch Denim Jacket", "mjacket2.jpg", "men", 'jacket', 499, "This reversible denim jacket features a vintage tweed and wave print. Perfect for a stylish, boxy fit.", 1),
(5, "Seagull Pocket and Slogan Print Relax Fit Sweatshirt", "msweatshirt2.webp", "men", 'sweatshirt', 235, "Embrace comfort with this relaxed-fit sweatshirt featuring bold graphics and dragon embroidery for a standout look.", 1),
(6, "seagull print relax fit denim jacket", "mjacket3.jpg", "men",'jacket', 579, "This classic denim jacket features a mountain landscape print, providing a rugged yet fashionable look.", 1),
(7, "Rseagull and slogan embroidery oversized denim coach jacket", "mjacket4.jpg", "men",'jacket', 309,"This oversized denim jacket features a bold patchwork and graphic print design, adding a unique retro vibe to any outfit.", 1),
(8, "Seagull Metallic Embroidery Carrot Fit Jeans #2017", "mjean2.webp", "men",'jean', 325, "These loose-fit jeans have a distressed faded blue wash and utility pockets, perfect for a rugged and stylish look.", 1),
(9, "Seagull Embroidery and Logo Appliqué Fashion Fit Leather Jacket", "mjacket1.webp", "men", 'jacket', 900, "This leather jacket is adorned with Seagull embroidery on the front and brand logo patch embroidery on the back. The edges of the jacket also feature intentionally distressed, vintage-inspired yellowed details. This design gives the jacket a unique antique style while showcasing the brand's logo and personality.", 1),
(10, "Allover EK Logo Velvet Relax Fit Down Jacket", "mjacket2.webp", "men",'jacket', 645, "Are you in pursuit of high-quality design? This down jacket features allover EK logo velvet, with logo embroidery on the back. The overall design is luxurious and elegant, showcasing an unparalleled sense of opulence.", 1 ),
(11, "Deconstructed Print and Logo Embroidery Relax Fit Down Jacket", "mjacket3.webp","men",'jacket', 605, "This down jacket cleverly incorporates a deconstructed style through prints, creating intentionally worn details that add a unique sense of fashion. The back features logo embroidery with various stitch patterns that showcase a three-dimensional effect, while the front is adorned with a Seagull embroidery decoration. The overall design is both warm and individualistic.", 1),
(12, "Seagull and Eagle Embroidery Cropped Carrot Fit Jeans", "mjean1.webp", "men",'jean', 425, "Dreaming of eagle on the first day of the new year represents good luck and realisation of wishes since Edo period. Cut for a cropped carrot fit, these jeans are intricately embroidered with eagle, logo and seagull, bringing good vibes only to the trendsetters.", 1),
(13, "Daruma and Logo Embroidery Relax Fit Sweatshirt", "msweatshirt3.webp", 'men','sweatshirt', 155, "With a streetwear-inspired design, this hoodie features intricate embroidery combining Daruma and EAVES logo on the chest, seamlessly blending Eastern culture with contemporary urban style. Its relaxed fit and soft fabric offer both comfort and fashion, making it perfect for everyday wear or standout street looks.", 1),
(14, "Deconstructed Contrast Relax Fit Sweatshirt", "msweatshirt4.webp", 'men','sweatshirt', 235, "This sweatshirt from EAVES features a garment dyeing process, showcasing the brand's seagull, various logo fonts, and slogans on the front. Notably, the calligraphic logo spans across the entire garment.", 1),
(15, "Garment Dyed Multi-Logo Print Relax Fit Sweatshirt", 'msweatshirt5.webp', 'men', 'sweatshirt', 235, "This sweatshirt features a multi-logo print, with a bold and contrasting design that adds a unique and stylish touch to any ensemble.", 1),
(16, "Graffiti Prints Regular Fit Jeans #2000", "mjean4.webp", 'men', 'jean', 379, "Drawing inspiration from urban art, these jeans feature bold graffiti prints that celebrate a rebellious cultural vibe. Classic brand motifs like the logo, seagull, slogans, Godhead and Daruma are seamlessly integrated, creating a design rich in meaning and character. The washed denim offers both toughness and a retro aesthetic.", 1),
(17, "Dip-dyed Oversize Sweatshirt", "wsweatshirt2.webp", "women",'sweatshirt', 235, "A lightweight, loose-fit blouse adorned with delicate floral embroidery, perfect for achieving a boho-chic look.", 1),
(18, "Embossed Slogan Cropped Sweatshirt", "wsweatshirt3.webp", "women",'sweatshirt', 219, "Classic high-waisted straight-leg jeans featuring a vintage wash, offering a timeless and versatile style.", 1),
(19, "Graffiti Kamon Print Sweatshirt", "wsweatshirt4.webp", "women",'sweatshirt', 259, "A sleek leather biker jacket with studded details, adding an edgy vibe to any ensemble.", 1),
(20, "Deconstructed Seagull Embossed Fashion Fit Skirt-Jeans", "wjean2.webp", "women", 'jean', 385, "A sleek leather biker jacket featuring studded details and an asymmetrical zip, perfect for an edgy, bold look.", 1),
(21, "Pixel Seagull Embroidery Relax Jeans", "wjean3.webp", "women",'jean', 370, "A cozy, oversized hoodie with a vibrant tie-dye design, offering both comfort and style for casual outings.", 1),
(22, "Cut-Line Fashion Fit Boot Cut Jeans", "wjean4.webp", "women",'jean', 330, "Elegant wide-leg palazzo trousers featuring a flowing silhouette, versatile for both formal and casual settings.", 1),
(23, "Seagull and Logo Laser Print Fashion Fit Denim Corset Jacket", "wjacket3.webp", "women",'jacket', 360, "Trendy denim overalls with multiple front pockets and adjustable straps, giving a playful and practical look.", 1),
(24, "Allover Rhinestone Seagull Loose Fit Denim Jacket", "wjacket4.webp", "women",'jacket', 625, "A classic slip dress with a satin finish and delicate spaghetti straps, ideal for elegant evening wear or layering.", 1),
(25, "Kamon EmbroideredDown Jacket", "wjacket1.webp", "women", 'jacket', 515, "A sleek leather biker jacket featuring studded details and an asymmetrical zip, perfect for an edgy, bold look.", 1),
(26, "Seagull Embroidery High-Waist Skinny Jeans", "wjean1.webp", "women", 'jean', 325, "Elegant wide-leg palazzo trousers featuring a flowing silhouette, versatile for both formal and casual settings.", 1),
(27, "Logo Appliquéd Leather Bomber Jacket", "wjacket2.webp", "women", 'jacket', 385, "A sleek leather biker jacket with studded details, adding an edgy vibe to any ensemble.", 1),
(28, "Seagull Brocade Appliqué and Logo Embroidery Regular Fit Sweatshirt", "wsweatshirt1.webp", "women", 'sweatshirt', 215, "A cozy, oversized hoodie with a vibrant tie-dye design, offering both comfort and style for casual outings.", 1),
(29, "Ishigaki Camouflage Inserted Daicock Slim Fit Jeans", "njean1.webp", "whatsnew", "jeans", 385, "These distressed skinny jeans feature a classic blue wash, perfect for a casual yet trendy look.", 1),
(30, "Seagull Print and Hybrid Ishigaki Camouflage Regular Fit Shirt Jacket", "njacket1.webp", "whatsnew", "jacket", 385, "A cozy oversized sweatshirt showcasing a bold graphic design, ideal for staying warm and stylish.", 1),
(31, "Seagull Print and Logo Tape Regular Fit Down Jacket", "njacket2.webp", "whatsnew", "jacket", 515, "These relaxed fit mom jeans come with a high waist and frayed hem, combining comfort and style effortlessly.", 1),
(32, "Brushstroke Seagull Print Straight Fit Jeans", "njean2.webp", "whatsnew", "jeans", 349, "A soft cotton fleece sweatshirt featuring an embroidered logo, perfect for a casual, sporty look.", 1),
(33, "Allover Logo Jacquard and Seagull Embroidery Boyfriend Fit Denim Shirt Jacket", "njacket3.webp", "whatsnew", "jacket", 385, "This classic denim jacket features distressed details, making it a timeless piece for any wardrobe.", 1),
(34, "SLEEK PULLOVER SWEATSHIRT WITH RIBBED CUFFS", "nsweatshirt1.webp", "whatsnew", "sweatshirt", 235, "A sleek pullover sweatshirt with ribbed cuffs, perfect for layering and staying warm on cooler days.", 1),
(35, "Deconstructed Contrast Relax Fit Sweatshirt", "nsweatshirt2.webp", "whatsnew", "sweatshirt", 220, "This relaxed fit boxy jacket features utility pockets, providing both style and functionality for everyday wear.", 1),
(36, "Seagull Brocade Appliqué and Logo Embroidery Regular Fit Sweatshirt", "nsweatshirt3.webp", "whatsnew", "sweatshirt", 219, "With embroidery as the theme, this sweatshirt features a Seagull brocade appliqué on the front and logo embroidery on the back. Showcasing brand identity and exquisite embroidery craftsmanship, it adds a delicate and artistic atmosphere to this sweatshirt.", 1),
(37, "Daicock and Seagull Print Relax Fit 2-in-1 Denim Worker Shirt Jacket", "njacket4.jpg", 'whatsnew', 'jacket', 410, "Highlighted by a Daicock and seagull print, this 2-in-1 shirt jacket features unique faded print details that align seamlessly with the retro theme. The vintage wash finish adds a touch of personality and classic appeal. The varied pocket shapes bring depth and structure, allowing for a layered, stylish look even when worn on its own, perfect for those who value both fashion and individuality.", 1),
(38, "Deconstructed with Multi-pocket Loose Fit Denim Jacket", 'njacket5.webp', 'whatsnew', 'jacket', 440, "Combining collage techniques and deconstruction elements from graffiti art, this denim set presents a unique washed multi-pocket design. The pockets were removed and reattached post-wash, forming a shadowy outline of dark blue pockets for a displaced, layered effect. The asymmetrical deconstruction enhances texture and personality, making the design both fun and infused with a bold streetwear aesthetic.", 1);

--
-- 
CREATE TABLE `orderdetail`(
  `OrderID` INT (11) NOT NULL,
  `ProductID` INT (11) NOT NULL,
  `price` INT (11) NOT NULL,
  `quantity` INT (11) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- 
-- 

INSERT INTO `orderdetail` (`OrderID`, `ProductID`, `price`, `quantity`) VALUES
(1, 1, 385, 2);

-- 
-- 

CREATE TABLE `orders`(
  `OrderID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `customer_id` INT(11) NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `street` varchar(50) NOT NULL,
  `ward` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `status` INT(11) NOT NULL,
  `order_date` datetime NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `orders`(`OrderID`, `customer_id`, `receiver`, `email`, `phone`, `street`, `ward`, `district`, `city`, `status`, `order_date`) VALUES  
(1, 1,'Trần Thị Quỳnh Như','trannhu@gmail.com','01212729580','400 Âu Cơ','8891','564','50',1,'2025-5-4 18:23:46');

-- 
-- 

ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

-- 
-- 

ALTER TABLE `product`
  ADD KEY `category_id` (`category_id`) USING BTREE;

-- 
--

ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

-- 
--

ALTER TABLE `manager`
  ADD PRIMARY KEY (`username`);
-- 
-- 
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`OrderID`,`ProductID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `OrderID`(`OrderID`),
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

-- 
-- 
ALTER TABLE `orders`
  ADD KEY `customer_id` (`customer_id`),
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);
-- 
-- 
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
