<select class="btn btn-primary btn-sm" name="tipo_filtro" id="tipo_filtro">
    <?php foreach ($tipoingreso->result_array() as $fila): ?>
        <option value="<?= $fila['id'] ?>" >
            <?= strtoupper($fila['tipomov']) ?>
        </option>
    <?php endforeach ?>
</select>