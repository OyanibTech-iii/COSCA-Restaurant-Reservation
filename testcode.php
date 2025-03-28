<?php
session_start();
require 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurant Reservation & Menu</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<style>
     .cart-icon{
    margin-top: 2px;
    color: rgb(249, 152, 249);
    font-size: 12px;
     }
     
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

body {
    font-family: 'Roboto', sans-serif;
    background-color: rgba(217, 164, 225, 0.919);
}

ul{
    list-style-type: none;
    display:flex;
    justify-content: end;
}

li{
    margin-right: 12px;
}

h1{
    color: rgb(254, 59, 254);
    font-weight: 700;
}

.main-content .text {
    color: unset;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }
 
  .text h1{
    color: unset;
    margin: 0;
    padding: 0;
  }
button{  
    border-width: 1px;
    color: white;
    background-color: rgb(193, 15, 152);
    border-radius: 12px;
    margin-top: 12px;

}
button:hover{
    font-weight: 300;
    background-color: rgb(115, 26, 93);
    color: rgb(249, 152, 249);
}

.product {
    background: rgba(241, 238, 242, 0.997);
    border-radius: 8px;
    box-shadow: 3px 6px 11px rgba(10, 0, 6, 0.2);
    padding: 5px;
    text-align: center;
    width: 100%;
}

.product img {
    width: 100%;
    border-radius: 4px;
}

.product h3 {
    color:  rgb(193, 15, 152);
    margin: 10px 0;
}

.product p {
    color: #555;
}

/* for input tag css + and - */
.quantity-control {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

.quantity-btn {
    background-color: rgb(193, 15, 152);
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
}

.quantity-btn:hover {
    background-color: rgb(115, 26, 93);
}

.quantity-control input {
    margin-top: 15px;
    width: 40px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
}
/* sideBar lay out */
.container {
    min-height: 100vh; 
    display: flex;
    flex-direction: row;
}

/* Sidebar */
.sidebar {
    width: 200px;
    background-color: rgba(193, 15, 152, 0.1);
    padding: 20px;
    align-self: stretch; /* Make it reach the bottom dynamically */
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for separation */
}

.sidebar ul {

    line-height: 12px;
    display: table-row;
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    margin-left: 30px;
    margin: 10px 0;
    cursor: pointer;
    color: rgb(115, 26, 93);
}

.sidebar ul li:hover {
    color: rgb(193, 15, 152);
    font-weight: bold;
}
.main-content {
    flex: 1;
    padding: 15px;
}

.menu {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

 /* logo */
 .logo-container {
    padding: 0;
    margin: 0;
       display: flex;
}

.logo-frame {
    width: 90px;
    height: 90px;
    clip-path: circle(50%);
    -webkit-clip-path: circle(50%);
    overflow: hidden;
    display: inline-block;
}

.logo {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.company-name {
    display: flex;
    color: rgb(115, 26, 93);
    font-weight: bold;
    justify-content: center;
    margin-top: 5px;
    margin-left: 12px;
}
.h4sp{
    color: purple;
font-weight: 200;
margin-top: 20px;
margin-bottom: 2px;
font-size: 16px;
    display: flex;
    align-items: center; /* Aligns icon with text */
    gap: 4px; /* Adds space between icon and text */
  }
  .h4sp:hover{
    color: rgb(193, 15, 152);
    font-weight: bold;
  }

  .h4sp .material-icons {
    font-size: 24px; /* Adjusts icon size */
  }
.ulsp{
margin-top: 0;
}



  
</style>
<body>
<div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
        <div class="logo-container">
        <div class="logo-frame">
            <img src="assets/samplelogo.png" alt="Company Logo" class="logo">
            <h3 class="company-name">Ohyeah Restaurant</h3>
        </div>
      
    </div>
            <h4 class="h4sp"><span class="material-icons">list</span>Menu Categories</h4>
            <ul class="ulsp">
                <li>Reservation</li>
                <li>Pasta</li>
                <li>Burgers</li>
                <li>Desserts</li>
                <li>Drinks</li>
            </ul>
        </aside>    
        <!-- <nav>
        <ul class="navbar">
            <li>Reservation</li>
            <li>Orders</li>
        </ul>
    </nav> -->
        <!-- Main Content -->
        <main class="main-content">
            <div class="text"> 
                <header class="headerText">
                <h1>Restaurant Reservation & Billing System</h1>
                <h3 class="message">Reserve yours now</h3>
                </header>           
            </div>

            <div class="menu">
                <?php
                $stmt = $conn->prepare("SELECT * FROM products");
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($products as $product) {
                    echo "
                        <div class='product'>
                            <img src='{$product['image']}' alt='{$product['name']}'>
                            <h3>{$product['name']}</h3>
                            <p>{$product['description']}</p>
                            <p>Price: ₱ <b>{$product['price']}</b></p>
                            <form action='includes/order.php' method='post'>
                                <input type='hidden' name='product_id' value='{$product['id']}'>
                                <div class='quantity-control'>
                                    <button type='button' class='quantity-btn decrement'>-</button>
                                    <input type='text' name='quantity' value='1' readonly>
                                    <button type='button' class='quantity-btn increment'>+</button>
                                </div>
                                <button class='btn' type='submit'>
                                    <span class='material-icons cart-icon'>add_shopping_cart</span> Buy Now
                                </button>
                            </form>
                        </div>
                    ";
                }
                ?>
            </div>
        </main>
    </div>
    <script>
    document.querySelectorAll('.quantity-control').forEach(function(control) {
        const input = control.querySelector('input[name="quantity"]');
        const increment = control.querySelector('.increment');
        const decrement = control.querySelector('.decrement');

        increment.addEventListener('click', function() {
            input.value = parseInt(input.value) + 1;
        });

        decrement.addEventListener('click', function() {
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });
    });
    document.querySelectorAll('ul li').forEach(item => {
  item.addEventListener('click', () => {
    if (item.innerText === 'Reservation') {
      window.location.href = 'reservationUi.php';
    }
    if (item.innerText === 'Pasta') {
      window.location.href = 'login.php';
    }
    if (item.innerText === 'Burgers') {
      window.location.href = 'signup.php';
    }
  });
});

</script>

</body>
</html>
