
<form action="?page=lisa" method="post" enctype="multipart/form-data">
    <input type="hidden" name="omanik" value="<?= $_SESSION["username"];?>">
    <input type="text" name="nimetus" value=""/><br/>
    <input type="text" name="text" value=""/><br/>
    Asjast pilt: <input type="file" name="pilt"/><br/>
    
   
    
    
    <input type="submit" value="Lisa"/> 
</form>

