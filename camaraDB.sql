-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 09, 2024 at 04:29 PM
-- Server version: 10.11.6-MariaDB-1:10.11.6+maria~ubu2204
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `camaaraapp`
--
CREATE DATABASE IF NOT EXISTS `camaraDB` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `camaraDB`;

-- --------------------------------------------------------

--
-- Table structure for table `app_introduction`
--

CREATE TABLE `app_introduction` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_introduction`
--

INSERT INTO `app_introduction` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(12, 'Events', 'Be updated with the latest events being held by Camara and its members', '2023-02-05 05:22:31', '2023-02-07 04:14:24'),
(13, 'Training', 'Join our training seminars to keep up with the latest trends and meta', '2023-02-05 05:23:10', '2023-02-07 04:14:22'),
(14, 'Members', 'Network with other Camara members to find new revenue sources and learn more', '2023-02-05 05:24:13', '2023-02-07 04:14:19');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner_image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `banner_type` varchar(255) NOT NULL,
  `redirection` enum('on','off') NOT NULL DEFAULT 'on'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `banner_image`, `created_at`, `updated_at`, `banner_type`, `redirection`) VALUES
(8, 'uploads/banner/7301031675576014.jpg', '2023-02-05 04:46:54', '2023-02-05 04:46:54', 'service', 'on'),
(9, 'uploads/banner/7914081675576041.jpg', '2023-02-05 04:47:21', '2023-02-05 04:47:21', 'event', 'on'),
(10, 'uploads/banner/3290801676636267.jpg', '2023-02-17 11:17:47', '2023-02-17 11:17:47', 'event', 'on'),
(11, 'uploads/banner/4703951676636282.jpg', '2023-02-17 11:18:02', '2023-02-17 11:18:02', 'event', 'on'),
(13, 'uploads/banner/2572601676636424.jpg', '2023-02-17 11:20:24', '2023-02-17 11:20:24', 'benefits', 'on'),
(14, 'uploads/banner/3666221676799960.jpg', '2023-02-19 08:46:00', '2023-02-19 08:46:00', 'event', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `benefits`
--

CREATE TABLE `benefits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1' COMMENT '0-Pending,1-Active,2-Delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `benefits`
--

INSERT INTO `benefits` (`id`, `cat_id`, `title`, `description`, `start_date`, `end_date`, `image`, `created_at`, `updated_at`, `status`) VALUES
(8, 9, 'Le Royal Méridien', 'Avail amazing benefits from our hotel partner Le Royal Meridien at the rooms to get 20% off on all rooms and halls.', '2023-02-05', '2023-03-05', 'uploads/benefits/7689471675578466.jpg', '2023-02-05 05:27:46', '2023-02-10 09:25:26', '1'),
(9, 8, 'Digital Marketing', 'more info', '2023-02-22', '2023-03-20', 'uploads/benefits/2438581676800143.jpg', '2023-02-19 08:49:03', '2023-02-19 08:49:03', '1');

-- --------------------------------------------------------

--
-- Table structure for table `business_registration`
--

