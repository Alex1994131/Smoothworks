CREATE TABLE `digital_download` (
  `id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `filename` varchar(256) NOT NULL,
  `buyer_show` tinyint(4) NOT NULL COMMENT '0-show,-hide',
  `seller_show` tinyint(4) NOT NULL COMMENT '0-show,1-hide',
  `upload_user_id` int(11) NOT NULL,
  `file_size` varchar(50) NOT NULL,
  `added_on` datetime NOT NULL,
  `time_zone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `digital_download`
--
ALTER TABLE `digital_download`
ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `digital_download`
--
ALTER TABLE `digital_download`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Gig Dynamic Price Settings
--

INSERT INTO `system_settings` (`key`, `value`, `system`, `groups`, `update_date`, `status`) VALUES
('price_option', 'dynamic', 1, 'config', '2017-10-13', 1);

--
-- Gig Dynamic Price
--

ALTER TABLE `extra_gigs` ADD `extra_gigs_amount` INT NOT NULL AFTER `extra_gigs`;

--
-- Medium gig image
--

ALTER TABLE `gigs_image` ADD `gig_image_medium` VARCHAR( 500 ) NOT NULL AFTER `gig_image_tile` ;

update  paypal_details set sandbox_email = 'c.soosairaj@gmail.com', sandbox_password = 'Dreams99' where sandbox_email = 'nithesh.anbalagan@gmail.com';