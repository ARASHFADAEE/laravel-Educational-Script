@extends('user.dashboard')



@section('title', 'پرداخت ها')



@section('content-dashboard')


    <div class="lg:col-span-9 md:col-span-8">
        <div class="space-y-10">
            <div class="space-y-5">
                <!-- section:title -->
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1">
                        <div class="w-1 h-1 bg-foreground rounded-full"></div>
                        <div class="w-2 h-2 bg-foreground rounded-full"></div>
                    </div>
                    <div class="font-black text-foreground">تاریخچه تراکنشها</div>
                </div>
                <!-- end section:title -->

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-right">
                        <thead class="text-xs text-muted uppercase bg-background border-b border-border">
                            <tr>
                                <th class="whitespace-nowrap p-5">شماره پیگیری</th>
                                <th class="whitespace-nowrap p-5">وضعیت</th>
                                <th class="whitespace-nowrap p-5">شرح تراکنش</th>
                                <th class="whitespace-nowrap p-5">مبلغ</th>
                                <th class="whitespace-nowrap p-5">تاریخ ایجاد</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment )
                                
                            <tr class="odd:bg-secondary even:bg-background">
                                <td class="p-5">
                                    <div class="font-black text-sm text-foreground">{{$payment->id}}</div>
                                </td>
                                <td class="p-5">
                                    <div class="flex items-center gap-2">
                                        @if ($payment->status == 'completed')
                                            
                                        <div class="flex-shrink-0 rounded-full bg-green-500/20 p-1">
                                            <div class="h-1.5 w-1.5 rounded-full bg-green-500"></div>
                                        </div>

                                        <span class="font-bold text-green-500">موفق</span>

                                        @elseif($payment->status == 'failed')
                                            <div class="flex-shrink-0 rounded-full bg-red-500/20 p-1">
                                            <div class="h-1.5 w-1.5 rounded-full bg-green-500"></div>
                                        </div>

                                        <span class="font-bold text-green-500">نا موفق</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-5">
                                    <div class="flex flex-col items-start gap-1 w-36">
                                        <span class="font-bold text-xs text-muted">خرید دوره آموزشی
                                            </span>
                                        <span class="font-black text-sm text-foreground line-clamp-1">{{$payment->course->title}}</span>
                                    </div>
                                </td>
                                <td class="p-5">
                                    <div class="flex items-center gap-1">
                                        <span class="font-black text-sm text-foreground">{{number_format($payment->amount)}}</span>
                                        <span class="text-xs text-muted">تومان</span>
                                    </div>
                                </td>
                                <td class="p-5">
                                    <div class="text-xs text-muted whitespace-nowrap">
                                        {{verta($payment->created_at)->format('j F Y')}}
                                    </div>
                                </td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



@endsection
