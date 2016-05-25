
<form action="?page=lisa" method="post" enctype="multipart/form-data">
    <input type="hidden" name="omanik" value="<?= $_SESSION["user"];?>">
    <table>
        <tr>
            <td>
                Nimi:
            </td>
                        <td>
                Omadused:
            </td>
                        <td>
                Pilt:
            </td>
        </tr>
               <tr>
            <td>
                <input type="text" placeholder="nimi" name="nimetus" value=""/>
            </td>
                        <td>
                <input type="text" placeholder="uus, vana / teh andmed"name="text" value=""/>
            </td>
                        <td>
                <input type="file" name="pilt"/>
            </td>
        </tr>
    </table>
    <br/>
   <input type="submit" value="Lisa"/> 
</form>
	<?php if (isset($errors)):?>
		<?php foreach($errors as $error):?>
			<div style="color:red;"><?php echo htmlspecialchars($error); ?></div>
		<?php endforeach;?>
	<?php endif;?>


