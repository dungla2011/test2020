
<div id="serverbox" class="serverbox" style="display: none">
    <label for="psw"><b>Server</b></label><br>
    <input type="text" id="server" name="server" title="server" placeholder="server" value="glx.com.vn" /><br>
    <label for="psw"><b>Port</b></label><br>
    <input type="number" min="1" id="port" name="port" title="port" placeholder="port" value="60000" /><br>
    <label for="psw"><b>User</b></label><br>
    <input type="text" id="user" name="user" title="user" placeholder="user" value="lad01" /><br>
    <label for="psw"><b>Password</b></label><br>
    <input type="password" id="password" name="password" title="password" placeholder="password" value="qqqppp@zzz" /><br>

</div>
<button type="button" onclick="ConnectServer()">Connect</button><br>
<div id="terminal" style="width:100%; height:50%;visibility:hidden"></div>
<script>
    var resizeInterval;
    //var wSocket = new WebSocket("wss:glx.com.vn:56789");
    var wSocket = new WebSocket("wss:sv991.pm33.net:20003");
    Terminal.applyAddon(attach);  // Apply the `attach` addon
    Terminal.applyAddon(fit);  //Apply the `fit` addon
    var term = new Terminal({
    cols: 80,
        rows: 24
    });
    term.open(document.getElementById('terminal'));


    function ConnectServer(){
        document.getElementById("serverbox").style.visibility="hidden";
        document.getElementById("terminal").style.visibility="visible";
        var dataSend = {"auth":
                {
                    "server": 'glx.com.vn',
                    "port":  60000,
                    "user": 'sys_admin_glx',
                    "password": 'glx@2020',
                }
        };
        wSocket.send(JSON.stringify(dataSend));

        term.fit();
        term.focus();
    }

    wSocket.onopen = function (event) {
        console.log("Socket Open");
        term.attach(wSocket,false,false);
        window.setInterval(function(){
            wSocket.send(JSON.stringify({"refresh":""}));
        }, 700);
    };

    wSocket.onerror = function (event){
        term.detach(wSocket);
        alert("Connection Closed");
    }

    term.on('data', function (data) {
        var dataSend = {"data":{"data":data}};
        wSocket.send(JSON.stringify(dataSend));
        //Xtermjs with attach dont print zero, so i force. Need to fix it :(
        if (data=="0"){
            term.write(data);
        }
    })

    //Execute resize with a timeout
    window.onresize = function() {
        clearTimeout(resizeInterval);
        resizeInterval = setTimeout(resize, 400);
    }
    // Recalculates the terminal Columns / Rows and sends new size to SSH server + xtermjs
    function resize() {
        if (term) {
            term.fit()
        }
    }

    setTimeout(function () {
        //ConnectServer()
    },1000)

    function pasteCmd() {

        $(".xterm-text-layer").trigger({type: 'keypress', which: 13, keyCode: 13});
        $(".xterm-cursor-layer").trigger({type: 'keypress', which: 13, keyCode: 13});
        console.log(" append... ");
        //$(".xterm-text-layer").append("ABC...");
    }

</script>