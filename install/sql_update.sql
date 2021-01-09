ALTER TABLE df_listsrows CHANGE rows items TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `df_userflag` CHANGE `brithday` `brithday` DATE NULL DEFAULT NULL;