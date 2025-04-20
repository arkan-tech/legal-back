@extends('site.layouts.main')
@section('title','الرسائل الواردة')
@section('content')

<style>
    .apply-office{
        font-family: 'Tajawal Bold';
    }
    .links{
        font-size: 20px;
        font-weight: 700
    }
    .links:hover{
        color: #dd9b25
    }
    a.active{
        color: #000
    }
    .table-inbox {
        border: 1px solid #d3d3d3;
        margin-bottom: 0;
    }
    .table>tbody>tr>td{
        border-top: 1px solid #ddd;
    }
    .table-inbox tr td {
        padding: 15px!important;
        vertical-align: middle;
        text-align: center;
    }
    .inbox-head{
        background: none repeat scroll 0 0 #dd9b25;
        border-radius: 0 4px 0 0;
        color: #fff;
        min-height: 80px;
        padding: 20px;
    }
    .avatar{
        width: 50px;
        border-radius: 50%;
    }
</style>

    <!-- Contact Form Section -->
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">


            <div class="form-column column col-lg-12 col-md-12 col-sm-12">

                <div class="sec-title">
                    <h2> الملف الشخصى </h2>
                    <div class="separate"></div>
                </div>

                <!--Login Form-->
                <div class="styled-form register-form">

                <div class="row">
                @include('site.lawyer_right_menu', array('lawyer'=> $lawyer))
                    <div class="col-lg-10 col-md-12 col-sm-12">
                        <div class="inbox-head">
                            <h3>الرسائل الواردة</h3>
                        </div>
                        <table class="table table-inbox table-hover">
                            <tbody>

                            @foreach($emails as $email)
                                <tr data-link="{{ route('site.lawyer.view.message',$email->id)}}">
                                    <td class="inbox-small-cells">
                                        <img class="avatar" src="{{asset('uploads/person.png')}}" alt="{{ $email->client->myname }}" />
                                    </td>
                                    <td class="view-message text-right dont-show">
                                        {{ $email->client->myname }}
                                    </td>
                                    <td class="view-message text-right">
                                        {{ $email->subject }}
                                    </td>
                                    <!-- <td class="view-message  inbox-small-cells"><i class="fa fa-paperclip"></i></td> -->
                                    <td class="view-message text-center">
                                        {{GetArabicDate2($email->created_at) . ' - ' . GetPmAmArabic(date('h:i A', strtotime($email->created_at)))}}
                                    </td>

                                    <td>
                                        {{getMainMessageOtherMessages($email->id) . ' رسالة جديدة'}}
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                </div>

            </div>



        </div>
    </section>

    <script>
        $(document).ready(function() {
            $('table').on('click', 'tr', function(e)
            {
                var u = $(this).data("link");

                window.location.href = u;
            });
        });
    </script>

@endsection
