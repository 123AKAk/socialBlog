document.getElementById("click").addEventListener("click", (e) => {
  e.preventDefault();
  const email = document.getElementById("email").value;
  const code = generateCode();
  const time = getTime();
  const date = getDate();

  const formdata = new FormData();

  formdata.append("email", email);
  formdata.append("code", code);
  formdata.append("time", time);
  formdata.append("date", date);

  fetch("./assets/php/code.php", {
    method: "POST",
    body: formdata,
  })
    .then((res) => res.text())
    .then((data) => {
      console.log(data);
      if (data == 1) {
        alert("Suceesful Check your email for the code");
        location.href = "resetPassword.php";
      } 
      else if(data == 2)
      {
        alert("Email Not Registered");

      }
      else {
        alert("Somthing Went Wrong");
      }
    });
});

function generateCode() {
  let min = 100000;
  let max = 1000000;
  let randomNumber = Math.floor(Math.random() * (max - min + 1)) + min; // generates a random integer between min and max
  return randomNumber;
}

function getTime() {
  const now = new Date();
  const hours = now.getHours().toString().padStart(2, "0");
  const minutes = now.getMinutes().toString().padStart(2, "0");
  const seconds = now.getSeconds().toString().padStart(2, "0");

  const timeString = `${hours}:${minutes}:${seconds}`;
  return timeString;
}

function getDate() {
  const now = new Date();
  const month = (now.getMonth() + 1).toString().padStart(2, "0");
  const day = now.getDate().toString().padStart(2, "0");
  const year = now.getFullYear();

  const dateString = `${month}/${day}/${year}`;
  return dateString;
}
