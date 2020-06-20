@extends('Quizviran::layout')
@section('title','تیزویران | کلاس ها')

@section('content')
  <div class="container-fluid px-lg-5">
    
    <div class="row justify-content-center">
      
      <div class="col-12 mt-5 mb-3">
        <div class="row justify-content-center">
          <div class="col-11 col-lg-4 d-flex justify-content-center">
            <img src="{{ asset('img/quizviran.png') }}" alt="لوگو-کوییزویران" class="img-fluid" style="margin-top: 38px">
          </div>
        </div>
      </div>
      @if(auth()->check())
        <div class="col-12 my-3">
          <div class="row justify-content-center">
            <div class="col-10 col-lg-4 d-flex flex-row justify-content-center px-3">
              @if($user->isTeacher())
                <a href="{{ route('quizviran.room.create') }}" class="mx-1">
                  <img src="{{ asset('quiz-assets/img/create-class.png') }}"
                       class="p-1 quiz-button img-fluid" alt="create-class">
                </a>
              @else
                <a href="{{ route('quizviran.room.join.page') }}" class="mx-1">
                  <img src="{{ asset('quiz-assets/img/join-class.png') }}"
                       class="p-1 quiz-button img-fluid" alt="join-room">
                </a>
              @endif
              <a href="{{ route('quizviran.panel') }}" class="mx-1">
                <img src="{{ asset('quiz-assets/img/dashboard.png') }}"
                     class="p-1 quiz-button img-fluid" alt="dashboard">
              </a>
            </div>
          </div>
        </div>
      @else
        <div class="col-12 my-3">
          <div class="row justify-content-center">
            <div class="col-10 my-1 col-lg-3 d-flex flex-row justify-content-center px-3">
              <div @click="EventBus.$emit('openSignUp')" class="mx-1">
                <img src="{{ asset('quiz-assets/img/signup.png') }}" class="p-1 quiz-button img-fluid" alt="dashboard">
              </div>
            </div>
            <div class="col-10 my-1 col-lg-3 d-flex flex-row justify-content-center px-3">
              <a href="{{ route('donate') }}" class="mx-1">
                <img src="{{ asset('img/donate.jpg') }}"
                     class="p-1 quiz-button img-fluid" alt="join-room">
              </a>
            </div>
          </div>
        </div>
      @endif
    </div>
    
    <div class="row justify-content-center my-3">
      <div class="col-12 col-md-8 d-flex flex-row justify-content-center">
        <app-main-box title="آخرین مسابقات" icon="flag-checkered">
          <app-main-box-last-exam :key="'exam' + exam.id" v-for="exam in {{ $exams->toJson() }}" :exam="exam"></app-main-box-last-exam>
        </app-main-box>
      </div>
      <div class="col-12 col-md-4 d-flex flex-row justify-content-center">
        <app-main-box title="چالش ها" icon="dice-six">
          <app-under-hand></app-under-hand>
        </app-main-box>
      </div>
    </div>
    
    <div class="row justify-content-center my-3">
      <div class="col-12 d-flex flex-row position-relative justify-content-center">
        <div class="gray-gradient rounded h-100"></div>
        <div class="w-100  bg-dark-gray big-shadow p-1 rounded"
             style="height: 100px;overflow-x: auto;overflow-y: hidden">
          
          <div class="p-1 d-flex flex-row justify-content-start">
            
            <div><img src="/quiz-assets/img/medal.png"
                      alt="دانش آموزان ممتاز"
                      style="height: 85px"
              >
            </div>
            
            <div style="padding: 1px" class="bg-light mx-2 rounded"></div>
            @if($bestStudents->isEmpty())
              <div class="d-flex flex-row justify-content-center align-items-center w-100">شما اولین نفر باشید.</div>
            @else
              <app-best-users-item v-for="user in {{ $bestStudents->toJson() }}" :key="user.id" :user="user"></app-best-users-item>
            @endif
          
          </div>
        
        
        </div>
      </div>
    </div>
    @if(auth()->check())
      <div class="row justify-content-center my-3">
        <div class="col-lg-6 col-12 my-2 position-relative">
          <app-main-box :dark="true" title="کلاس های من" icon="chalkboard-teacher">
            @if($rooms->isEmpty())
              @if($user->isTeacher())
                <a href="{{ route('quizviran.room.create') }}" class="btn btn-outline-light btn-block">
                  <span class="fas fa-plus"></span>
                  <span>ایجاد کلاس</span>
                </a>
              
              @else
                <a href="{{ route('quizviran.room.join.page') }}" class="btn btn-outline-light btn-block">
                  <span class="fas fa-plus"></span>
                  <span>عضویت در کلاس</span>
                </a>
              @endif
            @endif
            <app-main-box-last-classes :key="room.id"
                                       v-for="room in {{ $rooms->toJson() }}"
                                       :room="room">
            </app-main-box-last-classes>
          </app-main-box>
        </div>
        
        <div class="col-md-6 col-12 my-2">
          <app-main-box :dark="true" title="تکالیف" icon="scroll" color="">
            <app-under-hand></app-under-hand>
          </app-main-box>
        </div>
      </div>
    @endif
  </div>
@endsection
