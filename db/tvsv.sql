-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 07, 2015 at 07:25 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tvsv`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
`id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `content` text,
  `date` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `author_id`, `content`, `date`) VALUES
(45, 0, 'tôi trả lời', '2014-11-26 23:11:03'),
(47, 0, 'fhhfhfghfgfhgfhgfh\nsdfdsfds\nfds\nfsd\nfdsfs', '2014-11-26 23:21:22'),
(49, 0, 'ghfghfgfgfg\nfdsfdsf\ndsfds\nfds\nfds\nfds', '2014-11-26 23:33:51'),
(50, 0, 'fdvffdgfd&lt;br&gt;gfd&lt;br&gt;g&lt;br&gt;dfg&lt;br&gt;fd&lt;br&gt;gdf&lt;br&gt;gfd&lt;br&gt;g&lt;br&gt;fdgfd&lt;br&gt;', '2014-11-26 23:38:09'),
(51, 0, 'fdfdg&lt;br&gt;fdg&lt;br&gt;fdg&lt;br&gt;fdg&lt;br&gt;fd&lt;br&gt;gfd&lt;br&gt;', '2014-11-26 23:42:47'),
(52, 0, 'fbfhfghfghfgh&lt;br&gt;fg&lt;br&gt;h&lt;br&gt;fghfg&lt;br&gt;', '2014-11-26 23:46:07'),
(53, 0, 'dgfdgdf&lt;br&gt;g&lt;br&gt;fdg&lt;br&gt;fdg&lt;br&gt;fd&lt;br&gt;gdf&lt;br&gt;gfd&lt;br&gt;', '2014-11-26 23:50:11'),
(54, 0, 'fdsfdsfdsf&lt;br&gt;dsf&lt;br&gt;ds&lt;br&gt;fds&lt;br&gt;fds&lt;br&gt;f&lt;br&gt;dsf&lt;br&gt;ds&lt;br&gt;fsd&lt;br&gt;fds&lt;br&gt;', '2014-11-26 23:51:58'),
(55, 0, 'rttyt&lt;br&gt;y&lt;br&gt;try&lt;br&gt;ty&lt;br&gt;ty&lt;br&gt;t&lt;br&gt;yt&lt;br&gt;', '2014-11-26 23:55:27'),
(56, 0, 'dgdfgfdg&lt;br&gt;fdg&lt;br&gt;fdg&lt;br&gt;df&lt;br&gt;gfd&lt;br&gt;gfd&lt;br&gt;g&lt;br&gt;fdgfd&lt;br&gt;', '2014-11-26 23:55:45'),
(57, 0, 'jkjghjg&lt;br&gt;hjk&lt;br&gt;', '2014-11-26 23:56:42'),
(58, 0, 'dgfdg&lt;br&gt;fdg&lt;br&gt;fdg&lt;br&gt;dfg&lt;br&gt;df&lt;br&gt;gfd&lt;br&gt;gf&lt;br&gt;d&lt;br&gt;', '2014-11-26 23:57:03'),
(59, 0, 'tra loi&lt;br&gt;', '2014-11-27 11:56:28'),
(60, 0, 'asldkfjaslfaslfkaslkf', '2014-11-27 11:58:12'),
(61, 0, 'asdflsjflaksjflskj', '2014-11-27 12:12:06'),
(62, 0, '', '2014-11-27 13:54:30'),
(63, 0, 'test', '2014-11-27 13:58:47'),
(64, 0, 'test email&lt;br&gt;', '2014-11-27 14:03:36'),
(65, 0, 'test tra loi&lt;br&gt;&lt;br&gt;', '2014-11-27 14:12:50'),
(66, 0, 'testsdfsdfsd', '2014-11-27 14:14:01'),
(67, 0, 'ewewdsfdsfas', '2014-11-27 16:04:52'),
(68, 0, 'ádasdasdasd', '2014-11-27 16:05:12'),
(69, 0, 'dfsgvdfsgdfsgfds&lt;br&gt;gdf&lt;br&gt;gfd&lt;br&gt;gd&lt;br&gt;fs&lt;br&gt;gs<br><br>', '2014-11-27 16:07:41'),
(70, 0, 'sdjfdsjf&lt;br&gt;sdfjdshfsd&lt;br&gt;fsdlfhdsf&lt;br&gt;dsfdshf<br>aasdsad<br>d<br>sad<br>sad<br>sad<br>sad<br>', '2014-11-27 18:17:43'),
(71, 0, 'tra loi&lt;br&gt;', '2014-11-27 21:00:25'),
(72, 0, 'vbcvbvcbvcb&lt;br&gt;vb&lt;br&gt;vc&lt;br&gt;bvc&lt;br&gt;bvc&lt;br&gt;bvcb&lt;br&gt;', '2014-11-27 23:07:18'),
(73, 0, 'xcvcxvcvcxvxcv', '2014-11-27 23:17:14'),
(74, 0, 'cxvcxvcx&lt;br&gt;vcx&lt;br&gt;vcx&lt;br&gt;vcx&lt;br&gt;v&lt;br&gt;cxvcxv&lt;br&gt;', '2014-11-27 23:17:29'),
(77, 0, 'sdfdsfdsfdsf&lt;br&gt;ds&lt;br&gt;fds&lt;br&gt;f&lt;br&gt;sdfds&lt;br&gt;', '2014-11-28 11:19:13'),
(78, 0, 'Thời gian: khoảng đầu tháng 01/2015 tuỳ bộ môn, các em sẽ được thông báo trước 01 tuần&lt;br&gt;', '2014-11-28 11:39:21'),
(79, 0, 'fgfgfgfgfgfg&lt;br&gt;f&lt;br&gt;gf&lt;br&gt;g&lt;br&gt;fg&lt;br&gt;f&lt;br&gt;g&lt;br&gt;', '2014-11-28 11:39:47'),
(80, 0, 'Tự nghiên cứu nhé, hihi&lt;br&gt;', '2014-11-28 11:40:24'),
(81, 0, 'chfhfgh&lt;br&gt;fgh&lt;br&gt;gf&lt;br&gt;hgf&lt;br&gt;h&lt;br&gt;fgh&lt;br&gt;', '2014-11-28 11:40:37'),
(82, 0, 'thực tập tại phòng lap', '2014-11-28 11:41:25'),
(83, 0, 'Hai chương trình đào tạo hệ sư phạm và hệ kỹ sư khác nhau. Hệ sư phạm không phân chuyên ngành, hệ kỹ sư mới được phân chuyên ngành vào đầu học kỳ 6. Chính vì vậy sinh viên hệ sư phạm học theo chương trình của mình, các em có thể đăng ký học các môn của 1 chuyên ngành hoặc cả ba chuyên ngành của hệ kỹ sư. Các em hãy bám sát chương trình đào tạo hệ sư phạm được đăng trên web trường cũng như web khoa.', '2014-11-30 16:44:45'),
(84, 0, 'Chào em!&lt;br&gt;Thay mặt ban tư vấn sinh viên khoa CNTT cảm ơn em đã gửi câu hỏi. Theo câu hỏi của em thì thầy có thể trao đổi với em như sau: Khi Em xin qua lớp 1, em có làm đơn và được phòng đào tạo duyệt chưa? Nếu chưa có điều này thì em vẫn còn ở lớp 3 vì phòng đào tạo căn cứ vào chứng từ là đơn xin của em. Còn nếu đã có thì em cầm đơn lên phòng đào tạo để khiếu nại nhé.&lt;br&gt;&lt;br&gt;', '2014-12-01 09:01:34'),
(85, 11, 'Vấn đề này em liên hệ Trung tâm thông tin (Phòng A5-101) gặp thầy Hà để được cấp lại mật khẩu mới cho mail của em.&lt;br&gt;', '2014-12-02 11:05:37'),
(86, 8, 'Chào Kiệt,&lt;br&gt;Trên website Khoa đã có mục Đề Thi-Đáp áp (Menu Đào tạo). Bắt đầu từ HK này, các đáp án thi sẽ được post lên website khoa ngay sau khi môn thi xong.&lt;br&gt;Thầy Vinh.', '2014-12-13 09:17:55'),
(87, 11, 'Chào bạn!&lt;br&gt;Hiện tại danh sách cộng điểm CTXH Khoa đã chuyển về phòng CTHSSV và phòng CTHSSV chịu trách nhiệm về phần cập nhật điểm CTXH này. Bạn vui lòng liên hệ anh Bình phòng CTHSSV để được giải đáp cụ thể hơn nha.&lt;br&gt;Thân ái!&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;', '2014-12-17 01:23:17'),
(88, 8, 'Chào Kiệt,&lt;br&gt;Các hoạt động tính điểm CTXH đã được Khoa gửi lên phòng CT HSSV như bạn Bảo đã trả lời. Tuy nhiên hệ thống cập nhật điểm vẫn chưa hoạt động tốt, nên điểm vẫn chưa được cập nhật đầy đủ. Các em chờ thêm vài tuần nữa để phòng CTHSSV khắc phục nhé.&lt;br&gt;Thầy Vinh.', '2014-12-17 06:08:07'),
(89, 0, 'Chào em!&lt;br&gt;Việc em học chương trình đào tạo nào không phải vào năm thứ 2 mà là học kỳ 1 năm nhất em đã chọn chương trình học rồi nên khi đến năm 2 em không thể chuyển qua chương trình khác được chính vì vậy mà mặc dù năm 2 em chưa học sư phạm nhưng cũng không được đăng ký chuyên ngành như các bạn học chương trình công nghệ.&lt;br&gt;', '2014-12-17 11:05:11'),
(90, 8, 'Chào em,&lt;br&gt;Em đã chọn ngành SPKT CNTT, vì vậy em không được chọn chuyên ngành. Việc chọn chuyên ngành chỉ dành cho ngành CNTT mà thôi.&lt;br&gt;Thầy Vinh.', '2014-12-17 11:07:23'),
(91, 0, 'Chào em!&lt;br&gt;Về câu hỏi của em liên quan đến môn Nhập môn Lập trình, thì theo thầy biết thì môn này giáo viên có 01 trang thi thử online do giáo viên đó phát triển và triển khai nên ban tư vấn không rõ lắm về chương trình này. Ban tư vấn sẽ trao đổi với giáo viên về những vấn đề của em rồi sẽ trả lời cho em trong thời gian sớm nhất.&lt;br&gt;&lt;br&gt;<br><br><br>Thầy Trần Công Tú trả lời:<br><br>Ý kiến: <br><span>Em có đọc được câu hỏi: &lt;<i>&gt;\r\n Nay em gửi mail này mong khoa có thể thảo luận với các thầy cô dạy Nhập\r\n môn lập trình khóa mới, gửi lên trang web các bộ test chấm kết hợp với \r\nbài làm của tụi em để dễ dàng sửa lỗi hoàn thiện bài làm hơn. Với lại \r\nmột điều nữa trang web thi thử dành cho mấy môn căn bản của khoa mình <a rel="" target="_blank" href="http://it.hcmute.edu.vn/onlinejudge/">http://it.hcmute.edu.vn/onlinejudge/</a>\r\n nó cũng không có thông báo nào để biết mà sửa cả, chỉ chấm điểm thôi \r\nthì có chấm cũng như thực hiện được bộ test mẫu thôi có khác gì đâu. Nếu\r\n nó báo cho tụi em biết sai gì hay đưa ra bộ test sai sau 2-3 lần gửi \r\nbài thì mới có thể phát triển khả năng.<br></i><br></span>Trả lời:<br>Trang làm bài tập <i><a rel="" target="_blank" href="http://it.hcmute.edu.vn/onlinejudge/">http://it.hcmute.edu.vn/onlinejudge/</a></i>\r\n nhằm mục đích giúp SV biết ngay kết quả của bài tập mình làm, từ đó \r\nbiết được bài của mình đã hoàn thiện chưa, nếu chưa hoàn thiện, SV phải \r\ntập tự tư duy, dò lỗi trên code của mình và nếu phát hiện ra thì sửa và \r\nnộp lại xem đúng chưa.<br>Việc chương trình cho kết quả tức thời giúp SV\r\n yên tâm về bài của khi làm đúng cũng như kịp thời cho SV biết bài làm \r\ncòn thiếu sót để hoàn thiện, thay vì phải chờ gặp GV (làm bài lúc 23h \r\nthì sao gặp GV được) để GV xem và trả lời.<br>Để phát triển khả năng thì\r\n SV phải tự tư duy chứ nếu có testcase, SV khi lập trình sẽ có thói quen\r\n ỷ lại (có thể sẽ code đối phó với testcase) và không thể tự nghĩ ra \r\ntestcase cho mình hay tự phát hiện sai sót trên bài làm. Việc bài có lỗi\r\n mà tự mình tìm ra lúc nào cũng "sướng" hơn là do người khác chỉ và mình\r\n cũng sẽ gần như không bao giờ bị lại lỗi đó.<br><br>Ý kiến:<span><br><i>Chứ\r\n mấy hôm trước em lên thi thử mà cứ làm hoài một bài, sửa mãi mà cũng \r\nchỉ hai bộ test mà không thể nghĩ ra lỗi gì, thiếu điều kiện gì... rồi \r\nlại bài khác cũng thế tốn hơn 5 tiếng mà chỉ làm được 3 bài mà chỉ một \r\nbài chọn vẹn. Chán quá đến bây giờ em chỉ lấy đề đó để tham khảo chứ \r\ntrình chấm ấy chẳng có lợi gì cả. Em mong quý thầy cô xem xét cải thiện \r\ntrình chấm ấy để có thể học hiệu quả hơn về thời gian và kết quả. Chứ \r\nthế thì không thể đủ thời gian để em học tất cả các môn. </i><br><br></span>Trả lời:<br>Trong\r\n trường hợp đã rất cố gắng tư duy và tìm lỗi nhưng vẫn không tìm được \r\nlỗi sai thì SV đã được hướng dẫn rất rõ và nhiều lần trên lớp rằng vào <a rel="" target="_blank" href="http://www.facebook.com/NhapMonLapTrinh">http://www.facebook.com/NhapMonLapTrinh</a>,\r\n post bài mà mình không biết sửa lỗi lên, sẽ có người trả lời (GẦN NHƯ \r\nlập tức), việc post lên facebook như vậy không chỉ giúp cho mình mà còn \r\ngiúp các bạn khác thấy được lỗi này và rút kinh nghiệm thêm. <br>Trang \r\nfacebook/NhapMonLapTrinh còn là nơi để các SV trao đổi, học hỏi lẫn nhau\r\n về nội dung môn học và hiện đang được các bạn sử dụng khá hiệu quả!<br><br>Như vậy công cụ để giúp các bạn học tốt hơn là rất đầy đủ, vấn đề chỉ là SV đã khai thác một cách hiệu quả chưa hay thôi!!!<br><br>Nếu SV vẫn còn băn khoăn gì thì có thể gửi mail cho thầy Tú (<a rel="" target="_blank">tutc@fit.hcmute.edu.vn</a>) hoặc gặp trực tiếp để được hướng dẫn thêm!<br><br>', '2014-12-17 11:10:34'),
(92, 9, 'Khoa sẽ thông báo danh sách các bạn đủ điều kiện làm khóa luận tốt nghiệp. Kể cả hệ sư phạm lẫn hệ kỹ sư.&lt;br&gt;Đối với hệ sư phạm thì các bạn đăng ký khóa luận cùng thời điểm với hệ kỹ sư. Tức là học kỳ hai kỳ này. Nếu ko. Hệ sư phạm sẽ chỉ có thể học môn tôt nghiệp ở học kỳ 9. Như vậy ở học kỳ 8 là sv hệ sư phạm đăng ký khóa luận rồi nhé. Kỳ 9, các sv ko làm khóa luận sẽ học môn tốt nghiệp.&lt;br&gt;Thân chào bạn,&lt;br&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;', '2014-12-21 00:04:35'),
(93, 8, 'Chào em, mỗi học kỳ trước khi đăng ký môn học, nếu em không bị xét đình chỉ học tập thì vẫn được đăng ký môn học bình thường.', '2014-12-23 20:02:06'),
(94, 8, 'Chào em, đã có thông báo đăng ký chuyên ngành trên website Khoa rồi. Em xem nhé.', '2014-12-23 20:04:20'),
(95, 8, 'Chào em,&lt;br&gt;Em cần phải được xét và công nhận tốt nghiệp thì mới đến giai đoạn nhận bằng tốt nghiệp. Em theo dõi thường xuyên thông báo của khoa, trường và email của em để biết được các thông tin liên quan nhé.', '2015-01-02 10:45:05'),
(96, 8, 'Chào em,&lt;br&gt;Tốt nghiệp 6.5 đến dưới 8.0 &nbsp;là được xép loại Khá.', '2015-01-02 10:45:49'),
(97, 8, 'Chào em,&lt;br&gt;Nội dung câu hỏi của em liên quan trực tiếp đến môn học cụ thể. Vì vậy, em nên liên hệ và hỏi giảng viên đã giảng dạy môn học này nhé.', '2015-01-03 12:04:45'),
(98, 8, 'Chào em,&lt;br&gt;Nội dung câu hỏi của em liên quan trực tiếp đến môn học cụ thể. Vì vậy, em nên liên hệ và hỏi giảng viên đã giảng dạy môn học này nhé.', '2015-01-03 12:05:18'),
(99, 8, 'Chào em,&lt;br&gt;Em có thể tham khảo các ngành thuộc khoa Điện-Điện tử. Những ngày này liên quan đến những công việc như em mong muốn.', '2015-01-04 11:17:21'),
(100, 0, 'Chào em&lt;br&gt;Kể từ học kỳ III năm học 2013 - 2014 môn Visual Basic 6.0 được thi đề mở nhưng có ràng buộc (chỉ cho phép mang tài liệu viết tay bằng bút mực trừ màu đen và không giới hạn số trang mang vào)&lt;br&gt;', '2015-01-05 07:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
`id` int(11) NOT NULL,
  `option_key` varchar(45) DEFAULT NULL,
  `option_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `option_key`, `option_value`) VALUES
(1, 'pw-encryption', 'MD5'),
(2, 'disable-logins-enable', '0'),
(3, 'default_session', '0'),
(4, 'mailserver_url', 'smtp.gmail.com'),
(5, 'mailserver_port', '465'),
(6, 'mailserver_login', 'btvcntt@gmail.com'),
(7, 'mailserver_pass', '123456@a$'),
(8, 'general', '1');

-- --------------------------------------------------------

--
-- Table structure for table `QA_relationships`
--

CREATE TABLE IF NOT EXISTS `QA_relationships` (
`id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=99 ;

--
-- Dumping data for table `QA_relationships`
--

INSERT INTO `QA_relationships` (`id`, `question_id`, `answer_id`) VALUES
(76, 46, 78),
(81, 53, 83),
(82, 54, 84),
(83, 55, 85),
(84, 56, 86),
(85, 57, 87),
(86, 57, 88),
(87, 58, 89),
(88, 58, 90),
(89, 59, 91),
(90, 61, 92),
(91, 62, 93),
(92, 63, 94),
(93, 64, 95),
(94, 65, 96),
(95, 66, 97),
(96, 67, 98),
(97, 68, 99),
(98, 67, 100);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
`id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `author_stuID` int(11) DEFAULT NULL,
  `author_name` varchar(50) DEFAULT NULL,
  `author_email` varchar(50) DEFAULT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public',
  `i_am` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'student'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `title`, `author_stuID`, `author_name`, `author_email`, `content`, `date`, `type`, `i_am`) VALUES
(46, 'Báo cáo tiểu luận chuyên ngành', 11110079, 'Nguyễn Quang Minh', '11110079@student.hcmute.edu.vn', 'Thầy cho em hỏi thời gian báo cáo tiểu luận chuyên ngành vào khoảng thời gian nào?', '2014-11-28 11:35:19', 'public', 'student'),
(53, 'Hỏi về CTĐT của sư phạm', 0, 'Nguyễn Hồng Ngọc', 'nguyenthi2503@gmail.com', 'Xin cho em hỏi học kì 6 khi phân ngành thì sinh viên sư phạm sẽ học như thế nào ạ, học hết tất cả các môn của 3 chuyên ngành hay được chọn để học đủ tính chỉ', '2014-11-30 14:55:06', 'public', 'student'),
(54, 'thắc mắc về điểm các môn ', 14110179, 'phùng duy thành ', '14110179@student.hcmute.edu.vn', 'Đầu năm e có xin chuyển lớp từ lớp 3 sang lớp 1, Htại e học lớp 141101C và trong thời gian kiểm tra giữa kì, trong danh sách sv kiểm tra lại không có tên và tên e lại có trong danh sách lớp cũ. Do một số môn khác thầy cô giảng dạy. E có thắc mắc là, tại sao e lại k có tên trong danh sách lớp e đang học mà lại có tên trong danh sách lớp cũ(trong danh sách thi giữa kì) . vì e thấy trên bảng điểm e có bị điểm 0,chắc vì lí do k thi môn đó. Nhưg e đã thi đầy đủ. ?. E xin cảm ơn! ', '2014-12-01 00:08:54', 'public', 'student'),
(55, 'mail sinh vien', 14149239, 'hong van sang', 'chuonglam742@gmail.com.vn', 'thay  co oi !dau nam em o vao dia chi mail do truong cap nay em khong vao dc nua \r\nlieu em co dc cap dia chi mail moi dc o a ! em  xin cam on!!!', '2014-12-02 10:27:29', 'public', 'student'),
(56, 'Đề thi - Đáp án', 12110092, 'Lê Tấn Kiệt', '12110092@student.hcmute.edu.vn', 'Em có ý kiến là Web Khoa nên có mục đề thi và đáp án.\r\nĐề thi và đáp án nên được đăng lên web Khoa sau khi thi, chậm nhất là 1 ngày sau khi thi xong.\r\nViệc này sẽ giúp SV trong khoa có nguồn tài liệu tham khảo và các dạng bài tập có trong cấu trúc đề thi. Từ đó có chiến lược ôn tập sao cho thật hiệu quả.\r\nEm có ý kiến như vậy, mong thầy cô giải đáp. Em xin cảm ơn. Chúc thầy cô luôn khoẻ và thành công!', '2014-12-13 08:14:01', 'public', 'student'),
(57, 'Ngày Công Tác Xã Hội', 12110092, 'Lê Tấn Kiệt', '12110092@student.hcmute.edu.vn', 'Cho em hỏi vấn đề liên quan đến ngày CTXH.\r\nTrong năm 2013, em và các bạn trong khoa có tham gia các hoạt động, và được lập danh sách cộng ngày CTXH theo quy định. Nhưng đến nay, Ngày CTXH vẫn không thấy cập nhật, chỉ có Ngày CTXH của năm 2014 (chỉ có nội dung cộng là Tiếp sức mùa thi, còn các nội dung trước thì không được cộng và không thấy cập nhật trên trang online của SV.\r\nMong thầy cô giải đáp>\r\nEm cảm ơn!', '2014-12-16 22:11:24', 'public', 'student'),
(58, 'Về vấn đề Sư phạm Công nghệ thông tin không được đăng ký chuyên ngành', 0, 'Tín Học', 'xahoitinhoc@gmail.com', 'Em đọc được câu trả lời của thầy:\r\nThS. Nguyễn Hữu Trung \r\n<<Hai chương trình đào tạo hệ sư phạm và hệ kỹ sư khác nhau. Hệ sư phạm không phân chuyên ngành, hệ kỹ sư mới được phân chuyên ngành vào đầu học kỳ 6. Chính vì vậy sinh viên hệ sư phạm học theo chương trình của mình, các em có thể đăng ký học các môn của 1 chuyên ngành hoặc cả ba chuyên ngành của hệ kỹ sư. Các em hãy bám sát chương trình đào tạo hệ sư phạm được đăng trên web trường cũng như web khoa.>>\r\n\r\nMà theo em biết là sau khoảng 2 năm là đã bắt đầu chọn chuyện ngành nhưng khi đó tụi em vẫn chưa bắt đầu học bên sư phạm công nghệ thông tin bên viện. Vậy sao em vẫn không được chọn chuyên ngành như mấy bạn bên hệ kỹ sư công nghệ thông.', '2014-12-17 10:30:25', 'public', 'student'),
(59, 'Vấn đề thi lập trình, em muốn xin bộ test chấm sau khi thi', 0, 'Tín Học', 'xahoitinhoc@gmail.com', 'Em có đọc được câu hỏi:\r\n<<Em có ý kiến là Web Khoa nên có mục đề thi và đáp án. Đề thi và đáp án nên được đăng lên web Khoa sau khi thi, chậm nhất là 1 ngày sau khi thi xong. Việc này sẽ giúp SV trong khoa có nguồn tài liệu tham khảo và các dạng bài tập có trong cấu trúc đề thi. Từ đó có chiến lược ôn tập sao cho thật hiệu quả. Em có ý kiến như vậy, mong thầy cô giải đáp. Em xin cảm ơn. Chúc thầy cô luôn khoẻ và thành công!\r\n\r\nThầy ThS. Lê Văn Vinh  có trả lời\r\n<<Trên website Khoa đã có mục Đề Thi-Đáp áp (Menu Đào tạo). Bắt đầu từ HK này, các đáp án thi sẽ được post lên website khoa ngay sau khi môn thi xong.>>\r\n\r\nNay em gửi mail này mong khoa có thể thảo luận với các thầy cô dạy Nhập môn lập trình khóa mới, gửi lên trang web các bộ test chấm kết hợp với bài làm của tụi em để dễ dàng sửa lỗi hoàn thiện bài làm hơn. Với lại một điều nữa trang web thi thử dành cho mấy môn căn bản của khoa mình http://it.hcmute.edu.vn/onlinejudge/ nó cũng không có thông báo nào để biết mà sửa cả, chỉ chấm điểm thôi thì có chấm cũng như thực hiện được bộ test mẫu thôi có khác gì đâu. Nếu nó báo cho tụi em biết sai gì hay đưa ra bộ test sai sau 2-3 lần gửi bài thì mới có thể phát triển khả năng. Chứ mấy hôm trước em lên thi thử mà cứ làm hoài một bài, sửa mãi mà cũng chỉ hai bộ test mà không thể nghĩ ra lỗi gì, thiếu điều kiện gì... rồi lại bài khác cũng thế tốn hơn 5 tiếng mà chỉ làm được 3 bài mà chỉ một bài chọn vẹn.\r\nChán quá đến bây giờ em chỉ lấy đề đó để tham khảo chứ trình chấm ấy chẳng có lợi gì cả. Em mong quý thầy cô xem xét cải thiện trình chấm ấy để có thể học hiệu quả hơn về thời gian và kết quả. Chứ thế thì không thể đủ thời gian để em học tất cả các môn.\r\nEm xin cảm ơn!', '2014-12-17 11:04:50', 'public', 'student'),
(61, 'Khóa luận tốt nghiệp CNTT của sinh viênsư phạm', 13110113, 'Nguyễn Văn Nhàn', 'nguyenvannhan0810@gmail.com', 'Em chào thầy!\r\nTheo em được biết là mỗi năm khoa chỉ mở một đợt bảo vệ luận án tốt nghiệp vào học kì 2. Theo như chương trình đào tạo của hệ sư phạm thì vào học kì 9 bọn em mới làm khóa luận tốt nghiệp CNTT. Vậy vào học kì đó bọn em sẽ phải đợi vào học kì sau để bảo vệ luận án hay là phải học các môn tốt nghiệp ạ.\r\nEm xin cảm ơn ạ.', '2014-12-20 23:01:16', 'public', 'student'),
(62, 'đăng ký môn học', 12110024, 'Huỳnh Trung Dũng', 'dungb2vn1@gmail.com', 'cho em hỏi điều kiện để đăng kí môn học ?, rớt nhiều môn quá có được đăng kí môn học không', '2014-12-22 09:19:36', 'private', 'student'),
(63, 'Chọn chuyên ngành', 0, 'Huỳnh Thế Huy', '12110070@student.hcmute.edu.vn', 'Thầy cho em hỏi khóa 12 khi nào thì chọn chuyên ngành?', '2014-12-22 20:13:06', 'public', 'student'),
(64, 'DanhSachTotNghiep', 10110028, 'Triệu Minh Đoàn', 'doan91vip@gmail.com', 'Chào Thầy/Cô\r\ncho em hỏi học kỳ này em đã kết thúc chương trình học vậy khi nào có danh sách dự kiến tốt nghiệp và khi nào nhận bằng tạm thời,chính thức ? có phải nhận bằng cùng bên sư phạm k ạ ? ', '2015-01-01 15:18:11', 'private', 'student'),
(65, 'XẾP LOẠI TỐT NGHIỆP', 11110075, 'Nguyễn Đức Lợi', 'ducloi221@gmail.com', 'Thầy cô cho em hỏi là sinh viên khóa 11 tụi em khi tốt nghiệp thì bao nhiêu chấm mới có thể xếp loại tốt nghiệp là Khá ạ', '2015-01-02 09:36:57', 'public', 'student'),
(66, 'Kỳ thi cuối kỳ Nhập Môn Lập Trình', 13110131, 'Nguyễn Anh Quí', 'thebestbigzero@gmail.com', 'Dạ thưa thầy cô cho em hỏi, kỳ thi cuối kỳ môn nhập môn lập trình được mang theo tài liệu, vậy em có được mang quyển vở học ghi chép vào được không ạ.', '2015-01-02 19:13:34', 'private', 'student'),
(67, 'cách thức thi môn visual basic', 13145048, 'lê thị kim danh', 'kimdanh4@gmail.com', 'cho e hỏi năm nay.thi môn VB là đề đóng hay đề mở ạ.nếu mở thì đc đêm theo những gì và có giới hạn tài liệu đêm vô không ạ.Em cảm ơn ạ!', '2015-01-02 23:44:19', 'private', 'student'),
(68, 'Chế tạo điện thoại di động/ máy tính bảng', 0, 'Phương Nam', 'phuongnam1997tg@gmail.com', 'Em muốn sau này ra trường  được tham gia chế tạo, thiết kế, sản xuất... điện thoại di động (cơ bản, thông minh), máy tính bảng... thì em phải học ngành nào của trường mình đây?', '2015-01-03 15:36:30', 'private', 'student'),
(69, 'MÔN TƯƠNG ĐƯƠNG', 11110075, 'Nguyễn Đức Lợi', 'ducloi221@gmail.com', 'Em là sinh viên khóa 11 và hiện tại em vẫn đang còn nợ môn Kỹ thuật số (131111180040) và em nghe nói là môn đã bị hủy. Vậy thầy hoặc cô cho em hỏi là môn này hiện đang tương đương với môn nào ạ, tại trên danh sách môn tương đương em không thấy môn này ạ', '2015-01-06 23:17:00', 'public', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE IF NOT EXISTS `terms` (
`term_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `type` varchar(15) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`term_id`, `name`, `type`) VALUES
(1, ' Học tập của sinh viên', 'field'),
(2, 'Trưởng ban tư vấn', 'position'),
(11, 'Nghiên cứu khoa học sinh viên', 'field'),
(12, 'Công tác Học sinh - Sinh viên', 'field'),
(13, 'Tâm lý học đường', 'field'),
(14, ' Thành viên ban tư vấn', 'position');

