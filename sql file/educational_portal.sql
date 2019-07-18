-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2019 at 08:30 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `educational_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE `college` (
  `ID` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `course` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contactNumber` varchar(255) NOT NULL,
  `officeHours` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`ID`, `name`, `picture`, `description`, `course`, `state`, `address`, `contactNumber`, `officeHours`) VALUES
(1, 'KDU College Penang', 'KDU PENANG.jpg', 'Since 1983, KDU has been leading the way for private higher education in Malaysia. As a real world university meeting real world needs, students at KDU are nurtured to be competent graduates who hit the ground running and are able to adapt seamlessly into the real world, no matter what programme they choose to delve into.', 'Foundation Studies (Art & Technology)', 'Penang', '32, Jalan Anson\r\n10400, George Town', '04-2386368', '9AM - 5.30PM'),
(2, 'TARC College Penang', 'tarcCollege.jpg', 'Occupying 23 acres of land located at the prime tourist belt of Tanjong Bungah, TAR UC Penang Branch Campus has proven itself to be an institution of academic excellence, attracting thousands of students from all over the different states in the Northern Region of Peninsular Malaysia. The campus comprises of a team of professionally qualified academics who inspire and lead students towards achieving academic excellence. The campus is also strategically located – nestled between the lush greenery and scenic beach – and it is only a 15-minute drive from Georgetown.', 'Accounting', 'Penang', '77, Lorong Lembah Permai 3\r\n11200, Tanjung Bungah', '04-8995230', '9AM - 6PM'),
(3, 'INTI Interntional College Penang', '5d28472ca7c720.09437704.jpg', 'With over 30 years of empowering young minds and more than 65,000 graduates to testify to the quality education delivered, INTI is one of the most respected and trusted names in the Malaysian private higher education sector.', 'Diploma in Information & Communication Technology ', 'Penang', '1-Z, Lebuh Bukit Jambul, Bukit Jambul\r\n11900, Georgetown', '04-6310138', '8AM - 6PM'),
(4, 'The One Academy College', 'oneAcademy.jpg', 'The One Academy is a MQA-accredited college with MSC-status, carrying formal affiliations with reputable design universities and colleges worldwide. The One Academy\'s \'Masters Train Masters\' teaching philosophy that provides \'Just World Class Results\' has enabled students to experience heightened evolution in concept development and creativity.', 'Digital Media Design', 'Penang', '33 Jalan Anson\r\n10400, Georgetown', '04-2103000', '9AM - 5PM'),
(5, 'RCSI & UCD Malaysia', 'medicalCollege.jpg', 'RCSI & UCD Malaysia Campus is Malaysia’s first accredited private medical school*, owned and established by the Royal College of Surgeons in Ireland (RCSI) and University College Dublin (UCD), two world-renowned medical universities in Ireland.\r\n\r\nRecently, the College was awarded University status by the Malaysian Ministry of Education (MOE) as a Foreign University Branch Campus, one of the highest levels for a foreign-owned institution in Malaysia. RUMC remains as the only Irish University in the region.\r\n\r\nThe University is recognised by the Malaysian Medical Council (MMC) and Irish Medical Council (IMC) as graduating high performing doctors. Students are recognised for practice in the USA, Canada and others by the ECFMG and FAIMER with the institution listed as an Irish medical school in the World Directory of Medical Schools (WDOMS).', 'BACHELOR OF MEDICINE', 'Penang', '4, Jalan Sepoy Lines\r\n10450, George Town', '04-2171999', '9AM - 5PM'),
(6, 'Wawasan Open University ', '5d2fe13a18d473.72250756.jpg', 'Wawasan Open University is a private university in Malaysia that provides working adults with access to higher education via open distance learning. It was established in 2006 and enrolled its first batch of students in 2007', 'Diploma in IT ', 'Penang', '54, Jalan Sultan Ahmad Shah\n10050, Georgetown', '04-2180333', '8.30AM - 7PM');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `collegeID` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date1` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `collegeID`, `username`, `rating`, `comment`, `date1`) VALUES
(1, 2, 'Chiah Kah Hin', 3, 'Hello', '2019-07-18'),
(2, 3, 'Chiah Kah Hin', 4, 'Hello', '2019-07-18'),
(3, 1, 'Chiah Kah Hin', 5, 'Not bad', '2019-07-18'),
(4, 5, 'Chiah Kah Hin', 5, 'Not bad', '2019-07-18'),
(5, 3, 'Teng Wei Kang', 5, 'Not bad ', '2019-07-18'),
(6, 4, 'Teng Wei Kang', 2, 'Not bad', '2019-07-18'),
(7, 6, 'admin', 5, 'Not bad', '2019-07-18');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `state` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `date` date NOT NULL,
  `phoneNo` varchar(255) NOT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `username`, `password`, `email`, `gender`, `state`, `status`, `date`, `phoneNo`, `admin`) VALUES
(1, 'admin', '25d55ad283aa400af464c76d713c07ad', 'admin@hotmail.com', 'M', 'Kedah', 1, '2019-06-11', '012-3456789', 1),
(2, 'Chiah Kah Hin', '25d55ad283aa400af464c76d713c07ad', 'kahhinchiah1@gmail.com', 'M', 'Kedah', 1, '2019-06-20', '012-3456789', 0),
(5, 'Teng Wei Kang', '25d55ad283aa400af464c76d713c07ad', 'kahhinchiah2@gmail.com', 'M', 'Kedah', 1, '2019-07-18', '012-3456789', 0),
(6, 'Ho Haw Liang', '25d55ad283aa400af464c76d713c07ad', 'chiahkahhin1@hotmail.com', 'M', 'Kedah', 1, '2019-07-18', '012-3456789', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `college`
--
ALTER TABLE `college`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