CREATE TABLE `business_registration` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `document` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_registration`
--

INSERT INTO `business_registration` (`id`, `title`, `description`, `document`, `created_at`, `updated_at`, `image`) VALUES
(2, 'Business register', 'The Member States of the European Union have undertaken a programme to harmonise and develop their national business registers for statistical purposes. This programme is co-ordinated by Eurostat, with priorities decided and progress reported at annual Business Registers Working Group meetings. The main tool for assessing progress is the annual business register questionnaire, administered by Eurostat. Regular contact is also maintained between Member States and Eurostat via less formal means such as e-mail and the BR Net Internet site:', 'uploads/businessregistration/1673411676465125.pdf', '2023-02-15 07:56:25', '2023-02-20 15:09:29', 'uploads/businessregistration/2476861676909369.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `business_registration_upload`
--

CREATE TABLE `business_registration_upload` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_registration_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `document` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `career`
--

CREATE TABLE `career` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `career_date` date NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `pay_scale` decimal(9,2) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `career`
--

INSERT INTO `career` (`id`, `cat_id`, `title`, `description`, `career_date`, `company_name`, `pay_scale`, `email`, `image`, `created_at`, `updated_at`) VALUES
(5, 11, 'Event Planner', 'From conferences to high-end galas,&nbsp;event planners do it all.&nbsp;That&rsquo;s why the role is a perfect fit for strong multitaskers. Before the big day, planners choose and arrange all the logistics for food, d&Atilde;&copy;cor, personnel, presenters, and technology to pull off a flawless event.\r\n\r\nThey might even handle large-scale events like trade shows or coordinate complex conference schedules for thousands of people.\r\n\r\nLike to be the one people come to? During the event execution, planners are the go-to person for problem-solving every unforeseen change or obstacle. It&rsquo;s a fast-paced and intense job at times, but the feeling of accomplishment after a great event is priceless.', '2023-03-02', 'planitswiss', 12000.00, 'planitswiss@yopmail.com', 'uploads/career/753781676528064.png', '2023-02-16 05:14:24', '2023-02-16 05:14:24'),
(6, 6, 'EFA Events and Entertainment', 'EFA Events and Entertainment is a full-service event planner based in Surat. They pride themselves on their highly customized and unique events. Whether planning your next wedding or wedding anniversary, they are there to make sure that each and every event they are involved with is inspiring, extraordinary, and unforgettable. Whatever the circumstances, EFA Events and Entertainment is here to make your wedding extra special. Contact today to make your event wonderful, successful, and ultimately less stressful for you. They pride themselves on their exceptionally tweaked and interesting occasions. In the case of arranging your next wedding or wedding commemoration, they are there to ensure that every single occasion they associated with is moving, phenomenal, and life-changing. Whatever the conditions, EFA Events and Entertainment is here to make your wedding additional unique. Contact today to make your occasion brilliant, fruitful, and eventually less unpleasant for you.', '2023-03-10', 'EFA', 15000.00, 'efa@yopmail.com', 'uploads/career/5955881676528272.png', '2023-02-16 05:17:52', '2023-02-16 05:19:33');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(5, 'Finance', '2023-02-05 04:45:24', '2023-02-05 04:45:24'),
(6, 'Culture', '2023-02-05 04:45:37', '2023-02-05 04:45:37'),
(7, 'Sports', '2023-02-05 04:45:47', '2023-02-05 04:45:47'),
(8, 'Training', '2023-02-05 04:45:53', '2023-02-05 04:45:53'),
(9, 'Hotels', '2023-02-05 05:24:54', '2023-02-05 05:24:54'),
(10, 'Updates', '2023-02-05 05:28:10', '2023-02-05 05:28:10'),
(11, 'Event', '2023-02-16 05:12:27', '2023-02-16 05:12:27');

-- --------------------------------------------------------

--
-- Table structure for table `chambers_of_commerce`
--

CREATE TABLE `chambers_of_commerce` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chambers_of_commerce`
--

