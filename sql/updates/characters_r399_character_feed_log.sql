-- This update is for `characters` database, not `armory`!
ALTER TABLE `character_feed_log` CHANGE `difficulty` `difficulty` SMALLINT( 6 ) DEFAULT '-1';