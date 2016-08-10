<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE=edge">
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <meta name = "description" content = "">
    <meta name = "author" content = "">
    <title>Stylish Portfolio - Start Bootstrap Theme</title>
    <link href = "../views/css/bootstrap.min.css" rel = "stylesheet">
    <link href = "../views/css/stylish-portfolio.css" rel = "stylesheet">
    <link rel = "stylesheet" href = "../views/css/selectButton.css" />
    <link rel = "stylesheet" href = "../views/css/addActivity.css" />
    <link rel = "stylesheet" href = "../views/css/seeActivity.css" />
    <script type = "text/javascript" src  ="/EasyMVC/views/js/jquery-1.9.1.min.js"></script>
</head>

<body>
    <a href = "index">回上一頁</a>
    <table id = "keywords" cellspacing = "0" cellpadding = "0" >
    <thead>
        <tr>
            <th><span>時間</span></th>
            <th><span>帳號</span></th>
            <th><span>支出</span></th>
            <th><span>收入</span></th>
            <th><span>餘額</span></th>
        </tr>
    </thead>
    <?php foreach ($data[0] as $value) { ?>
    <tbody>
        <tr>
            <td><?php echo $value[5]?></td>
            <td><?php echo $value[1]?></td>
            <td><?php echo $value[2]?></td>
            <td><?php echo $value[3]?></td>
            <td><?php echo $value[4]?></td>
        </tr>
    <?php } ?>
    </tbody>
    </table>
    <div align = "center">
        <h2>總金額</h2><?php  foreach ($data[1] as $value) {echo $value[0]; } ?>
    </div>
</body>

</html>
