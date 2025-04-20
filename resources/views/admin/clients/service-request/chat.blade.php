@extends('admin.layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content chat-application">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-area-wrapper container-xxl p-0">
            <div class="content-right w-100">
                <div class="content-wrapper container-xxl p-0">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <div class="body-content-overlay"></div>
                        <!-- Main chat area -->
                        <section class="chat-app-window">
                            <!-- To load Conversation -->

                            <!--/ To load Conversation -->
                            <!-- Active Chat -->
                            <div class="active-chat">
                                <!-- Chat Header -->
                                <div class="chat-navbar">
                                    <header class="chat-header">
                                        <div class="d-flex align-items-center">
                                            <div class="sidebar-toggle d-block d-lg-none me-1">
                                                <i data-feather="menu" class="font-medium-5"></i>
                                            </div>
                                            <div class="avatar avatar-border user-profile-toggle m-0 me-1">
                                                <img src="{{asset('uploads/person.png')}}" alt="avatar" height="36"
                                                     width="36"/>
                                            </div>
                                            <h6 class="mb-0"> {{$item->client->myname}}</h6>
                                        </div>

                                    </header>
                                </div>
                                <!--/ Chat Header -->
                                <!-- User Chat messages -->
                                <div class="user-chats">
                                    <div class="chats">
                                        @foreach($item_replies as $reply)
                                            <div class="chat {{$reply->from == 1?'chat-left':''}}">
                                                <div class="chat-avatar">
                                                <span class="avatar box-shadow-1 cursor-pointer">
                                                    <img src="{{asset('uploads/person.png')}}" alt="avatar" height="36"
                                                         width="36"/>
                                                </span>
                                                </div>
                                                <div class="chat-body">
                                                    <div class="chat-content">
                                                        @if(!is_null($reply->file))
                                                            <img src="{{$reply->file}}" width="70%" height="80%">
                                                        @endif
                                                        <p>{{$reply->replay}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- User Chat messages -->

                                <!-- Submit Chat form -->
                                <form class="chat-app-form"
                                      action="{{route('admin.clients.service-request.replayClientServiceRequest')}}"
                                      method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group input-group-merge me-1 form-send-message">
                                        <input type="hidden" value="{{$item->id}}" name="client_requests_id"/>
                                        <span class="speech-to-text input-group-text">
{{--                                            <i data-feather="mic" class="cursor-pointer"></i>--}}
                                        </span>
                                        <input type="text" name="replay_message" class="form-control message" required
                                               placeholder="ادخل رسالتك هنا "/>
                                                                                <span class="input-group-text">
                                                                                    <label for="attach-doc" class="attachment-icon form-label mb-0">
                                                                                        <i data-feather="image" class="cursor-pointer text-secondary"></i>
                                                                                        <input type="file" id="attach-doc" name="file" accept=".png, .jpeg , jpg" hidden/>
                                                                                    </label>
                                                                                </span>
                                    </div>
                                    <button type="submit" class="btn btn-primary send">
                                        <i data-feather="send" class="d-lg-none"></i>
                                        <span class="d-none d-lg-block">ارسال</span>
                                    </button>
                                </form>
                                <!--/ Submit Chat form -->
                            </div>
                            <!--/ Active Chat -->
                        </section>
                        <!--/ Main chat area -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

@endsection
@section('scripts')
    <script src="{{asset('admin/app-assets/js/scripts/pages/app-chat.js')}}"></script>
    <script>
        $('.chat-app-form').submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = getFormInputs(form);
            let actionUrl = form.attr('action');
            $.ajax({
                url: actionUrl,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    var message = $('.message').val();
                    if (/\S/.test(message)) {
                        let  file ;
                        if (response.file != null){
                           file = '<img width="70%" height="80%" src="'+response.file+'">';
                       }else {
                            file = '';
                        }

                        var html = ' <div class="chat">' +
                            '<div class="chat-avatar"> ' +
                            ' <span class="avatar box-shadow-1 cursor-pointer"> ' +
                            ' <img src="{{asset('uploads/person.png')}}" alt="avatar" height="36" ' +
                            '   width="36"/> ' +
                            ' </span> ' +
                            '   </div> ' +
                            ' <div class="chat-body"> ' +
                            '  <div class="chat-content"> ' +
                            ''+file+'' +
                            '<p>' + message + '</p>' +
                            '  </div> ' +
                            ' </div> ' +
                            ' </div>'
                        $('.chats ').append(html);
                        $('.message').val('');
                        $('.user-chats').scrollTop($('.user-chats > .chats').height());
                    }
                },
                error: function (error) {

                },

            })
        });
    </script>

@endsection
