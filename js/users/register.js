/**
 * Validates that a new user account can be registered.
 *
 * This function will check that the form values are properly filled in before sending the form through.
 * There is obviously also back end data validation, so this function is only front end sugar for the user experience.
 *
 * @param   {string}  path  The path to the root of the website
 *
 * @returns {void}
 */

function users_register_submit(path)
{
  // Begin by assuming that everything is ok
  form_failed = 0;

  // Ensure every text field is filled up
  form_failed = (!form_require_field("register_nickname", "label_register_nickname")) ? 1 : form_failed;
  form_failed = (!form_require_field("register_password_1", "label_register_password_1")) ? 1 : form_failed;
  form_failed = (!form_require_field("register_password_2", "label_register_password_2")) ? 1 : form_failed;
  form_failed = (!form_require_field("register_email", "label_register_email")) ? 1 : form_failed;
  form_failed = (!form_require_field("register_captcha", "label_register_captcha")) ? 1 : form_failed;

  // Ensure minimum/maximum string length are respected
  if(document.getElementById("register_nickname").value.length < 3)
  {
    document.getElementById("label_register_nickname").classList.add('negative');
    document.getElementById("label_register_nickname").classList.add('text_white');
    form_failed = 1;
  }
  if(document.getElementById("register_nickname").value.length > 15)
  {
    document.getElementById("label_register_nickname").classList.add('negative');
    document.getElementById("label_register_nickname").classList.add('text_white');
    form_failed = 1;
  }
  if(document.getElementById("register_password_1").value.length < 8)
  {
    document.getElementById("label_register_password_1").classList.add('negative');
    document.getElementById("label_register_password_1").classList.add('text_white');
    form_failed = 1;
  }

  // Ensure passwords are identical
  if(document.getElementById("register_password_1").value != document.getElementById("register_password_2").value)
  {
    document.getElementById("label_register_password_2").classList.add('negative');
    document.getElementById("label_register_password_2").classList.add('text_white');
    form_failed = 1;
  }

  // Check whether the questions are correctly answered
  document.getElementById("label_register_question_1").classList.remove('negative');
  document.getElementById("label_register_question_1").classList.remove('text_white');
  var temp = document.querySelectorAll('input[name=register_question_1]:checked');
  var temp = (temp.length > 0) ? temp[0].value : null;
  if(temp != 2)
  {
    document.getElementById("label_register_question_1").classList.add('negative');
    document.getElementById("label_register_question_1").classList.add('text_white');
    form_failed = 1;
  }
  document.getElementById("label_register_question_2").classList.remove('negative');
  document.getElementById("label_register_question_2").classList.remove('text_white');
  var temp = document.querySelectorAll('input[name=register_question_2]:checked');
  var temp = (temp.length > 0) ? temp[0].value : null;
  if(temp != 2)
  {
    document.getElementById("label_register_question_2").classList.add('negative');
    document.getElementById("label_register_question_2").classList.add('text_white');
    form_failed = 1;
  }
  document.getElementById("label_register_question_3").classList.remove('negative');
  document.getElementById("label_register_question_3").classList.remove('text_white');
  var temp = document.querySelectorAll('input[name=register_question_3]:checked');
  var temp = (temp.length > 0) ? temp[0].value : null;
  if(temp != 2)
  {
    document.getElementById("label_register_question_3").classList.add('negative');
    document.getElementById("label_register_question_3").classList.add('text_white');
    form_failed = 1;
  }
  document.getElementById("label_register_question_4").classList.remove('negative');
  document.getElementById("label_register_question_4").classList.remove('text_white');
  var temp = document.querySelectorAll('input[name=register_question_4]:checked');
  var temp = (temp.length > 0) ? temp[0].value : null;
  if(temp != 1)
  {
    document.getElementById("label_register_question_4").classList.add('negative');
    document.getElementById("label_register_question_4").classList.add('text_white');
    form_failed = 1;
  }

  // If there's no error in the form, submit it
  if(!form_failed)
    document.getElementById('register_form').submit();
}