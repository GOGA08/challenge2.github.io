<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>BITOID challenge 2</title>
</head>
<body>
    <div class="box">
<form class="inputs" action="index.php" method="POST">
      <label for="username">Username</label>
      <input type="text" name="username">
      <label for="data"> Choose: </label>
      <select name="select">
        <option value="follower">follower</option>
        <option value="repositories">repositories</option>
        <option value="both">followers & repositories</option>
      </select>
      <input type="submit" name="submit" class="button">
</form>
    </div>
    <?php 
    $opts = array(
        'http'=>array(
          'method'=>"GET",
          'header'=>'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36'
        )
      );

      $context = stream_context_create($opts);
      
    
      if(isset($_POST['submit']) && $_POST['username']!=""){
        $username = $_POST['username'];
        $select = $_POST['select'];

        if( $_POST['username']===""){
            echo "<div class='repo'>Must not be empty</div>";
          }

        
      
      if($select == "repositories"){ 
        $repo = file_get_contents("https://api.github.com/users/$username/repos", false, $context);
        $decoded = json_decode($repo, true);
        // 
        
        foreach($decoded as $info){
          $name = $info['name'];
          
          echo "<div class='repo'><a class='href' href='https://github.com/$username/$name' target=_blank>$name</a></div><p></p>";
  
        }
    }
    if($select == "follower"){
    
        $file = file_get_contents("https://api.github.com/users/$username/followers", false, $context);
        $decode = json_decode($file, true); 
            
            
        foreach($decode as $data){
        $login =  $data['login'] . "<br>";
        $url = $data['html_url'];
        echo "<div class='repo'><a class='href' href='$url' target=_blank>$login</a></div>";
        $image = $data['avatar_url'];
        echo "<div class='repo'><a class='href' href='$url' target=_blank><img class='img' src=$image></a></div>";
              }
            }
    
    if($select == "both"){
        $file = file_get_contents("https://api.github.com/users/$username/followers", false, $context);
        $decode = json_decode($file, true);
        
        foreach($decode as $data){
            $login =  $data['login'] . "<br>";
            $url = $data['html_url'];
            echo "<div class='repo'><a class='href' href='$url' target=_blank>$login</a></div>";
            $image = $data['avatar_url'];
            echo "<div class='repo'><a class='href' href='$url' target=_blank><img class='img' src=$image ></a></div>";
            }
            
                
            echo "<br>";
            echo "<br>";
            
            $repo = file_get_contents("https://api.github.com/users/$username/repos", false, $context);
            $decoded = json_decode($repo, true);
            foreach($decoded as $keys => $info){
                $name = $info['name'];
                    
                echo "<div class='repo'><a class='href' href='https://github.com/$username/$name' target=_blank><h1 class='title'>$name</h1></a></div>";
            
            }



    }
}
    ?>
</body>

</html>