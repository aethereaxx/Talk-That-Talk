function validateForm() {
  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;
  if (username === "" || password === "") {
    alert("Username dan password harus diisi!");
    return false;
  } 
  return true;
}
