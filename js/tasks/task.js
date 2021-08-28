/*********************************************************************************************************************/
/*                                                                                                                   */
/*  task_delete               Triggers the soft deletion of a task.                                                  */
/*  task_restore              Triggers the restoration of a soft deleted task.                                       */
/*  task_delete_hard          Triggers the hard deletion of a task.                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Triggers the soft deletion of a task.
 *
 * @param   {string}  task_id   The ID of the task that should be soft deleted.
 * @param   {string}  message   The confirmation message which will be displayed prior to the deletion.
 *
 * @return  {void}
 */

 function task_delete(  task_id ,
                        message )
{
  // Assemble the postdata
  postdata =  'task_id=' + fetch_sanitize(task_id);
  postdata += '&task_delete=1';

  // Trigger the deletion
  if(confirm(message))
    fetch_page(task_id, 'task_full_body', postdata);
}




/**
 * Triggers the restoration of a soft deleted task.
 *
 * @param   {string}  task_id   The ID of the task that should be restored.
 * @param   {string}  message   The confirmation message which will be displayed prior to the restoration.
 *
 * @return  {void}
 */

 function task_restore( task_id ,
                      message )
{
  // Assemble the postdata
  postdata =  'task_id=' + fetch_sanitize(task_id);
  postdata += '&task_restore=1';

  // Trigger the restoration
  if(confirm(message))
    fetch_page(task_id, 'task_full_body', postdata);
}




/**
 * Triggers the hard deletion of a task.
 *
 * @param   {string}  task_id   The ID of the task that should be hard deleted.
 * @param   {string}  message   The confirmation message which will be displayed prior to the hard deletion.
 *
 * @return  {void}
 */

 function task_delete_hard( task_id ,
                            message )
{
  // Assemble the postdata
  postdata =  'task_id=' + fetch_sanitize(task_id);
  postdata += '&task_delete_hard=1';

  // Trigger the hard deletion
  if(confirm(message))
    fetch_page('delete', 'task_full_body', postdata);
}