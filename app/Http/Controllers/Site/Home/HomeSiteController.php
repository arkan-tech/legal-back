<?php

namespace App\Http\Controllers\Site\Home;

use App\Http\Controllers\Controller;
use App\Models\Contents\Content;
use App\Models\Courses\Course;
use App\Models\Lawyer\Lawyer;
use App\Models\Post\Post;
use App\Models\Service\Service;
use App\Models\Sponsor\Sponsor;


class HomeSiteController extends Controller
{
    public function index()
    {
        $Lawyers = Lawyer::where('accepted', 2)->where('show_in_advoisory_website', 1)->orderBy('id', 'DESC')->get();
        $About = Content::where('section', 1)->first();
        $Mission = Content::where('section', 2)->first();
        $Vision = Content::where('section', 3)->first();
        $sponsors = Sponsor::get();
        $services = Service::where('status', 1)->latest()->take(8)->get();
        $posts = Post::take(3)->orderBy('id', 'DESC')->get();
        $all_courses = Course::take(8)->get();
        return view('site.home.index', compact('About', 'Mission', 'Vision', 'Lawyers', 'sponsors', 'services', 'posts', 'all_courses'));
    }

    public function about()
    {
        $About = Content::where('section', 1)->first();
        $Mission = Content::where('section', 2)->first();
        $Vision = Content::where('section', 3)->first();
        $Advantages = Content::where('section', 4)->get();
        $Faq = Content::where('section', 5)->get();
        return view('site.about.about', compact('About', 'Mission', 'Vision', 'Advantages', 'Faq'));
    }

    public function lawyersRules()
    {
        $rules = Content::where('type', 'lawyersrules')->first();
        return view('site.lawyers.rules.index', compact('rules'));
    }

    public function login(){
        return view('site.auth.login');
    }
}
