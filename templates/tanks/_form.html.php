<?php
    /** @var $tanks ?\App\Model\Tank */
?>

<div class="form-group">
    <label for="make">Marka</label>
    <input type="text" id="make" name="tanks[make]" value="<?= $tanks ? $tanks->getMake() : '' ?>" required>
</div>

<div class="form-group">
    <label for="model">Model</label>
    <input type="text" id="model" name="tanks[model]" value="<?= $tanks ? $tanks->getModel() : '' ?>" required>
</div>

<div class="form-group">
    <label for="year">Rocznik</label>
    <input type="number" id="year" name="tanks[year]" value="<?= $tanks ? $tanks->getYear() : '' ?>" required>
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="Save">
</div>

