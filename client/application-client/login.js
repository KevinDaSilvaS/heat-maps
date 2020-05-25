function sendRegisterForm(data){
    const url = `http://localhost/heat-maps/client/api_client/Client-Api.php`;

    const myInit = { 
        method: 'POST',
        headers: myHeaders,
        body: JSON.stringify(data),
        mode: 'cors',
    };

    const myRequest = new Request(url, myInit);

    fetch(myRequest)
    .then(function(response) {
        document.getElementById("msg-register").innerHTML = "";
        if (response.status === 200) {
            return;
        }
        return response.json();
    })
    .then(function(json) {
        console.log(json.response);
        document.getElementById("msg-register").innerHTML = `${json.response}`;
    });
}


function validateRegisterForm(){
    document.getElementById("msg-register").innerHTML = "";
    const confirm = document.getElementById("rconfirm-password");
    const password = document.getElementById("rpassword");
    const phone = document.getElementById("rphone");
    const name = document.getElementById("rname");
    const email = document.getElementById("remail");

    if (confirm.value !== password.value) {
        confirm.classList.add("error-bottom");
        password.classList.add("error-bottom");
        document.getElementById("msg-register").innerHTML += 
        `passwords should be equal in both fields <br>`;
        return;
    }

    if (phone.value !== '' && phone.value.match("[A-Za-z]")) {
        phone.classList.add("error-bottom");
        document.getElementById("msg-register").innerHTML += 
        `Your phone number should not contain alpha characters [A-Za-z] <br>`;
        return;
    }

    confirm.classList.remove("error-bottom");
    password.classList.remove("error-bottom");
    phone.classList.remove("error-bottom");

    const data = new Object;
    data.email = email.value;
    data.name = name.value;
    data.phone = phone.value;
    data.password = password.value;

    sendRegisterForm(data);
}

function sendLoginData(){
    const url = `http://localhost/heat-maps/client/api_client/Client-Api-Login.php`;

    const data = new Object;
    data.email = document.getElementById("email").value;
    data.password = document.getElementById("password").value;

    const myInit = { 
        method: 'POST',
        headers: myHeaders,
        body: JSON.stringify(data),
        mode: 'cors',
    };

    const myRequest = new Request(url, myInit);

    fetch(myRequest)
    .then(function(response) {
        document.getElementById("msg-login").innerHTML = "";
        if (response.status === 200) {
            return;
        }
        return response.json();
    })
    .then(function(json) {
        console.log(json);
        document.getElementById("msg-login").innerHTML = `${json.response}`;
    });
}