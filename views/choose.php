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

    <div align = "center">
        <form method = "post" action = "btAction">
            <input type= "text" class = "form-control" name = "searchName" placeholder="帳號"><br>
            <input type= "text" class = "form-control" name = "money" placeholder="金額"><br>
            <button type = "submit" class = "addbutton" name = "expend">出款</button>
            <button type = "submit" class = "addbutton" name = "income">入款</button><br>
            <button type = "submit" class = "addbutton" name = "btSearch">搜尋</button>
        </form>
    </div>
</body>

</html>
