<style>
    .designation {
        text-align: justify
    }
</style>
@extends('site.api.layouts.apiMainLayout')
@section('title', 'عملية دفع معلقة ')
@section('content')


    <!-- Team Detail Section -->
    <section class="team-detail-section">
        <div class="auto-container">
            <div class="upper-box">
                <div class="row clearfix">

                    <div class="content-column col-lg-12 col-md-12 col-sm-12">

                        <div class="inner-column">

                            <div style="font-size: 20px"
                                class="text-center alert alert-danger fade in alert-dismissible show">
                                <img width="200" src="{{ asset('site/images/close.png') }}">
                                <div class="clearfix"></div>
                                <strong>تنبيه !</strong>
                                العملية معلقة من البنك, برجاء مراجعة البنك

                                <div class="clearfix"></div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>


@endsection
