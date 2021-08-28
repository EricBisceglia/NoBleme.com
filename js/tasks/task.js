/*********************************************************************************************************************/
/*                                                                                                                   */
/*  task_delete               Triggers the soft deletion of a task.                                                  */
/*  task_restore              Triggers the restoration of a soft deleted task.                                       */
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