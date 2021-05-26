// Branche un écouteur d'événement CHANGE sur le select DBS
document.querySelector('#dbs').addEventListener(
    'change',
    function (evt) {
        let oXhr = new XMLHttpRequest();
        oXhr.open('get', 'bo.php?db=' + evt.target.value, true);
        oXhr.addEventListener(
            'readystatechange',
            function () {
                if ((oXhr.status === 200 || oXhr.status === 0) && oXhr.readyState === 4) {
                    // Convertit a réponse en objet littéral
                    let oCont = document.querySelector('#badges');
                    oCont.innerHTML = '';
                    let oData = JSON.parse(oXhr.responseText);
                    // Pour chaque membre du tableau...
                    let oSpan, oTxt, oHead;
                    for (let i = 0; i < oData.length; i++) {
                        // Crée un nouvel élément HTML
                        oSpan = document.createElement('span');
                        oSpan.textContent = oData[i]['TABLE_ROWS'];
                        oSpan.classList.add('badge', 'badge-primary');
                        // Crée le texte du titre
                        oTxt = document.createTextNode(oData[i]['TABLE_NAME'] + ' ');
                        // Crée un nouvel élément H4
                        oHead = document.createElement('h4');
                        oHead.className = 'm-2';
                        // Rattache les élément entre eux
                        oHead.appendChild(oTxt);
                        oHead.appendChild(oSpan);
                        oCont.appendChild(oHead);
                    }
                }
            }
        );
        oXhr.send();
    }
);