// Close the ban log popin if it is open upon loading the page
popin_close('ban_log_popin');


/**
 * Fetches a ban log.
 *
 * @param   {int} log_id    The ID of the ban log to fetch.
 * @param   {int} [ban_id]  The ID of the banned user - will be used if the log id is unknown.
 *
 * @returns {void}
 */

function admin_ban_fetch_log( log_id          ,
                              ban_id  = null  )
{
  // Assemble the postdata
  postdata  = 'log_id='   + fetch_sanitize(log_id);
  if(ban_id)
    postdata += '&ban_id='  + fetch_sanitize(ban_id);

  // Fetch the requested ban log
  fetch_page('ban_log', 'admin_ban_popin_log', postdata);
}