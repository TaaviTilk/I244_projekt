<h2>MEIL ON RENDTIDA JÄRGMISED ASJAD</h2>


<?php include_once('views/renditingimused.html'); ?>


<br/>
<div class="center">
    <table class="center2">
    <thead>
        <tr>
            <th>Nimetus</th>
            <th>Pilt</th>
            <th>Selgitused</th>
        </tr>
    </thead>

    <tbody>

        <?php
        // koolon tsükli lõpus tähendab, et tsükkel koosneb HTML osast
        foreach (pealeht() as $rida):
            ?>

            <tr>
                <td>
                    <?= htmlspecialchars($rida['nimetus']); ?>
                </td>
                <td>
                    <img src="<?= $rida['pilt']; ?>" alt="<?= $rida['nimetus']; ?>" height="100"/>  

                </td>
                <td>
                    <?= htmlspecialchars($rida['text']); ?>
                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>
</table>
<br/>
<div class="center2">
<button id="kuva">KUVA RENDI TINGIMUSED</button>
</div>        
</div>    