-- --------------------------------------------------------

--
-- Table structure for table `term_relationships`
--

CREATE TABLE IF NOT EXISTS `term_relationships` (
`id` int(11) NOT NULL,
  `term_id` int(11) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `type` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=86 ;

--
-- Dumping data for table `term_relationships`
--

INSERT INTO `term_relationships` (`id`, `term_id`, `object_id`, `type`) VALUES
(1, 14, 0, 'position'),
(44, 2, 8, 'position'),
(45, 14, 9, 'position'),
(46, 14, 10, 'position'),
(47, 14, 11, 'position'),
(48, 14, 12, 'position'),
(62, 1, 46, 'field'),
(69, 1, 53, 'field'),
(70, 1, 54, 'field'),
(71, 12, 55, 'field'),
(72, 1, 56, 'field'),
(73, 12, 57, 'field'),
(74, 1, 58, 'field'),
(75, 1, 59, 'field'),
(77, 1, 61, 'field'),
(78, 1, 62, 'field'),
(79, 1, 63, 'field'),
(80, 1, 64, 'field'),
(81, 1, 65, 'field'),
(82, 1, 66, 'field'),
(83, 1, 67, 'field'),
(84, 1, 68, 'field'),
(85, 1, 69, 'field');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `restricted` int(11) DEFAULT '0',
  `registed_date` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `fullname`, `restricted`, `registed_date`) VALUES
