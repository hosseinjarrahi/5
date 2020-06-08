@extends('Quizviran::layout')
@section('title','نیزویران | ویرایش سوال')

@section('head')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endsection

@section('content')

    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="{{ auth()->user()->type }}"></app-panel-links-header>
            </div>
        </div>

        <app-back route="{{ url()->previous() }}"></app-back>

        <div class="row justify-content-center mt-3">
            <div class="col-12 col-lg-7 rounded p-2">
                <app-main-box :dark="true" title="ویرایش سوال" icon="edit">
                    <app-question-edit-form
                            :categories="{{ auth()->user()->categories->toJson() }}"
                            route="{{ route('quizviran.question.update',['question' => $question->id]) }}"
                            :question="{{ $question->toJson() }}"
                    ></app-question-edit-form>
                </app-main-box>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let editor_config = {
            external_plugins: {
                'mathSymbols': '/quiz-assets/js/math.js',
                'graphTinymcePlugin': '/quiz-assets/js/graph.js',
            },
            menubar: false,
            directionality: 'rtl',
            // language: 'fa_IR',
            // language_url : '/assets/js/fa_IR.js',
            selector: "#editor",
            plugins: [
                "advlist lists charmap preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime nonbreaking table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | mathSymbols graphTinymcePlugin",

            graph_uploader: function (file, cb) {
                // Here is your uploader logic, start to upload you image here like that:

                // yourUploader.sendIMG(file.blob)
                //   .then(function(url){
                //      // Take a look at "class='tinymce-graph'" and "graph-data='" + file.graphData + "'", it is really important to keep it in the tag - that's way you able to edit your graph.
                //      cb("<img class='tinymce-graph' graph-data='" + file.graphData + "' width='" + file.width + "' height='" + file.height + "' src='" + url + "' />");
                //   });

                // or just put SVG-html into your content. Example:
                cb(file.html);
            }

        };

        tinymce.init(editor_config);
    </script>
@endsection
