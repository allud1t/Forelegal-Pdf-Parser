<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../public/result-table-style.css" />
    <title>Resultado do Parser</title>
</head>
<body>
    <h3>Resultado da extração de nome e cpf do arquivo <?= $file['name'] ?></h3>
    <table>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
        </tr>
        <?php foreach ($names as $index => $name): ?>
            <tr>
                <td><?= $name ?></td>
                <td><?= $allCpf[$index] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>