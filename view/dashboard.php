<?php  
require '../func/CProducts.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <main>
        <h1>Актуальные товары: </h1>
        <table border="1" style="width: 100%; text-align:center;">
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Идентификатор
                </th>
                <th>
                    Название
                </th>
                <th>
                    Цена
                </th>
                <th>
                    Артикл товара
                </th>
                <th>
                    Количество
                </th>
                <th>
                    Дата создания
                </th>
                <th>
                    Действие
                </th>
            </tr>
            <?php

            $db = new CProducts();

                    if($_SERVER['REQUEST_METHOD'] == 'POST' ){
                        if(isset($_POST['hide'])){
                        $productId = htmlspecialchars($_POST['productId']);

                        if(!isset($_SESSION['hidden_products'])){
                            $_SESSION['hidden_products'] = []; //Создаем массив сессии
                        }
                        //Добавляем в массив сессии id товара
                        $_SESSION['hidden_products'][] = $productId;
                    }
                        if(isset($_POST['increment'])){
                            $productId = htmlspecialchars($_POST['productId']);
                            $count = htmlspecialchars($_POST['count']);
                            $increment = $count + 1;
                            $db->increment( $productId, $increment);
                        }elseif(isset($_POST['dicrement'])){
                            $productId = htmlspecialchars($_POST['productId']);
                            $count = htmlspecialchars($_POST['count']);
                            $dicrement = $count - 1;
                            $db->dicrement( $productId, $dicrement);
                        }
                    }
                    $hiddenProducts = isset($_SESSION['hidden_products']) ? $_SESSION['hidden_products'] : [];
            
            $products = $db->getProductsByDateDesc();
            foreach ($products as $product){
                if(in_array($product['ID'], $hiddenProducts)){
                    continue;
                }
            ?>
            <tr id="product-row-<?php echo $product['ID']; ?>">
                <td>
                    <?php echo $product['ID']; ?>
                </td>
                <td>
                    <?php echo $product['PRODUCT_ID']; ?>
                </td>
                <td>
                    <?php echo $product['PRODUCT_NAME']; ?>
                </td>
                <td>
                    <?php echo $product['PRODUCT_PRICE']; ?>
                </td>
                <td>
                    <?php echo $product['PRODUCT_ARTICLE']; ?>
                </td>
                <td>
                    <form action="../view/dashboard.php" method="POST">
                        <input type="hidden" name="productId" value="<?=$product['ID']; ?>">
                        <input type="hidden" name="count" value="<?=$product['PRODUCT_QUANTITY']; ?>">
                        <button type="submit" name="increment">
                            +
                        </button>
                        <button type="submit" name="dicrement">
                            -
                        </button>
                    </form>
                    <?php echo $product['PRODUCT_QUANTITY']; ?>
                </td>
                <td>
                    <?php echo $product['DATE_CREATE']; ?>
                </td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="productId" value="<?php echo $product['ID']; ?>">
                        <button type="submit" name="hide"
                            onclick="methodHidden('<?php echo $product['ID']; ?>')">Скрыть</button>
                    </form>
                </td>
                <?php 
            }
            ?>
            </tr>
        </table>
    </main>
    <script>
    function methodHidden(productId) {
        var row = document.getElementById('product-row-' + productId);
        if (row) {
            row.style.display = 'none';
        } else {
            alert('Продукт не найден');
        }
    }
    </script>
</body>

</html>