let G1;
let G2;

window.onload = function(){
    this.document.getElementById("longURLInput").value = '';
    let lista = "";
    let urlsLen = 0;
        
    function loadDoc(){
        const xhttp = new XMLHttpRequest();
        xhttp.open("POST","http://localhost:8000/prueba.php",true);
        xhttp.onload = function(){
            urls = this.responseText.split(" ");
            cpyBTN = "<div class=\'BTNOptions\'><button class=\"miniBTN smoothColor\" onclick=\"copyToClipboard("+"\'surls"+urlsLen+"\')\">Copiar</button></div>";
            text = "<div id=\"surls"+urlsLen+"\" class=\'surlText\'><p>"+urls[4]+"</p></div>";
            text2 = "<div class=\'surlText\'><p>"+urls[5]+"</p></div>";
            statsBTN = "<div class=\'BTNOptions\'><button class=\"miniBTN smoothColor\" onclick=\"showStatsModal("+"\'surls"+urlsLen+"\')\">Estadisticas</button></div>";
            lista += "<div class=\"surlist\">\n\t"+text+cpyBTN+text2+statsBTN+"\n</div>";
            console.log(this.responseText);
            urlsLen++;
            document.getElementById("changes").innerHTML = lista;
        }
        inputText = document.getElementById("longURLInput").value;

        json = JSON.stringify({
          url: inputText,
        });

        console.log(json);
        xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhttp.send(json);
    }

    document.getElementById("acortBTN").addEventListener("click",function(){
        loadDoc();
    });
}

function copyToClipboard(id){
    let elementText = document.getElementById(id);
    let range = document.createRange();
    range.selectNode(elementText);
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);
    document.execCommand("copy");
    window.getSelection().removeAllRanges();
    alert("Copied to clipboard");
}

function showStatsModal(id){
    dates = "bomboclat";
    document.getElementById("defaultStatsModal").showModal();
    miGrafica = this.document.getElementById("Grafica").getContext("2d");
    G1 = new Chart(miGrafica,{
        type:"line",
        data:{
            labels:[
                "vino","Tequila","atun","queso","pan"
            ],
            datasets:[
                {
                    label:"Visitas diarias",
                    backgroundColor:"rgb(243, 53, 150)",
                    data:[12,34,100,34,90],
                    borderColor:"rgb(243, 53, 150)"
                }
            ]
        }
    });
    miGrafica2 = this.document.getElementById("GraficaC").getContext("2d");
    G2 = new Chart(miGrafica2,{
        type:"line",
        data:{
            labels:[
                "vino","Tequila","atun","queso","pan"
            ],
            datasets:[
                {
                    label:"Visitas por pais",
                    backgroundColor:"rgb(255, 157, 0)",
                    data:[12,34,100,34,90],
                    borderColor:"rgb(255, 157, 0)"
                }
            ]
        }
    });
    document.getElementById("totalAcces").textContent = "Total de accesos: "+dates;
    document.getElementById("creationDate").textContent = "Fecha de creacion: "+dates;
    console.log("Do something");
}

function DONTshowStatsModal(){
    document.getElementById("defaultStatsModal").close();
    G1.destroy();
    G2.destroy();
    console.log("DONT do something");
}