document.getElementById('check-in').addEventListener('click', function(e) {
    this.blur();
});
document.getElementById('check-out').addEventListener('click', function(e) {
    this.blur();
});

document.getElementById('check-in').addEventListener('change', () => {
    let checkInValue = document.getElementById('check-in').value;
    
    if (checkInValue === "") {
        document.getElementById('numberOfNights').innerHTML = "&nbsp";
        return;
    }

    let checkIn = new Date(`${checkInValue} GMT-4`);
    checkIn.setDate(checkIn.getDate() + 1);
    let minCheckOut = checkIn.toISOString().split('T')[0];
    
    document.getElementById('check-out').setAttribute('min', minCheckOut);

    let checkOutValue = document.getElementById('check-out').value;
    
    if (checkOutValue !== "" && new Date(checkInValue) >= new Date(checkOutValue)) {
        document.getElementById('check-out').value = "";
        document.getElementById('numberOfNights').innerHTML = "&nbsp";
    } else if (checkOutValue !== "") {
        outputDiffDays();
    }
});

document.getElementById('check-out').addEventListener('change', () => {
    if (document.getElementById('check-in').value == "") {
        return;
    }
    outputDiffDays();
});

function outputDiffDays() {
    let start = new Date(document.getElementById('check-in').value);
    let end = new Date(document.getElementById('check-out').value);
    
    if (document.getElementById('check-out').value === "") {
        document.getElementById('numberOfNights').innerHTML = "&nbsp";
        return;
    }

    let diffDays = (end - start) / (1000 * 60 * 60 * 24);
    document.getElementById('numberOfNights').innerHTML = `${diffDays} night(s)`;
}
