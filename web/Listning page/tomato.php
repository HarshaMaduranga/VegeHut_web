<!DOCTYPE html>
<html>
<head>
  <title>Tomato Sellers</title>
  <style>
    body { font-family: Arial; background-color: #fffaf0; padding: 20px; width:500px; }
    .seller {
      background: palegreen;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 8px;
      box-shadow: 0 0 5px lightgray;
    }
    button { padding: 10px 15px; background-color: green;}
  </style>
</head>
<body>
   <img src="../images/tomatoes.jpg"
     style="position:fixed;top:0;left:0;width:100%;height:100%;z-index:-1; filter: blur(4px); object-fit: cover;">

  <h2>
  <p style="color:rgb(70, 255, 73); 
            text-shadow: -1px -1px 0 #000,  
                         1px -1px 0 #000,  
                        -1px 1px 0 #000,  
                         1px 1px 0 #000;
                         font-size: 40px;">
    Tomato Sellers
  </p>
</h2>

  <!--Load seller data from PHP -->
  <?php include 'tomatoselect.php'; ?>

</body>
</html>