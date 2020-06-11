@extends('Quizviran::layout')
@section('title','تیزویران | مدیریت سوالات آزمون')

@section('head')
  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endsection

@section('content')
  <div class="container-fluid">
    
    <div class="row justify-content-center">
      <div class="bg-dark-gray col-12" style="padding-top: 100px;">
        <app-panel-links-header type="{{ $user->type }}"></app-panel-links-header>
      </div>
    </div>
    
    <app-breadcrumb>
      <app-breadcrumb-item route="{{ route('quizviran.panel') }}">
        پنل مدیریت
      </app-breadcrumb-item>
      <app-breadcrumb-item route="{{ route('quizviran.room.show',['room' => $room->link]) }}">
        {{ $room->name }}
      </app-breadcrumb-item>
      <app-breadcrumb-item route="{{ route('quizviran.exam.manage',['room' => $room->link]) }}">
        مدیریت آزمون ها
      </app-breadcrumb-item>
      <app-breadcrumb-item :active="true">
        مدیریت سوالات
      </app-breadcrumb-item>
    </app-breadcrumb>
    
    <div class="row my-5 justify-content-around justify-content-center">
      <div class="col-12 px-2 px-lg-5 col-lg-6">
        {{-- todo : convert tabs to component swithing --}}
        <app-question-manage-tabs>
          <template #question>
            <app-question-add-form :categories="{{ $categories->toJson() }}"
                                   route="{{ route('quizviran.question.store') }}"></app-question-add-form>
          </template>
          
          <template #category>
            <app-question-category-tab :categories="{{ $categories->toJson() }}"
                                       route="{{ route('quizviran.category.store') }}"></app-question-category-tab>
          </template>
        </app-question-manage-tabs>
      
      </div>
      
      <div class="my-3 col-12 col-lg-6">
        
        <div class="px-2 my-4 px-lg-5 col-12">
          <app-question-exam name="{{ $exam->name }}"
                             :questions="{{ $exam->questions->toJson() }}"
                             id="{{ $exam->id }}">
          </app-question-exam>
        </div>
        
        <div class="px-1 my-4 px-lg-5 col-12 mt-5">
          <app-question-all :categories="{{ $categories->toJson() }}"
                            :questions="{{ $questionsWithoutCategory->toJson() }}"
                            id="{{ $exam->id }}">
          </app-question-all>
        </div>
      
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
