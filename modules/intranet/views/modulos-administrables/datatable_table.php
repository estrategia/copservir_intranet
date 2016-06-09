<?php foreach ($objWorksheet as $registro => $objCelda): ?>
    <?php if ($registro == 1): ?>
        <thead>
        <?php endif; ?>

        <?php echo "<tr>"; ?>
        <?php foreach ($objCelda as $column => $value): ?>
            <?php echo ($registro == 1 ? "<th>" : "<td>") . $value . ($registro == 1 ? "</th>" : "</td>"); ?>
        <?php endforeach; ?>
        <?php $claseFila = "" ?>
        <?php if ($registro >> 1) {
            $claseFila = ( ($registro % 2) == 0 ? "odd" : "even" );
        } ?>

    <?php echo "</tr class='$claseFila'>"; ?>
        <?php if ($registro == 1): ?>
        </thead>
        <tbody>
    <?php endif; ?>
<?php endforeach; ?>
</tbody>