<?php

include './class/store.php';
(new DevCoder\DotEnv('./.env'))->load();

?>

<!DOCTYPE html>
<html>
<head>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#ffffff">

<title>n8n matrix Cricket</title>
<meta name="description" content="ON and OFF n8n matrix Cricket Workflow." />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.4/css/bulma.min.css" integrity="sha512-HqxHUkJM0SYcbvxUw5P60SzdOTy/QVwA1JJrvaXJv4q7lmbDZCmZaqz01UPOaQveoxfYRv1tHozWGPMcuTBuvQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0.3/dist/pretty-checkbox.min.css" integrity="sha256-sI14MHRjSf+KF9MjQHjqHkbDPwsdKXUkhBUdnGCg1iU=" crossorigin="anonymous">

<style>
::-webkit-scrollbar{width:8px;height:8px}::-webkit-scrollbar-thumb{background-color:rgba(45,59,255,.302);border-radius:8px}::-webkit-scrollbar-thumb:hover{background-color:rgba(191,18,253,.5)}
body {
    background-color: #1d3557;
    font-family: 'Fira Code', monospace;
    font-weight: 500;
    height: 100vh;
    overflow-x: hidden;
}
.boxpanel {
flex-grow: 0.3;
font-family: 'Fira Code', monospace;
font-weight: 700;
box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
border-radius: 25px;
padding: 25px;
-moz-osx-font-smoothing: grayscale;
-webkit-font-smoothing: antialiased !important;
-moz-font-smoothing: antialiased !important;
text-rendering: optimizelegibility !important;
}
.databutton {
flex-grow: 0.3;
font-family: 'Fira Code', monospace;
font-weight: 700;
box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
border-radius: 32px;
padding: 20px;
-moz-osx-font-smoothing: grayscale;
-webkit-font-smoothing: antialiased !important;
-moz-font-smoothing: antialiased !important;
text-rendering: optimizelegibility !important;
}
</style>

</head>
<body>

    <section class="section">
    <div class="content">
    <div class="columns is-centered">
    <div class="column is-half">
    <div class="card-content">
    
    <blockquote class="notification is-link boxpanel">
    <h3 class="is-size-5 has-text-light">Matrix Workflow</h3>
    <hr>
    <div class="pretty p-default p-curve p-toggle">
        <input type="checkbox" type="checkbox" id="trigger" />
        <div class="state p-success p-on">
            <label>Activated</label>
        </div>
        <div class="state p-danger p-off">
            <label>Deactivated</label>
        </div>
    </div>
    <br>
    <br>
    <button onclick="check()" class="button is-success databutton">ON</button>
    <button onclick="uncheck()" class="button is-warning databutton">OFF</button>

    </blockquote>
    <br>
    <div id="notice"></div>
    <br>
    <div id="verify"></div>
    </div>
    </div>
    </div>
    </div>
    </section>

<script>

function check() {
  document.getElementById("trigger").checked = true;
  console.log("ON");
  localStorage.setItem("n8n", "ON");

  let activate_flow = "<?php echo getenv('ACTIVATE'); ?>";

  async function FetchData() {
    try {
      const response = await fetch(
        activate_flow
      );
      const data = await response.json();
      console.log(data.message);
    } catch (exception) {
      console.log("Failed to retrieve API");
    }
  }
  FetchData();
  setTimeout(() => {
    window.location.reload();
  }, 1000);
}

function uncheck() {
  document.getElementById("trigger").checked = false;
  console.log("OFF");
  localStorage.setItem("n8n", "OFF");

  let deactivate_flow = "<?php echo getenv('DEACTIVATE'); ?>";

  async function FetchData() {
    try {
      const response = await fetch(
         deactivate_flow
      );
      const data = await response.json();
      console.log(data.message);
    } catch (exception) {
      console.log("Failed to retrieve API");
    }
  }
  FetchData();
  setTimeout(() => {
    window.location.reload();
  }, 1000);
}

let local_db = localStorage.getItem("n8n");

if (local_db === null) {
  async function verify_data() {
    let content;
    const res = await fetch("/api/verify.php");
    content = await res.json();
    console.log(content.message);
    if (content.message == "OFF") {
      document.getElementById("trigger").checked = false;
      document.getElementById("notice").innerHTML =
        '<div class="notification is-warning boxpanel">⛔ Workflow inactive and not running</div>';
    } else if (content.message == "ON") {
      document.getElementById("trigger").checked = true;
      document.getElementById("notice").innerHTML =
        '<div class="notification is-warning boxpanel">✅  Workflow Active and Running</div>';
    } else {
      ('<div class="notification is-info boxpanel">⛔ no workflow data</div>');
    }
  }
  verify_data();
} else {
  (async () => {
    const rawResponse = await fetch("/api/post.php?user=n8n&status=" + local_db, {
      method: "GET",
    });
    const content = await rawResponse.json();
    console.log(content);
    document.getElementById("verify").innerHTML =
      '<hr><div class="notification is-info boxpanel">✅ DB Connected and running data</div>';

    async function verify_data() {
      let content;
      const res = await fetch("/api/verify.php");
      content = await res.json();
      console.log(content.message);
      if (content.message == "OFF") {
        document.getElementById("trigger").checked = false;
        document.getElementById("notice").innerHTML =
          '<div class="notification is-warning boxpanel">⛔ Workflow Deactivated</div>';
      } else if (content.message == "ON") {
        document.getElementById("trigger").checked = true;
        document.getElementById("notice").innerHTML =
          '<div class="notification is-warning boxpanel">✅ Workflow Activated</div>';
      } else {
        ('<div class="notification is-info boxpanel">⛔ Empty Data and DB Not Connected</div>');
      }
    }
    verify_data();
  })();
}

</script>

</body>
</html>