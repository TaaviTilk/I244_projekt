

<h1>ASJAD</h1>



<table id="asjad" border="1">
    <thead>
        <tr>
            <th>Nimetus</th>
            <th>Pilt</th>
            <th>Selgitused</th>
            <th>Omanik</th>
            <th>Tegevused</th>
        </tr>
    </thead>

    <tbody>

        <?php
        // koolon tsükli lõpus tähendab, et tsükkel koosneb HTML osast
        foreach (asjad() as $rida):
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

                    <form method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="action" value="delete">
                        <!--<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">-->
                        <input type="hidden" name="id" value="<?= $rida['id']; ?>">
                        <button type="submit">Kustuta rida</button>
                    </form>

                </td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>