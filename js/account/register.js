/*********************************************************************************************************************/
/*                                                                                                                   */
/*  user_register_submit              Validates that a new user account can be registered.                           */
/*  user_register_validate_username   Validates that a username is correct during the account registration process.  */
/*  user_register_validate_password   Validates that a password is correct during the account registration process.  */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Validates that a new user account can be registered.
 *
 * This function will check that the form values are properly filled in before sending the form through.
 * There is obviously also back end data validation, so this function is only front end sugar for the user experience.
 *
 * @returns {void}
 */

function user_register_submit()
{
  // Begin by assuming that everything is ok
  form_failed = 0;

  // Ensure every text field is filled up
  form_failed = (!form_require_field('register_username', 'label_register_username')) ? 1 : form_failed;
  form_failed = (!form_require_field('register_password_1', 'label_register_password_1')) ? 1 : form_failed;
  form_failed = (!form_require_field('register_password_2', 'label_register_password_2')) ? 1 : form_failed;
  form_failed = (!form_require_field('register_captcha', 'label_register_captcha')) ? 1 : form_failed;

  // Ensure minimum/maximum string length are respected
  if(document.getElementById('register_username').value.length < 3)
  {
    css_add('label_register_username', 'red');
    form_failed = 1;
  }
  if(document.getElementById('register_username').value.length > 15)
  {
    css_add('label_register_username', 'red');
    form_failed = 1;
  }
  if(document.getElementById('register_password_1').value.length < 8)
  {
    css_add('label_register_password_1', 'red');
    form_failed = 1;
  }

  // Ensure passwords are identical
  if(document.getElementById('register_password_1').value !== document.getElementById('register_password_2').value)
  {
    css_add('label_register_password_2', 'red');
    form_failed = 1;
  }

  // Check whether the questions are correctly answered
  css_remove('label_register_question_1', 'red');
  var question1 = document.querySelectorAll('input[name=register_question_1]:checked');
  question1 = (question1.length > 0) ? parseInt(question1[0].value) : null;
  if(question1 !== 2)
  {
    css_add('label_register_question_1', 'red');
    form_failed = 1;
  }
  css_remove('label_register_question_2', 'red');
  var question2 = document.querySelectorAll('input[name=register_question_2]:checked');
  question2 = (question2.length > 0) ? parseInt(question2[0].value) : null;
  if(question2 !== 2)
  {
    css_add('label_register_question_2', 'red');
    form_failed = 1;
  }
  css_remove('label_register_question_3', 'red');
  var question3 = document.querySelectorAll('input[name=register_question_3]:checked');
  question3 = (question3.length > 0) ? parseInt(question3[0].value) : null;
  if(question3 !== 2)
  {
    css_add('label_register_question_3', 'red');
    form_failed = 1;
  }
  css_remove('label_register_question_4', 'red');
  var question4 = document.querySelectorAll('input[name=register_question_4]:checked');
  question4 = (question4.length > 0) ? parseInt(question4[0].value) : null;
  if(question4 !== 1)
  {
    css_add('label_register_question_4', 'red');
    form_failed = 1;
  }

  // If there's no error in the form, submit it
  if(!form_failed)
    document.getElementById('register_form').submit();
}




/**
 * Validates that a username is correct during the account registration process.
 *
 * @returns {void}
 */


function user_register_validate_username()
{
  // Define the username validation regular expression
  regex_username = new RegExp('^[a-zA-Z0-9]{3,15}$');

  // Fetch the username
  register_username = document.getElementById('register_username').value;

  // If the username is valid, reset the label to normal
  if (regex_username.test(register_username))
  {
    // Reset the label to normal
    css_remove('label_register_username', 'red');

    // Check if the username is already taken and display the warning container
    fetch_page('register_check_username', 'register_username_error', 'register_username='+fetch_sanitize(register_username), css_remove('register_username_error', 'hidden'));
  }

  // If the username is invalid, show it
  else
  {
    // Make the label red
    css_add('label_register_username', 'red');

    // Hide the username already taken warning container
    css_add('label_register_error', 'hidden');
  }
}




/**
 * Validates that a password is correct during the account registration process.
 *
 * @returns {void}
 */


function user_register_validate_password()
{
  // Fetch the passwords
  register_password_1 = document.getElementById('register_password_1').value;
  register_password_2 = document.getElementById('register_password_2').value;

  // If the first password is invalid, show it
  if (register_password_1.length < 8)
    css_add('label_register_password_1', 'red');

  // If the password is valid, reset the field to normal
  else
    css_remove('label_register_password_1', 'red');

  // If the second password is invalid or passwords are different, show it
  if (register_password_2 && (register_password_2.length < 8 || (register_password_2 !== register_password_1)))
    css_add('label_register_password_2', 'red');

  // If the passwords are valid, reset the field to normal
  else
    css_remove('label_register_password_2', 'red');
}