@extends('Quizviran::layout')
@section('title','تیزویران | کلاس ها')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="col-12 mt-5 mb-2">
                <div class="row justify-content-center">
                    <div class="col-11 col-md-4 d-flex justify-content-center">
                        <img src="{{ asset('img/quizviran.png') }}" alt="لوگو-کوییزویران" class="img-fluid" style="margin-top: 38px">
                    </div>
                </div>
            </div>

            <div class="col-12 my-2">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-4 d-flex flex-row justify-content-center px-3">
                        <a href="#" class="mx-1">
                            <img src="{{ asset('quiz/assets/img/join-class.png') }}"
                                 class="p-1 quiz-button img-fluid" alt="join-class">
                        </a>
                        <a href="#" class="mx-1">
                            <img src="{{ asset('quiz/assets/img/dashboard.png') }}"
                                 class="p-1 quiz-button img-fluid" alt="dashboard">
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col-11 my-2">
                <div class="row p-0 justify-content-center">
                    <div class="col-12 col-md-4 d-flex flex-row justify-content-center">
                        <app-main-box title="چالش ها" icon="dice-six">
                            <app-under-hand></app-under-hand>
                        </app-main-box>
                    </div>
                    <div class="col-12 col-md-8 d-flex flex-row justify-content-center">
                        <app-main-box title="آخرین مسابقات" icon="flag-checkered">
                            <app-main-box-last-quiz></app-main-box-last-quiz>
                            <app-main-box-last-quiz></app-main-box-last-quiz>
                            <app-main-box-last-quiz></app-main-box-last-quiz>
                        </app-main-box>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col-11 my-2">
                <div class="row p-0 justify-content-center">
                    <div class="col-12 d-flex flex-row position-relative justify-content-center">
                        <div class="gray-gradient rounded h-100"></div>
                        <div class="w-100  bg-dark-gray p-1 rounded"
                             style="height: 100px;overflow-x: auto;overflow-y: hidden">

                            <div class=" d-flex flex-row justify-content-start justify-content-md-between">

                                <div><img src="/quiz/assets/img/medal.png"
                                          alt="دانش آموزان ممتاز"
                                          style="height: 90px"
                                    >
                                </div>

                                <div style="padding: 1px" class="bg-light mx-2 rounded"></div>

                                <app-best-users-item></app-best-users-item>
                                <app-best-users-item></app-best-users-item>
                                <app-best-users-item></app-best-users-item>
                                <app-best-users-item></app-best-users-item>
                                <app-best-users-item></app-best-users-item>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row px-2 px-md-5 justify-content-center">
            <div class="col-md-6 col-12 my-2 position-relative">
                <app-main-box :dark="true" title="کلاس های من" icon="chalkboard-teacher">
                    <app-main-box-last-classes teacher="فلانی" link="/asas" title="ریاضی 8/4"></app-main-box-last-classes>
                </app-main-box>
            </div>

            <div class="col-md-6 col-12 my-2">
                <app-main-box :dark="true" title="تکالیف" icon="scroll" color="">
                    <app-under-hand></app-under-hand>
                </app-main-box>
            </div>
        </div>

    </div>
@endsection
<script>
    import AppBestUsersItem from "../js/components/AppBestUsersItem";

    export default {
        components: {AppBestUsersItem}
    }
</script>