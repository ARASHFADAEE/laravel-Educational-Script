 @extends('user.dashboard')
 
 

 @section('content-dashboard')
 
 <div class="space-y-5">
     <!-- section:title -->
     <div class="flex items-center gap-3">
         <div class="flex items-center gap-1">
             <div class="w-1 h-1 bg-foreground rounded-full"></div>
             <div class="w-2 h-2 bg-foreground rounded-full"></div>
         </div>
         <div class="font-black text-foreground">دوره های در حال یادگیری</div>
     </div>
     <!-- end section:title -->

     <!-- section:learning-courses:slider -->
     <div class="swiper col3-swiper-slider">
         <div class="swiper-wrapper">
            @if($items->count() > 0)

             @foreach ($items as $item )
                
             <div class="swiper-slide">
                 <!-- course:card -->
                 <div class="relative">
                     <div class="relative z-10">
                         <a href="{{Route('course.show',$item->course->slug)}}" class="block">
                             <img src="{{asset('storage')}}/{{$item->course->thumbnail}}" class="max-w-full rounded-3xl" alt="..." />
                         </a>
                         <a href="./course-category.html"
                             class="absolute left-3 top-3 h-11 inline-flex items-center justify-center gap-1 bg-black/20 rounded-full text-white transition-all hover:opacity-80 px-4">
                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                 class="w-6 h-6">
                                 <path fill-rule="evenodd"
                                     d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z"
                                     clip-rule="evenodd" />
                             </svg>
                             <span class="font-semibold text-sm">{{$item->course->course_categorie->name}}</span>
                         </a>
                     </div>
                     <div class="bg-background rounded-b-3xl -mt-12 pt-12">
                         <div class="bg-gradient-to-b from-background to-secondary rounded-b-3xl space-y-2 p-5 mx-5">
                             <div class="flex items-center gap-2">
                                 <span class="block w-1 h-1 bg-success rounded-full"></span>
                                 <span class="font-bold text-xs text-success">
                                    {{$item->course->status}}
                                     </span>
                             </div>
                             <h2 class="font-bold text-sm">
                                 <a href="{{Route('course.show',$item->course->slug)}}"
                                     class="line-clamp-1 text-foreground transition-colors hover:text-primary">
                                     {{$item->course->title}}
                                    </a>
                             </h2>
                         </div>
                         <div class="space-y-3 p-5">

                             <div class="space-y-3 mt-3">

                                 <a href="./course-episodes.html"
                                     class="w-full h-11 inline-flex items-center justify-center gap-1 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4">
                                     <span class="font-semibold text-sm">ادامه یادگیری</span>
                                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                         class="w-5 h-5">
                                         <path fill-rule="evenodd"
                                             d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                                             clip-rule="evenodd"></path>
                                     </svg>
                                 </a>
                             </div>
                         </div>
                     </div>
                 </div>
                 <!-- end course:card -->
             </div>
             @endforeach
             
             @endif

         </div>

         <div class="swiper-button-prev"></div>
         <div class="swiper-button-next"></div>
     </div>
     <!-- end section:learning-courses:slider -->
 </div>

 @endsection
