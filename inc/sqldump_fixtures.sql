/*! ******************************************************************************************************************/
/*!                                                                                                                  */
/*!                                            FIXTURES FOR THE DATABASE                                             */
/*!                                                                                                                  */
/*! ******************************************************************************************************************/
/*!                                                                                                                  */
/*!                   These fixtures are data meant to be used locally when working on the website                   */
/*!      They should/will never be run on a production environment, so don't worry too much about their conents      */
/*!                                                                                                                  */
/*! *****************************************************************************************************************/;

INSERT INTO dev_blogs
SET         posted_at = UNIX_TIMESTAMP()      ,
            title     = 'Sample devblog'      ,
            body      = 'Sample devblog body' ;

INSERT INTO users
SET         users.id                  = 1             ,
            users.nickname            = 'Admin'       ,
            users.password            = ''            ,
            users.is_administrator    = 1             ;
INSERT INTO users
SET         users.id                  = 2             ,
            users.nickname            = 'Global_mod'  ,
            users.password            = ''            ,
            users.is_global_moderator = 1             ;
INSERT INTO users
SET         users.id                  = 3             ,
            users.nickname            = 'Moderator'   ,
            users.password            = ''            ,
            users.is_moderator        = 1             ,
            users.moderator_rights    = 'forum'       ,
            users.moderator_title_en  = 'Forum'       ,
            users.moderator_title_fr  = 'Forum'       ;
INSERT INTO users
SET         users.id                  = 4             ,
            users.nickname            = 'User'        ,
            users.password            = ''            ;

INSERT INTO users_profile
SET         users_profile.fk_users      = 1                     ,
            users_profile.email_address = 'admin@localhost'     ,
            users_profile.created_at    = '1111239420 '         ;
INSERT INTO users_profile
SET         users_profile.fk_users      = 2                     ,
            users_profile.email_address = 'globalmod@localhost' ,
            users_profile.created_at    = '1111239420 '         ;
INSERT INTO users_profile
SET         users_profile.fk_users      = 3                     ,
            users_profile.email_address = 'moderator@localhost' ,
            users_profile.created_at    = '1111239420 '         ;
INSERT INTO users_profile
SET         users_profile.fk_users      = 4                     ,
            users_profile.email_address = 'user@localhost'      ,
            users_profile.created_at    = '1111239420 '         ;

INSERT INTO users_settings
SET         users_settings.fk_users = 1 ;
INSERT INTO users_settings
SET         users_settings.fk_users = 2 ;
INSERT INTO users_settings
SET         users_settings.fk_users = 3 ;
INSERT INTO users_settings
SET         users_settings.fk_users = 4 ;

INSERT INTO users_stats
SET         users_stats.fk_users = 1 ;
INSERT INTO users_stats
SET         users_stats.fk_users = 2 ;
INSERT INTO users_stats
SET         users_stats.fk_users = 3 ;
INSERT INTO users_stats
SET         users_stats.fk_users = 4 ;