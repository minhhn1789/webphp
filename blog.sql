-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 19, 2024 at 02:55 PM
-- Server version: 8.0.37-0ubuntu0.22.04.3
-- PHP Version: 8.1.2-1ubuntu2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `username`, `password`, `status`) VALUES
(10, 26, 'test1', '$2y$10$r7CDEdygHBuoX7dA1lmwBu19t1x50g73CdJkMLv.Wlc3bdXyF7SLe', 0),
(11, 27, 'test2', '$2y$10$V2G/VABPGL1lJMgkpqFVB.UEAq9lPPTBTQoBlQyELUrVx1DDFuAQC', 0),
(12, 28, 'test3', '$2y$10$ypcczGRPpdDgAJGLg4ZuveyFWJcVuCZiGkuUe9ZgcLiWfTrbc5qbG', 0),
(13, 29, 'test4', '$2y$10$8bGvRElIUCC25aSwSdQUAO2YBv8mZD7TkA0YScaYwL6Jow5ULETou', 0),
(14, 30, 'test5', '$2y$10$fyb0y2F/R5k8651/OC0Ww.aWYijiKjgZTfbufoF6up/C7/lX1LTjW', 0),
(15, 31, 'test6', '$2y$10$i2CQtZI6KsSyemhD8Cx9IO5.iSI9iCZjkma8nuPl9jY3OuGzGj00K', 0),
(16, 32, 'admin1', '$2y$10$/tQFMVkQZu4R7cc92JXwk.7xcRR.akfQW/GR5PjaAUy1WyPMNh4V.', 0),
(17, 33, 'admin2', '$2y$10$mpOcguFAcXu2X9FWkBU7I.ltSqi9s12OzOQjHRzGqn5KHj81WcYky', 0),
(18, 34, 'admin3', '$2y$10$/y7SeW9/huFNtNSvM3s8rOxtll3D2R8SrLcyFh/wSvlc6T89YBr1C', 0),
(19, 35, 'admin4', '$2y$10$HsZMRGxtT3jIdffcNo.KTeJXo8hE1R4Mz84.eNHPkKVfg5I4JgWjS', 0),
(20, 36, 'admin5', '$2y$10$nUWC1UlBTbSwQpGEFpAlbuB.vcZNVztnXcfu1sif8BDMM8sV3FmwG', 0),
(21, 37, 'admin6', '$2y$10$Bb0uSABdKUA1mRhEjpyS2u4zZ94UMPPBDS3OxChLilVHGujY55tB2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `author_id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `title`, `content`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2, 26, 'war', 'Military Vehicles\r\nMilitary vehicles play a crucial role in modern military strategy and tactics. They are categorized into several main types:\r\n\r\nArmored Personnel Carrier (APC): Designed to transport infantry and provide protection against small arms fire and landmines.\r\n\r\nMain Battle Tank (MBT): The primary combat vehicle in a military force, known for its high destructive power and strong defensive capabilities.\r\n\r\nMine-Resistant Ambush Protected (MRAP) Vehicle: Designed to withstand attacks from mines and armed ambushes.\r\n\r\nInfantry Fighting Vehicle (IFV): Combines the transport capability of an APC with the firepower of a tank.\r\n\r\nMilitary Weapons\r\nMilitary weapons are diverse and advanced:\r\n\r\nSmall Arms: Including pistols, rifles, and machine guns, with various types of ammunition for different combat purposes.\r\n\r\nArtillery: Ranging from light anti-aircraft guns to heavy artillery pieces, capable of long-range attacks and causing significant damage.\r\n\r\nMissiles: Including anti-tank missiles, anti-aircraft missiles, and ballistic missiles, essential for strategic offense and defense.\r\n\r\nNuclear Weapons: Used for deterrence or retaliation in large-scale warfare.', NULL, 'publish', '2024-06-19 05:25:46', '2024-06-19 05:25:46'),
(3, 26, 'Strategic Versatility', 'Tanks play a versatile role in both offensive and defensive operations. In offensive roles, they lead armored assaults, breach enemy defenses, and support infantry advances. Defensively, tanks provide strong points of resistance, holding key positions and repelling enemy attacks.', NULL, 'publish', '2024-06-19 05:29:57', '2024-06-19 05:29:57'),
(4, 26, 'Mobility', 'Despite their heavy weight, tanks are surprisingly agile and mobile across diverse terrains, including rough terrain and urban environments. They can traverse obstacles such as trenches, rivers, and steep slopes, maintaining their operational effectiveness and maneuverability.', NULL, 'publish', '2024-06-19 05:30:37', '2024-06-19 05:30:37'),
(5, 26, 'Command and Control', 'Modern tanks are equipped with advanced targeting systems, thermal sights, and digital communication systems that enhance situational awareness and coordination with other units on the battlefield. This integration improves tactical effectiveness and minimizes friendly fire incidents.', NULL, 'publish', '2024-06-19 05:31:44', '2024-06-19 05:31:44'),
(6, 26, 'Psychological Impact', 'The presence of tanks on the battlefield exerts a significant psychological effect on adversaries and can influence the outcome of engagements. Their imposing size, firepower, and resilience instill fear and uncertainty among enemy forces, often leading to tactical advantages for friendly forces.', NULL, 'publish', '2024-06-19 05:32:46', '2024-06-19 05:32:46'),
(7, 27, 'Impact of the Greenhouse Effect', 'The greenhouse effect, a phenomenon whereby certain gases trap heat in the Earth\'s atmosphere, has profound implications for our planet and its ecosystems. Here’s a look at its influence.', NULL, 'publish', '2024-06-19 05:34:35', '2024-06-19 05:34:35'),
(8, 27, 'Climate Change', 'The primary consequence of the greenhouse effect is climate change. Gases like carbon dioxide (CO2), methane (CH4), and nitrous oxide (N2O) emitted from human activities such as burning fossil fuels and deforestation enhance the natural greenhouse effect. This leads to an increase in global temperatures, causing shifts in weather patterns, more frequent and intense heatwaves, altered precipitation patterns, and rising sea levels.', NULL, 'publish', '2024-06-19 06:37:34', '2024-06-19 06:37:34'),
(9, 27, 'Economic Implications', 'Addressing the greenhouse effect requires global cooperation and action. Mitigation efforts focus on reducing greenhouse gas emissions through renewable energy adoption, energy efficiency improvements, and sustainable land use practices. Adaptation strategies involve preparing communities for the impacts of climate change, such as building resilient infrastructure and implementing early warning systems.                                                ', NULL, 'publish', '2024-06-19 06:39:58', '2024-06-19 06:43:29'),
(10, 27, 'Mitigation and Adaptation', 'Addressing the greenhouse effect requires global cooperation and action. Mitigation efforts focus on reducing greenhouse gas emissions through renewable energy adoption, energy efficiency improvements, and sustainable land use practices. Adaptation strategies involve preparing communities for the impacts of climate change, such as building resilient infrastructure and implementing early warning systems.', NULL, 'publish', '2024-06-19 06:40:14', '2024-06-19 06:40:14'),
(11, 27, 'Conclusion', 'The greenhouse effect is a critical environmental issue with far-reaching consequences for Earth’s climate, ecosystems, and human societies. Addressing its effects requires urgent and coordinated global action to safeguard our planet for future generations.', NULL, 'publish', '2024-06-19 06:42:09', '2024-06-19 06:42:09'),
(12, 27, 'Global Health Risks', 'Climate change exacerbates health risks globally. It increases the spread of infectious diseases like malaria and dengue fever as warmer temperatures expand the habitats of disease-carrying insects. Air pollution, linked to climate change, worsens respiratory illnesses, cardiovascular diseases, and premature deaths.', NULL, 'publish', '2024-06-19 06:45:02', '2024-06-19 06:45:02'),
(13, 28, 'Types of Vulnerabilities: Critical Issues That Need Addressing', 'In various aspects of life and society, vulnerabilities represent significant challenges that require attention to ensure smooth operations and sustainable development. Here are examples of different types of vulnerabilities and their impacts:', NULL, 'hidden', '2024-06-19 06:47:37', '2024-06-19 06:47:37'),
(14, 28, '1. Cybersecurity and Data Privacy Vulnerabilities', 'Security vulnerabilities in networks and personal data pose a significant threat to individuals, businesses, and organizations. Cyberattacks, such as data breaches and Distributed Denial of Service (DDoS) attacks, can result in severe economic and reputational damage.', NULL, 'publish', '2024-06-19 06:48:03', '2024-06-19 06:48:03'),
(15, 28, '2. Infrastructure Vulnerabilities', 'Critical infrastructure systems, such as bridges, railways, and power grids, face serious vulnerabilities. These systems require regular maintenance and upgrades to ensure safety and the continuity of essential services.', NULL, 'publish', '2024-06-19 06:48:31', '2024-06-19 06:48:31'),
(16, 28, '3. Healthcare System Vulnerabilities', 'The healthcare system is not immune to vulnerabilities related to patient data security and the efficiency of public health services. These issues can lead to risks of critical data loss and impact the health and security of individuals.', NULL, 'publish', '2024-06-19 06:49:21', '2024-06-19 06:49:21'),
(17, 28, '4. Environmental and Climate Change Vulnerabilities', 'Climate change is a major vulnerability threatening life on Earth. Global warming, rising sea levels, and habitat changes for flora and fauna are direct consequences of this vulnerability.', NULL, 'publish', '2024-06-19 06:50:10', '2024-06-19 06:50:10'),
(18, 29, 'The Shift from Gasoline to Electric Vehicles: A Transformative Choice', 'In recent years, the transition from gasoline-powered vehicles to electric vehicles (EVs) has gained significant traction worldwide. This shift is driven by several compelling reasons and promises transformative impacts across various domains:', NULL, 'publish', '2024-06-19 06:52:06', '2024-06-19 06:52:06'),
(19, 29, 'Environmental Benefits', 'Electric vehicles are recognized for their minimal carbon emissions compared to traditional gasoline-powered counterparts. By reducing greenhouse gas emissions and air pollutants such as nitrogen oxides and particulate matter, EVs contribute to improving air quality and combating climate change. This transition aligns with global efforts to achieve sustainability goals and reduce dependency on fossil fuels.', NULL, 'publish', '2024-06-19 06:52:48', '2024-06-19 06:52:48'),
(20, 29, 'Economic Advantages', 'The adoption of electric vehicles offers economic benefits at multiple levels. Initially, EV owners benefit from lower operating costs due to cheaper electricity compared to gasoline. Moreover, as technology advances and production scales up, the cost of EVs is gradually becoming more competitive, attracting more consumers and stimulating market growth. Countries investing in EV infrastructure and manufacturing also stand to gain in terms of job creation and technological innovation.', NULL, 'publish', '2024-06-19 06:53:31', '2024-06-19 06:53:31'),
(21, 29, 'Technological Innovation', 'Electric vehicles represent a frontier of technological advancement. Innovations in battery technology, energy storage, and vehicle design are accelerating, enhancing the range, efficiency, and performance of EVs. These advancements not only benefit transportation but also drive progress in renewable energy integration and smart grid solutions.', NULL, 'publish', '2024-06-19 06:54:12', '2024-06-19 06:54:12'),
(22, 29, 'Energy Security', 'EVs are increasingly appealing to consumers due to their quiet operation, instant torque, and smooth driving experience. The expanding availability of charging infrastructure, including fast-charging stations, enhances convenience and addresses range anxiety, making electric vehicles a practical choice for daily commuting and long-distance travel.', NULL, 'publish', '2024-06-19 06:54:50', '2024-06-19 06:54:50'),
(23, 30, '1. The Lost Key', 'Sarah hurriedly searched through her bag, panic rising as she realized her house key was missing. She retraced her steps, hoping to find it before her roommate returned from work.', NULL, 'publish', '2024-06-19 06:56:47', '2024-06-19 06:56:47'),
(24, 30, '2. The Unexpected Encounter', 'Tom sat alone at the café, lost in thought, when he heard a familiar voice. Turning around, he was stunned to see his childhood best friend, whom he hadn\'t seen in years.', NULL, 'publish', '2024-06-19 06:57:24', '2024-06-19 06:57:24'),
(25, 30, '3. A Midnight Adventure', 'Under the moonlit sky, Emily and Jake sneaked out of the house for a midnight adventure. They giggled nervously as they explored the old abandoned mansion at the edge of town.', NULL, 'publish', '2024-06-19 06:58:03', '2024-06-19 06:58:03'),
(26, 30, '4. The Mystery of the Old Bookstore', 'Emma stumbled upon a dusty old bookstore tucked away in a corner of the city. As she browsed through the shelves, she discovered a hidden compartment containing a collection of handwritten letters.', NULL, 'publish', '2024-06-19 06:58:46', '2024-06-19 06:58:46'),
(27, 30, '5. The Magical Garden', 'Lucas stumbled upon a hidden garden behind his grandmother\'s house. To his amazement, the flowers whispered secrets, and the trees seemed to sway in rhythm with his heartbeat.', NULL, 'publish', '2024-06-19 06:59:32', '2024-06-19 06:59:32'),
(28, 30, '6. The Haunted Cabin', 'Mark and his friends dared each other to spend a night in the haunted cabin deep in the woods. Strange noises and flickering lights kept them on edge until dawn broke, revealing an unexpected twist.', NULL, 'publish', '2024-06-19 06:59:57', '2024-06-19 06:59:57'),
(29, 30, '7. The Forgotten Promise', 'Sophie stumbled upon an old photo album in her attic, filled with memories of her parents\' youth. Among the photos was a note—a forgotten promise that would change her perspective on family forever.', NULL, 'publish', '2024-06-19 07:00:22', '2024-06-19 07:00:22'),
(30, 30, '8. The Curious Artifact', 'In an antique shop, Daniel found a peculiar artifact—a small, intricately carved statue with an unknown inscription. Little did he know, it held the key to unraveling a centuries-old mystery.', NULL, 'publish', '2024-06-19 07:00:45', '2024-06-19 07:00:45'),
(31, 30, '9. The Last Letter', 'Julia received a letter in the mail, addressed to her late grandmother. Inside was a heartfelt message and a key to a hidden drawer, unlocking secrets from a past she never knew existed.', NULL, 'publish', '2024-06-19 07:01:11', '2024-06-19 07:01:11'),
(32, 31, 'Ease of Use', 'PHP is known for its simplicity and ease of learning, making it accessible for developers at various skill levels. Its syntax is straightforward and similar to C and Perl.', NULL, 'publish', '2024-06-19 07:24:23', '2024-06-19 07:24:23'),
(33, 31, 'Integration Capabilities', 'PHP integrates effortlessly with various databases, including MySQL, PostgreSQL, Oracle, and MongoDB. This compatibility enhances its ability to handle dynamic content and interact with databases efficiently.', NULL, 'publish', '2024-06-19 07:26:13', '2024-06-19 07:26:13'),
(34, 31, 'Open Source', 'As an open-source language, PHP is freely available for anyone to use, modify, and distribute. This fosters a large and active community that contributes to its continuous improvement.', NULL, 'publish', '2024-06-19 07:26:42', '2024-06-19 07:26:42'),
(35, 31, 'Platform Independence', 'PHP runs seamlessly on various operating systems like Windows, macOS, Linux, and Unix. This flexibility allows developers to deploy PHP applications across different platforms without major modifications.', NULL, 'publish', '2024-06-19 07:27:26', '2024-06-19 07:27:26'),
(36, 31, 'Scalability', 'PHP supports scalable web applications, capable of handling large volumes of traffic and complex tasks. Combined with caching mechanisms and load balancing techniques, PHP facilitates robust and scalable solutions.', NULL, 'publish', '2024-06-19 07:27:58', '2024-06-19 07:27:58'),
(38, 31, 'Rich Feature Set', 'PHP offers a rich set of features and functionalities tailored for web development, including built-in support for sessions, cookies, XML parsing, and file handling. Its extensive library of extensions and frameworks further enhances development efficiency.', NULL, 'publish', '2024-06-19 07:29:01', '2024-06-19 07:29:01'),
(39, 31, 'Speed', 'PHP executes quickly since it\'s processed on the server-side before being sent to the client\'s browser. With performance optimizations and bytecode caching (e.g., OPCache), PHP ensures rapid response times for web applications.', NULL, 'publish', '2024-06-19 07:29:23', '2024-06-19 07:29:23'),
(40, 31, 'Community Support', 'PHP benefits from a vast community of developers, forums, and resources. This support network provides assistance, tutorials, and updates, helping developers stay current with best practices and emerging trends.', NULL, 'publish', '2024-06-19 07:30:10', '2024-06-19 07:30:10'),
(41, 32, '1. Choosing the Right Components', 'Building a PC can be a rewarding experience! Start by selecting the right components:\r\n\r\nProcessor (CPU): Consider your needs—whether for gaming, content creation, or everyday use.\r\nMotherboard: Ensure compatibility with your CPU and other components.\r\nMemory (RAM): Opt for sufficient RAM for multitasking and gaming performance.\r\nStorage: Decide between SSDs for speed or HDDs for larger capacity.\r\nGraphics Card (GPU): Crucial for gaming; choose based on your gaming resolution and graphics settings.\r\nPower Supply (PSU): Calculate wattage needs based on your components.', NULL, 'publish', '2024-06-19 07:37:23', '2024-06-19 07:37:23'),
(42, 32, '2. Budget-Friendly Build', 'Building a PC on a budget? Here’s how to maximize performance without breaking the bank:\r\n\r\nCPU: Look for AMD Ryzen or Intel Core i3/i5 processors for cost-effective performance.\r\nGPU: Consider mid-range options like NVIDIA GTX 1660 or AMD RX 5600 XT.\r\nRAM: Aim for 16GB DDR4 RAM for balanced performance.\r\nStorage: Start with a smaller SSD for your OS and main applications, add an HDD for additional storage later.\r\nMotherboard: Opt for a reliable motherboard with essential features that fit your budget.\r\nCase and PSU: Choose a case with good airflow and a PSU that meets your power needs without overpaying.', NULL, 'publish', '2024-06-19 07:38:03', '2024-06-19 07:38:03'),
(43, 32, '3. High-Performance Gaming Rig', 'Building a PC for high-performance gaming? Here’s how to achieve the ultimate gaming experience:\r\n\r\nCPU: Select a powerful processor like AMD Ryzen 7 or Intel Core i7/i9 for smooth gaming and multitasking.\r\nGPU: Invest in a top-tier graphics card such as NVIDIA RTX 3080 or AMD RX 6800 XT for ultra-settings gaming.\r\nRAM: Aim for 32GB DDR4 RAM for future-proofing and handling intensive gaming sessions.\r\nStorage: Prioritize fast SSDs (NVMe) with ample capacity for quick game loading times.\r\nCooling: Consider liquid cooling solutions or high-performance air coolers for efficient heat dissipation.\r\nMonitor: Pair with a high-refresh-rate monitor and gaming peripherals for an immersive experience.', NULL, 'publish', '2024-06-19 07:41:52', '2024-06-19 07:41:52'),
(44, 32, '4. Compact and Portable Build', 'Looking to build a compact and portable PC? Here’s how to achieve a small form-factor build:\r\n\r\nMini-ITX Case: Choose a compact case that supports Mini-ITX motherboards.\r\nCPU: Opt for low-profile coolers and efficient processors like AMD Ryzen 5 or Intel Core i5.\r\nGPU: Select compact graphics cards such as NVIDIA GTX 1650 Super or AMD RX 5500 XT.\r\nCooling: Consider low-profile or small form-factor coolers and efficient case fans.\r\nStorage: Use M.2 SSDs for space-saving and fast performance.\r\nPower Supply: Choose an SFX or compact PSU that fits your case and power requirements.', NULL, 'publish', '2024-06-19 07:42:32', '2024-06-19 07:42:32'),
(45, 32, '5. Content Creation Workstation', 'Building a PC for content creation? Here’s how to optimize for productivity and performance:\r\n\r\nCPU: Prioritize multi-core processors like AMD Ryzen 9 or Intel Core i9 for rendering and editing.\r\nGPU: Balance with a capable GPU such as NVIDIA RTX 3070 or AMD RX 6700 XT for accelerated workflows.\r\nRAM: Invest in 32GB or more of fast DDR4 RAM for handling large files and multitasking.\r\nStorage: Utilize fast NVMe SSDs for OS and active projects, supplemented with HDDs for storage.\r\nMonitor: Choose a color-accurate monitor with high resolution for precise editing and design work.\r\nCooling: Consider efficient cooling solutions to maintain performance during intensive tasks.', NULL, 'publish', '2024-06-19 07:44:35', '2024-06-19 07:44:35'),
(46, 32, '6. Future-Proof Build', 'Planning a future-proof PC build? Here’s how to ensure longevity and upgradability:\r\n\r\nCPU and GPU: Invest in the latest generation processors and graphics cards for longevity.\r\nMotherboard: Choose a motherboard with future-proof features such as PCIe 4.0 and sufficient expansion slots.\r\nRAM: Start with at least 16GB of RAM, with room to upgrade to higher capacities in the future.\r\nStorage: Opt for a large SSD for OS and critical applications, with additional storage for games and files.\r\nPower Supply: Select a high-quality PSU with headroom for future upgrades and efficiency.\r\nCase: Pick a spacious case with good airflow and cable management for easy upgrades.', NULL, 'publish', '2024-06-19 07:45:21', '2024-06-19 07:45:21'),
(47, 33, '1. John Wick (2014)', 'Plot: A retired hitman seeks vengeance against those who wronged him, unleashing a relentless pursuit through the criminal underworld.\r\n\r\nReview: \"John Wick\" is a thrilling rollercoaster of non-stop action, featuring stylish choreography and intense gunfights that keep you on the edge of your seat. Keanu Reeves delivers a standout performance, making this film a modern classic in the action genre.', NULL, 'publish', '2024-06-19 07:49:26', '2024-06-19 07:49:26'),
(48, 33, '2. Mad Max: Fury Road (2015)', 'Plot: In a post-apocalyptic wasteland, Max teams up with Imperator Furiosa to escape a tyrannical warlord and his army in an epic chase across the desert.\r\n\r\nReview: \"Mad Max: Fury Road\" is a visual spectacle with jaw-dropping practical effects and exhilarating car battles. Charlize Theron shines as Furiosa, bringing depth to the adrenaline-pumping action sequences that redefine the genre.', NULL, 'publish', '2024-06-19 07:50:31', '2024-06-19 07:50:31'),
(49, 33, '4. The Dark Knight (2008)', 'Plot: Ethan Hunt and his IMF team race against time to prevent a global catastrophe, navigating double-crosses and high-stakes espionage.\r\n\r\nReview: \"Mission: Impossible - Fallout\" is a masterclass in action filmmaking, featuring Tom Cruise\'s daring stunts and intense set pieces. The plot twists keep you guessing, while the breathtaking action sequences make this a standout entry in the franchise.                        ', NULL, 'publish', '2024-06-19 07:51:05', '2024-06-19 07:51:51'),
(50, 34, 'Die Hard (1988)', 'Plot: NYPD officer John McClane battles terrorists who have taken hostages in a Los Angeles skyscraper during a Christmas party.\r\n\r\nReview: \"Die Hard\" is a quintessential action movie, defined by Bruce Willis\' charismatic performance as McClane and its suspenseful, high-octane action. The film\'s clever script and memorable one-liners have solidified its status as a beloved action classic.', NULL, 'publish', '2024-06-19 07:53:12', '2024-06-19 07:53:12'),
(51, 35, 'The Raid: Redemption (2011)', 'Plot: A SWAT team becomes trapped in a high-rise apartment building controlled by a ruthless crime lord, forcing them to fight their way to the top floor.\r\n\r\nReview: \"The Raid: Redemption\" is an Indonesian martial arts masterpiece, known for its relentless and brutal fight choreography. The film\'s intense action sequences and claustrophobic setting deliver an adrenaline rush from start to finish, setting a new standard for action cinema.', NULL, 'publish', '2024-06-19 07:53:39', '2024-06-19 07:53:39'),
(52, 36, 'Introduction to ChatGPT', 'OpenAI\'s ChatGPT is an advanced language model designed to understand and generate human-like text based on the input it receives. Leveraging the power of artificial intelligence, ChatGPT has become a versatile tool for various applications, including customer service automation, content generation, and educational assistance.\r\n\r\nUser Experience:\r\nUsing ChatGPT is straightforward and intuitive. Users interact with the model by typing messages or questions, and ChatGPT responds in natural language. The model\'s responses are contextually relevant and can range from informative explanations to creative writing prompts, depending on the user\'s input.', NULL, 'publish', '2024-06-19 07:54:36', '2024-06-19 07:54:36'),
(53, 37, 'Future Developments', 'OpenAI continues to innovate with ChatGPT, exploring advancements in natural language understanding, integration with other AI technologies, and enhancing user customization options for specific use cases.', NULL, 'publish', '2024-06-19 07:55:11', '2024-06-19 07:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `age` int NOT NULL,
  `sex` varchar(10) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `address`, `age`, `sex`, `phone_number`, `email`, `role`, `status`, `created_at`, `updated_at`) VALUES
(26, 'jack', '199ngothinam', 23, 'male', '1987654321', 'jack@gmail.com', 'user', 'active', '2024-06-19 04:45:20', '2024-06-19 04:45:20'),
(27, 'jacksparou', '199ngothinam', 25, 'male', '1986574321', 'jacksparou@gmail.com', 'user', 'active', '2024-06-19 04:47:58', '2024-06-19 04:47:58'),
(28, 'hausu', '557ngoquyen', 23, 'female', '98753214126', 'hausu@gmail.com', 'user', 'active', '2024-06-19 04:52:21', '2024-06-19 04:52:21'),
(29, 'Dellme', '247metri', 45, 'male', '78965432586', 'dellme@gmail.com', 'user', 'active', '2024-06-19 04:53:41', '2024-06-19 04:53:41'),
(30, 'haiphong', '279Laocai', 30, 'female', '15963214778', 'haiphong@gmail.com', 'user', 'active', '2024-06-19 04:54:50', '2024-06-19 04:54:50'),
(31, 'ocuunho', '775kimngu', 19, 'male', '785478547854', 'ocuunho@gmail.com', 'user', 'active', '2024-06-19 04:56:05', '2024-06-19 04:56:05'),
(32, 'admin', 'koroodau', 22, 'female', '778899445566', 'admin1@gmail.com', 'admin', 'active', '2024-06-19 05:03:24', '2024-06-19 05:08:29'),
(33, 'adminsupper', '755taoracu', 19, 'female', '6958476352414', 'adminsupper@gmail.com', 'admin', 'active', '2024-06-19 05:05:02', '2024-06-19 07:46:58'),
(34, 'adminlose', '288kumathong', 25, 'male', '232326252421', 'adminlose@gmail.com', 'admin', 'active', '2024-06-19 05:06:26', '2024-06-19 07:46:52'),
(35, 'adminalahuacma', 'caribe', 27, 'male', '56595857545', 'adminalahuacma@gmail.com', 'admin', 'active', '2024-06-19 05:07:55', '2024-06-19 07:46:47'),
(36, 'adminjack', '09laukora', 19, 'male', '263551425957', 'adminjack@gmail.com', 'admin', 'active', '2024-06-19 05:11:44', '2024-06-19 07:46:42'),
(37, 'adminsaitama', '66775508luoitam', 33, 'male', '575855656595', 'adminsaitama@gmail.com', 'admin', 'active', '2024-06-19 05:13:07', '2024-06-19 07:46:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test1` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test` (`author_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `test1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `test` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
