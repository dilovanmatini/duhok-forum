ALTER TABLE `df_listsrows` CHANGE `rows` `items` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `df_userflag` CHANGE `brithday` `brithday` DATE NULL DEFAULT NULL;

INSERT INTO `df_template` (`id`, `name`, `text`) VALUES (NULL, 'navbar', '');
INSERT INTO `df_template` (`id`, `name`, `text`) VALUES (NULL, 'footer', '');