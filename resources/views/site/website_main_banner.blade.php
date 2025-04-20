@if(Session::get('loggedInUserID') != '')
    @php
        $lawyerEmail = GetName('lawyers', 'Email', 'id', Session::get('loggedInUserID'));
        $lawyerPassword = GetName('lawyers', 'Password', 'id', Session::get('loggedInUserID'));
        $lawyerPaidStatus = GetName('lawyers', 'paid_status', 'id', Session::get('loggedInUserID'));
    @endphp

    @if($lawyerPaidStatus == 1)
        <a target="_blank"
           href="">
            <div class="side-tag">
                المكتب الإلكترونى
            </div>
        </a>
    @else
        <a href="/show-payment-rules">
            <a target="_blank" href="{{route('site.lawyer.show.login.form')}}" style="color: white"> <div class="side-tag"> بادر بحجز مكتبك الالكتروني فوراً </div></a>
        </a>
    @endif
@endif
