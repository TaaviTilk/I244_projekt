

<h1>RENDITAVAD ASJAD</h1>



<table id="asjad" border="1">
    <thead>
        <tr>
            <th>Nimetus</th>
            <th>Pilt</th>
            <th>Selgitused</th>
            <th>Omanik</th>
            <th>Rendi</th>
            <th>Kelle käes</th>
            <th>Mis ajast</th>
        </tr>
    </thead>

    <tbody>

        <?php
        // koolon tsükli lõpus tähendab, et tsükkel koosneb HTML osast
        foreach (rendi() as $rida):
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
                <td>
                    <?= htmlspecialchars($rida['omanik']); ?>
                </td>
                <td>

                    <form method="post" action="?page=rendi_valja">
                        <input type="hidden" name="action" value="rendi_valja">
                        <input type="hidden" name="kasutaja" value="<?= $_SESSION['user']; ?>">
                        <input type="hidden" name="aeg" value="<?= date("Y-m-d H:i:s"); ?>">
                        <input type="hidden" name="id" value="<?= $rida['id']; ?>">
                        <button type="submit">RENDIN</button>
                    </form>

                </td>
                <td>
                    <?= htmlspecialchars($rida['rentnik']); ?>
                </td>
                <td>
                    <?= htmlspecialchars($rida['aeg']); ?>
                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>
</table>