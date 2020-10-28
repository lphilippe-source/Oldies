<br/>
<h2 class="h2 blockquote-footer">Selection du driver</h2><br/>
<form action='/ocr2/pdo-sqli' method='POST'>
    <div class="form-check form-check-inline">
        <input name="PDOorMSQL" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="connectPDO">
        <label class="form-check-label" for="inlineCheckbox1">PDO</label>
    </div>
    <div class="form-check form-check-inline">
        <input name="PDOorMSQL" class="form-check-input" type="checkbox" id="inlineCheckbox2" value="connectMysqli">
        <label class="form-check-label" for="inlineCheckbox2">Mysqli</label>
    </div>
    <input class="btn btn-primary" type="submit" name="choixDb" />
</form>

