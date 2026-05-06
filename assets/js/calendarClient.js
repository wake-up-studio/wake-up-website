class RDVManager{
    date;
    time;
    motif;

    constructor(date) {
        this.date = date;
    }

    createRendezVousClient(){
        let selectMotif = document.querySelector("#selectMotif");
        this.motif = selectMotif.value;

        let formFull = new FormData();
        formFull.append("date", this.date);
        formFull.append("time", this.time);
        formFull.append("motif", this.motif);

        fetch("index.php?route=checkCreateRendezVousClient", {
            method: 'POST',
            body: formFull,
        })
            .then(response => response.text())
            .then(data => {
                window.location.assign("index.php?route=homeClient");
            })
            .catch(err => {
                console.error(err);
                window.location.assign("index.php?route=authUser");
            })
    }

    getConfirmation(event){
        let buttonSubmit = document.querySelector("#submit");

        if(event.target.checked){
            buttonSubmit.removeAttribute("hidden");
            buttonSubmit.addEventListener("click", () => {this.createRendezVousClient()});
        }
        else{
            buttonSubmit.setAttribute("hidden", true);
        }
    }

    renderMotifPicker(htmlContent){
        document.querySelector(".motifs").innerHTML = htmlContent;

        let check = document.querySelector("#confirm");
        check.addEventListener("change", (event) => {this.getConfirmation(event)});
    }

    getInfoTime(event) {
        this.time = event.target.value;

        fetch(`index.php?route=giveInfoTime&time=${this.time}`, {
            method: 'GET',
        })
            .then(response => response.text())
            .then(data => {
                this.renderMotifPicker(data);
            })
            .catch(err => console.error(err))
    }

    renderTimePicker(htmlContent){
        document.querySelector(".creneaux").innerHTML = htmlContent;

        let buttons = document.querySelectorAll(".timeButton");
        for(let timeButton of buttons){
            timeButton.addEventListener("click", (event)=> {
                this.getInfoTime(event)}); //appel d'une fonction anonyme qui appelle getInfoTime pour ne pas tomber dans les backrooms du code
        }
    }

    getInfoDate() {
        // console.log(this);
        fetch(`index.php?route=giveInfoDate&date=${this.date}`, {
            method: 'GET',
        })
            .then(response => response.text())
            .then(data => {
                this.renderTimePicker(data);
            })
            .catch(err => console.error(err))
    }
}

document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: "fr",
        initialView: 'dayGridMonth',
        fixedWeekCount: false,
        selectable: true,
        firstDay: 1,

        dateClick: function(info){
            let rdvManager = new RDVManager(info.dateStr);
            rdvManager.getInfoDate();
        }

        // dateClick: function(info) {
        //     let formDate = new FormData();
        //     formDate.append('date', info.dateStr);
        //
        //     rdvManager.date = info.dateStr;
        //
        //     fetch("index.php?route=giveInfoDate", {
        //         method: 'POST',
        //         body: formDate,
        //     })
        //         .then(response => response.text())
        //         .then(data => {
        //             document.querySelector(".creneaux").innerHTML = data
        //
        //             let buttons = document.querySelectorAll(".timeButton");
        //             for(let timeButton of buttons){
        //                 timeButton.addEventListener("click", getTime)
        //             }
        //         })
        //         .catch(err => console.error(err))
        // }
    });

    calendar.render();


});