function validatePassword(password) {
  if (password.length < 8) {
      return false;
  }
  return true;
}

function validateUsername(username) {
  if (username.startsWith("t3adm")) {
    return false;
  }
  return true;
}

function validateAge(dateOfBirth) {
  var today = new Date();
  var birthDate = new Date(dateOfBirth);
  var age = today.getFullYear() - birthDate.getFullYear();
  var monthDiff = today.getMonth() - birthDate.getMonth();
  if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
      age--;
  }
  if (age < 14) {
      return false;
  }
  return true;
}

function showError(message) {
  var errorElement = document.getElementsByClassName("error-message")[0];
  errorElement.innerText = message;
  errorElement.style.display = "block";
}

function hideError() {
  var errorElement = document.getElementsByClassName("error-message")[0];
  errorElement.innerText = "";
  errorElement.style.display = "none";
}

function handleSubmit() {
  var password = document.getElementById('password').value;
  var dateOfBirth = document.getElementById('tanggal_lahir').value;

  hideError();

  if (!validatePassword(password)) {
      showError('Password must be at least 8 characters');
      return false;
  }

  if (!validateAge(dateOfBirth)) {
      showError('You must be at least 14 years old to register');
      return false;
  }

  return true; 
}
