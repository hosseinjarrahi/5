<div class="w-100" id="courseItemsParent">

    <div class="btn btn-primary btn-sm my-3" onclick="generate()"><span class="fas fa-plus"></span> <span>افزودن آیتم</span></div>
</div>

<div class="d-none">
    <span id="courseTemplate">
        <div class="form-group">
            <input name="" type="text" class="form-control" placeholder="عنوان">
        </div>

        <div class="form-row">
            <div class="col-8 col-md-10 mb-3">
                <div class="custom-file">
                    <input type="file" name="" class="custom-file-input">
                    <label class="custom-file-label">فایل</label>
                </div>
            </div>
            <div class="col-2 col-md-1">
                <div class="btn btn-primary btn-block"><span class="fas fa-hdd"></span></div>
            </div>
            <div class="col-2 col-md-1">
                <div class="btn btn-primary btn-block"><span class="fas fa-link"></span></div>
            </div>
        </div>

        <div class="form-row justify-content-between align-items-center">
            <div class="col-3 col-md-1">
                <div class="form-group my-3">
                    <div class="custom-control custom-checkbox my-1 mr-sm-2">
                        <input type="checkbox" name="free[]" class="custom-control-input" id="free-">
                        <label class="custom-control-label" for="free-">
                            رایگان
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-4 col-md-8">
                <div class="input-group my-3">
                    <div class="input-group-append"><span class="input-group-text">زمان</span></div>
                    <input name="time[]" type="text" class="time form-control">
                </div>
            </div>

            <div class="col-5 col-md-2 d-flex align-items-start">
                <div class="btn mr-auto btn-danger btn-sm" onclick="removeItem(this)">
                    <span class="fas fa-times"></span>
                    <span>حذف آیتم</span>
                </div>
            </div>
        </div>

        <div class="dropdown-divider"></div>
    </span>
</div>

<script>
    let cTemplate = courseTemplate.cloneNode(true);
    let counter = 0;
    courseTemplate.remove();

    function generate() {
        let item = cTemplate.cloneNode(true);
        item.querySelector('.custom-checkbox').childNodes[1].setAttribute('id', 'free-' + counter);
        item.querySelector('.custom-checkbox').childNodes[3].setAttribute('for', 'free-' + counter);
        let checkbox = item.querySelector('[type = "checkbox"]');
        let time = item.querySelector('.time');
        let file = item.querySelector('[type = "file"]');
        let title = item.querySelector('[type = "text"]');

        checkbox.name = `courseFreeBoxes[${counter}]`;
        file.name = `courseFiles[${counter}]`;
        title.name = `courseTitles[${counter}]`;
        time.name = `courseTimes[${counter}]`;

        courseItemsParent.appendChild(item);
        counter++;
    }

    function removeItem(element) {
        let shouldRemove = element.parentElement.parentElement.parentElement;
        shouldRemove.remove();
    }

</script>
