
<form action="?page=lisa" method="post" enctype="multipart/form-data">
    <input type="hidden" name="omanik" value="<?= $_SESSION["user"];?>">
    <!--tapsustada, kudias "user"iga tuleb kasutaja, Kust ta selle muutujaga kasutaja votab-->
    <input type="text" name="nimetus" value=""/><br/>
    <input type="text" name="text" value=""/><br/>
    Asjast pilt: <input type="file" name="pilt"/><br/>
    
    
    
   
    <?= $_SESSION["user"];?>
    
    <input type="submit" value="Lisa"/> 
</form>


