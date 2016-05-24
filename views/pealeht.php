<h2>MEIL ON RENDTIDA JÄRGMISED ASJAD</h2>



<table id="asjad" border="1">
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