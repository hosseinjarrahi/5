@extends('Admin::layout')
@section('title','افزودن محصول')

@section('head')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endsection

@section('content')
    <form id="form" action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <x-card title="اطلاعات">
                    <div>
                        <div class="form-group">
                            <label>عنوان :</label>
                            <input onchange="generateSlug(this)" name="title" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>توضیحات :</label>
                            <textarea class="form-control my-editor" name="desc" id="editor" cols="30" rows="15"></textarea>
                        </div>


                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label>قیمت :</label>
                                <div class="input-group">
                                    <input type="number" name="price" class="form-control">
                                    <div class="input-group-prepend"><span class="input-group-text">تومان</span></div>
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid city.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>با تخفیف :</label>
                                <div class="input-group">
                                    <input type="number" name="offer" class="form-control">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">تومان</span>
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid city.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>وضعیت :</label>
                                <select name="status" class="form-control">
                                    <option value="none" selected>بدون وضعیت</option>
                                    <option value="complete">تکمیل</option>
                                    <option value="making">در حال برگزاری</option>
                                    <option value="soon">به زودی</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please provide a valid state.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>درصد تکمیل :</label>
                                <div class="input-group">
                                    <input type="number" name="percentage" class="form-control">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-8 col-md-10 mb-3">
                                <div class="custom-file">
                                    <input type="file" name="pic" class="custom-file-input">
                                    <label class="custom-file-label">تصویر محصول</label>
                                </div>
                            </div>
                            <div class="col-2 col-md-1">
                                <div class="btn btn-primary btn-block"><span class="fas fa-hdd"></span></div>
                            </div>
                            <div class="col-2 col-md-1">
                                <div class="btn btn-primary btn-block"><span class="fas fa-link"></span></div>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="col-8 col-md-10 mb-3">
                                <div class="custom-file">
                                    <input type="file" name="video" class="custom-file-input">
                                    <label class="custom-file-label">ویدیو دمو</label>
                                </div>
                            </div>
                            <div class="col-2 col-md-1">
                                <div class="btn btn-primary btn-block"><span class="fas fa-hdd"></span></div>
                            </div>
                            <div class="col-2 col-md-1">
                                <div class="btn btn-primary btn-block"><span class="fas fa-link"></span></div>
                            </div>
                        </div>


                        <div class="form-group my-3">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="courseCheckbox"
                                       name="makeCourse"
                                >
                                <label class="custom-control-label" for="courseCheckbox">
                                    میخواهم دوره ایجاد کنم
                                </label>
                            </div>
                        </div>

                        <div id="courseList" class="d-none">
                            <x-card>
                                <x-course-items/>
                            </x-card>
                        </div>

                        <div class="form-group my-3">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="fileCheckbox"
                                       name="makeFile"
                                >
                                <label class="custom-control-label" for="fileCheckbox">
                                    میخواهم فایل ایجاد کنم
                                </label>
                            </div>
                        </div>

                        <div id="fileList" class="d-none">
                            <x-card>
                                <x-file-items/>
                            </x-card>
                        </div>


                        <button class="btn btn-block btn-primary my-2">ارسال</button>
                    </div>
                </x-card>

            </div>

            <div class="col-md-4">
                <div class="row">

                    <div class="col-12">
                        <x-card title="دسته بندی ها">
                            <div class="form-group">
                                <select multiple class="select3 form-control" name="categories[]">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </x-card>
                    </div>

                    <div class="col-12">
                        <x-card title="سئو">

                            <div class="form-group">
                                <label>تگ ها</label>
                                <select multiple class="select2 form-control" name="tags[]">
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>کلید واژه ها</label>
                                <select multiple class="select2 form-control" name="keywords[]">
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>عنوان صفحه :</label>
                                <input id="pageTitle" name="pageTitle" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>توضیحات صفحه :</label>
                                <textarea name="pageDescription" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label>نامک :</label>
                                <input id="slug" name="slug" class="form-control">
                            </div>

                        </x-card>
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        function generateSlug(item) {
            slug.value = slugify(item.value);
            pageTitle.value = item.value;
        }

        courseCheckbox.onchange = function (e) {
            if (e.target.checked) {
                courseList.classList.remove('d-none');
                courseList.classList.add('d-block');
                generate();
                return;
            }
            courseList.classList.add('d-none');
            courseList.classList.remove('d-block');
        }

        fileCheckbox.onchange = function (e) {
            if (e.target.checked) {
                fileList.classList.remove('d-none');
                fileList.classList.add('d-block');
                generateFileItem();
                return;
            }
            fileList.classList.add('d-none');
            fileList.classList.remove('d-block');
        }

        $(document).ready(function () {
            $('.select2').select2({
                placeholder: 'انتخاب موضوع',
                tags: 'true',
                allowClear: true
            });

            $('.select3').select2({
                placeholder: 'انتخاب موضوع',
                allowClear: true
            });
        });

    </script>

    <script>
        let editor_config = {
            path_absolute : "/",
            directionality : 'rtl',
            content_style: "body {font-family: 'Vazir' !important}",
            // language: 'fa_IR',
            // language_url : '/assets/js/fa_IR.js',
            selector: "textarea.my-editor",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>

@endsection