(0, 'admin', 'trungnh@fit.hcmute.edu.vn', '99e87baa7ee5c592a682723d25c322ef', 'ThS. Nguyễn Hữu Trung', 0, '2014-11-16 00:00:00'),
(8, 'vinhlv', 'vinhlv@fit.hcmute.edu.vn', '91c0eda011d083363259069b36f4e4b0', 'ThS. Lê Văn Vinh', 0, '2014-11-26 22:55:18'),
(9, 'tuannt', 'tuannt@fit.hcmute.edu.vn', '91c0eda011d083363259069b36f4e4b0', 'ThS. Nguyễn Thanh Tuấn', 0, '2014-11-26 22:56:10'),
(10, 'hanhvk', 'hanhvk@fit.hcmute.edu.vn', '91c0eda011d083363259069b36f4e4b0', 'CN. Vũ Thị Kim Hạnh', 0, '2014-11-26 22:56:55'),
(11, 'baont', 'baont2003@gmail.com', '3ef46416b5f69091426d910fabddbbff', 'SV. Nguyễn Thế Bảo', 0, '2014-11-26 22:57:34'),
(12, 'xuyenntk', 'kimxuyenkute93@gmail.com', '91c0eda011d083363259069b36f4e4b0', 'SV. Nguyễn Thị Kim Xuyến', 0, '2014-11-26 22:59:45');

