@extends('Admin::layout')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-6 col-12 p-3">
                <x-card title="نظرات">
                    <table class="table table-responsive-md table-striped">
                        <tr>
                            <th>نظر</th>
                            <th>تایید</th>
                            <th>حذف</th>
                        </tr>
                        @foreach($comments as $comment)
                            <tr style="cursor:pointer;" class="{{ $comment->show ? '' : 'bg-dark' }}" onclick="showComment({{ $comment->id }})">
                                <td>
                                    <span style="max-width: 100px;
                                    white-space: nowrap;
                                    overflow: hidden !important;
                                    text-overflow: ellipsis;">{{ $comment->comment }}</span>
                                    <span class="figure-caption d-block">{{ $comment->user->name }}</span>
                                    <span class="figure-caption d-block">{{ \Morilog\Jalali\Jalalian::forge($comment->created_at)->format('Y-m-d') }}</span>
                                </td>

                                <td class="text-white">
                                    <form action="{{ url('manager/comment',['comment' => $comment->id]) }}" method="post">
                                        @csrf
                                        @method('patch')
                                        <button class="btn btn-sm btn-primary">{{ $comment->show ? 'عدم تایید' : 'تایید' }}</button>
                                    </form>
                                </td>

                                <td class="text-white">
                                    <form action="{{ url('manager/comment',['comment' => $comment->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-danger">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                </x-card>
                <div class="row justify-content-center">
                    {{ $comments->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade pr-0" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="margin-top: 100px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="m-0 p-0 close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="modalForm" action="" method="post">
                    <div class="modal-body">
                        @csrf
                        @method('put')
                        <textarea class="form-control" name="comment" rows="10" id="commentArea"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary"><span class="fas fa-edit"></span> <span>ذخیره تغییرات</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let comments = @json($comments);
        comments = comments.data;
        let action = '{{ route('admin.comment.update',['comment' => 1]) }}';
        action = action.slice(0, action.length - 1)

        function showComment(commentId) {
            let comment = comments.find(function (singleComment) {
                return singleComment.id == commentId;
            });
            modalTitle.innerText = comment.user.name;
            commentArea.innerText = comment.comment;
            modalForm.action = action + comment.id;
            $('#modal').modal({focus: true});
        }
    </script>
@endsection
