let G1;
let G2;

window.onload = function(){
    this.document.getElementById("longURLInput").value = '';
    let lista = "";
    getAllSURLS();
        
    function getAllSURLS(){
        const xhttp = new XMLHttpRequest();
        xhttp.open("GET","http://localhost:8000/GASURLS.php",true);
        xhttp.onload = function(){
            surlen = 0;
            surls = this.responseText.split("\n");
            console.log(surls);
            for(let i = 0; i<surls.length-1;i++){
                items = surls[i].split(" ");
                cpyBTN = "<div class=\'BTNOptions\'><button class=\"miniBTN smoothColor\" onclick=\"copyToClipboard("+"\'surls"+surlen+"\')\">Copiar</button></div>";
                text = "<div id=\"surls"+surlen+"\" class=\'surlText\'><p>"+items[0]+"</p></div>";
                text2 = "<div class=\'surlText\'><p class=\"truncateText\">"+items[1]+"</p></div>";
                statsBTN = "<div class=\'BTNOptions\'><button class=\"miniBTN smoothColor\" onclick=\"showStatsModal("+"\'surls"+surlen+"\')\">Estadisticas</button></div>";
                lista += "<div class=\"surlist\">\n\t"+text+cpyBTN+text2+statsBTN+"\n</div>";
                document.getElementById("changes").innerHTML = lista;
                surlen++;
            }
        }
        xhttp.send();
    }

    function addSC(){
        const xhttp = new XMLHttpRequest();
        xhttp.open("POST","http://localhost:8000/prueba.php",true);
        xhttp.onload = function(){
            lista2 = "";
            surlen = lista.length;
            urls = this.responseText.split(" ");
            cpyBTN = "<div class=\'BTNOptions\'><button class=\"miniBTN smoothColor\" onclick=\"copyToClipboard("+"\'surls"+surlen+"\')\">Copiar</button></div>";
            text = "<div id=\"surls"+surlen+"\" class=\'surlText\'><p>"+urls[4]+"</p></div>";
            text2 = "<div class=\'surlText\'><p class=\"truncateText\">"+urls[5]+"</p></div>";
            statsBTN = "<div class=\'BTNOptions\'><button class=\"miniBTN smoothColor\" onclick=\"showStatsModal("+"\'surls"+surlen+"\')\">Estadisticas</button></div>";
            lista2 += "<div class=\"surlist\">\n\t"+text+cpyBTN+text2+statsBTN+"\n</div>";
            console.log(this.responseText);
            lista = lista2+lista;
            document.getElementById("changes").innerHTML = lista;
        }
        inputText = document.getElementById("longURLInput").value.replaceAll("\"","\'");

        json = JSON.stringify({
          url: inputText,
        });

        console.log(json);
        xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhttp.send(json);
    }

    document.getElementById("acortBTN").addEventListener("click",function(){
        addSC();
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

function getViews(surl){
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET","http://localhost:8000/GVBSURLS.php?surl="+surl,true);
    xhttp.onload = function(){
        views = this.responseText;
        document.getElementById("totalAcces").textContent = "Total de accesos: "+views;
    }
    xhttp.send();
}

function getDate(surl){
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET","http://localhost:8000/GDBSURLS.php?surl="+surl,true);
    xhttp.onload = function(){
        Dates = this.responseText;
        document.getElementById("creationDate").textContent = "Fecha de creacion: "+Dates;
    }
    xhttp.send();
}

function showStatsModal(id){
    let elementText = document.getElementById(id).textContent;
    code = elementText.split("=")[1];
    getViews(code);
    getDate(code)
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
    console.log("Do something");
}

function DONTshowStatsModal(){
    document.getElementById("defaultStatsModal").close();
    G1.destroy();
    G2.destroy();
    console.log("DONT do something");
}