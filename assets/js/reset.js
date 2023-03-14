document.getElementById("click").addEventListener("click", (e) => {
  e.preventDefault();
  const code = document.getElementById("code").value;
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirmPassword").value;

  if (password == confirmPassword) {
    fetch(`./assets/php/checkCode.php?code=${code}`, {
      method: "GET",
    })
      .then((res) => res.json())
      .then((data) => {
        console.log(data);
        if (data.length > 0) {
          let diff = GetDateDiff(data[0].date, data[0].time);
          console.log(Number(diff.split(" ")[0]));
          console.log(diff);

          if (
            (diff.toLowerCase().includes("min") &&
              Number(diff.split(" ")[0]) <= 10) ||
            diff.toLowerCase().includes("sec")
          ) {
            if (data[0].expire == 0) {
              alert("this code has Has Already Been Used");
            } else {
              const formdata = new FormData();
              formdata.append("password", password);
              formdata.append("email", data[0].email);

              fetch("./assets/php/resetpass.php", {
                method: "POST",
                body: formdata,
              })
                .then((res) => res.text())
                .then((data) => {
                  console.log(data);
                  if (data == 1) {
                    alert("Password Reset Succesful");
                  } else {
                    alert("Somthing Went Wrong");
                  }
                });
            }
          } else {
            alert("this code has expired, input code within 4 minutes");
          }
        } else {
          alert("code is wrong");
        }
      });
  } else {
    alert("confirm password should macth the password");
  }
});

function GetDateDiff(previousDate, previousTime) {
  let today = new Date();
  let dd = String(today.getDate()).padStart(2, "0");
  let mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
  let yyyy = today.getFullYear();

  let currentDate = mm + "/" + dd + "/" + yyyy; // this will give you the current date
  let previousHours = previousTime.split(":")[0];
  let previousMinutes = previousTime.split(":")[1];
  let previousSeconds = previousTime.split(":")[2];

  let timePeriod = "seconds"; // timePeriod is the current unit of mesearement whether in seconds hours or days
  let timeInNumber = "0"; //timeInNumber is the number infront of the timeperiod eg the 40 in 40 minites is the timeInNumber

  let dateObj = new Date();

  // this is to set the appropriate seconds, minutes and hours
  if (currentDate == previousDate) {
    if (dateObj.getHours() == previousHours) {
      if (dateObj.getMinutes() == previousMinutes) {
        timeInNumber = dateObj.getSeconds() - previousSeconds;
        timePeriod = "Second";
      } else {
        timeInNumber = dateObj.getMinutes() - previousMinutes;
        timePeriod = "Minute";
      }
    } else {
      timeInNumber = dateObj.getHours() - previousHours;
      timePeriod = "Hour";
    }
  } else {
    const previousDateDifferential = new Date(previousDate);
    const currentDateDifferential = new Date(currentDate);
    const diffrenceInDate = Math.abs(
      currentDateDifferential - previousDateDifferential
    );

    // this is to calculate the diffrence in days, weeks, months and years
    const diffDays = Math.ceil(diffrenceInDate / (1000 * 60 * 60 * 24));
    const diffWeeks = Math.ceil(diffrenceInDate / (1000 * 60 * 60 * 24 * 7));
    const diffMonths = Math.ceil(
      diffrenceInDate / (1000 * 60 * 60 * 24 * 7 * 4)
    );
    const diffyears = Math.ceil(
      diffrenceInDate / (1000 * 60 * 60 * 24 * 7 * 4 * 12)
    );

    // this is to set the appropriate days, weeks, months and years
    if (diffDays <= 30) {
      timeInNumber = diffDays;
      timePeriod = "Day";
    } else if (diffDays > 30 && diffWeeks <= 4) {
      timeInNumber = diffWeeks;
      timePeriod = "Week";
    } else if (diffWeeks > 4 && diffMonths <= 12) {
      timeInNumber = diffMonths - 2;
      timePeriod = "Month";
    } else if (diffMonths > 12) {
      timeInNumber = diffyears - 1;
      timePeriod = "Year";
    }
  }

  if (timeInNumber > 1) {
    timePeriod += "s"; // this is to ad 's' at the end of the time period if the time period is more than 1
  }
  return `${timeInNumber} ${timePeriod}, ago`;
}
