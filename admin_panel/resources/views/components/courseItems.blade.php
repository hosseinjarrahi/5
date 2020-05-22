<div class="w-100" id="courseItemsParent">

    <div class="btn btn-primary btn-sm my-3" onclick="generate()"><span class="fas fa-plus"></span></div>
</div>

<script>

    let counter = 0;


    function generate() {
        let random = Math.random(10);

        let item = `
        <span>
        <div class="form-group">
            <input name="courseTitle[]" class="form-control" placeholder="عنوان">
        </div>

        <div class="form-row">
            <div class="col-10 mb-3">
                <div class="custom-file">
                    <input type="file" name="file[]" class="custom-file-input">
                    <label class="custom-file-label">فایل</label>
                </div>
            </div>
            <div class="col-1">
                <div class="btn btn-primary btn-block"><span class="fas fa-hdd"></span></div>
            </div>
            <div class="col-1">
                <div class="btn btn-primary btn-block"><span class="fas fa-link"></span></div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-11">
                <div class="form-group my-3">
                    <div class="custom-control custom-checkbox my-1 mr-sm-2">
                        <input type="checkbox"
                               name="free[]"
                               class="custom-control-input"
                               id="free-${random}"
                        >
                        <label class="custom-control-label" for="free-${random}">
                            رایگان
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-1 d-flex align-items-start">
                <div class="btn mr-auto btn-danger btn-sm" onclick="removeItem(this)"><span class="fas fa-times"></span></div>
            </div>
        </div>

        <div class="dropdown-divider"></div>
        </span>
        `;

        courseItemsParent.innerHTML += item;


    }

    function removeItem(ev){
        let shouldRemove = ev.parentElement.parentElement.parentElement;
        shouldRemove.remove();
    }

</script>
