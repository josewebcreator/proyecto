<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\bootstrap.min.css">
    <link rel="stylesheet" href="..\css\estilo.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arvo&display=swap" rel="stylesheet">
    <title><?php echo $tittle;?></title>
</head>
<body>
    <header>
        <div class="header-content">
            <div id="titulo">
                <img src="..\img\logo.png" alt="" id="logo">
            </div>

                <input type="checkbox" name="btn-menu" id="btn-menu">
                <label for="btn-menu"><img src="..\img\burguer-menu.png" alt="" width=40px></label>
                <nav id="menu">
                    <ul>
                        <li><a href="../inicio/index.php">Inicio</a></li>
                        <li><a href="../sobre_mi/index.php">¿Quien Soy?</a></li>
                        <li><a href="../blog/index.php">Blog</a></li>
                        <li><a href="../contacto/index.php">Contacto</a></li>
                    </ul>
                </nav>
                
        </div>
    </header>