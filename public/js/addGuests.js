document.getElementById('addAdult').addEventListener('click', addAdult);
document.getElementById('minusAdult').addEventListener('click', minusAdult);
document.getElementById('addChild').addEventListener('click', addChild);
document.getElementById('minusChild').addEventListener('click', minusChild);

function addAdult() {
    let adults = parseInt(document.getElementById('adults').value);
    adults ++;
    document.getElementById('adults').value = `${adults}`;
    fetchNewData();
}

function minusAdult() {
    let adults = parseInt(document.getElementById('adults').value);
    if (adults != 1) {
        adults --;
    }
    document.getElementById('adults').value = `${adults}`;
    fetchNewData();
}

function addChild() {
    let children = parseInt(document.getElementById('children').value);
    children ++;
    document.getElementById('children').value = `${children}`;
    fetchNewData();
}

function minusChild() {
    let children = parseInt(document.getElementById('children').value);
    if (children != 0) {
        children --;
    }
    document.getElementById('children').value = `${children}`;
    fetchNewData();
}
