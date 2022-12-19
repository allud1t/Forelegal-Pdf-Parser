<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    <link rel="stylesheet" href="public/style.css" />
    <title>Extrator do André Casanova</title>
</head>
<body>
<form action="app/Controllers/PdfUploadController.php" method="post" enctype="multipart/form-data">
    <div class="file-upload-wrapper">
        <div class="file-choose-wrapper">
            <div class="choose-file-button" id="getFile">Escolha o Arquivo</div>
            <div class="chosen-file-name" id="chosenFileName">Nenhum arquivo escolhido...</div>
            <input class="choose-file-input-field" type="file" name="theFile" id="theFile"/>
        </div>
        <div class="send-file-button-wrapper">
            <button type="submit" class="btn btn-primary send-file-button" id="sendBtn">Enviar</button>
        </div>
    </div>
</form>
<div class="copyright">By <a href="https://www.github.com/casanova-ep">André Casanova</a></div>
</body>
</html>
<script>
    document.getElementById("theFile").onchange = function () {
        document.getElementById("chosenFileName").innerHTML = this.files[0].name;
    };
</script>
