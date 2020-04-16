var token = "1fcbd791bba0ff9784acba0e898f6af5";
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const t = urlParams.get('t')
if (t == token) {
    displayClicks();
}

const element = document.getElementsByTagName("html")[0];
element.addEventListener("click", getPosition, true);

const today = new Date();

month = today.getMonth()+1;
if (month < 10) {
    month = "0" + month;
}

day = today.getDate();
if (day < 10) {
    day = "0" + day;
}

const fullDate = today.getFullYear()+'-'+month+'-'+day;

function getPosition(click) {
    const xPosition = click.clientX;
    const yPosition = click.clientY;

    const logData = Object();

    logData.positionX = xPosition;
    logData.positionY = yPosition;
    logData.date = fullDate;

    saveClickData(logData);

    //console.log(logData);

}

function saveClickData(dataObject) {
    console.log(dataObject)

    const dataAjax = {
        "date" : dataObject.date,
        "positionX" : dataObject.positionX,
        "positionY" : dataObject.positionY,
    };

    const pageurl = 'http://localhost/heat-maps/api/Heat-maps.php?token=' + token;

    $.ajax({
        url: pageurl,

        dataType : 'json',

        data: JSON.stringify(dataAjax),

        type: 'POST',

        cache: false,

        error: function(err) {
            console.log(err);
        },

        success: function(result) {
            console.log(result);
        }
              
    });
}

function displayClicks() {
    jQuery.ajax({
        url : 'http://localhost/heat-maps/api/Heat-maps.php?token=' + token ,
        dataType : 'json',
        type : 'GET',

        success : function(response){
            console.log(response);
            let data = response

            for (let index = 0; index < data.length; index++) {

                let className = 'green';
                if (data[index].amount > 25) {
                    className = "red";

                }else if (data[index].amount >= 8) {
                    className = "yellow";
                }

                const heatPos = document.createElement("div");
                heatPos.classList.add("circle", className);
                heatPos.appendChild(document.createTextNode(data[index].amount));
                heatPos.style.position = "absolute";
                heatPos.style.left = data[index].posX - 10 + 'px';
                heatPos.style.top = data[index].posY - 15 + 'px';

                element.appendChild(heatPos);
                
            }

        },
        error : function(err){

        	alert("something went wrong");
        	console.error(err);
        }
    });

}