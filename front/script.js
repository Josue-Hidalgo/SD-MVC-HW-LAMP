window.onload = function(){
    this.document.getElementById("longURLInput").value = '';
    let lista = "";
    let urlsLen = 0;
        
    function loadDoc(){
        const xhttp = new XMLHttpRequest();
        xhttp.open("POST","http://localhost:8000/prueba.php",true);
        xhttp.onload = function(){
        //lista.append(this.responseText);
            cpyBTN = "<div class=\'BTNOptions\'><button class=\"miniBTN smoothColor\" onclick=\"copyToClipboard("+"\'surls"+urlsLen+"\')\">Copy</button></div>";
            text = "<div class=\'surlText\'><p>"+this.responseText+"</p></div>"
            lista += "<div class=\"surlist\" id=\"surls"+urlsLen+"\">\n\t"+text+cpyBTN+"\n</div>";
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