INSERT INTO `chambers_of_commerce` (`id`, `title`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Indian Chamber of Commerce', 'Founded in 1925, Indian Chamber of Commerce (ICC) is the leading and only National Chamber of Commerce having&nbsp;&nbsp;headquarter&nbsp;in Kolkata,&nbsp;and one of the most pro-active and forward-looking Chambers in the country today. Its membership spans some of the most prominent and major industrial groups in India.ICC&rsquo;s forte is its ability to anticipate the needs of the future, respond to challenges, and prepare the stakeholders in the economy to benefit from these changes and opportunities. Set up by a group of pioneering industrialists led by Mr G D Birla, the Indian Chamber of Commerce was closely associated with the Indian Freedom Movement, as the first organised voice of indigenous Indian Industry. Several of the distinguished industry leaders in India, such as Mr B M Birla, Sir Ardeshir Dalal, Sir Badridas Goenka, Mr S P Jain, Lala Karam Chand Thapar, Mr Russi Mody, Mr Ashok Jain, Mr.Sanjiv Goenka, have led the ICC as its President.', 'uploads/chambersofcommerce/2070011676465010.png', NULL, '2023-02-15 11:43:30');

-- --------------------------------------------------------

--
-- Table structure for table `contact_email`
--

CREATE TABLE `contact_email` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_email`
--

INSERT INTO `contact_email` (`id`, `email`, `created_at`, `updated_at`) VALUES
(3, 'info@camaraspainqatar.com', '2023-02-11 08:42:42', '2023-02-15 13:10:46');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `address` text NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  `start_datetime` timestamp NULL DEFAULT NULL,
  `end_datetime` timestamp NULL DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `event_share` enum('on','off') NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1' COMMENT '0-Pending,1-Active,2-Delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `cat_id`, `title`, `description`, `address`, `longitude`, `latitude`, `start_datetime`, `end_datetime`, `image`, `event_share`, `created_at`, `updated_at`, `status`) VALUES
(7, 6, 'Souq Waqif Festival', 'Souq Waqif is holding a cultural and historical event to showcase the origin and rise of the souq across the history of Qatar', 'Souq Waqif, Doha', 72.799736, 21.192572, '2023-03-01 11:00:00', '2023-03-20 10:00:00', 'uploads/event/9131111675578794.jpg', 'on', '2023-02-05 05:33:14', '2023-02-07 04:15:11', '1'),
(8, 5, 'Doha Finance Expo 2023', 'Join the Doha Finance Expo 2023 event being hosted by the Qatar authority and learn about the new development by global leaders in Qatar', 'Doha Exhibition and Convention Centre', 72.799736, 21.192572, '2023-04-12 21:30:00', '2023-05-28 23:00:00', 'uploads/event/2341601675578925.jpg', 'on', '2023-02-05 05:35:25', '2023-04-11 16:14:42', '1'),
(14, 8, 'Governing Laws', 'Get the latest information on the governing business laws.', 'Doha Exhibition Center', 72.799736, 21.192572, '2023-04-12 21:30:00', '2023-05-23 23:00:00', 'uploads/event/106621681236857.jpg', 'on', '2023-04-11 16:14:17', '2023-04-11 16:14:17', '1'),
(15, 11, 'Business Breakfast', 'The Chamber of Commerce of Spain in Qatar invites you to participate in the Business Breakfast exclusive for members that to be held at the Delta Hotel on September 21st , where we will have the opportunity to meet new members. The cost per person is 90 QAR which includes a breakfast menu', 'Delta Hotel - Ontario Ballroom', 72.799736, 21.192572, '2023-09-21 07:00:00', '2023-09-21 09:30:00', 'uploads/event/9040731695041704.png', 'on', '2023-09-18 10:55:04', '2023-09-18 10:55:04', '1'),
(16, 11, 'Get Together', 'The&nbsp;Chamber of Commerce of Spain in Qatar&nbsp;is delighted to announce that our upcoming Get Together will take place at&nbsp;LALIGA&nbsp;Twenty Nine&#39;s, located on the 61st floor of the&nbsp;Kempinski Residences &amp; Suites, Doha, from 7:00 PM to 11:00 PM. We cordially invite you to join us for this event, which is open to the entire community. It will provide an excellent opportunity to connect, network, and socialize in a relaxed atmosphere.\r\n&nbsp;', 'LALIGA Twenty Nine\'s, 61st floor\r\nKempinski Residences & Suites, Doha', 72.799736, 21.192572, '2023-10-04 17:00:00', '2023-10-04 21:00:00', 'uploads/event/3953261695814821.png', 'on', '2023-09-27 09:40:21', '2023-09-27 09:40:21', '1');

-- --------------------------------------------------------

--
-- Table structure for table `event_attend`
--

CREATE TABLE `event_attend` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1-attend,2-not_attend'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` longtext NOT NULL,
  `answer` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(2, 'How do you keep up with industry trends and news?', 'Event planning blogs (like this one) are a great resource for keeping up to date with it all. If you don&rsquo;t already have some ready to go for this question, start by bookmarking the Social Tables blog for future reference.&nbsp;', '2023-02-14 07:38:06', '2023-02-15 11:36:57'),
(3, 'What was your most successful event planning experience?', '&nbsp;When explaining the event, make sure you showcase which key&nbsp;event planning skill&nbsp;you used to pull it off.', '2023-02-15 11:37:14', '2023-02-15 11:37:14'),
(4, 'Why do you want to plan events for our company?', '&nbsp;Be thoughtful in your answer to this question. Besides a love of events, you&rsquo;ll probably want to go over the company&rsquo;s mission or value statement and find the points you resonate with the most.', '2023-02-15 11:37:35', '2023-02-15 11:37:35'),
(5, 'What’s your experience with social media?', 'Event planning is all about communication, and your potential employer wants to ensure you can communicate face-to-face as well as screen-to-screen. Show that you&rsquo;re a promoter par excellence by giving an example of how you&rsquo;ve executed a comprehensive social media strategy&mdash;and if you can point to having a measurable impact, all the better. Oh, and if you haven&rsquo;t handled social media professionally? Personal accounts count, too!', '2023-02-15 11:37:56', '2023-02-15 11:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `member_directory`
--

CREATE TABLE `member_directory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `website` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `poc_name` varchar(255) NOT NULL,
  `sector` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member_directory`
--

INSERT INTO `member_directory` (`id`, `company_name`, `website`, `image`, `email`, `contact_no`, `poc_name`, `sector`, `created_at`, `updated_at`, `description`) VALUES
(3, 'American Institute of Physics', 'https://www.aip.org/', 'uploads/memberdirectory/4256651676527885.png', 'membersocieties@aip.org', '3012093100', 'Professional Society', 'Non profit', '2023-02-16 05:11:25', '2023-02-17 07:23:32', 'The American Institute of Physics promotes science and the profession of physics, publishes physics journals, and produces publications for scientific and engineering societies. The AIP is made up of various member societies.'),
(4, 'CICESE', 'https://www.cicese.edu.mx/', 'uploads/memberdirectory/7421241676529133.png', 'jefatura_optica@cicese.edu.mx', '6461750500', 'Academic University', 'Optics & Photonics Research', '2023-02-16 05:32:13', '2023-02-17 07:23:12', 'The Center for Scientific Research and Higher Education at Ensenada is a public research center sponsored by the National Council for Science and Technology of Mexico in the city of Ensenada, Baja California, and specialized in Earth Sciences, Oceanography, Life Sciences and Applied Physics.');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2023_01_05_112107_create_reset_code_passwords_table', 2),
(5, '2023_01_09_103537_create_user_notification_setting_table', 3),
(6, '2023_01_09_112923_create_category_table', 4),
(7, '2023_01_09_134843_create_banner_table', 5),
(9, '2023_01_10_111714_create_user_address_table', 6),
(10, '2023_01_26_044205_create_event_table', 7),
(11, '2023_01_27_051203_create_event_attend_table', 8),
(12, '2023_01_27_051644_create_services_table', 8),
(13, '2023_01_27_052103_create_benefits_table', 8),
(14, '2023_01_29_110230_create_newsletter_category_table', 9),
(15, '2023_01_29_110347_create_newsletter_table', 9),
(16, '2023_01_30_100554_create_staticpage_table', 10),
(17, '2023_02_03_044004_create_app_introduction_table', 11),
(18, '2023_02_10_104048_add_membership_no_to_users_table', 12),
(19, '2023_02_11_092215_add_company_name_to_users_table', 13),
(20, '2023_02_11_093009_create_contact_email_table', 14),
(21, '2023_02_14_080636_create_faq_table', 15),
(22, '2023_02_14_084507_create_chambers_of_commerce_table', 16),
(23, '2023_02_14_100952_create_official_document_table', 17),
(24, '2023_02_14_101943_create_career_table', 18),
(25, '2023_02_14_160131_add_image_to_career_table', 19),
(26, '2023_02_15_085035_create_business_registration_table', 20),
(27, '2023_02_15_090931_create_member_directory_table', 21),
(28, '2023_02_15_114526_create_business_registration_upload_table', 22),
(29, '2023_02_15_114551_create_official_document_upload_table', 22),
(30, '2023_02_17_081221_add_description_to_member_directory_table', 23),
(31, '2023_02_17_113826_add_banner_type_to_banner_table', 24),
(32, '2023_02_20_145309_add_nfile_to_newsletter_table', 25),
(33, '2023_02_20_155638_add_image_to_official_document_table', 26),
(34, '2023_02_20_155727_add_image_to_business_registration_table', 26);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1' COMMENT '0-Pending,1-Active,2-Delete',
  `n_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`id`, `cat_id`, `title`, `description`, `image`, `created_at`, `updated_at`, `status`, `n_file`) VALUES
(5, 5, 'Launch of Camara app', 'We&#39;re excited to announce the launch of the Camara Spain for Qatar app where our members can be updated with upcoming events, find other members, and avail benefits from our partners', 'uploads/newsletter/3280991675578580.jpg', '2023-02-05 05:29:40', '2023-02-20 14:16:43', '1', 'uploads/newsletter/5385371676906203.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `official_document`
--

CREATE TABLE `official_document` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `document` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `official_document`
--

INSERT INTO `official_document` (`id`, `title`, `description`, `document`, `created_at`, `updated_at`, `image`) VALUES
(4, 'Fundraising Event Plan', 'Our 18 board members have been pushed hard to give to their maximum over the last 5 years. They have given to the annual fund drive and capital campaign. There is little room for improved giving. Each board member is required to give to the best of his/her ability. Continue to have the Chair solicit the Executive Committee members and to have the Executive Committee members solicit the other board members. All solicitations will be made in person.', 'uploads/officialdocument/8249921676464826.pdf', '2023-02-15 11:40:26', '2023-02-20 15:23:01', 'uploads/officialdocument/5814281676910181.jpg'),
(5, 'Fundraising action plan', 'Organising a CAFOD fundraising event is easy and fun, especially if there&rsquo;s a whole team of you doing it. Plus the money you raise for CAFOD helps the poorest people in the world turn their lives around.', 'uploads/officialdocument/4731811676464878.pdf', '2023-02-15 11:41:18', '2023-02-20 15:22:30', 'uploads/officialdocument/9576171676910150.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `official_document_upload`
--

CREATE TABLE `official_document_upload` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `official_document_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `document` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reset_code_passwords`
--

CREATE TABLE `reset_code_passwords` (
  `email` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reset_code_passwords`
--

INSERT INTO `reset_code_passwords` (`email`, `code`, `created_at`, `updated_at`) VALUES
('n@gmail.com', '707642', '2023-01-11 06:08:25', '2023-01-11 06:08:25'),
('brainbinaryinfotech@gmail.com', '979662', '2023-01-27 02:53:47', '2023-01-27 02:53:47'),
('bindia@gmail.com', '680331', '2023-02-03 09:40:00', '2023-02-03 09:40:00'),
('bindiya@gmail.com', '542636', '2023-02-11 07:36:56', '2023-02-11 07:36:56'),
('jiya@gmail.com', '338034', '2023-02-14 04:04:00', '2023-02-14 04:04:00'),
('bindiya.brainbinary@gmail.com', '378636', '2023-02-15 04:26:01', '2023-02-15 04:26:01'),
('bindiya@yopmail.com', '200152', '2023-02-15 05:05:02', '2023-02-15 05:05:02'),
('diya@yopmail.com', '2119', '2023-02-28 03:04:06', '2023-02-28 03:04:06'),
('ronik.brainbinary@gmail.com', '7383', '2023-02-28 03:11:19', '2023-02-28 03:11:19'),
('hiral@yopmail.com', '4893', '2023-08-17 09:44:21', '2023-08-17 09:44:21'),
('hiral.stackapp@gmail.com', '1494', '2023-08-17 09:50:38', '2023-08-17 09:50:38'),
('dodiyanihar8460@gmail.com', '3446', '2023-08-17 09:52:18', '2023-08-17 09:52:18'),
('comunicacion@camaraspainqatar.com', '6291', '2023-09-18 10:40:16', '2023-09-18 10:40:16'),
('it+testing@tfsbs.com', '1289', '2023-11-25 12:36:18', '2023-11-25 12:36:18'),
('it@tfsbs.com', '5593', '2024-01-08 12:32:03', '2024-01-08 12:32:03');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1' COMMENT '0-Pending,1-Active,2-Delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `image`, `created_at`, `updated_at`, `status`) VALUES
(41, 'Market reports', 'The market reports are an analysis tool that is only available to Spanish companies interested in Qatar and that allows our clients to know the details of the specific sector. These reports are aimed both at companies interested in the Qatari market, as well as those that are already established and are interested in obtaining additional information that will help them in decision-making.', 'uploads/services/1254351695817083.jpg', '2023-02-05 05:20:36', '2023-09-27 10:18:03', '1'),
(42, 'Commercial Agendas', 'Trade agendas are a key instrument for those companies that want to internationalize. The Spanish Chamber of Commerce in Qatar organizes direct or inverse commercial agendas, that is, both for Spanish companies that want to market their product or service in Qatar, and for Qatari companies that want to do the same in Spain. This service can be carried out during fairs or events in a specific sector, where there is a large concentration of companies of interest to the client company, or it can be carried out during a company visit to the destination market.', 'uploads/services/3587061695816065.jpg', '2023-02-05 05:21:44', '2023-09-27 10:01:05', '1'),
(44, 'Trade missions and identification of partners', 'Trade Missions serve as a market prospecting tool for those companies with a low level of knowledge about it and who wish to present their products and/or services to other companies potentially interested in them. This can be done virtually or in person. The Chamber has a large and up-to-date database that will allow the company and the Chamber to choose the most suitable contacts for their clients together.', 'uploads/services/5762801695817115.jpg', '2023-09-27 10:18:35', '2023-09-27 10:18:35', '1'),
(45, 'Company listings', 'The Chamber prepares personalized company lists from our database, filtering the information based on the sector of interest. Our extensive knowledge of the market allows us to differentiate the most suitable profiles for your company. The objective is to identify companies that can help the contracting client to market, import, distribute and/or promote their product or service.', 'uploads/services/7679181695817140.jpg', '2023-09-27 10:19:00', '2023-09-27 10:19:00', '1'),
(46, 'Advice on electronic commerce (e-Commerce)', 'The offer of personalized services of the Chamber of Commerce regarding e-Commerce Advice is designed to support SMEs in their internationalization strategy in online channels.', 'uploads/services/3024551695817179.jpg', '2023-09-27 10:19:39', '2023-09-27 10:19:39', '1'),
(47, 'Purchase of specifications for tenders', 'The Bidding Specifications Purchase service provides Spanish companies with access to the Bidding Specifications for International Tenders or prequalification documents.', 'uploads/services/887311695817230.jpg', '2023-09-27 10:20:30', '2023-09-27 10:20:30', '1'),
(48, 'Advertising', 'Banner and advertisements within our website. (https://camaraspainqatar.com/en/)', 'uploads/services/5898121695817366.jpg', '2023-09-27 10:22:46', '2023-09-27 10:22:46', '1'),
(49, 'Participation in fairs', 'Objective: to promote the presence of Spanish companies in international fairs at the Doha Exhibition and Convention Center (DECC) and the Qatar National Convention Center (QNCC).\r\n\r\nManaging the following aspects:\r\n\r\n\r\n	Recruitment of space at the fair\r\n	Hiring and assembly of stand architecture\r\n	Reception of samples for use at the fair\r\n	Recruitment of the hostess service\r\n', 'uploads/services/403411695817504.jpg', '2023-09-27 10:25:04', '2023-09-27 10:25:04', '1');

-- --------------------------------------------------------

--
-- Table structure for table `staticpage`
--

CREATE TABLE `staticpage` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staticpage`
--

INSERT INTO `staticpage` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'about us', 'The Official Chamber of Commerce of Spain in Qatar, a non-profit association, was founded in Doha in 2009 as the Spanish Business Council and was officially recognized as a Chamber of Commerce in 2019 by the Ministry of Industry, Trade and Tourism of Spain. The Chamber is registered under the Qatar Financial Center with address in the Burj Doha Tower. The Chamber is part of the Federation of Spanish Chambers of Commerce in Europe-Africa-Asia-Oceania (FEDECOM) and maintains a permanent link with the Spanish Chamber of Commerce, Industry, Services and Navigation, which provides members the ability to benefit from the Official Chambers network around the world made of 42 Chambers abroad. Chambers abroad are also paramount for one of the main objectives of the Spanish Chamber of Commerce which is the internationalization of Spanish companies. In this sense, with the aim of supporting the initiation and diversification of Spanish businesses in their internationalization processes, the Spanish Chamber of Commerce provides aid to companies through its company members.', NULL, '2023-02-07 04:14:32'),
(2, 'Privacy Policy', '1.- Terms and conditions of access and use of this website 1.1. Access to the website, content and information. Access to this website is the sole responsibility of users, and implies understanding and acceptance of the legal warnings and terms and conditions of use contained herein. C&Aacute;MARA DE COMERCIO DE ESPA&Ntilde;A EN CATAR reserves the right, at any moment, to make any changes or amendments it deems appropriate and necessary to the website, without the need for prior notice. The user guarantees the accuracy and authenticity of all the data they provide both when completing registration forms at any future point. It is their sole responsibility to update the information provided, to accurately reflect their current situation. The user will be responsible for any inaccuracies or lack of authenticity in the information provided. 1.2 Obligation to use the website and its contents appropriately. The user agrees to the proper use of the website and its utilities, in accordance with the law, this present legal notice, and the instructions and advice contained therein. The user is obliged to use the website and all its content solely for lawful, non-prohibited purposes, that do not infringe current laws and/or that could be detrimental to the legitimate rights of C&Aacute;MARA DE COMERCIO DE ESPA&Ntilde;A EN CATAR or any third party, and/or that could cause any harm either directly or indirectly. To that effect, the user shall refrain from using any of the website&rsquo;s content for unlawful purposes or effects that are prohibited in this Legal Notice herein, that are detrimental to the rights and interests of third parties, or that could in any way harm, disable, overload, deteriorate, or interrupt normal use of the website, IT equipment, or documents, files, or any type of content stored in any IT equipment (hacking) belonging to C&Aacute;MARA DE COMERCIO DE ESPA&Ntilde;A EN CATAR, other users or any internet user (hardware or software). In particular, listed for guidance purposes and by no means exhaustively, the user agrees to not transmit, disseminate, or make available to third parties information, data, content, messages, graphics, drawings, sound and/or image files, photographs, recordings, software, or in general, any type of material that: (a) is in any way contrary to, or disparages or undermines constitutionally recognised fundamental rights and liberties, international treaties or the rest of the legislation; (b) induces, incites, or promotes criminal, degrading, defamatory, libellous, violent, or generally unlawful acts, or acts contrary to morality and generally accepted behaviours, or to public order; (c) induces, incites, or promotes discriminatory acts, attitudes, or opinions due to sex, race, religion, beliefs, age, or condition; (d) incorporates, makes available, or allows access to criminal, violent, offensive, harmful, degrading products, elements, messages, and/or services, or generally unlawful acts or that are contrary to morality and generally accepted behaviours, or to public order;', NULL, '2023-02-07 04:14:30'),
(3, 'Terms and Condition', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pellentesque aliquam velit in rhoncus. Integer placerat urna ligula, vel dapibus enim congue et. In auctor augue sit amet sem mollis, nec malesuada mi dictum. Mauris metus diam, vulputate et pretium nec, vulputate id nunc. Nullam bibendum, nibh in rutrum condimentum, arcu mauris imperdiet ligula, sed pharetra ante massa sit amet mi. Ut feugiat quis libero at malesuada. In facilisis porta aliquam. Curabitur purus odio, iaculis eget diam eu, pharetra suscipit ipsum Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pellentesque aliquam velit in rhoncus. Integer placerat urna ligula, vel dapibus enim congue et. In auctor augue sit amet sem mollis, nec malesuada mi dictum. Mauris metus diam, vulputate et pretium nec, vulputate id nunc. Nullam bibendum, nibh in rutrum condimentum, arcu mauris imperdiet ligula, sed pharetra ante massa sit amet mi. Ut feugiat quis libero at malesuada. In facilisis porta aliquam. Curabitur purus odio, iaculis eget diam eu, pharetra suscipit ipsum', NULL, '2023-02-07 04:14:28'),
(9, 'contact us', 'contact us abd', '2023-02-22 03:22:46', '2023-02-22 09:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phoneno` varchar(255) NOT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 0,
  `device_token` text NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `membership` text DEFAULT NULL,
  `membership_no` text DEFAULT NULL,
  `validity` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0-Block,1-Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phoneno`, `occupation`, `age`, `password`, `user_image`, `type`, `device_token`, `company_name`, `membership`, `membership_no`, `validity`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Admin', 'admin@yopmail.com', '9876542345', '', '', '$2y$10$3eSb3PwlDFrP3eUw7thyzeNwGWulFzgvVyg/fGsISNxDQlGoPsIQW', 'uploads/admin/8302201672895156.png', 1, '', NULL, '', NULL, NULL, '2023-01-05 04:04:50', '2023-11-25 11:27:08', '1'),
(118, NULL, 'comunicacion@camaraspainqatar.com', '559089001', NULL, NULL, '$2y$10$SetlebJKGPZFHCnvONdSK.jOtY6ktKoK0p2iADlL/LgKBB5yZuio.', NULL, 0, 'dymQ_F9O7ETlpQkSqYnQWL:APA91bFoRJRAG7f3vfF3JmsVEP7jLbCGga3wHBJ5h4iZrnNaY6aVFlCvRrAhwTdYcT4qBz5DiqrciTjM1eieqoWeHovLFHmoqZ1vQdlpvayqzovavffM5ClhFWX1uWHmQKOYuR7L-kPM', NULL, NULL, '000', NULL, '2023-09-18 10:38:29', '2023-09-18 10:38:29', '0'),
(120, NULL, 'f@gmail.com', '6398524785', NULL, NULL, '$2y$10$pZUvdi81QOgZ.A/WKgi3PurjMnMu/fMoLAngxmJ5luIQprthTTtAm', NULL, 0, 'dbnQ4uSKTKG7KrQfLJlScK:APA91bGEKZ2xsqo5ix1pmzOSYtyP9_mXIkR03fzUEMdjxYI2Mg8Gzw9ga-PUSM1LcCbW0YB2Whel93_QbLtN_hwVX-3UZAWx2JwgCOY6237HP8f3gohenMUv4NBE0e-w3QRJy82pL1ch', NULL, NULL, '2', NULL, '2023-09-29 02:25:59', '2023-09-29 02:25:59', '0'),
(121, NULL, 'e@gmail.com', '4562398752', NULL, NULL, '$2y$10$F7TPBJGOmTaeuyFnLucvO.914p.zvfSqdQeFF.MWxO8ewnpZQ8gva', NULL, 0, 'cGPAnl19oEfxirLSS1R9KX:APA91bEFNRJQJAYjI6tl2umoQUQ98sDek04b1K8qPyxFCrW5ymodAfzrecps0xJIX0AptkUCBvarQipu8Aac2XcS8xm6bkUJaEXCR06u7w8T1aLsfylM_1rOX7cfTFM7fVAwgK4NXRAj', NULL, NULL, '9', NULL, '2023-09-29 02:28:46', '2023-09-29 02:28:46', '0'),
(123, NULL, 'it@tfsbs.com', '70111284', NULL, NULL, '$2y$10$oWmHIWbLMeQfK1vF7Jl4k.WWROD8a8cbccXAtmO/lFUHix3P5dy0K', NULL, 0, 'fIgqKG1oRkSJQQ5wzMiu1l:APA91bFbRb2llJmaqJ7QAVX3G9TpgkP1_rZ8NMegZnKqegAlgJxFApCVGoTUEPoMfb8GgvA26W5kjnCBO5BVqsgQX29_zZA6aAnnT0aP9-WDSCe_rtzl8_EB42CI4VBYcEw0uu8ItkPI', NULL, NULL, '83727', NULL, '2024-01-09 07:04:39', '2024-01-09 07:05:15', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `address_type` enum('home','office') NOT NULL DEFAULT 'home',
  `address` text NOT NULL,
  `additional_details` text DEFAULT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_notification_setting`
--

CREATE TABLE `user_notification_setting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` enum('on','off') NOT NULL DEFAULT 'on',
  `calendar_event` enum('on','off') NOT NULL DEFAULT 'on',
  `news_letter` enum('on','off') NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_notification_setting`
--

INSERT INTO `user_notification_setting` (`id`, `user_id`, `event`, `calendar_event`, `news_letter`, `created_at`, `updated_at`) VALUES
(70, 118, 'off', 'off', 'off', '2023-09-18 10:38:29', '2023-09-18 10:38:29'),
(72, 120, 'off', 'off', 'off', '2023-09-29 02:25:59', '2023-09-29 02:25:59'),
(73, 121, 'off', 'off', 'off', '2023-09-29 02:28:46', '2023-09-29 02:28:46'),
(75, 123, 'off', 'off', 'off', '2024-01-09 07:04:39', '2024-01-09 07:04:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_introduction`
--
ALTER TABLE `app_introduction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `benefits`
--
ALTER TABLE `benefits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `benefits_cat_id_foreign` (`cat_id`);

--
-- Indexes for table `business_registration`
--
ALTER TABLE `business_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_registration_upload`
--
ALTER TABLE `business_registration_upload`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_registration_upload_business_registration_id_foreign` (`business_registration_id`),
  ADD KEY `business_registration_upload_user_id_foreign` (`user_id`);

--
-- Indexes for table `career`
--
ALTER TABLE `career`
  ADD PRIMARY KEY (`id`),
  ADD KEY `career_cat_id_foreign` (`cat_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chambers_of_commerce`
--
ALTER TABLE `chambers_of_commerce`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_email`
--
ALTER TABLE `contact_email`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contact_email_email_unique` (`email`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_cat_id_foreign` (`cat_id`);

--
-- Indexes for table `event_attend`
--
ALTER TABLE `event_attend`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_attend_event_id_foreign` (`event_id`),
  ADD KEY `event_attend_user_id_foreign` (`user_id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_directory`
--
ALTER TABLE `member_directory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `official_document`
--
ALTER TABLE `official_document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `official_document_upload`
--
ALTER TABLE `official_document_upload`
  ADD PRIMARY KEY (`id`),
  ADD KEY `official_document_upload_official_document_id_foreign` (`official_document_id`),
  ADD KEY `official_document_upload_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reset_code_passwords`
--
ALTER TABLE `reset_code_passwords`
  ADD KEY `reset_code_passwords_email_index` (`email`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staticpage`
--
ALTER TABLE `staticpage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phoneno_unique` (`phoneno`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_address_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_notification_setting`
--
ALTER TABLE `user_notification_setting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_notification_setting_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_introduction`
--
ALTER TABLE `app_introduction`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `benefits`
--
ALTER TABLE `benefits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `business_registration`
--
ALTER TABLE `business_registration`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `business_registration_upload`
--
ALTER TABLE `business_registration_upload`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `career`
--
ALTER TABLE `career`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `chambers_of_commerce`
--
ALTER TABLE `chambers_of_commerce`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_email`
--
ALTER TABLE `contact_email`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `event_attend`
--
ALTER TABLE `event_attend`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `member_directory`
--
ALTER TABLE `member_directory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `official_document`
--
ALTER TABLE `official_document`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `official_document_upload`
--
ALTER TABLE `official_document_upload`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `staticpage`
--
ALTER TABLE `staticpage`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user_notification_setting`
--
ALTER TABLE `user_notification_setting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `benefits`
--
ALTER TABLE `benefits`
  ADD CONSTRAINT `benefits_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `business_registration_upload`
--
ALTER TABLE `business_registration_upload`
  ADD CONSTRAINT `business_registration_upload_business_registration_id_foreign` FOREIGN KEY (`business_registration_id`) REFERENCES `business_registration` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `business_registration_upload_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `career`
--
ALTER TABLE `career`
  ADD CONSTRAINT `career_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_attend`
--
ALTER TABLE `event_attend`
  ADD CONSTRAINT `event_attend_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_attend_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD CONSTRAINT `newsletter_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `official_document_upload`
--
ALTER TABLE `official_document_upload`
  ADD CONSTRAINT `official_document_upload_official_document_id_foreign` FOREIGN KEY (`official_document_id`) REFERENCES `official_document` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `official_document_upload_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_notification_setting`
--
ALTER TABLE `user_notification_setting`
  ADD CONSTRAINT `user_notification_setting_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
