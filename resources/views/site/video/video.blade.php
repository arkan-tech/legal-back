@extends('site.layouts.main')
@section('title','المكتبة')

<!-- Page Title -->
@section('extrajs')
<!-- jQuery, Popper and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
$(document).on("click", ".openvid", function () {

   var myBookId = $(this).data('id');
   var url='https://www.youtube.com/embed/'+myBookId;

   document.getElementById("videoplayer").src =url


});
 </script>


@endsection

@section('content')
<section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
   <div class="auto-container">
      <div class="side-icon">
         <img src="{{asset('site/images/logo.png')}}" alt="" />
      </div>
      <h2>القناة الثافية </h2>
      <ul class="page-breadcrumb">
         <li><a href="/">الرئيسية</a></li>
         <li>القناة الثافية </li>
      </ul>
      @include('site.website_main_banner')

                @if(Session::get('loggedInClientID') == '' && Session::get('loggedInUserID') == '')
                <a href="/signin">
                    <a target="_blank" href="{{route('site.lawyer.show.login.form')}}" style="color: white"> <div class="side-tag"> بادر بحجز مكتبك الالكتروني فوراً </div></a>

                </a>
				@endif
   </div>
</section>
<!-- End Page Title -->
<div class="sidebar-page-container libraries">
   <div class="auto-container">
      <div class="row clearfix">
         <!-- Sidebar Side -->
         <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
            <aside class="sidebar sticky-top">
               <!-- Categories Widget -->
               <div class="sidebar-widget categories-widget">
                  <div class="widget-content">
                     <!-- Sidebar Title -->
                     <div class="sidebar-title">
                        <h3>القناة الثافية </h3>
                     </div>
                     <ul class="nav nav-tabs blog-cat" role="tablist">
                        @foreach($VideoAlbums as $Librarycat)
                        <li>
                           <a class="{{($loop->first) ? 'active' : ''}}" data-toggle="tab" href="#tabs-{{$Librarycat->id}}" role="tab">
                               {{$Librarycat->title}}
                               <span>
                              </span>
                           </a>
                        </li>
                        @endforeach
                     </ul>
                  </div>
               </div>
            </aside>
         </div>
         <!-- Content Side -->
         <div class="content-side col-lg-8 col-md-12 col-sm-12">
            <div class="tab-content">


			@foreach($VideoAlbums as $Librarycat)
               <div class="tab-pane  {{($loop->first) ? 'active' :''}}" id="tabs-{{$Librarycat->id}}" role="tabpanel">
                  <div class="our-shops">
                     <!--Shop Single-->
                     <div class="shop-section">
                        <!--Sort By-->
                        <div class="items-sorting">
                           <div class="row clearfix">
                              <div class="results-column col-md-12">
                                 <h6>{{$Librarycat->title}}</h6>
                              </div>
                           </div>
                        </div>
                        <div class="our-shops">
                           <div class="row clearfix">
                          @php $BKS=GetVideoSubCat($Librarycat->id); @endphp
						  @foreach($BKS as $BK)
                             @php
                             $vid=videotref($BK->url);
                             @endphp

						   <div class="single-product-item col-lg-4 col-md-6 col-sm-12 text-center">
                                 <div class="img-holder">
                                    <img width="270" height="300" src="{{videothum($BK->url)}}" class="" alt="">
                                 </div>
                                 <div class="title-holder text-center">
                                    <div class="static-content">
                                       <h3 class="title text-center"><a  class='openvid' data-id="{{$vid}}" data-toggle="modal" data-target="#exampleModal">{{$BK->Title}}</a></h3>
                                    </div>
                                 </div>
                                </div>
							@endforeach
                           </div>
                           <!-- Post Share Options -->
                        </div>
                     </div>
                  </div>
               </div>
                @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
@endsection


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <iframe  height="315"  width="100%" style="min-height: 300px;height: 100%;border-radius: 10px" id="videoplayer"
                src=""
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                >
        </iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
      </div>
    </div>
  </div>
</div>
