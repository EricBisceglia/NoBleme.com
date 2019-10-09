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