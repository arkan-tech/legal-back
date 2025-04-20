@extends('site.layouts.main')
@section('title',$main_message->subject)
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
    .chats{
        width: 100%;
    }
    .chats li {
        list-style: none;
        padding: 8px 0 5px;
        margin: 7px auto;
        font-size: 15px;
        width: 50%
    }
    .chats li.in {
        float: right
    }
    .chats li.out {
        float: left
    }
    .chats li .message .body {
        display: block;
    }
    .chats li .message {
        display: block;
        padding: 5px;
        position: relative;

        background: #fbfbfb;
        background-color: rgb(251, 251, 251);
        border-left: 1px solid #eaeaea !important;
        border-right: 1px solid #eaeaea !important;
        padding: 10px !important;
        border-radius: 5px;
    }
    .chats li.in .message {
        text-align: right;
        margin-right: 65px;
        width: 100%
    }
    li.in .message .arrow {
        border-bottom: 8px solid transparent;
        border-top: 8px solid transparent;
        display: block;
        height: 0;
        right: -8px;
        position: absolute;
        top: 15px;
        width: 0;
    }

    .chats li.in .message .arrow {
        border-right: 8px solid #2f8e95;
    }
    li.in .name {
        color: #FB9800 !important;
    }
    .chats li .name {
        font-size: 16px;
        font-weight: 700;
    }
    .chats li.in img.avatar {
        float: right;
        margin-left: 10px;
        height: 45px;
        width: 45px;
    }

    .chats li.out img.avatar {
        float: left;
        margin-right: 10px;
        margin-top: 0px;
        height: 45px;
        width: 45px;
    }
    .chats li.out .name {
        color: #2FADE7 !important;
    }
    .chats li.out .message {
        border-left: 2px solid #b14c4c;
        margin-left: 65px;
        text-align: left;

        /* min-height: 130px; */
        background-color: #dff0d8;
    }
    
    .message {
        border: 1px solid #eaeaea;
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
                <div class="register-form">

                <div class="row">
                    
                    @include('site.lawyer_right_menu', array('lawyer'=> $lawyer))
                    
                    <div class="col-lg-10 col-md-12 col-sm-12">

                            <div class="row clearfix">

                                <ul class="chats">
                                    
                                    @include('site.viewlawyerreceivedmessagereplies',['messages','main_message'])

                                </ul>
                            </div>

                        <form id="writeReply">
						    @csrf
                            <div class="row clearfix">
                                <input type="hidden" value="{{ $main_message->id }}" name="mainMessage">

                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                    <textarea class="form-control" cols="5" rows="5" name="message" placeholder="الرد على الرسالة"></textarea>

                                    <span style="display: block;text-align: right;color: #dc3545!important" class="mail-text-danger error-text message_error"></span>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 text-center form-group">
                                    <button class="theme-btn btn-style-four" type="submit" name="submit-form"><span class="txt"> ارســـال </span></button>

                                    <span style="display: none;" id="AjaxLoader" class="">                    
                                        <img src="/site/images/loader2.gif">
                                    </span>
                                </div>
                                
                            </div>
                        </form>

                    </div>
                </div>

            </div>
                
        </div>                                             
    </div>
</section>


<script>
    $('#writeReply').on('submit', function(event)
    {
        event.preventDefault();                      
        $.ajax
        ({                                         
            url: "{{ route('savelawyerreply') }}",										 
            type:'POST',
            data:new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false, 
            beforeSend: function() {
                $("#AjaxLoader").show();
            },      
            success: function(data)
            {	            
                if($.isEmptyObject(data.error))
                {                            
                    $("#writeReply")[0].reset();
                    $('.text-danger').hide();
                    $("#AjaxLoader").hide();
                    $('.chats').html(data.chats);

                }else{
                    $.each(data.error, function( key, value ) {	                        			
                        $('.'+key+'_error').text(value);
                    });
                }

            }
        });
    });
</script>

    
@endsection