-- --------------------------------------------------------

--
-- Table structure for table `user_meta`
--

CREATE TABLE IF NOT EXISTS `user_meta` (
`meta_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user_meta`
--

INSERT INTO `user_meta` (`meta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 0, 'profile_img', 'public/uploads/trungnh_info-45x45.jpg'),
(4, 8, 'profile_img', 'public/uploads/vinh_info-45x45.png'),
(5, 9, 'profile_img', 'public/uploads/tuannt_info-45x45.png'),
(6, 10, 'profile_img', 'public/uploads/hanhvk_info-45x45.png'),
(7, 11, 'profile_img', 'public/uploads/1318 (2)-45x45.jpg'),
(8, 12, 'profile_img', 'public/uploads/xuyenntk_info-45x45.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_answers_1_idx` (`author_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `QA_relationships`
--
ALTER TABLE `QA_relationships`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_QA_relationships_1_idx` (`question_id`), ADD KEY `fk_QA_relationships_2_idx` (`answer_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
 ADD PRIMARY KEY (`term_id`);

--
-- Indexes for table `term_relationships`
--
ALTER TABLE `term_relationships`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_term_relationships_1_idx` (`term_id`), ADD KEY `fk_term_relationships_2_idx` (`object_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `username_UNIQUE` (`username`), ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `user_meta`
--
ALTER TABLE `user_meta`
 ADD PRIMARY KEY (`meta_id`), ADD KEY `fk_user_meta_1_idx` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `QA_relationships`
--
ALTER TABLE `QA_relationships`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
MODIFY `term_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `term_relationships`
--
ALTER TABLE `term_relationships`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `user_meta`
--
ALTER TABLE `user_meta`
MODIFY `meta_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
ADD CONSTRAINT `fk_answers_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `QA_relationships`
--
ALTER TABLE `QA_relationships`
ADD CONSTRAINT `fk_QA_relationships_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_QA_relationships_2` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `term_relationships`
--
ALTER TABLE `term_relationships`
ADD CONSTRAINT `fk_term_relationships_1` FOREIGN KEY (`term_id`) REFERENCES `terms` (`term_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_meta`
--
ALTER TABLE `user_meta`
ADD CONSTRAINT `fk_user_meta_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
