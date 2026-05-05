function getConfirmation(event, ){
    let buttonSubmit = document.querySelector("#submit");

    if(event.target.checked){
        buttonSubmit.removeAttribute("hidden");
    }
    else{
        buttonSubmit.setAttribute("hidden", true);
    }
}

function getTime(event) {
    let time = event.target.innerHTML;
    let formData = new FormData();
    formData.append('time', time);

    fetch("index.php?route=giveInfoTime", {
        method: 'POST',
        body: formData,
    })
        .then(response => response.text())
        .then(data => {
            document.querySelector(".motifs").innerHTML = data

            let check = document.querySelector("#confirm");
            console.log(check);
            check.addEventListener("change", getConfirmation)
        })
        .catch(err => console.error(err))
}

document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: "fr",
        initialView: 'dayGridMonth',
        fixedWeekCount: false,
        selectable: true,
        firstDay: 1,

        dateClick: function(info) {
            let formData = new FormData();
            formData.append('date', info.dateStr);

            fetch("index.php?route=giveInfoDate", {
                method: 'POST',
                body: formData,
            })
                .then(response => response.text())
                .then(data => {
                    document.querySelector(".creneaux").innerHTML = data

                    let buttons = document.querySelectorAll(".timeButton");
                    for(let timeButton of buttons){
                        timeButton.addEventListener("click", getTime)
                    }
                })
                .catch(err => console.error(err))
        }
    });

    calendar.render();


});