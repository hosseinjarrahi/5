<div class="w-100" id="fileItemsParent">

    <div class="btn btn-primary btn-sm my-3" onclick="generateFileItem()"><span class="fas fa-plus"></span> <span>افزودن آیتم</span></div>
</div>

<div class="d-none">
    <span id="fileTemplate">

        <div class="form-row">
            <div class="col-9 mb-3">
                <div class="custom-file">
                    <input type="file" name="files[]" class="custom-file-input">
                    <label class="custom-file-label">فایل</label>
                </div>
            </div>
            <div class="col-1">
                <div class="btn btn-primary btn-block"><span class="fas fa-hdd"></span></div>
            </div>
            <div class="col-1">
                <div class="btn btn-primary btn-block"><span class="fas fa-link"></span></div>
            </div>
            <div class="col-1">
                <div class="btn btn-danger btn-block" onclick="removeItem(this)"><span class="fas fa-times"></span></div>
            </div>
        </div>

        <div class="dropdown-divider"></div>
    </span>
</div>

<script>
    let fTemplate = fileTemplate.cloneNode(true);
    fileTemplate.remove();

    function generateFileItem() {
        let item = fTemplate.cloneNode(true);
        fileItemsParent.appendChild(item);
    }
</script>
